<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Holiday;
use App\Models\Service;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RuntimeException;

class AppointmentController extends Controller
{
    public function create(Request $request)
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $branches = Branch::where('is_active', true)
            ->orderByDesc('is_main')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $requestedServiceId = $request->query('service');
        $selectedServiceId = is_numeric($requestedServiceId)
            ? $services->firstWhere('id', (int) $requestedServiceId)?->id
            : null;

        return view('appointments.create', compact('services', 'branches', 'selectedServiceId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]{7,20}$/'],
            'age' => ['required', 'integer', 'between:1,120'],
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where('is_active', true),
            ],
            'branch_id' => [
                'required',
                Rule::exists('branches', 'id')->where('is_active', true),
            ],
            'appointment_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'symptoms' => ['nullable', 'string', 'max:2000'],
            'patient_message' => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            $appointment = DB::transaction(function () use ($validated) {
                $branch = Branch::whereKey($validated['branch_id'])
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                if (! $branch || ! $this->slotIsAvailable(
                    $branch,
                    $validated['appointment_date'],
                    $validated['appointment_time']
                )) {
                    throw new RuntimeException('That appointment time is no longer available. Please select another time.');
                }

                do {
                    $reference = 'ARO-'.Carbon::parse($validated['appointment_date'])->format('Ymd').'-'.Str::upper(Str::random(12));
                } while (Appointment::where('booking_reference', $reference)->exists());

                return Appointment::create([
                    ...$validated,
                    'booking_reference' => $reference,
                    'status' => 'pending',
                ]);
            });
        } catch (RuntimeException $exception) {
            return back()->withInput()->withErrors([
                'appointment_time' => $exception->getMessage(),
            ]);
        }

        return redirect()->route('appointment.success', $appointment->booking_reference);
    }

    public function success(string $reference)
    {
        $appointment = Appointment::with(['service', 'branch'])
            ->where('booking_reference', $reference)
            ->firstOrFail();

        return view('appointments.success', compact('appointment'));
    }

    public function availableSlots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'branch_id' => ['required', 'integer', Rule::exists('branches', 'id')->where('is_active', true)],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $branch = Branch::whereKey($validated['branch_id'])
            ->where('is_active', true)
            ->firstOrFail();

        $daySchedule = $this->daySchedule($branch, $validated['date']);

        if (! $daySchedule) {
            return response()->json([
                'available' => false,
                'slots' => [],
                'message' => 'This branch is closed on the selected date.',
            ]);
        }

        $slots = [];
        foreach ($this->slotsForSchedule($daySchedule, $validated['date']) as $time) {
            if ($this->slotIsAvailable($branch, $validated['date'], $time)) {
                $slots[] = [
                    'value' => $time,
                    'label' => Carbon::createFromFormat('H:i', $time)->format('h:i A'),
                ];
            }
        }

        return response()->json([
            'available' => count($slots) > 0,
            'slots' => $slots,
            'message' => count($slots) > 0
                ? 'Choose an available appointment time.'
                : 'No appointment times are available on this date.',
        ]);
    }

    private function slotIsAvailable(Branch $branch, string $date, string $time): bool
    {
        $daySchedule = $this->daySchedule($branch, $date);

        if (! $daySchedule || ! in_array($time, $this->slotsForSchedule($daySchedule, $date), true)) {
            return false;
        }

        return ! Appointment::where('branch_id', $branch->id)
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->where(function ($query) use ($date, $time) {
                $query->where(function ($original) use ($date, $time) {
                    $original->whereDate('appointment_date', $date)
                        ->whereTime('appointment_time', $time);
                })->orWhere(function ($rescheduled) use ($date, $time) {
                    $rescheduled->whereDate('rescheduled_date', $date)
                        ->whereTime('rescheduled_time', $time);
                });
            })
            ->exists();
    }

    private function daySchedule(Branch $branch, string $date): ?array
    {
        if (Holiday::whereDate('holiday_date', $date)->where('is_closed', true)->exists()) {
            return null;
        }

        $schedule = $branch->working_days[Carbon::parse($date)->format('l')] ?? null;

        if (
            ! is_array($schedule) ||
            ! empty($schedule['is_closed']) ||
            empty($schedule['open']) ||
            empty($schedule['close'])
        ) {
            return null;
        }

        try {
            $opens = Carbon::createFromFormat('H:i', $schedule['open']);
            $closes = Carbon::createFromFormat('H:i', $schedule['close']);
        } catch (\Throwable) {
            return null;
        }

        if (! $opens || ! $closes || $opens->gte($closes)) {
            return null;
        }

        return ['open' => $opens->format('H:i'), 'close' => $closes->format('H:i')];
    }

    /** @return list<string> */
    private function slotsForSchedule(array $schedule, string $date): array
    {
        $interval = (int) Setting::where('key', 'appointment_slot_interval')->value('value');
        if ($interval < 5 || $interval > 180) {
            $interval = 30;
        }

        $opens = Carbon::createFromFormat('H:i', $schedule['open']);
        $closes = Carbon::createFromFormat('H:i', $schedule['close']);
        $slot = $opens->copy();
        $now = now();
        $slots = [];

        while ($slot->lt($closes)) {
            if ($date !== today()->toDateString() || $slot->gt($now)) {
                $slots[] = $slot->format('H:i');
            }
            $slot->addMinutes($interval);
        }

        return $slots;
    }
}

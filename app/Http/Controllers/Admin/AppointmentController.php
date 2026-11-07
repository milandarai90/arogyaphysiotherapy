<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Holiday;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:pending,approved,rejected,rescheduled,completed,cancelled'],
        ]);

        $query = Appointment::with(['service', 'branch'])->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('booking_reference', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(15)->withQueryString();

        return view('admin.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['service', 'branch']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['approved', 'rejected', 'completed', 'cancelled']),
            ],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        if (in_array($appointment->status, ['completed', 'cancelled'], true)) {
            return back()->with(
                'error',
                'Completed or cancelled appointments cannot be changed.'
            );
        }

        $appointment->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? null,
            'rescheduled_date' => null,
            'rescheduled_time' => null,
        ]);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'Appointment status updated successfully.');
    }

    public function reschedule(Request $request, Appointment $appointment)
    {
        if (in_array($appointment->status, ['completed', 'cancelled', 'rejected'], true)) {
            return back()->with(
                'error',
                'This appointment cannot be rescheduled.'
            );
        }

        if (!$appointment->branch_id) {
            return back()->with(
                'error',
                'This appointment has no assigned branch. It cannot be rescheduled.'
            );
        }

        $validated = $request->validate([
            'rescheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'rescheduled_time' => ['required', 'date_format:H:i'],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $date = Carbon::parse($validated['rescheduled_date']);
        $time = $validated['rescheduled_time'];

        $requestedDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $date->format('Y-m-d') . ' ' . $time
        );

        if ($requestedDateTime->lte(now())) {
            return back()->withInput()->withErrors([
                'rescheduled_time' => 'Please select a future appointment date and time.',
            ]);
        }

        $interval = (int) Setting::where('key', 'appointment_slot_interval')
            ->value('value');

        if ($interval < 5 || $interval > 180) {
            $interval = 30;
        }

        try {
            DB::transaction(function () use (
                $appointment,
                $validated,
                $date,
                $time,
                $interval
            ) {
                $branch = Branch::whereKey($appointment->branch_id)
                    ->lockForUpdate()
                    ->first();

                if (!$branch || !$branch->is_active) {
                    throw new \RuntimeException(
                        'The assigned branch is unavailable or inactive.'
                    );
                }

                // Check branch working hours.
                $workingDays = $branch->working_days ?? [];
                $dayName = $date->format('l');
                $daySchedule = $workingDays[$dayName] ?? null;

                if (
                    !$daySchedule ||
                    !empty($daySchedule['is_closed']) ||
                    empty($daySchedule['open']) ||
                    empty($daySchedule['close'])
                ) {
                    throw new \RuntimeException(
                        "The selected branch is closed on {$dayName}."
                    );
                }

                $openingTime = Carbon::createFromFormat(
                    'H:i',
                    $daySchedule['open']
                );

                $closingTime = Carbon::createFromFormat(
                    'H:i',
                    $daySchedule['close']
                );

                $selectedTime = Carbon::createFromFormat('H:i', $time);

                if (
                    $selectedTime->lt($openingTime) ||
                    $selectedTime->gte($closingTime)
                ) {
                    throw new \RuntimeException(
                        'The selected time is outside this branch’s opening hours.'
                    );
                }

                // Check appointment interval.
                $openingMinutes = ($openingTime->hour * 60) + $openingTime->minute;
                $selectedMinutes = ($selectedTime->hour * 60) + $selectedTime->minute;

                if (($selectedMinutes - $openingMinutes) % $interval !== 0) {
                    throw new \RuntimeException(
                        "Please select a time matching the {$interval}-minute appointment interval."
                    );
                }

                // Check holidays. Holidays apply to all branches.
                $isHoliday = Holiday::whereDate(
                    'holiday_date',
                    $date->format('Y-m-d')
                )->exists();

                if ($isHoliday) {
                    throw new \RuntimeException(
                        'The selected date is marked as a holiday.'
                    );
                }

                // Check whether another appointment occupies this effective slot.
                $conflictExists = Appointment::where('branch_id', $branch->id)
                    ->where('id', '!=', $appointment->id)
                    ->whereNotIn('status', ['rejected', 'cancelled'])
                    ->where(function ($query) use ($date, $time) {
                        $query->where(function ($original) use ($date, $time) {
                            $original->whereNull('rescheduled_date')
                                ->whereDate(
                                    'appointment_date',
                                    $date->format('Y-m-d')
                                )
                                ->whereTime('appointment_time', $time);
                        })->orWhere(function ($rescheduled) use ($date, $time) {
                            $rescheduled->whereNotNull('rescheduled_date')
                                ->whereDate(
                                    'rescheduled_date',
                                    $date->format('Y-m-d')
                                )
                                ->whereTime('rescheduled_time', $time);
                        });
                    })
                    ->exists();

                if ($conflictExists) {
                    throw new \RuntimeException(
                        'This time slot is already booked at the selected branch. Please choose another time.'
                    );
                }

                // Save the new appointment date and time.
                $appointment->update([
                    'status' => 'rescheduled',
                    'rescheduled_date' => $validated['rescheduled_date'],
                    'rescheduled_time' => $time,
                    'admin_note' => $validated['admin_note'] ?? null,
                ]);
            });
        } catch (\RuntimeException $exception) {
            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'Appointment rescheduled successfully.');
    }

    public function availableRescheduleSlots(
        Request $request,
        Appointment $appointment
    ) {
        $validated = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        if (!$appointment->branch_id) {
            return response()->json([
                'slots' => [],
                'message' => 'This appointment has no assigned branch.',
            ]);
        }

        $branch = $appointment->branch;

        if (!$branch || !$branch->is_active) {
            return response()->json([
                'slots' => [],
                'message' => 'The assigned branch is unavailable.',
            ]);
        }

        $date = Carbon::parse($validated['date']);
        $dayName = $date->format('l');

        $workingDays = $branch->working_days ?? [];
        $schedule = $workingDays[$dayName] ?? null;

        if (
            !$schedule ||
            !empty($schedule['is_closed']) ||
            empty($schedule['open']) ||
            empty($schedule['close'])
        ) {
            return response()->json([
                'slots' => [],
                'message' => 'The branch is closed on this day.',
            ]);
        }

        // Check holidays.
        if (
            Holiday::whereDate(
                'holiday_date',
                $date->format('Y-m-d')
            )->exists()
        ) {
            return response()->json([
                'slots' => [],
                'message' => 'The selected date is a holiday.',
            ]);
        }

        $interval = (int) Setting::where('key', 'appointment_slot_interval')
            ->value('value');

        if ($interval < 5 || $interval > 180) {
            $interval = 30;
        }

        $openingTime = Carbon::createFromFormat('H:i', $schedule['open']);
        $closingTime = Carbon::createFromFormat('H:i', $schedule['close']);

        // Get other appointments occupying their effective slots.
        $appointments = Appointment::where('branch_id', $branch->id)
            ->where('id', '!=', $appointment->id)
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->where(function ($query) use ($date) {
                $query->where(function ($original) use ($date) {
                    $original->whereNull('rescheduled_date')
                        ->whereDate(
                            'appointment_date',
                            $date->format('Y-m-d')
                        );
                })->orWhere(function ($rescheduled) use ($date) {
                    $rescheduled->whereNotNull('rescheduled_date')
                        ->whereDate(
                            'rescheduled_date',
                            $date->format('Y-m-d')
                        );
                });
            })
            ->get([
                'appointment_time',
                'rescheduled_time',
                'rescheduled_date',
            ]);

        $bookedTimes = $appointments->map(function ($item) {
            return $item->rescheduled_date
                ? Carbon::parse($item->rescheduled_time)->format('H:i')
                : Carbon::parse($item->appointment_time)->format('H:i');
        })->all();

        $slots = [];
        $current = $openingTime->copy();

        while ($current->lt($closingTime)) {
            $slot = $current->format('H:i');

            $slotDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $date->format('Y-m-d') . ' ' . $slot
            );

            if (
                $slotDateTime->gt(now()) &&
                !in_array($slot, $bookedTimes, true)
            ) {
                $slots[] = $slot;
            }

            $current->addMinutes($interval);
        }

        return response()->json([
            'slots' => $slots,
            'message' => empty($slots)
                ? 'No available slots for this date.'
                : null,
        ]);
    }
}

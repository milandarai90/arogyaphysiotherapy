<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Holiday;
use App\Models\OperatingHour;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display the public appointment booking form.
     */
    public function create(Request $request)
    {
        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedService = $request->query('service');
        $selectedServiceId = null;

        if ($selectedService && filter_var($selectedService, FILTER_VALIDATE_INT)) {
            $validService = $services->firstWhere('id', (int) $selectedService);

            if ($validService) {
                $selectedServiceId = $validService->id;
            }
        }

        return view('appointments.create', compact(
            'services',
            'selectedServiceId'
        ));
    }

    /**
     * Return available time slots for a selected date.
     */
    public function availableSlots(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $date = Carbon::parse($validated['date']);
        $dayName = $date->format('l');

        $operatingHour = OperatingHour::where('day_of_week', $dayName)
            ->first();

        if (!$operatingHour || $operatingHour->is_closed) {
            return response()->json([
                'available' => false,
                'message' => 'The clinic is closed on this day.',
                'slots' => [],
            ]);
        }

        $holiday = Holiday::whereDate('holiday_date', $date->toDateString())
            ->where('is_closed', true)
            ->first();

        if ($holiday) {
            return response()->json([
                'available' => false,
                'message' => 'The clinic is closed due to ' . $holiday->title . '.',
                'slots' => [],
            ]);
        }

        if (!$operatingHour->opening_time || !$operatingHour->closing_time) {
            return response()->json([
                'available' => false,
                'message' => 'Appointment hours are not configured for this day.',
                'slots' => [],
            ]);
        }

        $opening = Carbon::parse($operatingHour->opening_time);
        $closing = Carbon::parse($operatingHour->closing_time);

        $bookedTimes = Appointment::whereDate('appointment_date', $date->toDateString())
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->pluck('appointment_time')
            ->map(fn ($time) => Carbon::parse($time)->format('H:i'))
            ->all();

        $slots = [];

        // Generate slots at 30-minute intervals.
        $slot = $opening->copy();

        while ($slot->lt($closing)) {
            $time = $slot->format('H:i');

            $slotDateTime = Carbon::parse(
                $date->toDateString() . ' ' . $time
            );

            if (
                !in_array($time, $bookedTimes, true) &&
                $slotDateTime->greaterThan(now())
            ) {
                $slots[] = [
                    'value' => $time,
                    'label' => $slot->format('h:i A'),
                ];
            }

            $slot->addMinutes(30);
        }

        return response()->json([
            'available' => count($slots) > 0,
            'message' => count($slots) > 0
                ? 'Please select an available time.'
                : 'No appointment slots are available on this date.',
            'slots' => $slots,
        ]);
    }

    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]{7,20}$/'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],

            'service_id' => [
                'required',
                'integer',
                Rule::exists('services', 'id')->where('is_active', true),
            ],

            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'appointment_time' => [
                'required',
                'date_format:H:i',
            ],

            'symptoms' => ['nullable', 'string', 'max:2000'],
            'patient_message' => ['nullable', 'string', 'max:2000'],
        ]);

        $appointmentDate = Carbon::parse($validated['appointment_date']);
        $dayName = $appointmentDate->format('l');

        $operatingHour = OperatingHour::where('day_of_week', $dayName)
            ->first();

        if (!$operatingHour || $operatingHour->is_closed) {
            return back()->withInput()->withErrors([
                'appointment_date' => 'The clinic is closed on the selected day. Please choose another date.',
            ]);
        }

        $holiday = Holiday::whereDate(
            'holiday_date',
            $appointmentDate->toDateString()
        )->where('is_closed', true)->first();

        if ($holiday) {
            return back()->withInput()->withErrors([
                'appointment_date' => 'The clinic is closed on this date due to ' . $holiday->title . '.',
            ]);
        }

        if (!$operatingHour->opening_time || !$operatingHour->closing_time) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'Appointment hours are not configured for this day.',
            ]);
        }

        $selectedTime = Carbon::createFromFormat(
            'H:i',
            $validated['appointment_time']
        );

        $opening = Carbon::parse($operatingHour->opening_time)->format('H:i');
        $closing = Carbon::parse($operatingHour->closing_time)->format('H:i');
        $selectedTimeString = $selectedTime->format('H:i');

        if (
            $selectedTimeString < $opening ||
            $selectedTimeString >= $closing
        ) {
            return back()->withInput()->withErrors([
                'appointment_time' => "Please select a time between {$opening} and {$closing}.",
            ]);
        }

        // Only allow times that match the 30-minute slot interval.
        $openingMinutes = Carbon::parse($opening)->hour * 60
            + Carbon::parse($opening)->minute;

        $selectedMinutes = $selectedTime->hour * 60 + $selectedTime->minute;

        if (($selectedMinutes - $openingMinutes) % 30 !== 0) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'Please select one of the available appointment slots.',
            ]);
        }

        $selectedDateTime = Carbon::parse(
            $validated['appointment_date'] . ' ' . $validated['appointment_time']
        );

        if ($selectedDateTime->lessThanOrEqualTo(now())) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'Please select a future appointment time.',
            ]);
        }

        $appointment = DB::transaction(function () use ($validated) {
            // Recheck the slot inside the transaction.
            $alreadyBooked = Appointment::whereDate(
                'appointment_date',
                $validated['appointment_date']
            )
                ->whereTime('appointment_time', $validated['appointment_time'])
                ->whereNotIn('status', ['rejected', 'cancelled'])
                ->lockForUpdate()
                ->exists();

            if ($alreadyBooked) {
                return null;
            }

            do {
                $reference = 'ARO-' . now()->format('Ymd') . '-' .
                    Str::upper(Str::random(5));
            } while (
                Appointment::where('booking_reference', $reference)->exists()
            );

            return Appointment::create([
                'booking_reference' => $reference,
                'patient_name' => $validated['patient_name'],
                'phone' => $validated['phone'],
                'age' => $validated['age'],
                'service_id' => $validated['service_id'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'symptoms' => $validated['symptoms'] ?? null,
                'patient_message' => $validated['patient_message'] ?? null,
                'status' => 'pending',
            ]);
        });

        if (!$appointment) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'This time slot has just been booked. Please select another time.',
            ]);
        }

        return redirect()
            ->route('appointment.success', $appointment->booking_reference)
            ->with('success', 'Your appointment request has been submitted.');
    }

    /**
     * Display the booking confirmation.
     */
    public function success(string $reference)
    {
        $appointment = Appointment::with('service')
            ->where('booking_reference', $reference)
            ->firstOrFail();

        return view('appointments.success', compact('appointment'));
    }
}

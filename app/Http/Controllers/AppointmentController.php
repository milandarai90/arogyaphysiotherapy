<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
                Rule::exists('services', 'id')
                    ->where('is_active', true),
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

        $appointment = DB::transaction(function () use ($validated) {
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

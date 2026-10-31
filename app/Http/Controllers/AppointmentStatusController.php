<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentStatusController extends Controller
{
    public function index()
    {
        return view('appointments.status');
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'booking_reference' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'digits:10'],
        ], [
            'booking_reference.required' => 'Please enter your booking reference.',
            'phone.required' => 'Please enter your registered phone number.',
            'phone.digits' => 'Please enter a valid 10-digit phone number.',
        ]);

        $appointment = Appointment::where(
            'booking_reference',
            strtoupper(trim($validated['booking_reference']))
        )
            ->where('phone', $validated['phone'])
            ->with('service')
            ->first();

        if (!$appointment) {
            return back()
                ->withInput([
                    'booking_reference' => $validated['booking_reference'],
                ])
                ->with('lookup_error', 'No appointment was found. Please check your booking reference and phone number.');
        }

        return view('appointments.status', compact('appointment'));
    }
}
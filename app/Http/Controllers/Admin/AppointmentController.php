<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with('service')->latest();

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
        $appointment->load('service');

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

        if ($appointment->status === 'completed' || $appointment->status === 'cancelled') {
            return back()->with('error', 'Completed or cancelled appointments cannot be changed.');
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
            return back()->with('error', 'This appointment cannot be rescheduled.');
        }

        $validated = $request->validate([
            'rescheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'rescheduled_time' => ['required', 'date_format:H:i'],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $appointment->update([
            'status' => 'rescheduled',
            'rescheduled_date' => $validated['rescheduled_date'],
            'rescheduled_time' => $validated['rescheduled_time'],
            'admin_note' => $validated['admin_note'] ?? null,
        ]);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'Appointment rescheduled successfully.');
    }
}
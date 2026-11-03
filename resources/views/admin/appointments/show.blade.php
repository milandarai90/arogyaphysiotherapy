@extends('admin.layouts.app')

@section('title', 'Appointment Details')
@section('page-title', 'Appointment Details')
@section('page-description', 'Booking reference: ' . $appointment->booking_reference)

@section('page-actions')
    <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Appointments
    </a>
@endsection

@section('content')

    {{-- Patient Information --}}
    <div class="card table-card mb-4">
        <div class="card-header bg-white p-3">
            <h5 class="fw-bold mb-0">Patient Information</h5>
        </div>

        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="text-muted small">Patient Name</label>
                    <div class="fw-semibold">{{ $appointment->patient_name }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Phone Number</label>
                    <div class="fw-semibold">{{ $appointment->phone }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Age</label>
                    <div class="fw-semibold">{{ $appointment->age ?? 'Not provided' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Service</label>
                    <div class="fw-semibold">{{ $appointment->service->name ?? 'N/A' }}</div>
                </div>

                {{-- Branch Information --}}
                <div class="col-12">
                    <hr>
                    <h6 class="fw-bold mb-3">
                        <i class="fa-solid fa-hospital me-2"></i>
                        Selected Branch
                    </h6>
                </div>

                @if($appointment->branch)
                    <div class="col-md-6">
                        <label class="text-muted small">Branch Name</label>
                        <div class="fw-semibold">
                            {{ $appointment->branch->name }}

                            @if($appointment->branch->is_main)
                                <span class="badge text-bg-primary ms-1">Main Branch</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Branch Phone</label>
                        <div class="fw-semibold">
                            @if($appointment->branch->phone)
                                <a href="tel:{{ $appointment->branch->phone }}">
                                    {{ $appointment->branch->phone }}
                                </a>
                            @else
                                Not provided
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Branch Address</label>
                        <div class="fw-semibold">
                            {{ $appointment->branch->address ?: 'Not provided' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Location</label>
                        <div class="fw-semibold">
                            {{ collect([
                                $appointment->branch->city,
                                $appointment->branch->district,
                                $appointment->branch->province
                            ])->filter()->implode(', ') ?: 'Not provided' }}
                        </div>
                    </div>

                    @if($appointment->branch->google_maps_url)
                        <div class="col-12">
                            <a href="{{ $appointment->branch->google_maps_url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-location-dot me-1"></i>
                                View Branch Location
                            </a>
                        </div>
                    @endif
                @else
                    <div class="col-12">
                        <div class="alert alert-secondary mb-0">
                            No branch was assigned to this appointment.
                            This may be an appointment created before branch selection was introduced.
                        </div>
                    </div>
                @endif

                <div class="col-12">
                    <hr>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Requested Date</label>
                    <div class="fw-semibold">
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Requested Time</label>
                    <div class="fw-semibold">
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Current Status</label>
                    <div>
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                'rescheduled' => 'info',
                                'completed' => 'primary',
                                'cancelled' => 'secondary',
                            ];
                        @endphp

                        <span class="badge text-bg-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                </div>

                @if($appointment->rescheduled_date)
                    <div class="col-md-6">
                        <label class="text-muted small">Rescheduled Date</label>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($appointment->rescheduled_date)->format('d M Y') }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Rescheduled Time</label>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($appointment->rescheduled_time)->format('h:i A') }}
                        </div>
                    </div>
                @endif

                <div class="col-12">
                    <label class="text-muted small">Symptoms / Reason for Appointment</label>
                    <div>{{ $appointment->symptoms ?: 'Not provided' }}</div>
                </div>

                <div class="col-12">
                    <label class="text-muted small">Additional Patient Message</label>
                    <div>{{ $appointment->patient_message ?: 'Not provided' }}</div>
                </div>

                <div class="col-12">
                    <label class="text-muted small">Admin Note</label>
                    <div>{{ $appointment->admin_note ?: 'No admin note' }}</div>
                </div>

            </div>
        </div>
    </div>

    @if(!in_array($appointment->status, ['completed', 'cancelled']))

        <div class="row g-4">

            {{-- Update Status --}}
            <div class="col-lg-6">
                <div class="card table-card h-100">
                    <div class="card-header bg-white p-3">
                        <h5 class="fw-bold mb-0">Update Appointment Status</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST"
                              action="{{ route('admin.appointments.status', $appointment) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    @foreach(['pending', 'approved', 'rejected', 'completed', 'cancelled'] as $status)
                                        <option value="{{ $status }}"
                                            @selected(old('status', $appointment->status) === $status)>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Admin Note</label>
                                <textarea name="admin_note"
                                          class="form-control"
                                          rows="4"
                                          placeholder="Enter an optional note">{{ old('admin_note', $appointment->admin_note) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-save me-1"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Reschedule --}}
            <div class="col-lg-6">
                <div class="card table-card h-100">
                    <div class="card-header bg-white p-3">
                        <h5 class="fw-bold mb-0">Reschedule Appointment</h5>
                    </div>

                    <div class="card-body">
                         @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                        <form method="POST"
                              action="{{ route('admin.appointments.reschedule', $appointment) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="form-label">New Appointment Date</label>
                                <input type="date"
                                       name="rescheduled_date"
                                       class="form-control"
                                       min="{{ today()->format('Y-m-d') }}"
                                       value="{{ old('rescheduled_date', $appointment->rescheduled_date ? \Carbon\Carbon::parse($appointment->rescheduled_date)->format('Y-m-d') : '') }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Appointment Time</label>
                                <input type="time"
                                       name="rescheduled_time"
                                       class="form-control"
                                       value="{{ old('rescheduled_time', $appointment->rescheduled_time ? \Carbon\Carbon::parse($appointment->rescheduled_time)->format('H:i') : '') }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Admin Note</label>
                                <textarea name="admin_note"
                                          class="form-control"
                                          rows="4"
                                          placeholder="Reason for rescheduling">{{ old('admin_note', $appointment->admin_note) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-calendar-check me-1"></i> Reschedule
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    @else

        <div class="alert alert-info">
            <i class="fa-solid fa-circle-info me-1"></i>
            This appointment is {{ $appointment->status }} and cannot be changed.
        </div>

    @endif
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('rescheduled_date');
    const timeSelect = document.getElementById('rescheduled_time');
    const message = document.getElementById('reschedule-slot-message');

    const availabilityUrl = @json(route('admin.appointments.available-slots', $appointment));

    const preferredTime = @json(
        old(
            'rescheduled_time',
            $appointment->rescheduled_time
                ? \Carbon\Carbon::parse($appointment->rescheduled_time)->format('H:i')
                : \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')
        )
    );

    async function loadAvailableSlots() {
        const date = dateInput.value;

        timeSelect.innerHTML = '<option value="">Loading available times...</option>';
        timeSelect.disabled = true;
        message.textContent = '';

        if (!date) {
            timeSelect.innerHTML = '<option value="">Select a date first</option>';
            message.textContent = 'Available times will appear after selecting a date.';
            return;
        }

        try {
            const response = await fetch(
                availabilityUrl + '?date=' + encodeURIComponent(date),
                {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Unable to load available times.');
            }

            timeSelect.innerHTML = '';

            if (!data.slots || data.slots.length === 0) {
                timeSelect.innerHTML = '<option value="">No available times</option>';
                message.textContent = data.message || 'No available slots for this date.';
                return;
            }

            timeSelect.innerHTML = '<option value="">Select an available time</option>';

            data.slots.forEach(function (slot) {
                const option = document.createElement('option');
                option.value = slot;

                const parts = slot.split(':');
                let hour = parseInt(parts[0], 10);
                const minute = parts[1];
                const period = hour >= 12 ? 'PM' : 'AM';

                hour = hour % 12 || 12;

                option.textContent = hour + ':' + minute + ' ' + period;

                if (slot === preferredTime) {
                    option.selected = true;
                }

                timeSelect.appendChild(option);
            });

            timeSelect.disabled = false;
            message.textContent = data.slots.length + ' available time(s).';

        } catch (error) {
            timeSelect.innerHTML = '<option value="">Could not load times</option>';
            message.textContent = error.message || 'Something went wrong. Please try again.';
        }
    }

    dateInput.addEventListener('change', loadAvailableSlots);

    // Load slots for the date already shown when the page opens.
    loadAvailableSlots();
});
</script>

@endsection

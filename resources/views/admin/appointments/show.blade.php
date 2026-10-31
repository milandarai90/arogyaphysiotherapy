
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

@endsection

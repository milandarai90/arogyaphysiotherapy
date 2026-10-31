@extends('layouts.app')

@section('title', 'Check Appointment Status | Arogya Physiotherapy Center')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="text-center mb-4">
                    <h1 class="fw-bold">Check Appointment Status</h1>
                    <p class="text-muted">
                        Enter your booking reference and registered phone number
                        to check your appointment.
                    </p>
                </div>

                @if(!isset($appointment))

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">

                            @if(session('lookup_error'))
                                <div class="alert alert-danger">
                                    {{ session('lookup_error') }}
                                </div>
                            @endif

                            <form action="{{ route('appointment.status.check') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Booking Reference
                                    </label>

                                    <input
                                        type="text"
                                        name="booking_reference"
                                        class="form-control form-control-lg @error('booking_reference') is-invalid @enderror"
                                        value="{{ old('booking_reference') }}"
                                        placeholder="Example: ARO-20261030-ABC123"
                                        required
                                    >

                                    @error('booking_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Registered Phone Number
                                    </label>

                                    <input
                                        type="tel"
                                        name="phone"
                                        class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                        placeholder="Enter your 10-digit phone number"
                                        maxlength="10"
                                        pattern="[0-9]{10}"
                                        inputmode="numeric"
                                        required
                                    >

                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-search me-2"></i>
                                    Check Appointment
                                </button>
                            </form>

                            <p class="text-muted small text-center mt-3 mb-0">
                                Your appointment details are accessible only when
                                both your booking reference and phone number match.
                            </p>

                        </div>
                    </div>

                @else

                    @php
                        $status = $appointment->status;

                        $statusColors = [
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            'rescheduled' => 'info',
                            'completed' => 'primary',
                            'cancelled' => 'secondary',
                        ];

                        $statusMessages = [
                            'pending' => 'Your appointment is waiting for clinic approval.',
                            'approved' => 'Your appointment has been accepted. Please arrive on time.',
                            'rejected' => 'Unfortunately, your appointment was not accepted.',
                            'rescheduled' => 'Your appointment has been rescheduled. Please check the updated details below.',
                            'completed' => 'Your appointment has been marked as completed.',
                            'cancelled' => 'This appointment has been cancelled.',
                        ];
                    @endphp

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-check fa-3x text-primary"></i>
                                </div>

                                <h3 class="fw-bold">Appointment Details</h3>

                                <span class="badge bg-{{ $statusColors[$status] ?? 'secondary' }} fs-6 mt-2">
                                    {{ ucfirst($status) }}
                                </span>

                                <p class="mt-3 mb-0">
                                    {{ $statusMessages[$status] ?? 'Please contact the clinic for more information.' }}
                                </p>
                            </div>

                            <hr>

                            <div class="row g-3">

                                <div class="col-sm-6">
                                    <small class="text-muted">Booking Reference</small>
                                    <div class="fw-bold">
                                        {{ $appointment->booking_reference }}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <small class="text-muted">Patient Name</small>
                                    <div class="fw-bold">
                                        {{ $appointment->patient_name }}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <small class="text-muted">Phone Number</small>
                                    <div class="fw-bold">
                                        {{ $appointment->phone }}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <small class="text-muted">Service</small>
                                    <div class="fw-bold">
                                        {{ $appointment->service?->name ?? 'Not available' }}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <small class="text-muted">Appointment Date</small>
                                    <div class="fw-bold">
                                        {{ \Carbon\Carbon::parse(
                                            $status === 'rescheduled' && $appointment->rescheduled_date
                                                ? $appointment->rescheduled_date
                                                : $appointment->appointment_date
                                        )->format('d M Y') }}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <small class="text-muted">Appointment Time</small>
                                    <div class="fw-bold">
                                        {{ \Carbon\Carbon::parse(
                                            $status === 'rescheduled' && $appointment->rescheduled_time
                                                ? $appointment->rescheduled_time
                                                : $appointment->appointment_time
                                        )->format('h:i A') }}
                                    </div>
                                </div>

                            </div>

                            @if($appointment->admin_note)
                                <div class="alert alert-info mt-4 mb-0">
                                    <strong>Message from the clinic:</strong><br>
                                    {{ $appointment->admin_note }}
                                </div>
                            @endif

                            <div class="text-center mt-4">
                                <a href="{{ route('appointment.status') }}"
                                   class="btn btn-outline-primary">
                                    Check Another Appointment
                                </a>
                            </div>

                        </div>
                    </div>

                @endif

            </div>
        </div>
    </div>
</section>

@endsection
@extends('layouts.app')

@section('title', 'Appointment Submitted | Arogya Physiotherapy Center')

@section('content')

<section class="section-padding bg-light-custom">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="service-card text-center">

                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success"
                           style="font-size: 65px;"></i>
                    </div>

                    <h2 class="text-success mb-3">
                        Appointment Request Submitted!
                    </h2>

                    <p class="text-muted">
                        Thank you, {{ $appointment->patient_name }}.
                        Your appointment request has been received successfully.
                    </p>

                    <div class="bg-light rounded p-4 my-4">

                        <p class="mb-2">Your Booking Reference</p>

                        <h3 class="text-primary fw-bold">
                            {{ $appointment->booking_reference }}
                        </h3>

                        <hr>

                        <div class="text-start">

                            <p>
                                <strong>Patient:</strong>
                                {{ $appointment->patient_name }}
                            </p>

                            <p>
                                <strong>Service:</strong>
                                {{ $appointment->service->name }}
                            </p>

                            <p>
                                <strong>Date:</strong>
                                {{ $appointment->appointment_date->format('d M Y') }}
                            </p>

                            <p>
                                <strong>Time:</strong>
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            </p>

                            <p class="mb-0">
                                <strong>Status:</strong>

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

                                <span class="badge bg-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </p>

                        </div>

                    </div>

                    <div class="alert alert-info text-start">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Important:</strong>
                        Please save your booking reference. You can use it along
                        with your registered phone number to check whether your
                        appointment has been accepted, rejected, or rescheduled.
                    </div>

                    <p class="text-muted">
                        Your appointment is currently subject to clinic approval.
                        Please check your appointment status on our website for updates.
                    </p>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">

                        <a href="{{ route('appointment.status') }}"
                           class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Check Appointment Status
                        </a>

                        <a href="{{ url('/') }}" class="btn-primary-custom">
                            Return to Homepage
                        </a>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

@endsection

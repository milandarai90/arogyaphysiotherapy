
@extends('layouts.app')

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
                        Your appointment request has been received.
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
                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </p>

                        </div>

                    </div>

                    <p class="text-muted">
                        Please keep your booking reference.
                        The clinic will contact you to confirm your appointment.
                    </p>

                    <a href="{{ url('/') }}" class="btn-primary-custom">
                        Return to Homepage
                    </a>

                </div>

            </div>
        </div>

    </div>
</section>

@endsection

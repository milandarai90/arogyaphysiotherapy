
@extends('layouts.app')

@section('content')

<section class="section-padding bg-light-custom">
    <div class="container">

        <div class="section-title">
            <h2>Book Your Appointment</h2>
            <p>
                Take the first step towards better movement and a healthier life.
                Complete the form below to request an appointment.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="service-card">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Please correct the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('appointment.store') }}">
                        @csrf

                        <h5 class="mb-4">Patient Information</h5>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="patient_name" class="form-label">
                                    Full Name *
                                </label>

                                <input
                                    type="text"
                                    id="patient_name"
                                    name="patient_name"
                                    class="form-control"
                                    value="{{ old('patient_name') }}"
                                    maxlength="150"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    Phone Number *
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone') }}"
                                    maxlength="20"
                                    placeholder="98XXXXXXXX"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="age" class="form-label">
                                    Age *
                                </label>

                                <input
                                    type="number"
                                    id="age"
                                    name="age"
                                    class="form-control"
                                    value="{{ old('age') }}"
                                    min="1"
                                    max="120"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="service_id" class="form-label">
                                    Physiotherapy Service *
                                </label>

                                <select
                                    id="service_id"
                                    name="service_id"
                                    class="form-select"
                                    required
                                >
                                    <option value="">Select a service</option>

                                    @foreach ($services as $service)
                                        <option
                                            value="{{ $service->id }}"
{{ old('service_id', $selectedServiceId ?? '') == $service->id ? 'selected' : '' }}                                        >
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($services->isEmpty())
                                    <small class="text-danger">
                                        No services are currently available.
                                        Please contact the clinic.
                                    </small>
                                @endif
                            </div>

                        </div>

                        <hr class="my-4">

                        <h5 class="mb-4">Appointment Details</h5>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="appointment_date" class="form-label">
                                    Preferred Date *
                                </label>

                                <input
                                    type="date"
                                    id="appointment_date"
                                    name="appointment_date"
                                    class="form-control"
                                    value="{{ old('appointment_date') }}"
                                    min="{{ now()->toDateString() }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="appointment_time" class="form-label">
                                    Preferred Time *
                                </label>

                                <input
                                    type="time"
                                    id="appointment_time"
                                    name="appointment_time"
                                    class="form-control"
                                    value="{{ old('appointment_time') }}"
                                    required
                                >

                                <small class="text-muted">
                                    Your requested time will be confirmed by the clinic.
                                </small>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="symptoms" class="form-label">
                                Symptoms / Health Concerns
                            </label>

                            <textarea
                                id="symptoms"
                                name="symptoms"
                                class="form-control"
                                rows="3"
                                maxlength="2000"
                                placeholder="Briefly describe your pain, injury or condition..."
                            >{{ old('symptoms') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="patient_message" class="form-label">
                                Additional Message
                            </label>

                            <textarea
                                id="patient_message"
                                name="patient_message"
                                class="form-control"
                                rows="3"
                                maxlength="2000"
                                placeholder="Any additional information..."
                            >{{ old('patient_message') }}</textarea>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Submitting this form sends an appointment request.
                            Your appointment is not confirmed until the clinic
                            approves it.
                        </div>

                        <button
                            type="submit"
                            class="btn-primary-custom border-0 w-100"
                            @disabled($services->isEmpty())
                        >
                            <i class="fas fa-calendar-check me-2"></i>
                            Submit Appointment Request
                        </button>

                    </form>

                </div>

            </div>
        </div>

    </div>
</section>

@endsection


@extends('layouts.app')

@section('title', 'Book an Appointment | Aarogya Physiotherapy Center')

@section('content')

<section class="section-padding bg-light-custom appointment-create-section">
    <div class="container">

        <div class="section-title appointment-page-heading text-center">
            <h2>Book Your Appointment</h2>
            <p>
                Take the first step towards better movement and a healthier life.
                Complete the form below to request an appointment.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="service-card appointment-form-card">

                    @if ($errors->any())
                        <div class="alert alert-danger appointment-validation-alert">
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

                        <h5 class="appointment-form-heading mb-4">
                            <i class="fas fa-user me-2"></i>
                            Patient Information
                        </h5>

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
                                            {{ old('service_id', $selectedServiceId ?? '') == $service->id ? 'selected' : '' }}
                                        >
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

                            <div class="col-md-6 mb-3">
    <label for="branch_id" class="form-label">
        Select Branch *
    </label>

    <select
        id="branch_id"
        name="branch_id"
        class="form-select"
        required
    >
        <option value="">Select a branch</option>

        @foreach ($branches as $branch)
            <option
                value="{{ $branch->id }}"
                {{ old('branch_id') == $branch->id ? 'selected' : '' }}
            >
                {{ $branch->name }}
                {{ $branch->is_main ? '(Main Branch)' : '' }}
            </option>
        @endforeach
    </select>

    @if ($branches->isEmpty())
        <small class="text-danger">
            No branches are currently available for booking.
        </small>
    @endif
</div>

                        </div>

                        <hr class="my-4">

                        <h5 class="appointment-form-heading mb-4">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Appointment Details
                        </h5>

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

                                <small class="text-muted appointment-field-message" id="date-message">
                                    Select a date to see available appointment times.
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="appointment_time" class="form-label">
                                    Available Time Slots *
                                </label>

                                <select
                                    id="appointment_time"
                                    name="appointment_time"
                                    class="form-select"
                                    required
                                    disabled
                                >
                                    <option value="">Select a date first</option>
                                </select>

                                <small class="text-muted appointment-field-message" id="time-message">
                                    Available slots will appear here.
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

                        <div class="alert alert-info appointment-notice">
                            <i class="fas fa-info-circle me-2"></i>
                            Submitting this form sends an appointment request.
                            Your appointment is not confirmed until the clinic
                            approves it.
                        </div>

                        <button
                            type="submit"
                            class="btn-primary-custom appointment-submit-button border-0 w-100"
@disabled($services->isEmpty() || $branches->isEmpty())                        >
                            <i class="fas fa-calendar-check me-2"></i>
                            Submit Appointment Request
                        </button>

                    </form>

                </div>

            </div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const branchInput = document.getElementById('branch_id');
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');
    const dateMessage = document.getElementById('date-message');
    const timeMessage = document.getElementById('time-message');

    const oldTime = @json(old('appointment_time'));

    function resetSlots(message) {
        timeSelect.innerHTML = '<option value="">Select a date and branch first</option>';
        timeSelect.disabled = true;
        timeMessage.textContent = message;
    }

    async function loadSlots() {
        const branchId = branchInput.value;
        const date = dateInput.value;

        if (!branchId || !date) {
            resetSlots('Select a branch and date to see available times.');
            return;
        }

        timeSelect.innerHTML = '<option value="">Loading available times...</option>';
        timeSelect.disabled = true;
        dateMessage.textContent = 'Checking branch availability...';
        timeMessage.textContent = 'Please wait...';

        try {
            const url = new URL(
                @json(route('appointment.available-slots')),
                window.location.origin
            );

            url.searchParams.set('branch_id', branchId);
            url.searchParams.set('date', date);

            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Unable to load available times.');
            }

            timeSelect.innerHTML = '';

            if (!data.available || !data.slots.length) {
                timeSelect.innerHTML = '<option value="">No available slots</option>';
                timeSelect.disabled = true;
                dateMessage.textContent = data.message;
                timeMessage.textContent = 'Please select another date or branch.';
                return;
            }

            timeSelect.innerHTML = '<option value="">Select a time</option>';

            data.slots.forEach(function (slot) {
                const option = document.createElement('option');
                option.value = slot.value;
                option.textContent = slot.label;

                if (oldTime && oldTime === slot.value) {
                    option.selected = true;
                }

                timeSelect.appendChild(option);
            });

            timeSelect.disabled = false;
            dateMessage.textContent = 'This branch is open on this date.';
            timeMessage.textContent = data.message;

        } catch (error) {
            resetSlots('Unable to load appointment times. Please try again.');
            dateMessage.textContent = 'Availability check failed.';
            console.error(error);
        }
    }

    branchInput.addEventListener('change', loadSlots);
    dateInput.addEventListener('change', loadSlots);

    if (branchInput.value && dateInput.value) {
        loadSlots();
    }
});
</script>

@endsection

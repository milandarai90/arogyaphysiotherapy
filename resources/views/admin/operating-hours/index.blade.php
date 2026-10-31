@extends('admin.layouts.app')

@section('title', 'Operating Hours')
@section('page-title', 'Operating Hours & Holidays')
@section('page-description', 'Manage clinic opening times and upcoming closures.')

@section('content')

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert alert-danger">
        <strong><i class="fas fa-exclamation-circle me-2"></i>Please correct the following:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Weekly Operating Hours --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">

    <div class="card-header bg-white border-0 p-3">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-clock text-primary me-2"></i>
            Weekly Operating Hours
        </h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('admin.operating-hours.update') }}">
            @csrf
            @method('PUT')

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Opening Time</th>
                            <th>Closing Time</th>
                            <th>Closed</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($days as $day)
                            @php
                                $hour = $hours->get($day);
                                $closed = old("hours.$day.is_closed", $hour?->is_closed ?? false);
                            @endphp

                            <tr>
                                <td class="fw-semibold">
                                    {{ $day }}
                                </td>

                                <td>
                                    <input
                                        type="time"
                                        name="hours[{{ $day }}][opening_time]"
                                        class="form-control"
                                        value="{{ old("hours.$day.opening_time", $hour?->opening_time ? substr($hour->opening_time, 0, 5) : '09:00') }}"
                                        {{ $closed ? 'disabled' : '' }}
                                    >
                                    @error("hours.$day.opening_time")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>

                                <td>
                                    <input
                                        type="time"
                                        name="hours[{{ $day }}][closing_time]"
                                        class="form-control"
                                        value="{{ old("hours.$day.closing_time", $hour?->closing_time ? substr($hour->closing_time, 0, 5) : '17:00') }}"
                                        {{ $closed ? 'disabled' : '' }}
                                    >
                                    @error("hours.$day.closing_time")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>

                                <td>
                                    <input
                                        type="hidden"
                                        name="hours[{{ $day }}][is_closed]"
                                        value="0"
                                    >

                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            name="hours[{{ $day }}][is_closed]"
                                            value="1"
                                            class="form-check-input closed-checkbox"
                                            {{ $closed ? 'checked' : '' }}
                                        >

                                        <label class="form-check-label">
                                            Closed
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>
                Save Operating Hours
            </button>

        </form>

    </div>
</div>


{{-- Add Holiday / Closure --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">

    <div class="card-header bg-white border-0 p-3">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-calendar-plus text-success me-2"></i>
            Add Holiday / Closure
        </h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('admin.holidays.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Holiday Name <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        required
                        placeholder="e.g. Dashain Holiday"
                    >

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Holiday Date <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="holiday_date"
                        class="form-control @error('holiday_date') is-invalid @enderror"
                        value="{{ old('holiday_date') }}"
                        min="{{ now()->toDateString() }}"
                        required
                    >

                    @error('holiday_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-semibold">
                        Description
                    </label>

                    <input
                        type="text"
                        name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        value="{{ old('description') }}"
                        placeholder="Optional information"
                    >

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <button type="submit" class="btn btn-success mt-3">
                <i class="fas fa-plus me-2"></i>
                Add Holiday
            </button>

        </form>

    </div>
</div>


{{-- Upcoming Holidays --}}
<div class="card border-0 shadow-sm rounded-3">

    <div class="card-header bg-white border-0 p-3">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-calendar-alt text-primary me-2"></i>
            Upcoming Holidays
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Holiday</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($holidays as $holiday)
                        <tr>
                            <td class="fw-semibold">
                                {{ $holiday->title }}
                            </td>

                            <td>
                                {{ $holiday->holiday_date->format('d M Y') }}
                            </td>

                            <td>
                                {{ $holiday->description ?: '—' }}
                            </td>

                            <td class="text-end">
                                <form
                                    method="POST"
                                    action="{{ route('admin.holidays.destroy', $holiday) }}"
                                    onsubmit="return confirm('Delete this holiday?')"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Delete holiday"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                                No holidays added yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $holidays->links() }}
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.closed-checkbox').forEach(function (checkbox) {

    function updateTimeFields() {
        const row = checkbox.closest('tr');

        row.querySelectorAll('input[type="time"]').forEach(function (input) {
            input.disabled = checkbox.checked;
        });
    }

    checkbox.addEventListener('change', updateTimeFields);

    updateTimeFields();
});
</script>
@endpush

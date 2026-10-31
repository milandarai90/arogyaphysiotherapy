
@extends('admin.layouts.app')

@section('title', 'Appointments')
@section('page-title', 'Appointments')
@section('page-description', 'View and manage patient appointment requests.')

@section('page-actions')
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
    </a>
@endsection

@section('content')

    <div class="card table-card">

        <div class="card-header bg-white border-0 p-3">
            <form method="GET" action="{{ route('admin.appointments.index') }}">
                <div class="row g-2 align-items-end">

                    <div class="col-md-5">
                        <label class="form-label">Search appointments</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Reference, patient name or phone"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Filter by status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach(['pending', 'approved', 'rejected', 'rescheduled', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-search me-1"></i> Search
                        </button>

                        <a href="{{ route('admin.appointments.index') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Reference</th>
                            <th>Patient</th>
                            <th>Phone</th>
                            <th>Service</th>
                            <th>Appointment Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($appointments as $appointment)

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

                            <tr>
                                <td class="ps-3 fw-semibold">
                                    {{ $appointment->booking_reference }}
                                </td>

                                <td>{{ $appointment->patient_name }}</td>

                                <td>{{ $appointment->phone }}</td>

                                <td>{{ $appointment->service->name ?? 'N/A' }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </td>

                                <td>
                                    <span class="badge text-bg-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <a href="{{ route('admin.appointments.show', $appointment) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-calendar-xmark fa-2x mb-2"></i>
                                    <p class="mb-0">No appointments found.</p>
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

        @if($appointments->hasPages())
            <div class="card-footer bg-white border-0 p-3">
                {{ $appointments->withQueryString()->links() }}
            </div>
        @endif

    </div>

@endsection

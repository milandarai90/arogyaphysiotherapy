
@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Welcome back, ' . auth()->user()->name)

@section('content')

    {{-- Statistics --}}
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Appointments</p>
                        <h3 class="fw-bold mb-0">{{ $totalAppointments }}</h3>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pending Requests</p>
                        <h3 class="fw-bold mb-0">{{ $pendingAppointments }}</h3>
                    </div>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Approved</p>
                        <h3 class="fw-bold mb-0">{{ $approvedAppointments }}</h3>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Today's Appointments</p>
                        <h3 class="fw-bold mb-0">{{ $todayAppointments }}</h3>
                    </div>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Appointments --}}
    <div class="card table-card">

        <div class="card-header bg-white border-0 p-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Recent Appointment Requests</h5>

            <a href="{{ route('admin.appointments.index') }}"
               class="btn btn-sm btn-outline-primary">
                View All <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Reference</th>
                            <th>Patient</th>
                            <th>Phone</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentAppointments as $appointment)

                            <tr>
                                <td class="ps-3 fw-semibold">
                                    {{ $appointment->booking_reference }}
                                </td>

                                <td>{{ $appointment->patient_name }}</td>

                                <td>{{ $appointment->phone }}</td>

                                <td>{{ $appointment->service->name ?? 'N/A' }}</td>

                                <td>
                                    {{ $appointment->appointment_date->format('d M Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </td>

                                <td>
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
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-calendar-xmark fa-2x mb-2"></i>
                                    <p class="mb-0">No appointment requests found.</p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection

 @extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Welcome back, ' . auth()->user()->name)

@section('content')

    {{-- Appointment Statistics --}}
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Appointments</p>
                        <h3 class="fw-bold mb-0">{{ number_format($totalAppointments) }}</h3>
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
                        <h3 class="fw-bold mb-0">{{ number_format($pendingAppointments) }}</h3>
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
                        <h3 class="fw-bold mb-0">{{ number_format($approvedAppointments) }}</h3>
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
                        <h3 class="fw-bold mb-0">{{ number_format($todayAppointments) }}</h3>
                    </div>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Website Visitor Statistics --}}
    <div class="mb-3">
        <h5 class="fw-bold mb-1">Website Analytics</h5>
        <p class="text-muted small mb-0">Visitor activity across your public website.</p>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Page Visits</p>
                        <h3 class="fw-bold mb-0">{{ number_format($totalVisits) }}</h3>
                        <small class="text-muted">All-time visits</small>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Unique Visitors</p>
                        <h3 class="fw-bold mb-0">{{ number_format($uniqueVisitors) }}</h3>
                        <small class="text-muted">Distinct browsers</small>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Today's Visits</p>
                        <h3 class="fw-bold mb-0">{{ number_format($todayVisits) }}</h3>
                        <small class="text-muted">
                            {{ number_format($todayUniqueVisitors) }} unique visitors
                        </small>
                    </div>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">This Month</p>
                        <h3 class="fw-bold mb-0">{{ number_format($monthlyVisits) }}</h3>
                        <small class="text-muted">
                            Yesterday: {{ number_format($yesterdayVisits) }}
                        </small>
                    </div>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="fa-solid fa-calendar-week"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Daily Visitor Chart --}}
    <div class="card table-card mb-4">
        <div class="card-header bg-white border-0 p-3">
            <h5 class="fw-bold mb-0">Visitor Activity</h5>
            <small class="text-muted">Daily visits and unique visitors over the last 30 days</small>
        </div>

        <div class="card-body">
            <div style="height: 320px; position: relative;">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Most Visited Pages --}}
    <div class="card table-card mb-4">

        <div class="card-header bg-white border-0 p-3">
            <h5 class="fw-bold mb-0">Most Visited Pages</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Page</th>
                            <th>Total Visits</th>
                            <th>Unique Visitors</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($popularPages as $page)
                            <tr>
                                <td class="ps-3 fw-semibold">
                                    {{ $page->page_path === '/' ? 'Homepage' : $page->page_path }}
                                </td>
                                <td>{{ number_format($page->total_visits) }}</td>
                                <td>{{ number_format($page->unique_visitors) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    No visitor data available yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('visitorChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {
        type: 'line',

        data: {
            labels: @json($chartLabels),

            datasets: [
                {
                    label: 'Page Visits',
                    data: @json($chartVisits),
                    borderColor: '#244A9A',
                    backgroundColor: 'rgba(36, 74, 154, 0.10)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2
                },
                {
                    label: 'Unique Visitors',
                    data: @json($chartUniqueVisitors),
                    borderColor: '#D92535',
                    backgroundColor: 'rgba(217, 37, 53, 0.08)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            interaction: {
                intersect: false,
                mode: 'index'
            },

            plugins: {
                legend: {
                    position: 'top'
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>
@endpush
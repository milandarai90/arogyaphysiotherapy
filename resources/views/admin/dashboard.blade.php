
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | Arogya Physiotherapy Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #173f78;
            color: white;
            padding: 25px 18px;
        }

        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: #dce8fa;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 7px;
            margin-bottom: 8px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: rgba(255,255,255,.15);
            color: white;
        }

        .main-content {
            padding: 30px;
        }

        .stat-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,.05);
            height: 100%;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 20px;
        }

        .table-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,.05);
        }

        .table th {
            font-size: 13px;
            color: #667085;
            font-weight: 600;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        @media(max-width: 767px) {
            .sidebar {
                min-height: auto;
            }

            .main-content {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <aside class="col-md-3 col-lg-2 sidebar">

            <h4>
                <i class="fa-solid fa-heart-pulse me-2"></i>
                AROGYA
            </h4>

            <a href="{{ route('admin.dashboard') }}" class="active">
                <i class="fa-solid fa-gauge-high me-2"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.appointments.index') }}">
    <i class="fa-solid fa-calendar-check me-2"></i>
    Appointments
</a>

           <a href="{{ route('admin.services.index') }}">
    <i class="fa-solid fa-stethoscope me-2"></i>
    Services
</a>
       <a href="{{ route('admin.gallery.index') }}">
    <i class="fa-solid fa-images me-2"></i>
    Gallery
</a>

            <a href="#">
                <i class="fa-solid fa-newspaper me-2"></i>
                Blog
            </a>

            <a href="#">
                <i class="fa-solid fa-gear me-2"></i>
                Settings
            </a>

            <hr class="border-light">

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf

                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                    Logout
                </button>
            </form>

        </aside>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 main-content">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>
                    <h3 class="fw-bold mb-1">Dashboard</h3>
                    <p class="text-muted mb-0">
                        Welcome back, {{ auth()->user()->name }}
                    </p>
                </div>

                <div class="text-muted">
                    <i class="fa-regular fa-calendar me-2"></i>
                    {{ now()->format('d M Y') }}
                </div>

            </div>

            <!-- Statistics -->
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

            <!-- Recent Appointments -->
            <div class="card table-card">

                <div class="card-header bg-white border-0 p-3">
                    <h5 class="fw-bold mb-0">Recent Appointment Requests</h5>
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

            <p class="text-center text-muted small mt-4">
                © {{ date('Y') }} Arogya Physiotherapy Center. All rights reserved.
            </p>

        </main>

    </div>
</div>

</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointments | Arogya Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .page-card { border: 0; border-radius: 12px; }
        .table th { font-size: 13px; color: #667085; white-space: nowrap; }
        .table td { vertical-align: middle; font-size: 14px; }
    </style>
</head>
<body>

<div class="container-fluid py-4 px-3 px-lg-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Appointments</h3>
            <p class="text-muted mb-0">Manage patient appointment requests</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
            <i class="fa-solid fa-arrow-left me-2"></i>Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card page-card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.appointments.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Search appointments</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Patient name, phone or booking reference"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Filter by status</label>
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            @foreach(['pending', 'approved', 'rejected', 'rescheduled', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1">
                            <i class="fa-solid fa-search me-1"></i> Search
                        </button>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card page-card shadow-sm">
        <div class="card-header bg-white p-3">
            <strong>Appointment Records</strong>
            <span class="text-muted small ms-2">
                {{ $appointments->total() }} records
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Reference</th>
                        <th>Patient</th>
                        <th>Phone</th>
                        <th>Service</th>
                        <th>Appointment Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        @php
                            $colors = [
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
                            <td>{{ $appointment->appointment_date->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            <td>
                                <span class="badge text-bg-{{ $colors[$appointment->status] ?? 'secondary' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.appointments.show', $appointment) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                No appointments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $appointments->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
</body>
</html>

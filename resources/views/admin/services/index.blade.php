
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Services | Arogya Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .page-card { border: 0; border-radius: 12px; }
        .table td, .table th { vertical-align: middle; }
        .table th { font-size: 13px; color: #667085; white-space: nowrap; }
    </style>
</head>
<body>
<div class="container-fluid py-4 px-3 px-lg-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Service Management</h3>
            <p class="text-muted mb-0">Manage the treatments offered by your clinic.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                + Add Service
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card page-card shadow-sm">
        <div class="card-header bg-white p-3">
            <strong>All Services</strong>
            <span class="text-muted small ms-2">{{ $services->total() }} services</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Service Name</th>
                        <th>Price (NPR)</th>
                        <th>Duration</th>
                        <th>Appointments</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="ps-3">
                                <strong>{{ $service->name }}</strong>
                                <div class="text-muted small">
                                    {{ \Illuminate\Support\Str::limit($service->description, 75) }}
                                </div>
                            </td>
                            <td>{{ $service->price !== null ? 'Rs. ' . number_format((float) $service->price, 2) : 'Not set' }}</td>
                            <td>{{ $service->duration_minutes ? $service->duration_minutes . ' min' : 'Not set' }}</td>
                            <td>{{ $service->appointments_count }}</td>
                            <td>
                                @if($service->is_active)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="btn btn-sm btn-outline-primary">Edit</a>

                                    <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-warning">
                                            {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    @if($service->appointments_count === 0)
                                        <form method="POST"
                                              action="{{ route('admin.services.destroy', $service) }}"
                                              onsubmit="return confirm('Permanently delete this service?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                No services have been added.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
</body>
</html>

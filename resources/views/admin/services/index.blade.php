
@extends('admin.layouts.app')

@section('title', 'Service Management')
@section('page-title', 'Service Management')
@section('page-description', 'Manage the treatments offered by your clinic.')

@section('page-actions')
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Add Service
    </a>
@endsection

@section('content')

    <div class="card table-card">

        <div class="card-header bg-white border-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">All Services</h5>
                <span class="text-muted small">{{ $services->total() }} services</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

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

                            <td>
                                {{ $service->price !== null
                                    ? 'Rs. ' . number_format((float) $service->price, 2)
                                    : 'Not set' }}
                            </td>

                            <td>
                                {{ $service->duration_minutes
                                    ? $service->duration_minutes . ' min'
                                    : 'Not set' }}
                            </td>

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
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen me-1"></i> Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.services.toggle', $service) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-sm btn-outline-warning">
                                            <i class="fa-solid fa-power-off me-1"></i>
                                            {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    @if($service->appointments_count === 0)
                                        <form method="POST"
                                              action="{{ route('admin.services.destroy', $service) }}"
                                              onsubmit="return confirm('Permanently delete this service?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fa-solid fa-hand-holding-medical fa-2x mb-2"></i>
                                <p class="mb-0">No services have been added.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if($services->hasPages())
            <div class="card-footer bg-white border-0 p-3">
                {{ $services->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

@endsection

@extends('admin.layouts.app')

@section('title', 'Branch Management')
@section('page-title', 'Branch Management')
@section('page-description', 'Manage your clinic branches and locations.')

@section('page-actions')
    <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Add Branch
    </a>
@endsection

@section('content')

    <div class="card table-card">

        <div class="card-header bg-white border-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">All Branches</h5>
                <span class="text-muted small">{{ $branches->total() }} branches</span>
            </div>
        </div>



        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Branch</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th>Main Branch</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($branches as $branch)

                        <tr>
                            <td class="ps-3">
                                <strong>{{ $branch->name }}</strong>

                                @if($branch->image)
                                    <div class="small text-muted mt-1">
                                        <i class="fa-solid fa-image me-1"></i> Image uploaded
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if($branch->phone)
                                    <div>
                                        <i class="fa-solid fa-phone text-muted me-1"></i>
                                        {{ $branch->phone }}
                                    </div>
                                @endif

                                @if($branch->email)
                                    <div class="small text-muted">
                                        {{ $branch->email }}
                                    </div>
                                @endif

                                @if(!$branch->phone && !$branch->email)
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>

                            <td>
                                {{ $branch->city ?: '—' }}

                                @if($branch->district)
                                    <div class="small text-muted">
                                        {{ $branch->district }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if($branch->is_main)
                                    <span class="badge text-bg-primary">
                                        <i class="fa-solid fa-star me-1"></i> Main
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                @if($branch->is_active)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex flex-wrap gap-1">

                                    <a href="{{ route('admin.branches.edit', $branch) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen me-1"></i> Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.branches.toggle', $branch) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-sm btn-outline-warning">
                                            <i class="fa-solid fa-power-off me-1"></i>
                                            {{ $branch->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('admin.branches.destroy', $branch) }}"
                                          onsubmit="return confirm('Permanently delete this branch?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash me-1"></i> Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fa-solid fa-location-dot fa-2x mb-2"></i>
                                <p class="mb-0">No branches have been added yet.</p>
                                <a href="{{ route('admin.branches.create') }}"
                                   class="btn btn-sm btn-primary mt-3">
                                    <i class="fa-solid fa-plus me-1"></i> Add First Branch
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if($branches->hasPages())
            <div class="card-footer bg-white border-0 p-3">
                {{ $branches->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

@endsection
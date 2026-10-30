
@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Therapists & Staff</h2>
            <p class="text-muted mb-0">Manage your clinic team profiles.</p>
        </div>

        <a href="{{ route('admin.therapists.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Profile
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Please check the submitted information.
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.therapists.index') }}">
                <div class="row g-2">
                    <div class="col-md-7">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by name, designation or specialization..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Profiles</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-outline-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Profile</th>
                        <th>Qualification</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($therapists as $therapist)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($therapist->photo)
                                        <img
                                            src="{{ asset('storage/'.$therapist->photo) }}"
                                            alt="{{ $therapist->name }}"
                                            width="55"
                                            height="55"
                                            class="rounded-circle"
                                            style="object-fit:cover;"
                                        >
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                             style="width:55px;height:55px;">
                                            <i class="fas fa-user text-secondary fa-lg"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">{{ $therapist->name }}</div>
                                        <small class="text-muted">{{ $therapist->designation ?: 'Team Member' }}</small>
                                        @if($therapist->specialization)
                                            <br><small class="text-muted">{{ $therapist->specialization }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>{{ $therapist->qualification ?: '—' }}</td>

                            <td>{{ $therapist->experience_years }} years</td>

                            <td>
                                @if($therapist->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('admin.therapists.edit', $therapist) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.therapists.toggle', $therapist) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-warning"
                                            title="Change status">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.therapists.destroy', $therapist) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this profile?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                No therapist or staff profiles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($therapists->hasPages())
            <div class="card-footer bg-white">
                {{ $therapists->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

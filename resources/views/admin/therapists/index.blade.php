@extends('admin.layouts.app')

@section('title', 'Therapists & Staff')

@section('page-title', 'Therapists & Staff')

@section('page-description', 'Manage your clinic team profiles.')

@section('page-actions')
    <a href="{{ route('admin.therapists.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Add New Profile
    </a>
@endsection

@section('content')

{{-- Search and Filter --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">

        <form method="GET" action="{{ route('admin.therapists.index') }}">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Search Team Members</label>
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Name, designation or specialization..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Profile Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Profiles</option>
                        <option value="active" @selected(request('status') === 'active')>
                            Active
                        </option>
                        <option value="inactive" @selected(request('status') === 'inactive')>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>

                    <a href="{{ route('admin.therapists.index') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </div>
</div>

{{-- Team Table --}}
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white border-0 p-3">
        <h5 class="fw-bold mb-0">Team Members</h5>
    </div>

    <div class="table-responsive">

        <table class="table align-middle table-hover mb-0">

            <thead class="table-light">
                <tr>
                    <th class="ps-3">Profile</th>
                    <th>Qualification</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($therapists as $therapist)

                    <tr>

                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-3">

                                @if($therapist->photo)
                                    <img src="{{ asset('storage/'.$therapist->photo) }}"
                                         alt="{{ $therapist->name }}"
                                         width="55" height="55"
                                         class="rounded-circle"
                                         style="object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                         style="width:55px;height:55px;flex-shrink:0;">
                                        <i class="fas fa-user text-secondary fa-lg"></i>
                                    </div>
                                @endif

                                <div>
                                    <div class="fw-semibold">{{ $therapist->name }}</div>

                                    <small class="text-muted">
                                        {{ $therapist->designation ?: 'Team Member' }}
                                    </small>

                                    @if($therapist->specialization)
                                        <br>
                                        <small class="text-muted">
                                            {{ $therapist->specialization }}
                                        </small>
                                    @endif
                                </div>

                            </div>
                        </td>

                        <td>{{ $therapist->qualification ?: '—' }}</td>

                        <td>
                            {{ $therapist->experience_years }} years
                        </td>

                        <td>
                            @if($therapist->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>

                        <td class="text-end pe-3">

                            <div class="d-inline-flex flex-wrap justify-content-end gap-1">

                                <a href="{{ route('admin.therapists.edit', $therapist) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Edit Profile">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.therapists.toggle', $therapist) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Change status">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.therapists.destroy', $therapist) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this profile?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete Profile">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-users fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">
                                No therapist or staff profiles found.
                            </p>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($therapists->hasPages())
        <div class="card-footer bg-white border-0 p-3">
            {{ $therapists->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>

@endsection
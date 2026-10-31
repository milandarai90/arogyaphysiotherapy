@extends('admin.layouts.app')

@section('title', 'Patient Testimonials')

@section('page-title', 'Patient Testimonials')

@section('page-description', 'Manage patient feedback and reviews.')

@section('page-actions')
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Add Testimonial
    </a>
@endsection

@section('content')

{{-- Search and Filter --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">

        <form method="GET" action="{{ route('admin.testimonials.index') }}">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Search Testimonials</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search patient or message..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Publication Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Testimonials</option>
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

                    <a href="{{ route('admin.testimonials.index') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </div>
</div>

{{-- Testimonials Table --}}
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white border-0 p-3">
        <h5 class="fw-bold mb-0">Patient Reviews</h5>
    </div>

    <div class="table-responsive">

        <table class="table align-middle table-hover mb-0">

            <thead class="table-light">
                <tr>
                    <th class="ps-3">Patient</th>
                    <th>Review</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($testimonials as $testimonial)

                    <tr>

                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">

                                @if($testimonial->photo)
                                    <img src="{{ asset('storage/'.$testimonial->photo) }}"
                                         alt="{{ $testimonial->patient_name }}"
                                         width="45" height="45"
                                         class="rounded-circle"
                                         style="object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                         style="width:45px;height:45px;flex-shrink:0;">
                                        <i class="fas fa-user text-secondary"></i>
                                    </div>
                                @endif

                                <div>
                                    <strong>{{ $testimonial->patient_name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $testimonial->designation ?: 'Patient' }}
                                    </small>
                                </div>

                            </div>
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($testimonial->message, 80) }}
                        </td>

                        <td>
                            <div class="text-warning text-nowrap">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? '' : 'text-secondary opacity-25' }}"></i>
                                @endfor
                            </div>
                        </td>

                        <td>
                            @if($testimonial->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>

                        <td class="text-end pe-3">

                            <div class="d-inline-flex flex-wrap justify-content-end gap-1">

                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.testimonials.toggle', $testimonial) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Toggle status">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this testimonial?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-comments fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No testimonials found.</p>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($testimonials->hasPages())
        <div class="card-footer bg-white border-0 p-3">
            {{ $testimonials->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>

@endsection
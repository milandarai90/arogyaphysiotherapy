
@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Patient Testimonials</h2>
            <p class="text-muted">Manage patient feedback and reviews.</p>
        </div>

        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Testimonial
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.testimonials.index') }}">
                <div class="row g-2">
                    <div class="col-md-7">
                        <input type="text" name="search" class="form-control"
                               placeholder="Search patient or message..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Testimonials</option>
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
                        <th>Patient</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($testimonial->photo)
                                        <img src="{{ asset('storage/'.$testimonial->photo) }}"
                                             width="45" height="45"
                                             class="rounded-circle"
                                             style="object-fit:cover;">
                                    @endif

                                    <div>
                                        <strong>{{ $testimonial->patient_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $testimonial->designation }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ \Illuminate\Support\Str::limit($testimonial->message, 80) }}</td>

                            <td class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? '' : 'text-secondary opacity-25' }}"></i>
                                @endfor
                            </td>

                            <td>
                                @if($testimonial->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.testimonials.toggle', $testimonial) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-warning" title="Toggle status">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this testimonial?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                No testimonials found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white">
            {{ $testimonials->links() }}
        </div>
    </div>

</div>
@endsection

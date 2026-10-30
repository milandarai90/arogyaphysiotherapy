
@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Add Testimonial</h2>

        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('admin.testimonials.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Patient Name *</label>
                        <input type="text" name="patient_name" class="form-control"
                               value="{{ old('patient_name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Designation / Short Description</label>
                        <input type="text" name="designation" class="form-control"
                               placeholder="e.g. Patient"
                               value="{{ old('designation') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Testimonial *</label>
                        <textarea name="message" class="form-control" rows="5"
                                  required>{{ old('message') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Rating *</label>
                        <select name="rating" class="form-select" required>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               min="0" value="{{ old('sort_order', 0) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Patient Photo (Optional)</label>
                        <input type="file" name="photo" class="form-control"
                               accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Maximum 5 MB.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label d-block">Publication Status</label>
                        <div class="form-check form-switch mt-2">
                            <input type="checkbox" name="is_active" value="1"
                                   class="form-check-input" id="is_active"
                                   {{ old('is_active', '1') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active — display publicly
                            </label>
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Save Testimonial
                </button>

                <a href="{{ route('admin.testimonials.index') }}"
                   class="btn btn-light ms-2">Cancel</a>

            </form>

        </div>
    </div>
</div>
@endsection

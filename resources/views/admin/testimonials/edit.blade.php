
@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Testimonial</h2>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Back</a>
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

            <form action="{{ route('admin.testimonials.update', $testimonial) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Patient Name *</label>
                        <input type="text" name="patient_name" class="form-control"
                               value="{{ old('patient_name', $testimonial->patient_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Designation / Short Description</label>
                        <input type="text" name="designation" class="form-control"
                               value="{{ old('designation', $testimonial->designation) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Testimonial *</label>
                        <textarea name="message" class="form-control" rows="5" required>{{ old('message', $testimonial->message) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Rating *</label>
                        <select name="rating" class="form-select" required>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}"
                                    {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                    {{ $i }} Stars
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               min="0" value="{{ old('sort_order', $testimonial->sort_order) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Patient Photo</label>

                        @if($testimonial->photo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$testimonial->photo) }}"
                                     width="100" height="100"
                                     class="rounded-circle" style="object-fit:cover;">
                            </div>
                        @endif

                        <input type="file" name="photo" class="form-control"
                               accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Upload a new photo to replace the current one. Maximum 5 MB.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label d-block">Publication Status</label>
                        <div class="form-check form-switch mt-2">
                            <input type="checkbox" name="is_active" value="1"
                                   class="form-check-input" id="is_active"
                                   {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active — display publicly
                            </label>
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Update Testimonial
                </button>

                <a href="{{ route('admin.testimonials.index') }}"
                   class="btn btn-light ms-2">Cancel</a>

            </form>
        </div>
    </div>
</div>
@endsection

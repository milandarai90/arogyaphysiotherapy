@extends('admin.layouts.app')

@section('title', 'Add Testimonial')

@section('page-title', 'Add Testimonial')

@section('page-description', 'Add patient feedback and reviews to your website.')

@section('page-actions')
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Testimonials
    </a>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-10">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.testimonials.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Patient Name *</label>
                            <input type="text" name="patient_name"
                                   class="form-control @error('patient_name') is-invalid @enderror"
                                   value="{{ old('patient_name') }}" required>
                            @error('patient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Designation / Short Description</label>
                            <input type="text" name="designation"
                                   class="form-control @error('designation') is-invalid @enderror"
                                   placeholder="e.g. Patient"
                                   value="{{ old('designation') }}">
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Testimonial *</label>
                            <textarea name="message"
                                      class="form-control @error('message') is-invalid @enderror"
                                      rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rating *</label>
                            <select name="rating"
                                    class="form-select @error('rating') is-invalid @enderror"
                                    required>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}"
                                        @selected(old('rating', 5) == $i)>
                                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Display Order</label>
                            <input type="number" name="sort_order"
                                   class="form-control @error('sort_order') is-invalid @enderror"
                                   min="0"
                                   value="{{ old('sort_order', 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Patient Photo (Optional)</label>
                            <input type="file" name="photo"
                                   class="form-control @error('photo') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">JPG, PNG or WebP. Maximum 5 MB.</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">Publication Status</label>

                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="is_active" value="1"
                                       class="form-check-input" id="is_active"
                                       @checked(old('is_active', '1'))>

                                <label class="form-check-label" for="is_active">
                                    Active — display publicly
                                </label>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Save Testimonial
                        </button>

                        <a href="{{ route('admin.testimonials.index') }}"
                           class="btn btn-outline-secondary px-4">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
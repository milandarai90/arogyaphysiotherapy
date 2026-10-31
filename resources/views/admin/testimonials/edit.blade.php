@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('page-title', 'Edit Testimonial')

@section('page-description')
    Update the testimonial from {{ $testimonial->patient_name }}.
@endsection

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

                <form action="{{ route('admin.testimonials.update', $testimonial) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Patient Name *</label>
                            <input type="text" name="patient_name"
                                   class="form-control @error('patient_name') is-invalid @enderror"
                                   value="{{ old('patient_name', $testimonial->patient_name) }}"
                                   required>
                            @error('patient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Designation / Short Description</label>
                            <input type="text" name="designation"
                                   class="form-control @error('designation') is-invalid @enderror"
                                   value="{{ old('designation', $testimonial->designation) }}">
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Testimonial *</label>
                            <textarea name="message"
                                      class="form-control @error('message') is-invalid @enderror"
                                      rows="5" required>{{ old('message', $testimonial->message) }}</textarea>
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
                                        @selected(old('rating', $testimonial->rating) == $i)>
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
                                   value="{{ old('sort_order', $testimonial->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Patient Photo</label>

                            @if($testimonial->photo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/'.$testimonial->photo) }}"
                                         alt="{{ $testimonial->patient_name }}"
                                         width="110" height="110"
                                         class="rounded-circle"
                                         style="object-fit:cover;">
                                </div>
                            @endif

                            <input type="file" name="photo"
                                   class="form-control @error('photo') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.webp">

                            <small class="text-muted">
                                Upload a new photo to replace the current one. Maximum 5 MB.
                            </small>

                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">Publication Status</label>

                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="is_active" value="1"
                                       class="form-check-input" id="is_active"
                                       @checked(old('is_active', $testimonial->is_active))>

                                <label class="form-check-label" for="is_active">
                                    Active — display publicly
                                </label>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Update Testimonial
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
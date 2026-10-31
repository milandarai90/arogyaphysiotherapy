@extends('admin.layouts.app')

@section('title', 'Add Team Profile')

@section('page-title', 'Add Team Profile')

@section('page-description', 'Add a therapist or staff member to your clinic.')

@section('page-actions')
    <a href="{{ route('admin.therapists.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Team
    </a>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-10">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.therapists.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Designation</label>
                            <input type="text" name="designation"
                                   class="form-control @error('designation') is-invalid @enderror"
                                   placeholder="e.g. Senior Physiotherapist"
                                   value="{{ old('designation') }}">
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Qualification</label>
                            <input type="text" name="qualification"
                                   class="form-control @error('qualification') is-invalid @enderror"
                                   placeholder="e.g. BPT, MPT"
                                   value="{{ old('qualification') }}">
                            @error('qualification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Specialization</label>
                            <input type="text" name="specialization"
                                   class="form-control @error('specialization') is-invalid @enderror"
                                   placeholder="e.g. Orthopedic Physiotherapy"
                                   value="{{ old('specialization') }}">
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Years of Experience *</label>
                            <input type="number" name="experience_years"
                                   class="form-control @error('experience_years') is-invalid @enderror"
                                   min="0" max="100"
                                   value="{{ old('experience_years', 0) }}" required>
                            @error('experience_years')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Display Order</label>
                            <input type="number" name="sort_order"
                                   class="form-control @error('sort_order') is-invalid @enderror"
                                   min="0" value="{{ old('sort_order', 0) }}">
                            <small class="text-muted">Lower numbers appear first.</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Biography</label>
                            <textarea name="bio"
                                      class="form-control @error('bio') is-invalid @enderror"
                                      rows="5"
                                      placeholder="Write a short professional introduction...">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Profile Photo</label>
                            <input type="file" name="photo"
                                   class="form-control @error('photo') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">JPG, PNG or WebP. Maximum 5 MB.</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">Profile Status</label>

                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       name="is_active" value="1"
                                       id="is_active"
                                       @checked(old('is_active', '1'))>

                                <label class="form-check-label" for="is_active">
                                    Active — display this profile on the website
                                </label>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Save Profile
                        </button>

                        <a href="{{ route('admin.therapists.index') }}"
                           class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
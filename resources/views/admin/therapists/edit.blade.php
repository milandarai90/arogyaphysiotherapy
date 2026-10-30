
@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Team Profile</h2>
            <p class="text-muted mb-0">Update {{ $therapist->name }}'s information.</p>
        </div>

        <a href="{{ route('admin.therapists.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('admin.therapists.update', $therapist) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Name *</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $therapist->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Designation</label>
                        <input type="text" name="designation" class="form-control"
                               value="{{ old('designation', $therapist->designation) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Qualification</label>
                        <input type="text" name="qualification" class="form-control"
                               value="{{ old('qualification', $therapist->qualification) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Specialization</label>
                        <input type="text" name="specialization" class="form-control"
                               value="{{ old('specialization', $therapist->specialization) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Years of Experience *</label>
                        <input type="number" name="experience_years" class="form-control"
                               min="0" max="100"
                               value="{{ old('experience_years', $therapist->experience_years) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Display Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               min="0"
                               value="{{ old('sort_order', $therapist->sort_order) }}">
                        <small class="text-muted">Lower numbers appear first.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone', $therapist->phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $therapist->email) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Biography</label>
                        <textarea name="bio" class="form-control" rows="5">{{ old('bio', $therapist->bio) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Profile Photo</label>

                        @if($therapist->photo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$therapist->photo) }}"
                                     alt="{{ $therapist->name }}"
                                     width="110" height="110"
                                     class="rounded"
                                     style="object-fit:cover;">
                            </div>
                        @endif

                        <input type="file" name="photo" class="form-control"
                               accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Upload a new photo to replace the existing one. Maximum 5 MB.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block">Profile Status</label>

                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active" value="1"
                                   id="is_active"
                                   {{ old('is_active', $therapist->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active — display this profile on the website
                            </label>
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Update Profile
                    </button>

                    <a href="{{ route('admin.therapists.index') }}"
                       class="btn btn-light px-4">Cancel</a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('page-description', 'Manage your administrator account and security settings.')

@section('content')

<div class="row g-4">

    {{-- Profile Information --}}
    <div class="col-lg-7">

        <div class="card">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="fw-bold mb-1">Personal Information</h5>
                <p class="text-muted small mb-0">
                    Update your name, email address and profile picture.
                </p>
            </div>

            <div class="card-body p-4">

                <form method="POST"
                      action="{{ route('admin.profile.update') }}"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- Profile Picture --}}
                    <div class="text-center mb-4">

                        @if($user->profile_photo_path)
                            <img
                                id="profilePhotoPreview"
                                src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                alt="Profile Picture"
                                class="rounded-circle border"
                                style="width:120px;height:120px;object-fit:cover;"
                            >
                        @else
                            <div
                                id="profilePhotoPlaceholder"
                                class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto"
                                style="width:120px;height:120px;font-size:42px;"
                            >
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <img
                                id="profilePhotoPreview"
                                src=""
                                alt="Profile Picture Preview"
                                class="rounded-circle border d-none"
                                style="width:120px;height:120px;object-fit:cover;"
                            >
                        @endif

                        <div class="mt-3">

                            <label for="profile_photo"
                                   class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-camera me-1"></i>
                                Change Picture
                            </label>

                            <input
                                type="file"
                                name="profile_photo"
                                id="profile_photo"
                                class="d-none"
                                accept="image/jpeg,image/png,image/webp"
                            >

                            <div class="small text-muted mt-2">
                                JPG, PNG or WEBP. Maximum 2 MB.
                            </div>

                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Editable Name --}}
                    <div class="mb-3">

                        <label for="name" class="form-label fw-semibold">
                            Full Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            required
                            maxlength="255"
                        >

                    </div>

                    {{-- Editable Email --}}
                    <div class="mb-4">

                        <label for="email" class="form-label fw-semibold">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Enter your email address"
                            autocomplete="email"
                            required
                            maxlength="255"
                        >

                        <div class="form-text">
                            This email address will be used for administrator login.
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Save Profile Changes
                    </button>

                </form>

                {{-- Remove Profile Picture --}}
                @if($user->profile_photo_path)

                    <hr class="my-4">

                    <form method="POST"
                          action="{{ route('admin.profile.photo.remove') }}"
                          onsubmit="return confirm('Are you sure you want to remove your profile picture?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-trash me-1"></i>
                            Remove Profile Picture
                        </button>

                    </form>

                @endif

            </div>
        </div>

    </div>

    {{-- Account Information --}}
    <div class="col-lg-5">

        <div class="card mb-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">Account Information</h5>

                <div class="mb-3">
                    <div class="text-muted small">Account ID</div>
                    <div class="fw-semibold">#{{ $user->id }}</div>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="text-muted small">Account Name</div>
                    <div class="fw-semibold">{{ $user->name }}</div>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="text-muted small">Email Address</div>
                    <div class="fw-semibold text-break">{{ $user->email }}</div>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="text-muted small">Account Role</div>
                    <span class="badge bg-primary">
                        Administrator
                    </span>
                </div>

                <hr>

                <div>
                    <div class="text-muted small">Account Created</div>
                    <div class="fw-semibold">
                        {{ $user->created_at?->format('d M Y, h:i A') ?? 'Not available' }}
                    </div>
                </div>

            </div>
        </div>

        {{-- Password Change --}}
        <div class="card">

            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="fw-bold mb-1">Change Password</h5>
                <p class="text-muted small mb-0">
                    Keep your administrator account secure.
                </p>
            </div>

            <div class="card-body p-4">

                <form method="POST"
                      action="{{ route('admin.profile.password') }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <label for="current_password"
                               class="form-label fw-semibold">
                            Current Password
                        </label>

                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            class="form-control"
                            autocomplete="current-password"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label for="password"
                               class="form-label fw-semibold">
                            New Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            minlength="8"
                            autocomplete="new-password"
                            required
                        >

                        <div class="form-text">
                            Minimum 8 characters.
                        </div>

                    </div>

                    <div class="mb-4">

                        <label for="password_confirmation"
                               class="form-label fw-semibold">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            minlength="8"
                            autocomplete="new-password"
                            required
                        >

                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-lock me-1"></i>
                        Change Password
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('profile_photo');
    const preview = document.getElementById('profilePhotoPreview');
    const placeholder = document.getElementById('profilePhotoPlaceholder');

    if (!input || !preview) {
        return;
    }

    input.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Please select a JPG, PNG or WEBP image.');
            this.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Image size must not exceed 2 MB.');
            this.value = '';
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');

        if (placeholder) {
            placeholder.classList.add('d-none');
        }

    });

});
</script>
@endpush

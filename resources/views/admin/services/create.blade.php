
@extends('admin.layouts.app')

@section('title', 'Add Service')
@section('page-title', 'Add New Service')
@section('page-description', 'Add a new treatment or service offered by your clinic.')

@section('page-actions')
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Services
    </a>
@endsection

@section('content')

    <div class="card table-card">
        <div class="card-header bg-white border-0 p-3">
            <h5 class="fw-bold mb-0">New Service Information</h5>
        </div>

        <div class="card-body p-4">

            <form method="POST" action="{{ route('admin.services.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Service Name *</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        maxlength="150"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea
                        name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        maxlength="3000"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Price (NPR)</label>
                        <input
                            type="number"
                            name="price"
                            class="form-control @error('price') is-invalid @enderror"
                            min="0"
                            step="0.01"
                            value="{{ old('price') }}"
                        >
                        <small class="text-muted">Leave blank if the price varies.</small>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Duration (minutes)</label>
                        <input
                            type="number"
                            name="duration_minutes"
                            class="form-control @error('duration_minutes') is-invalid @enderror"
                            min="1"
                            max="1440"
                            value="{{ old('duration_minutes') }}"
                        >
                        @error('duration_minutes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="form-check-input"
                        id="is_active"
                        @checked(old('is_active', true))
                    >
                    <label class="form-check-label" for="is_active">
                        Active — show this service in the public appointment form
                    </label>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i> Save Service
                    </button>

                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection

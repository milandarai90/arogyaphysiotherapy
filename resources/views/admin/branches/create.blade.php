@extends('admin.layouts.app')

@section('title', 'Add Branch')
@section('page-title', 'Add Branch')
@section('page-description', 'Add a new clinic location.')

@section('page-actions')
    <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Branches
    </a>
@endsection

@section('content')

    <form method="POST"
          action="{{ route('admin.branches.store') }}"
          enctype="multipart/form-data">

        @csrf


        <div class="card table-card mb-4">
            <div class="card-header bg-white border-0 p-3">
                <h5 class="fw-bold mb-0">Branch Information</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Branch Name *</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Branch Image</label>
                        <input type="file" name="image" class="form-control"
                               accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Maximum size: 2 MB.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp" class="form-control"
                               value="{{ old('whatsapp') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Full Address *</label>
                        <textarea name="address" class="form-control" rows="3"
                                  required>{{ old('address') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control"
                               value="{{ old('city') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control"
                               value="{{ old('district') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Province</label>
                        <input type="text" name="province" class="form-control"
                               value="{{ old('province') }}">
                    </div>

                </div>
            </div>
        </div>

        <div class="card table-card mb-4">
            <div class="card-header bg-white border-0 p-3">
                <h5 class="fw-bold mb-0">Google Maps</h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Google Maps Directions URL</label>
                    <input type="url" name="google_maps_url" class="form-control"
                           value="{{ old('google_maps_url') }}"
                           placeholder="https://maps.google.com/...">
                </div>

                <div>
                    <label class="form-label">Google Maps Embed URL</label>
                    <input type="url" name="google_maps_embed_url" class="form-control"
                           value="{{ old('google_maps_embed_url') }}"
                           placeholder="https://www.google.com/maps/embed?...">
                    <small class="text-muted">
                        Paste the embed URL from Google Maps, not the entire iframe code.
                    </small>
                </div>
            </div>
        </div>

@include('admin.branches._form', ['branch' => (object) ['working_days' => []]])
        <div class="card table-card mb-4">
            <div class="card-header bg-white border-0 p-3">
                <h5 class="fw-bold mb-0">Branch Settings</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               min="0" value="{{ old('sort_order', 0) }}">
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input type="hidden" name="is_main" value="0">
                            <input type="checkbox" name="is_main" value="1"
                                   class="form-check-input" id="is_main"
                                   {{ old('is_main') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_main">
                                Set as main branch
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   class="form-check-input" id="is_active"
                                   {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (visible on public website)
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i> Save Branch
            </button>

            <a href="{{ route('admin.branches.index') }}"
               class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

    </form>

@endsection
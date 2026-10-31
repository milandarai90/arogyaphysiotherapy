 @extends('admin.layouts.app')

@section('title', 'Edit Gallery Image')

@section('page-title', 'Edit Gallery Image')

@section('page-description', 'Update the photograph and its display information.')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9 col-xl-8">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold d-block">Current Image</label>

                    <div class="bg-light rounded-3 p-3">
                        <img
                            src="{{ asset('storage/' . $gallery->image_path) }}"
                            alt="{{ $gallery->title }}"
                            style="display:block; max-width:100%; max-height:450px; width:auto; height:auto; object-fit:contain; border-radius:10px;"
                        >
                    </div>
                </div>

                <form method="POST"
                      action="{{ route('admin.gallery.update', $gallery) }}"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Image Title *</label>
                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $gallery->title) }}"
                               maxlength="150"
                               required>

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="4"
                                  maxlength="2000">{{ old('description', $gallery->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Replace Image (optional)</label>
                        <input type="file"
                               name="image"
                               class="form-control @error('image') is-invalid @enderror"
                               accept=".jpg,.jpeg,.png,.webp">

                        <small class="text-muted">
                            Leave empty to keep the current image. Maximum size: 5 MB.
                        </small>

                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Display Order</label>
                        <input type="number"
                               name="sort_order"
                               class="form-control @error('sort_order') is-invalid @enderror"
                               min="0"
                               max="99999"
                               value="{{ old('sort_order', $gallery->sort_order) }}">

                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               class="form-check-input"
                               id="is_active"
                               @checked(old('is_active', $gallery->is_active))>

                        <label class="form-check-label" for="is_active">
                            Display this image publicly
                        </label>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Image
                        </button>

                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
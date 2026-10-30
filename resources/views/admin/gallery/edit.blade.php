
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Gallery Image | Arogya Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .page-card { border: 0; border-radius: 12px; }
        .preview { max-width: 100%; width: 320px; height: 210px; object-fit: cover; border-radius: 10px; }
    </style>
</head>
<body>
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('admin.gallery.index') }}" class="text-decoration-none">← Back to Gallery</a>
        <h3 class="fw-bold mt-3">Edit Gallery Image</h3>
    </div>

    <div class="card page-card shadow-sm">
        <div class="card-body p-4">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="mb-4">
                <label class="form-label d-block">Current Image</label>
                <img
                    src="{{ asset('storage/' . $gallery->image_path) }}"
                    alt="{{ $gallery->title }}"
                    class="preview"
                >
            </div>

            <form method="POST"
                  action="{{ route('admin.gallery.update', $gallery) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Image Title *</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $gallery->title) }}"
                           maxlength="150" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"
                              rows="3" maxlength="2000">{{ old('description', $gallery->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Replace Image (optional)</label>
                    <input type="file" name="image" class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">Leave empty to keep the current image. Maximum size: 5 MB.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" name="sort_order" class="form-control"
                           min="0" max="99999"
                           value="{{ old('sort_order', $gallery->sort_order) }}">
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="is_active" value="1"
                           class="form-check-input" id="is_active"
                           @checked(old('is_active', $gallery->is_active))>
                    <label class="form-check-label" for="is_active">
                        Display this image publicly
                    </label>
                </div>

                <button class="btn btn-primary">Update Image</button>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>
</body>
</html>

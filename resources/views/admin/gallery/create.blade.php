
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Gallery Image | Arogya Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .page-card { border: 0; border-radius: 12px; }
    </style>
</head>
<body>
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('admin.gallery.index') }}" class="text-decoration-none">← Back to Gallery</a>
        <h3 class="fw-bold mt-3">Upload Gallery Image</h3>
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

            <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Image Title *</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title') }}" maxlength="150" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"
                              rows="3" maxlength="2000">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Choose Image *</label>
                    <input type="file" name="image" class="form-control"
                           accept=".jpg,.jpeg,.png,.webp" required>
                    <small class="text-muted">JPG, JPEG, PNG or WebP. Maximum size: 5 MB.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" name="sort_order" class="form-control"
                           min="0" max="99999" value="{{ old('sort_order', 0) }}">
                    <small class="text-muted">Smaller numbers appear first.</small>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="is_active" value="1"
                           class="form-check-input" id="is_active"
                           @checked(old('is_active', true))>
                    <label class="form-check-label" for="is_active">
                        Display this image publicly
                    </label>
                </div>

                <button class="btn btn-primary">Upload Image</button>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>
</body>
</html>

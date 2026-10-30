
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Service | Arogya Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .page-card { border: 0; border-radius: 12px; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('admin.services.index') }}" class="text-decoration-none">← Back to Services</a>
        <h3 class="fw-bold mt-3">Add New Service</h3>
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

            <form method="POST" action="{{ route('admin.services.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Service Name *</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" maxlength="150" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"
                              maxlength="3000">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price (NPR)</label>
                        <input type="number" name="price" class="form-control"
                               min="0" step="0.01" value="{{ old('price') }}">
                        <small class="text-muted">Leave blank if the price varies.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Duration (minutes)</label>
                        <input type="number" name="duration_minutes" class="form-control"
                               min="1" max="1440" value="{{ old('duration_minutes') }}">
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="is_active" value="1"
                           class="form-check-input" id="is_active"
                           @checked(old('is_active', true))>
                    <label class="form-check-label" for="is_active">
                        Active — show this service in the public appointment form
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Save Service</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

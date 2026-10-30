
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gallery Management | Arogya Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .gallery-card { border: 0; border-radius: 12px; overflow: hidden; }
        .gallery-image {
    width: 100%;
    height: auto;
    object-fit: contain;
    display: block;
}
    </style>
</head>
<body>
<div class="container-fluid py-4 px-3 px-lg-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Gallery Management</h3>
            <p class="text-muted mb-0">Upload and manage clinic photographs.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">+ Upload Image</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($galleries->isEmpty())
        <div class="alert alert-info">No gallery images have been uploaded yet.</div>
    @else
        <div class="row g-4">
            @foreach($galleries as $gallery)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card gallery-card shadow-sm h-100">
                        <img
                            src="{{ asset('storage/' . $gallery->image_path) }}"
                            class="gallery-image"
                            alt="{{ $gallery->title }}"
                        >

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                <h6 class="fw-bold mb-0">{{ $gallery->title }}</h6>

                                @if($gallery->is_active)
                                    <span class="badge text-bg-success">Visible</span>
                                @else
                                    <span class="badge text-bg-secondary">Hidden</span>
                                @endif
                            </div>

                            <p class="text-muted small">
                                {{ \Illuminate\Support\Str::limit($gallery->description, 90) }}
                            </p>

                            <p class="small text-muted mb-3">
                                Display order: {{ $gallery->sort_order }}
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.gallery.edit', $gallery) }}"
                                   class="btn btn-sm btn-outline-primary">Edit</a>

                                <form method="POST" action="{{ route('admin.gallery.toggle', $gallery) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-warning">
                                        {{ $gallery->is_active ? 'Hide' : 'Show' }}
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.gallery.destroy', $gallery) }}"
                                      onsubmit="return confirm('Permanently delete this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $galleries->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>
</body>
</html>

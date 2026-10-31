 @extends('admin.layouts.app')

@section('title', 'Gallery Management')

@section('page-title', 'Gallery Management')

@section('page-description', 'Upload and manage clinic photographs.')

@section('page-actions')
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Upload Image
    </a>
@endsection

@section('content')

@if($galleries->isEmpty())

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center py-5">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold">No Gallery Images Yet</h5>
            <p class="text-muted mb-3">Upload your first clinic photograph to get started.</p>

            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-upload me-1"></i> Upload Image
            </a>
        </div>
    </div>

@else

    <div class="row g-4">

        @foreach($galleries as $gallery)

            <div class="col-sm-6 col-lg-4 col-xl-3">

                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                    <div class="bg-light d-flex align-items-center justify-content-center"
                         style="min-height:180px;">

                        <img
                            src="{{ asset('storage/' . $gallery->image_path) }}"
                            alt="{{ $gallery->title }}"
                            style="width:100%; height:auto; max-height:260px; object-fit:contain; display:block;"
                        >

                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">

                            <h6 class="fw-bold mb-0">
                                {{ $gallery->title }}
                            </h6>

                            @if($gallery->is_active)
                                <span class="badge text-bg-success">Visible</span>
                            @else
                                <span class="badge text-bg-secondary">Hidden</span>
                            @endif

                        </div>

                        <p class="text-muted small mb-2">
                            {{ \Illuminate\Support\Str::limit($gallery->description, 90) }}
                        </p>

                        <p class="small text-muted mb-3">
                            Display order: {{ $gallery->sort_order }}
                        </p>

                        <div class="d-flex flex-wrap gap-2">

                            <a href="{{ route('admin.gallery.edit', $gallery) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.gallery.toggle', $gallery) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-eye-slash me-1"></i>
                                    {{ $gallery->is_active ? 'Hide' : 'Show' }}
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.gallery.destroy', $gallery) }}"
                                  onsubmit="return confirm('Permanently delete this image?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
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

@endsection
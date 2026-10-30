@extends('layouts.app')

@section('title', 'Edit Blog Article')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('admin.blog.index') }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Back to Blog
        </a>
        <h2 class="fw-bold mt-3">Edit Article</h2>
        <p class="text-muted">Update your article details and publication status.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.blog.update', $blog) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Article Title *</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $blog->title) }}"
                           maxlength="200" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Short Description</label>
                    <textarea name="excerpt" class="form-control" rows="3"
                              maxlength="500">{{ old('excerpt', $blog->excerpt) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Article Content *</label>
                    <textarea name="content" class="form-control" rows="15"
                              required>{{ old('content', $blog->content) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Featured Image</label>

                    @if($blog->featured_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                 alt="{{ $blog->title }}"
                                 style="max-width:250px;max-height:160px;object-fit:contain;border-radius:8px;">
                        </div>
                    @endif

                    <input type="file" name="featured_image" class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        Upload a new image only if you want to replace the current one. Maximum 5 MB.
                    </small>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">SEO Settings</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Title</label>
                    <input type="text" name="meta_title" class="form-control"
                           maxlength="200"
                           value="{{ old('meta_title', $blog->meta_title) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Description</label>
                    <textarea name="meta_description" class="form-control" rows="2"
                              maxlength="300">{{ old('meta_description', $blog->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox"
                           name="is_published" value="1"
                           id="is_published"
                           @checked(old('is_published', $blog->is_published))>

                    <label class="form-check-label fw-semibold" for="is_published">
                        Published
                    </label>
                </div>

                <small class="text-muted">
                    Uncheck this to save the article as a draft.
                </small>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-1"></i> Update Article
            </button>

            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection
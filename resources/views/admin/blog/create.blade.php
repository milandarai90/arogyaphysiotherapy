@extends('layouts.app')

@section('title', 'Write Blog Article')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('admin.blog.index') }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Back to Blog
        </a>
        <h2 class="fw-bold mt-3">Write New Article</h2>
        <p class="text-muted">Create an article for your clinic website.</p>
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

    <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Article Title *</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title') }}"
                           placeholder="Example: 5 Benefits of Physiotherapy"
                           maxlength="200" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Short Description</label>
                    <textarea name="excerpt" class="form-control" rows="3"
                              maxlength="500"
                              placeholder="A short introduction to your article...">{{ old('excerpt') }}</textarea>
                    <small class="text-muted">Maximum 500 characters.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Article Content *</label>
                    <textarea name="content" class="form-control" rows="15"
                              placeholder="Write your complete article here..."
                              required>{{ old('content') }}</textarea>
                    <small class="text-muted">
                        You can use paragraphs and line breaks. We'll add a richer text editor later if needed.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Featured Image</label>
                    <input type="file" name="featured_image" class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">JPG, PNG or WEBP. Maximum size: 5 MB.</small>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">SEO Settings</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Title</label>
                    <input type="text" name="meta_title" class="form-control"
                           maxlength="200" value="{{ old('meta_title') }}"
                           placeholder="Search engine title">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Description</label>
                    <textarea name="meta_description" class="form-control" rows="2"
                              maxlength="300"
                              placeholder="Short description for search engines">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox"
                           name="is_published" value="1"
                           id="is_published" @checked(old('is_published'))>

                    <label class="form-check-label fw-semibold" for="is_published">
                        Publish this article immediately
                    </label>
                </div>

                <small class="text-muted">
                    If unchecked, the article will be saved as a draft and will not appear publicly.
                </small>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-1"></i> Save Article
            </button>

            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection
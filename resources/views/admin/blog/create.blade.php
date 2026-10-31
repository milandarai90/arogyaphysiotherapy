
@extends('admin.layouts.app')

@section('title', 'Write Blog Article')
@section('page-title', 'Write New Article')
@section('page-description', 'Create an article for your clinic website.')

@section('page-actions')
    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Blog
    </a>
@endsection

@section('content')

    <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Article Information --}}
        <div class="card table-card mb-4">
            <div class="card-header bg-white border-0 p-3">
                <h5 class="fw-bold mb-0">Article Information</h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Article Title *</label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           placeholder="Example: 5 Benefits of Physiotherapy"
                           maxlength="200" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Short Description</label>
                    <textarea name="excerpt"
                              class="form-control @error('excerpt') is-invalid @enderror"
                              rows="3" maxlength="500"
                              placeholder="A short introduction to your article...">{{ old('excerpt') }}</textarea>
                    <small class="text-muted">Maximum 500 characters.</small>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Article Content *</label>
                    <textarea name="content"
                              class="form-control @error('content') is-invalid @enderror"
                              rows="15"
                              placeholder="Write your complete article here..."
                              required>{{ old('content') }}</textarea>
                    <small class="text-muted">
                        You can use paragraphs and line breaks. A richer text editor can be added later.
                    </small>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Featured Image</label>
                    <input type="file" name="featured_image"
                           class="form-control @error('featured_image') is-invalid @enderror"
                           accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">JPG, PNG or WEBP. Maximum size: 5 MB.</small>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- SEO Settings --}}
        <div class="card table-card mb-4">
            <div class="card-header bg-white border-0 p-3">
                <h5 class="fw-bold mb-0">SEO Settings</h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Title</label>
                    <input type="text" name="meta_title"
                           class="form-control @error('meta_title') is-invalid @enderror"
                           maxlength="200"
                           value="{{ old('meta_title') }}"
                           placeholder="Search engine title">
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Description</label>
                    <textarea name="meta_description"
                              class="form-control @error('meta_description') is-invalid @enderror"
                              rows="2" maxlength="300"
                              placeholder="Short description for search engines">{{ old('meta_description') }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Publishing --}}
        <div class="card table-card mb-4">
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
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i> Save Article
            </button>

            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

    </form>

@endsection

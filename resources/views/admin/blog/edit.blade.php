
@extends('admin.layouts.app')

@section('title', 'Edit Blog Article')
@section('page-title', 'Edit Article')
@section('page-description', 'Update your article details and publication status.')

@section('page-actions')
    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Blog
    </a>
@endsection

@section('content')

    <form method="POST"
          action="{{ route('admin.blog.update', $blog) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                           value="{{ old('title', $blog->title) }}"
                           maxlength="200" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Short Description</label>
                    <textarea name="excerpt"
                              class="form-control @error('excerpt') is-invalid @enderror"
                              rows="3" maxlength="500">{{ old('excerpt', $blog->excerpt) }}</textarea>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Article Content *</label>
                    <textarea name="content"
                              class="form-control @error('content') is-invalid @enderror"
                              rows="15"
                              required>{{ old('content', $blog->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Featured Image</label>

                    @if($blog->featured_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                 alt="{{ $blog->title }}"
                                 style="max-width:250px;max-height:160px;object-fit:contain;border-radius:8px;">
                            <div class="small text-muted mt-1">Current featured image</div>
                        </div>
                    @endif

                    <input type="file" name="featured_image"
                           class="form-control @error('featured_image') is-invalid @enderror"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        Upload a new image only if you want to replace the current one. Maximum 5 MB.
                    </small>

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
                           value="{{ old('meta_title', $blog->meta_title) }}">
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Description</label>
                    <textarea name="meta_description"
                              class="form-control @error('meta_description') is-invalid @enderror"
                              rows="2" maxlength="300">{{ old('meta_description', $blog->meta_description) }}</textarea>
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
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i> Update Article
            </button>

            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

    </form>

@endsection

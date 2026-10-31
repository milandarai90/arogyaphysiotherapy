
@extends('admin.layouts.app')

@section('title', 'Manage Blog')
@section('page-title', 'Blog Management')
@section('page-description', 'Create and manage your clinic articles.')

@section('page-actions')
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Write New Article
    </a>
@endsection

@section('content')

    {{-- Search and Filters --}}
    <div class="card table-card mb-4">
        <div class="card-body p-3">

            <form method="GET" action="{{ route('admin.blog.index') }}"
                  class="row g-2 align-items-end">

                <div class="col-md-6">
                    <label class="form-label">Search Articles</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by title..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Publication Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Articles</option>
                        <option value="published" @selected(request('status') === 'published')>
                            Published
                        </option>
                        <option value="draft" @selected(request('status') === 'draft')>
                            Draft
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fa-solid fa-search me-1"></i> Filter
                    </button>

                    <a href="{{ route('admin.blog.index') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>

            </form>

        </div>
    </div>

    {{-- Blog Articles --}}
    <div class="card table-card">

        <div class="card-header bg-white border-0 p-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">All Articles</h5>
            <span class="text-muted small">{{ $blogs->total() }} articles</span>
        </div>

        <div class="card-body p-0">

            @if($blogs->count())

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Article</th>
                                <th>Created</th>
                                <th>Published</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($blogs as $blog)

                                <tr>
                                    <td class="ps-3" style="min-width:250px;">
                                        <div class="d-flex align-items-center gap-3">

                                            @if($blog->featured_image)
                                                <img
                                                    src="{{ asset('storage/' . $blog->featured_image) }}"
                                                    alt="{{ $blog->title }}"
                                                    style="width:65px;height:55px;object-fit:cover;border-radius:8px;"
                                                >
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="width:65px;height:55px;">
                                                    <i class="fa-solid fa-image text-muted"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="fw-semibold">{{ $blog->title }}</div>
                                                <small class="text-muted">{{ $blog->slug }}</small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>{{ $blog->created_at->format('d M Y') }}</td>

                                    <td>
                                        {{ $blog->published_at
                                            ? $blog->published_at->format('d M Y')
                                            : '—' }}
                                    </td>

                                    <td>
                                        @if($blog->is_published)
                                            <span class="badge text-bg-success">Published</span>
                                        @else
                                            <span class="badge text-bg-secondary">Draft</span>
                                        @endif
                                    </td>

                                    <td class="text-end pe-3" style="min-width:220px;">
                                        <div class="d-flex justify-content-end flex-wrap gap-1">

                                            <a href="{{ route('admin.blog.edit', $blog) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.blog.toggle', $blog) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-{{ $blog->is_published ? 'warning' : 'success' }}">
                                                    {{ $blog->is_published ? 'Unpublish' : 'Publish' }}
                                                </button>
                                            </form>

                                            <form method="POST"
                                                  action="{{ route('admin.blog.destroy', $blog) }}"
                                                  onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>

            @else

                <div class="text-center py-5">
                    <i class="fa-solid fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5>No blog articles found</h5>
                    <p class="text-muted">Start by writing your first article.</p>

                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-1"></i> Write First Article
                    </a>
                </div>

            @endif

        </div>

        @if($blogs->hasPages())
            <div class="card-footer bg-white border-0 p-3">
                {{ $blogs->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

@endsection

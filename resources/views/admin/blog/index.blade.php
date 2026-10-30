@extends('layouts.app')

@section('title', 'Manage Blog')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Blog Management</h2>
            <p class="text-muted mb-0">Create and manage your clinic articles.</p>
        </div>

        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Write New Article
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.blog.index') }}"
                  class="row g-2 align-items-end">

                <div class="col-md-6">
                    <label class="form-label">Search articles</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by title..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Publication status</label>
                    <select name="status" class="form-select">
                        <option value="">All articles</option>
                        <option value="published" @selected(request('status') === 'published')>
                            Published
                        </option>
                        <option value="draft" @selected(request('status') === 'draft')>
                            Draft
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-dark flex-grow-1">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>

                    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            @if($blogs->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Article</th>
                                <th>Created</th>
                                <th>Published</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <td style="min-width: 220px;">
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
                                                    <i class="fas fa-image text-muted"></i>
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
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>

                                    <td class="text-end" style="min-width: 210px;">
                                        <div class="d-flex justify-content-end flex-wrap gap-1">

                                            <a href="{{ route('admin.blog.edit', $blog) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
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

                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $blogs->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5>No blog articles found</h5>
                    <p class="text-muted">Start by writing your first article.</p>

                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                        Write First Article
                    </a>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
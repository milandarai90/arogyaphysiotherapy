@extends('layouts.app')

@section('title', 'Physiotherapy Blog | Arogya Physiotherapy Center')
@section('description', 'Read physiotherapy tips, rehabilitation advice, pain management guidance and health articles from Arogya Physiotherapy Center in Bhandara, Nepal.')

@section('content')

<section class="py-5 bg-light">
    <div class="container">

        <div class="text-center mb-5">
            <span class="text-primary fw-semibold">HEALTH & WELLNESS</span>
            <h1 class="fw-bold mt-2">Our Blog</h1>
            <p class="text-muted">
                Helpful information, physiotherapy advice and tips for a healthier life.
            </p>
        </div>

        @if($blogs->count())

            <div class="row g-4">

                @foreach($blogs as $blog)
                    <div class="col-md-6 col-lg-4">

                        <article class="card h-100 border-0 shadow-sm blog-card">

                            <a href="{{ route('blog.show', $blog->slug) }}"
                               class="text-decoration-none">

                                @if($blog->featured_image)
                                    <img
                                        src="{{ asset('storage/' . $blog->featured_image) }}"
                                        class="blog-card-image"
                                        alt="{{ $blog->title }}"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="blog-placeholder">
                                        <i class="fas fa-heartbeat"></i>
                                    </div>
                                @endif

                            </a>

                            <div class="card-body p-4">

                                <small class="text-primary fw-semibold">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $blog->published_at->format('d M Y') }}
                                </small>

                                <h4 class="fw-bold mt-3 mb-2">
                                    <a href="{{ route('blog.show', $blog->slug) }}"
                                       class="text-dark text-decoration-none">
                                        {{ $blog->title }}
                                    </a>
                                </h4>

                                <p class="text-muted">
                                    {{ $blog->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}
                                </p>

                                <a href="{{ route('blog.show', $blog->slug) }}"
                                   class="btn btn-outline-primary btn-sm mt-2">
                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                </a>

                            </div>
                        </article>

                    </div>
                @endforeach

            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $blogs->links() }}
            </div>

        @else

            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4>No articles available yet</h4>
                <p class="text-muted">
                    We're preparing helpful health and physiotherapy articles. Please visit again soon.
                </p>
            </div>

        @endif

    </div>
</section>

<style>
    .blog-card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,.10) !important;
    }

    .blog-card-image {
        display: block;
        width: 100%;
        height: 230px;
        object-fit: cover;
    }

    .blog-placeholder {
        height: 230px;
        background: #eaf0ff;
        color: #2d53cf;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 55px;
    }
</style>

@endsection
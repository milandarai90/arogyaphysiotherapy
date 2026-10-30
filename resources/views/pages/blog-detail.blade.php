@extends('layouts.app')

@section('title', $blog->meta_title ?: $blog->title)

@section('content')

<section class="py-5 bg-light">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-9">

                <a href="{{ route('blog') }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Back to Blog
                </a>

                <article class="bg-white rounded-3 shadow-sm p-3 p-md-5 mt-4">

                    <div class="mb-4">
                        <span class="text-primary fw-semibold">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $blog->published_at->format('d F Y') }}
                        </span>

                        <h1 class="fw-bold mt-3 mb-3">
                            {{ $blog->title }}
                        </h1>

                        @if($blog->excerpt)
                            <p class="lead text-muted">
                                {{ $blog->excerpt }}
                            </p>
                        @endif
                    </div>

                    @if($blog->featured_image)
                        <img
                            src="{{ asset('storage/' . $blog->featured_image) }}"
                            alt="{{ $blog->title }}"
                            class="article-featured-image mb-4"
                        >
                    @endif

                    <div class="article-content">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    <hr class="my-5">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h6 class="fw-bold mb-1">Need physiotherapy assistance?</h6>
                            <p class="text-muted mb-0">
                                Contact Arogya Physiotherapy Center for an appointment.
                            </p>
                        </div>

                        <a href="{{ route('appointment.create') }}"
                           class="btn btn-primary">
                            Book an Appointment
                        </a>
                    </div>

                </article>

            </div>
        </div>

        @if($relatedBlogs->count())
            <div class="mt-5">
                <h3 class="fw-bold mb-4">Related Articles</h3>

                <div class="row g-4">
                    @foreach($relatedBlogs as $related)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">

                                @if($related->featured_image)
                                    <img
                                        src="{{ asset('storage/' . $related->featured_image) }}"
                                        alt="{{ $related->title }}"
                                        style="width:100%;height:190px;object-fit:cover;"
                                    >
                                @endif

                                <div class="card-body">
                                    <h5 class="fw-bold">
                                        {{ $related->title }}
                                    </h5>

                                    <p class="text-muted">
                                        {{ $related->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($related->content), 100) }}
                                    </p>

                                    <a href="{{ route('blog.show', $related->slug) }}"
                                       class="text-primary text-decoration-none fw-semibold">
                                        Read Article <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

<style>
    .article-featured-image {
        display: block;
        width: 100%;
        max-height: 480px;
        object-fit: contain;
        background: #f1f5f9;
        border-radius: 10px;
    }

    .article-content {
        font-size: 17px;
        line-height: 1.9;
        color: #444;
        overflow-wrap: anywhere;
    }
</style>

@endsection
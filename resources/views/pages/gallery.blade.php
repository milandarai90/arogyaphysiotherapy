
@extends('layouts.app')

@section('title', 'Gallery | Arogya Physiotherapy Center')

@section('content')

<style>
    .gallery-section {
        padding: 65px 0;
        background: #f8fafc;
    }

    .gallery-heading {
        text-align: center;
        margin-bottom: 40px;
    }

    .gallery-heading h1 {
        color: #173b70;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .gallery-heading p {
        color: #64748b;
        max-width: 650px;
        margin: 0 auto;
    }

    .gallery-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0,0,0,.07);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 28px rgba(0,0,0,.12);
    }

.gallery-card img {
    display: block;
    width: 100%;
    height: auto;
    max-height: 320px;
    object-fit: contain;
    margin: 0 auto;
}
.gallery-card {
    max-width: 100%;
    margin: 0 auto;
}

.gallery-card img {
    background: #f1f5f9;
}

@media (min-width: 992px) {
    .gallery-card img {
        max-height: 280px;
    }
}

@media (max-width: 575px) {
    .gallery-card img {
        max-height: 260px;
    }
}

    .gallery-card-body {
        padding: 18px;
    }

    .gallery-card-body h5 {
        color: #173b70;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .gallery-card-body p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }

    .gallery-empty {
        text-align: center;
        background: #fff;
        border-radius: 14px;
        padding: 45px 20px;
        color: #64748b;
    }

    @media (max-width: 575px) {
        .gallery-section {
            padding: 40px 0;
        }

        .gallery-card img {
            height: 220px;
        }
    }
</style>

<section class="gallery-section">
    <div class="container">

        <div class="gallery-heading">
            <h1>Our Gallery</h1>
            <p>
                Explore our physiotherapy center, treatment facilities,
                equipment, and activities at Arogya Physiotherapy Center.
            </p>
        </div>

        @if($galleries->isEmpty())
            <div class="gallery-empty">
                <h5 class="fw-bold mb-2">Gallery Coming Soon</h5>
                <p class="mb-0">We're preparing photos of our center and facilities. Please visit again soon.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($galleries as $gallery)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="gallery-card">
                            <img
                                src="{{ asset('storage/' . $gallery->image_path) }}"
                                alt="{{ $gallery->title }}"
                                loading="lazy"
                            >

                            <div class="gallery-card-body">
                                <h5>{{ $gallery->title }}</h5>

                                @if($gallery->description)
                                    <p>{{ $gallery->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

@endsection

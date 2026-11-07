@extends('layouts.app')

@section('title', 'Gallery | Aarogya Physiotherapy Center')
@section('description', 'Explore Aarogya Physiotherapy Center in Bhandara, Nepal, including our treatment facilities, physiotherapy equipment, clinic environment and activities.')

@section('content')

<div class="gallery-page">
<section class="gallery-section">
    <div class="container">

        <div class="gallery-heading">
            <h1>Our Gallery</h1>
            <p>
                Explore our physiotherapy center, treatment facilities,
                equipment, and activities at Aarogya Physiotherapy Center.
            </p>
        </div>

        @if($galleries->isEmpty())
            <div class="content-empty-state gallery-empty">
                <i class="fas fa-images" aria-hidden="true"></i>
                <h2>Photos are on the way</h2>
                <p>We’re preparing photos of our clinic and facilities. Please check back soon.</p>
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
</div>

@endsection

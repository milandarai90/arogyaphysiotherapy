
@extends('layouts.app')

@php
    $get = fn($key, $default = '') => $siteSettings->get($key)?->value ?: $default;

    $values = preg_split('/\r\n|\r|\n/', $get('about_values'));
    $values = array_filter(array_map('trim', $values));
@endphp

@section('title', $get('about_page_title', 'About Arogya Physiotherapy Center'))
@section('description', $get('about_page_intro', 'Learn about Arogya Physiotherapy Center and our commitment to quality physiotherapy care.'))

@section('content')

<section class="py-5" style="background:linear-gradient(135deg,#f1f5ff,#fff5f5);">
    <div class="container text-center py-4">
        <span class="text-uppercase fw-bold" style="color:#d62828;letter-spacing:2px;">
            About Us
        </span>

        <h1 class="display-5 fw-bold mt-3">
            {{ $get('about_page_title', 'About Arogya Physiotherapy Center') }}
        </h1>

        <p class="lead text-muted mx-auto mt-3" style="max-width:800px;">
            {{ $get('about_page_intro', 'We are dedicated to helping people move better, recover faster and live healthier lives.') }}
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                @if($get('about_page_image'))
                    <img src="{{ asset('storage/' . $get('about_page_image')) }}"
                         class="img-fluid rounded-4 shadow"
                         alt="Arogya Physiotherapy Center"
                         style="width:100%;max-height:450px;object-fit:cover;">
                @else
                    <div class="rounded-4 d-flex align-items-center justify-content-center"
                         style="height:350px;background:#eef2ff;">
                        <i class="fas fa-heartbeat fa-5x" style="color:#2d53cf;"></i>
                    </div>
                @endif
            </div>

            <div class="col-lg-6">
                <span class="fw-bold text-uppercase" style="color:#d62828;">
                    Who We Are
                </span>

                <h2 class="fw-bold mt-2">
                    {{ $get('about_story_heading', 'Our Story') }}
                </h2>

                <p class="text-muted" style="line-height:1.9;white-space:pre-line;">
                    {{ $get('about_story', 'Arogya Physiotherapy Center is committed to providing quality physiotherapy and rehabilitation services to our community.') }}
                </p>
            </div>

        </div>
    </div>
</section>

<section class="py-5" style="background:#f7f9fc;">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                    <div class="mb-3" style="color:#2d53cf;">
                        <i class="fas fa-bullseye fa-2x"></i>
                    </div>
                    <h3 class="fw-bold">Our Mission</h3>
                    <p class="text-muted mb-0" style="line-height:1.8;white-space:pre-line;">
                        {{ $get('about_mission', 'To provide compassionate, effective and accessible physiotherapy care.') }}
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                    <div class="mb-3" style="color:#d62828;">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <h3 class="fw-bold">Our Vision</h3>
                    <p class="text-muted mb-0" style="line-height:1.8;white-space:pre-line;">
                        {{ $get('about_vision', 'To build a healthier community where everyone can enjoy better movement and quality of life.') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

@if(count($values))
<section class="py-5">
    <div class="container text-center">
        <span class="fw-bold text-uppercase" style="color:#d62828;">
            What Guides Us
        </span>
        <h2 class="fw-bold mt-2 mb-4">Our Core Values</h2>

        <div class="row g-3 justify-content-center">
            @foreach($values as $value)
                <div class="col-sm-6 col-lg-4">
                    <div class="p-4 rounded-4 h-100"
                         style="background:#f1f5ff;">
                        <i class="fas fa-check-circle mb-3"
                           style="color:#2d53cf;font-size:28px;"></i>
                        <h5 class="fw-bold mb-0">{{ $value }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-5 text-white text-center"
         style="background:linear-gradient(120deg,#2d53cf,#1b347f);">
    <div class="container">
        <h2 class="fw-bold">Take the First Step Towards Better Health</h2>
        <p class="mb-4">Let us help you move better and feel better.</p>
        <a href="{{ route('appointment.create') }}"
           class="btn btn-light btn-lg fw-bold px-4">
            Book an Appointment
        </a>
    </div>
</section>

@endsection

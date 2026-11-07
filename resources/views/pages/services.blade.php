
@extends('layouts.app')

@php
    $get = fn($key, $default = '') => $siteSettings->get($key)?->value ?: $default;
@endphp

@section('title', $get('services_page_title', 'Our Physiotherapy Services'))
@section('description', $get('services_page_intro', 'Explore physiotherapy and rehabilitation services at Aarogya Physiotherapy Center in Bhandara, Nepal.'))

@section('content')

<section class="py-5 text-center services-hero">
    <div class="container py-4">
        <span class="text-uppercase fw-bold services-eyebrow">
            What We Offer
        </span>

        <h1 class="display-5 fw-bold mt-3">
            {{ $get('services_page_title', 'Our Physiotherapy Services') }}
        </h1>

        <p class="lead text-muted mx-auto mt-3 services-intro">
            {{ $get('services_page_intro', 'Professional care and rehabilitation services to help you recover, move better and live healthier.') }}
        </p>
    </div>
</section>

<section class="services-list-section py-5">
    <div class="container">

        @if($services->isEmpty())
            <div class="content-empty-state">
                <i class="fas fa-hand-holding-medical" aria-hidden="true"></i>
                <h2>Our service list is being updated</h2>
                <p>Contact the clinic and we’ll answer your questions about treatment options.</p>
                <a href="{{ route('contact') }}" class="btn btn-outline-custom">Contact the clinic</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card services-card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">

                                <div class="mb-3 services-icon">
                                    <i class="fas fa-heartbeat"></i>
                                </div>

                                <h4 class="fw-bold">
                                    {{ $service->name }}
                                </h4>

                                <p class="text-muted services-description">
                                    {{ $service->description ?: 'Contact us to learn more about this service.' }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                                    @if($service->price !== null)
                                        <span class="fw-bold services-price">
                                            Rs. {{ number_format($service->price, 2) }}
                                        </span>
                                    @endif

                                    @if($service->duration_minutes)
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $service->duration_minutes }} minutes
                                        </small>
                                    @endif
                                </div>

                                <a href="{{ route('appointment.create', ['service' => $service->id]) }}"
                                   class="btn btn-outline-primary mt-4 w-100">
                                    Book This Service
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

<section class="py-5 text-white text-center services-cta">
    <div class="container">
        <h2 class="fw-bold">Ready to Start Your Recovery?</h2>
        <p class="mb-4">
            Book an appointment with Aarogya Physiotherapy Center.
        </p>

        <a href="{{ route('appointment.create') }}"
           class="btn btn-light btn-lg fw-bold px-4">
            Book an Appointment
        </a>
    </div>
</section>

@endsection

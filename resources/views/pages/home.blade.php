
@extends('layouts.app')

@section('title', 'Arogya Physiotherapy Center | Bhandara')

@section('content')

@php
    $homepageHeading = $siteSettings->get('homepage_heading')?->value;
    $homepageIntro = $siteSettings->get('homepage_intro')?->value;

    $aboutHeading = $siteSettings->get('about_heading')?->value;
    $aboutParagraph1 = $siteSettings->get('about_paragraph_1')?->value;
    $aboutParagraph2 = $siteSettings->get('about_paragraph_2')?->value;

    $whyHeading = $siteSettings->get('why_heading')?->value;
    $whyIntro = $siteSettings->get('why_intro')?->value;

    // Editable homepage section headings
    $servicesHeading = $siteSettings->get('services_heading')?->value
        ?: 'Our Physiotherapy Services';

    $galleryHeading = $siteSettings->get('gallery_heading')?->value
        ?: 'A Glimpse of Our Center';

    $blogHeading = $siteSettings->get('blog_heading')?->value
        ?: 'Latest Health Articles';

    // Editable appointment CTA
    $appointmentCtaHeading = $siteSettings->get('appointment_cta_heading')?->value
        ?: 'Ready to Start Your Recovery Journey?';

    $appointmentCtaDescription = $siteSettings->get('appointment_cta_description')?->value
        ?: 'Book an appointment with Arogya Physiotherapy Center.';

    $appointmentCtaButton = $siteSettings->get('appointment_cta_button')?->value
        ?: 'Book Your Appointment';

    // Admin-uploaded images with default fallback images
    $heroImage = $siteSettings->get('hero_image')?->value
        ? asset('storage/' . $siteSettings->get('hero_image')->value)
        : 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1000&q=85';

    $aboutImage = $siteSettings->get('about_image')?->value
        ? asset('storage/' . $siteSettings->get('about_image')->value)
        : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=900&q=85';

    $whyImage = $siteSettings->get('why_image')?->value
        ? asset('storage/' . $siteSettings->get('why_image')->value)
        : 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?auto=format&fit=crop&w=1000&q=85';

    $whyItems = [];

    for ($i = 1; $i <= 3; $i++) {
        $title = $siteSettings->get("why_item_{$i}_title")?->value;
        $description = $siteSettings->get("why_item_{$i}_description")?->value;

        if ($title || $description) {
            $whyItems[] = [
                'title' => $title,
                'description' => $description,
            ];
        }
    }

    $whyIcons = [
        'fa-user-doctor',
        'fa-heart',
        'fa-dumbbell',
    ];
@endphp

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                <span class="hero-label">
                    <i class="fas fa-heart-pulse me-2"></i>
                    YOUR HEALTH, OUR PRIORITY
                </span>

                <h1>
                    @if($homepageHeading)
                        {{ $homepageHeading }}
                    @else
                        Move Better.
                        <span>Live Better.</span>
                    @endif
                </h1>

                <p class="hero-description">
                    {{ $homepageIntro ?: 'Your journey towards a healthier and pain-free life starts here. Experience personalized physiotherapy and rehabilitation care at Arogya Physiotherapy Center.' }}
                </p>

                <div class="d-flex flex-wrap gap-3 mt-4">

                    <a href="{{ route('appointment.create') }}"
                       class="btn btn-primary-custom">
                        Book An Appointment
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>

                    <a href="{{ route('services') }}"
                       class="btn btn-outline-custom">
                        Explore Services
                    </a>

                </div>

                <div class="hero-features mt-5">
                    <div>
                        <i class="fas fa-check-circle"></i>
                        Personalized Care
                    </div>

                    <div>
                        <i class="fas fa-check-circle"></i>
                        Patient Focused
                    </div>

                    <div>
                        <i class="fas fa-check-circle"></i>
                        Rehabilitation Support
                    </div>
                </div>

            </div>

            <div class="col-lg-6">
                <div class="hero-image-wrapper">

                    <img
                        src="{{ $heroImage }}"
                        alt="Healthcare professional providing patient care"
                        class="hero-image">

                    <div class="hero-floating-card">
                        <div class="floating-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>

                        <div>
                            <strong>Care That Matters</strong>
                            <small>Your recovery is important to us.</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Introduction / About Section -->
<section class="intro-section section-padding">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-5">
                <div class="intro-image-wrapper">

                    <img
                        src="{{ $aboutImage }}"
                        alt="Physiotherapy and healthcare"
                        class="intro-image">

                    <div class="intro-experience">
                        <i class="fas fa-heart-pulse"></i>
                        <strong>AROGYA</strong>
                        <small>Movement & Recovery</small>
                    </div>

                </div>
            </div>

            <div class="col-lg-7">

                <span class="section-label">ABOUT AROGYA</span>

                <h2 class="section-title">
                    {{ $aboutHeading ?: 'Helping You Get Back to Living Your Best Life' }}
                </h2>

                <p>
                    {{ $aboutParagraph1 ?: 'At Arogya Physiotherapy Center, we believe that everyone deserves the opportunity to move freely and live comfortably.' }}
                </p>

                <p>
                    {{ $aboutParagraph2 ?: 'We aim to provide patient-centered physiotherapy and rehabilitation services focused on improving mobility, reducing pain and supporting recovery.' }}
                </p>

                <a href="{{ route('about') }}"
                   class="btn btn-primary-custom mt-3">
                    Discover More
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>

            </div>

        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section section-padding">
    <div class="container">

        <div class="section-heading text-center">

            <span class="section-label">WHAT WE OFFER</span>

            <h2 class="section-title">
                {{ $servicesHeading }}
            </h2>

            <p>
                Personalized care and rehabilitation to support
                your movement, strength and recovery.
            </p>

        </div>

        <div class="row g-4 mt-4">

            @forelse($homeServices as $service)

                <div class="col-lg-4 col-md-6">

                    <div class="service-card h-100">

                        <div class="service-icon">
                            <i class="fas fa-hand-holding-medical"></i>
                        </div>

                        <h4>{{ $service->name }}</h4>

                        <p>
                            {{ $service->description ?: 'Contact us to learn more about this physiotherapy service.' }}
                        </p>

                        <a href="{{ route('services') }}">
                            Learn More
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">
                    <i class="fas fa-heart-pulse fa-3x mb-3 text-muted"></i>

                    <h5>No Services Available</h5>

                    <p class="text-muted">
                        Our services will be displayed here soon.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="text-center mt-5">
            <a href="{{ route('services') }}"
               class="btn btn-outline-custom">
                View All Services
            </a>
        </div>

    </div>
</section>

<!-- Why Choose Us -->
<section class="why-section section-padding">
    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                <span class="section-label">WHY CHOOSE US</span>

                <h2 class="section-title">
                    {{ $whyHeading ?: 'Your Recovery Is Our Priority' }}
                </h2>

                <p>
                    {{ $whyIntro ?: 'We focus on understanding individual needs and providing supportive, personalized rehabilitation care.' }}
                </p>

                @if(count($whyItems) > 0)

                    @foreach($whyItems as $index => $item)

                        <div class="why-item">

                            <i class="fas {{ $whyIcons[$index] ?? 'fa-check-circle' }}"></i>

                            <div>
                                @if($item['title'])
                                    <h5>{{ $item['title'] }}</h5>
                                @endif

                                @if($item['description'])
                                    <p>{{ $item['description'] }}</p>
                                @endif
                            </div>

                        </div>

                    @endforeach

                @else

                    <div class="why-item">
                        <i class="fas fa-user-doctor"></i>
                        <div>
                            <h5>Patient-Centered Approach</h5>
                            <p>Care plans based on individual needs and goals.</p>
                        </div>
                    </div>

                    <div class="why-item">
                        <i class="fas fa-heart"></i>
                        <div>
                            <h5>Compassionate Care</h5>
                            <p>A supportive environment throughout recovery.</p>
                        </div>
                    </div>

                    <div class="why-item">
                        <i class="fas fa-dumbbell"></i>
                        <div>
                            <h5>Focus on Rehabilitation</h5>
                            <p>Supporting better movement and physical function.</p>
                        </div>
                    </div>

                @endif

            </div>

            <div class="col-lg-6">
                <img
                    src="{{ $whyImage }}"
                    alt="Physiotherapy rehabilitation session"
                    class="why-image">
            </div>

        </div>
    </div>
</section>

<!-- Appointment CTA -->
<section class="appointment-cta">
    <div class="container text-center">

        <span>TAKE THE FIRST STEP</span>

        <h2>
            {{ $appointmentCtaHeading }}
        </h2>

        <p>
            {{ $appointmentCtaDescription }}
        </p>

        <a href="{{ route('appointment.create') }}"
           class="btn btn-light btn-lg">
            {{ $appointmentCtaButton }}
            <i class="fas fa-arrow-right ms-2"></i>
        </a>

    </div>
</section>

<!-- Gallery Preview -->
<section class="gallery-section section-padding">
    <div class="container">

        <div class="section-heading text-center">

            <span class="section-label">OUR GALLERY</span>

            <h2 class="section-title">
                {{ $galleryHeading }}
            </h2>

            <p>
                Explore our clinic environment and rehabilitation activities.
            </p>

        </div>

        <div class="row g-3 mt-4">

            @forelse($homeGallery as $image)

                <div class="col-lg-4 col-md-6">

                    <div class="gallery-card">

                        <img
                            src="{{ asset('storage/' . $image->image_path) }}"
                            class="gallery-image"
                            alt="{{ $image->title }}"
                            loading="lazy">

                        @if($image->title)
                            <div class="gallery-caption">
                                {{ $image->title }}
                            </div>
                        @endif

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>

                    <h5>No Gallery Images Available</h5>

                    <p class="text-muted">
                        Our clinic photos will be displayed here soon.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="text-center mt-4">
            <a href="{{ route('gallery') }}"
               class="btn btn-outline-custom">
                Explore Full Gallery
            </a>
        </div>

    </div>
</section>

<!-- Blog Preview -->
<section class="blog-section section-padding">
    <div class="container">

        <div class="section-heading text-center">

            <span class="section-label">HEALTH & WELLNESS</span>

            <h2 class="section-title">
                {{ $blogHeading }}
            </h2>

            <p>
                Helpful information about physiotherapy,
                rehabilitation and healthy movement.
            </p>

        </div>

        <div class="row g-4 mt-3">

            @forelse($homeBlogs as $blog)

                <div class="col-lg-4 col-md-6">

                    <div class="blog-card h-100">

                        @if($blog->featured_image)

                            <img
                                src="{{ asset('storage/' . $blog->featured_image) }}"
                                alt="{{ $blog->title }}"
                                loading="lazy">

                        @else

                            <img
                                src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=700&q=80"
                                alt="Physiotherapy and healthcare">

                        @endif

                        <div class="blog-content">

                            <span>
                                {{ $blog->published_at
                                    ? $blog->published_at->format('d M Y')
                                    : 'HEALTH & WELLNESS' }}
                            </span>

                            <h4>{{ $blog->title }}</h4>

                            <p>
                                {{ $blog->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}
                            </p>

                            <a href="{{ route('blog.show', $blog->slug) }}">
                                Read More
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">

                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>

                    <h5>No Articles Published Yet</h5>

                    <p class="text-muted">
                        Our health and wellness articles will appear here soon.
                    </p>

                </div>

            @endforelse

        </div>

        <div class="text-center mt-5">
            <a href="{{ route('blog') }}"
               class="btn btn-outline-custom">
                View All Articles
            </a>
        </div>

    </div>
</section>

@endsection

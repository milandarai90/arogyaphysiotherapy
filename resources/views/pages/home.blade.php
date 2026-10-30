@extends('layouts.app')

@section('title', 'Arogya Physiotherapy Center | Bhandara')

@section('content')

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
                    Move Better.
                    <span>Live Better.</span>
                </h1>

                <p class="hero-description">
                    Your journey towards a healthier and pain-free life
                    starts here. Experience personalized physiotherapy
                    and rehabilitation care at Arogya Physiotherapy Center.
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
                        src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1000&q=85"
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


<!-- Introduction -->
<section class="intro-section section-padding">

    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-5">

                <div class="intro-image-wrapper">

                    <img
                        src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=900&q=85"
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
                    Helping You Get Back to
                    <span>Living Your Best Life</span>
                </h2>

                <p>
                    At Arogya Physiotherapy Center, we believe that
                    everyone deserves the opportunity to move freely
                    and live comfortably.
                </p>

                <p>
                    We aim to provide patient-centered physiotherapy
                    and rehabilitation services focused on improving
                    mobility, reducing pain and supporting recovery.
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


<!-- Services -->
<section class="services-section section-padding">

    <div class="container">

        <div class="section-heading text-center">

            <span class="section-label">WHAT WE OFFER</span>

            <h2 class="section-title">
                Our Physiotherapy <span>Services</span>
            </h2>

            <p>
                Personalized care and rehabilitation to support
                your movement, strength and recovery.
            </p>

        </div>

        <div class="row g-4 mt-4">

            @php
                $services = [
                    [
                        'icon' => 'fa-bone',
                        'title' => 'Orthopedic Physiotherapy',
                        'description' => 'Care and rehabilitation for joint pain, back pain, neck pain and musculoskeletal conditions.'
                    ],
                    [
                        'icon' => 'fa-brain',
                        'title' => 'Neurological Rehabilitation',
                        'description' => 'Rehabilitation support to improve movement, balance and functional independence.'
                    ],
                    [
                        'icon' => 'fa-person-running',
                        'title' => 'Sports Physiotherapy',
                        'description' => 'Assessment and rehabilitation support for sports-related injuries.'
                    ],
                    [
                        'icon' => 'fa-hand-holding-medical',
                        'title' => 'Pain Management',
                        'description' => 'Individualized treatment approaches to help manage pain and improve mobility.'
                    ],
                    [
                        'icon' => 'fa-person-walking',
                        'title' => 'Post-operative Rehabilitation',
                        'description' => 'Guided rehabilitation following surgery to support safe recovery.'
                    ],
                    [
                        'icon' => 'fa-child',
                        'title' => 'Pediatric Physiotherapy',
                        'description' => 'Developmental movement and rehabilitation support for children.'
                    ],
                ];
            @endphp

            @foreach($services as $service)

                <div class="col-lg-4 col-md-6">

                    <div class="service-card">

                        <div class="service-icon">
                            <i class="fas {{ $service['icon'] }}"></i>
                        </div>

                        <h4>{{ $service['title'] }}</h4>

                        <p>{{ $service['description'] }}</p>

                        <a href="{{ route('services') }}">
                            Learn More
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>

                    </div>

                </div>

            @endforeach

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
                    Your Recovery Is
                    <span>Our Priority</span>
                </h2>

                <p>
                    We focus on understanding individual needs
                    and providing supportive, personalized
                    rehabilitation care.
                </p>

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

            </div>

            <div class="col-lg-6">

                <img
                    src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?auto=format&fit=crop&w=1000&q=85"
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
            Ready to Start Your Recovery Journey?
        </h2>

        <p>
            Book an appointment with Arogya Physiotherapy Center.
        </p>

        <a href="{{ route('appointment.create') }}"
           class="btn btn-light btn-lg">

            Book Your Appointment
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
                A Glimpse of <span>Our Center</span>
            </h2>

            <p>
                Explore our clinic environment and rehabilitation activities.
            </p>

        </div>

        <div class="row g-3 mt-4">

            <div class="col-md-4">
                <img
                    src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=700&q=80"
                    class="gallery-image"
                    alt="Healthcare environment">
            </div>

            <div class="col-md-4">
                <img
                    src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=700&q=80"
                    class="gallery-image"
                    alt="Physical rehabilitation">
            </div>

            <div class="col-md-4">
                <img
                    src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?auto=format&fit=crop&w=700&q=80"
                    class="gallery-image"
                    alt="Therapy session">
            </div>

        </div>

        <div class="text-center mt-4">

            <a href="{{ route('gallery') }}"
               class="btn btn-outline-custom">

                Explore Gallery

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
                Latest Health <span>Articles</span>
            </h2>

            <p>
                Helpful information about physiotherapy,
                rehabilitation and healthy movement.
            </p>

        </div>

        <div class="row g-4 mt-3">

            <div class="col-md-4">

                <div class="blog-card">

                    <img
                        src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=700&q=80"
                        alt="Exercise and fitness">

                    <div class="blog-content">

                        <span>HEALTH & WELLNESS</span>

                        <h4>Why Regular Physical Activity Matters</h4>

                        <p>
                            Learn how regular physical activity
                            supports mobility and general wellbeing.
                        </p>

                        <a href="{{ route('blog') }}">
                            Read More <i class="fas fa-arrow-right ms-1"></i>
                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="blog-card">

                    <img
                        src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=700&q=80"
                        alt="Stretching exercise">

                    <div class="blog-content">

                        <span>PHYSICAL HEALTH</span>

                        <h4>Benefits of Proper Stretching</h4>

                        <p>
                            Understand the importance of flexibility
                            and safe stretching practices.
                        </p>

                        <a href="{{ route('blog') }}">
                            Read More <i class="fas fa-arrow-right ms-1"></i>
                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="blog-card">

                    <img
                        src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&w=700&q=80"
                        alt="Physical exercise">

                    <div class="blog-content">

                        <span>REHABILITATION</span>

                        <h4>Understanding Physiotherapy</h4>

                        <p>
                            Discover how physiotherapy can support
                            movement and rehabilitation.
                        </p>

                        <a href="{{ route('blog') }}">
                            Read More <i class="fas fa-arrow-right ms-1"></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
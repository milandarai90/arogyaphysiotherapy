<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Arogya Physiotherapy Center')</title>

    <meta name="description"
          content="@yield('description', 'Arogya Physiotherapy Center, Bhandara. Personalized physiotherapy, rehabilitation and healthcare services.')">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>

<body>

    <!-- Top Contact Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div class="d-flex flex-wrap gap-3">
                    <span>
                        <i class="fas fa-location-dot"></i>
                        Mahendra Hwy, Bhandara
                    </span>

                    <span>
                        <i class="fas fa-envelope"></i>
                        Contact information coming soon
                    </span>
                </div>

                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg main-navbar sticky-top">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center gap-2"
               href="{{ route('home') }}">

                <img src="{{ asset('images/logo.png') }}"
                     alt="Arogya Physiotherapy Center Logo"
                     class="brand-logo">

                <div class="brand-text">
                    <strong>AROGYA</strong>
                    <small>PHYSIOTHERAPY CENTER</small>
                </div>
            </a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNavigation"
                    aria-controls="mainNavigation"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavigation">

                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('services') }}">Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gallery') }}">Gallery</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('appointment.create') }}"
                           class="btn btn-book">
                            Book Appointment
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Emergency Contact Strip -->
    <section class="emergency-strip">
        <div class="container">
            <div class="d-flex flex-column flex-md-row
                        justify-content-between align-items-center gap-3">

                <div>
                    <h5 class="mb-1">
                        <i class="fas fa-heart-pulse me-2"></i>
                        Need physiotherapy assistance?
                    </h5>
                    <p class="mb-0">
                        Get in touch with Arogya Physiotherapy Center.
                    </p>
                </div>

                <a href="{{ route('contact') }}" class="btn btn-light">
                    Contact Our Clinic
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">

            <div class="row g-4">

                <div class="col-lg-4 col-md-6">

                    <div class="footer-brand d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="Arogya Logo">

                        <div>
                            <h5>AROGYA</h5>
                            <small>PHYSIOTHERAPY CENTER</small>
                        </div>
                    </div>

                    <p>
                        Helping people move better, recover stronger
                        and live healthier through personalized
                        physiotherapy and rehabilitation care.
                    </p>

                </div>

                <div class="col-lg-2 col-md-6">

                    <h5>Quick Links</h5>

                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('services') }}">Services</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                    </ul>

                </div>

                <div class="col-lg-3 col-md-6">

                    <h5>Our Services</h5>

                    <ul class="footer-links">
                        <li>Orthopedic Physiotherapy</li>
                        <li>Neurological Rehabilitation</li>
                        <li>Sports Physiotherapy</li>
                        <li>Pain Management</li>
                        <li>Post-operative Rehabilitation</li>
                    </ul>

                </div>

                <div class="col-lg-3 col-md-6">

                    <h5>Contact Information</h5>

                    <p>
                        <i class="fas fa-location-dot me-2"></i>
                        Mahendra Hwy, Bhandara, Bagmati Province 44202
                    </p>

                    <p>
                        <i class="fas fa-phone me-2"></i>
                        Phone number coming soon
                    </p>

                    <p>
                        <i class="fas fa-clock me-2"></i>
                        Opening hours coming soon
                    </p>

                </div>

            </div>

            <hr>

            <div class="footer-bottom d-flex flex-column
                        flex-md-row justify-content-between gap-2">

                <p class="mb-0">
                    © {{ date('Y') }} Arogya Physiotherapy Center.
                    All Rights Reserved.
                </p>

                <p class="mb-0">
                    Designed with <i class="fas fa-heart text-danger"></i>
                    for better healthcare.
                </p>

            </div>

        </div>
    </footer>

    <!-- Floating Appointment Button -->
    <a href="{{ route('appointment.create') }}"
       class="floating-book"
       aria-label="Book appointment">

        <i class="fas fa-calendar-check"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>
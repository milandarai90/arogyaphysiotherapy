
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @php
    $defaultSeoTitle = 'Arogya Physiotherapy Center | Physiotherapy in Bhandara, Nepal';

    $defaultSeoDescription = 'Arogya Physiotherapy Center in Bhandara, Nepal, provides professional physiotherapy care, pain management and rehabilitation services.';

    $seoTitle = $siteSettings->get('seo_title')?->value ?: $defaultSeoTitle;

    $seoDescription = $siteSettings->get('seo_description')?->value ?: $defaultSeoDescription;
@endphp

<title>@yield('title', $seoTitle)</title>

<meta name="description"
      content="@yield('description', $seoDescription)">

<meta name="robots" content="index, follow">

{{-- Open Graph / Facebook / Messenger --}}
<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:site_name" content="{{ $clinicName ?? 'Arogya Physiotherapy Center' }}">
<meta property="og:title" content="@yield('title', $seoTitle)">
<meta property="og:description" content="@yield('description', $seoDescription)">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">

{{-- Twitter / X --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', $seoTitle)">
<meta name="twitter:description" content="@yield('description', $seoDescription)">
<meta name="twitter:image" content="@yield('og_image', asset('images/logo.png'))">    @php
        $logoPath = $siteSettings->get('logo')?->value;
        $clinicName = $siteSettings->get('clinic_name')?->value ?? 'Arogya Physiotherapy Center';

        $socialLinks = [
            'facebook' => ['Facebook', 'fa-brands fa-facebook-f'],
            'instagram' => ['Instagram', 'fa-brands fa-instagram'],
            'tiktok' => ['TikTok', 'fa-brands fa-tiktok'],
            'youtube' => ['YouTube', 'fa-brands fa-youtube'],
            'linkedin' => ['LinkedIn', 'fa-brands fa-linkedin-in'],
            'twitter' => ['X (Twitter)', 'fa-brands fa-x-twitter'],
            'threads' => ['Threads', 'fa-brands fa-threads'],
            'viber' => ['Viber', 'fa-brands fa-viber'],
        ];
    @endphp

    <link rel="icon" type="image/png"
          href="{{ $logoPath ? asset('storage/' . $logoPath) : asset('images/logo.png') }}">

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
                        {{ $siteSettings->get('address')?->value ?? 'Mahendra Hwy, Bhandara' }}
                    </span>

                    @if($siteSettings->get('email')?->value)
                        <span>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:{{ $siteSettings->get('email')->value }}">
                                {{ $siteSettings->get('email')->value }}
                            </a>
                        </span>
                    @endif
                </div>

                <div class="social-links">
                    @foreach($socialLinks as $key => $social)
                        @php
                            $socialUrl = $siteSettings->get($key)?->value;

                            if ($key === 'viber' && $socialUrl && !str_starts_with($socialUrl, 'http')) {
                                $socialUrl = 'viber://chat?number=' . preg_replace('/\D+/', '', $socialUrl);
                            }
                        @endphp

                        @if($socialUrl)
                            <a href="{{ $socialUrl }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="{{ $social[0] }}">
                                <i class="{{ $social[1] }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    </div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg main-navbar sticky-top">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2"
           href="{{ route('home') }}">

            <img src="{{ $logoPath ? asset('storage/' . $logoPath) : asset('images/logo.png') }}"
                 alt="{{ $clinicName }} Logo"
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

                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                {{-- About Us --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">
                        About Us
                    </a>
                </li>

                {{-- Services --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}"
                       href="{{ route('services') }}">
                        Services
                    </a>
                </li>

                {{-- Gallery --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}"
                       href="{{ route('gallery') }}">
                        Gallery
                    </a>
                </li>

                {{-- Blog --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}"
                       href="{{ route('blog') }}">
                        Blog
                    </a>
                </li>

                {{-- Contact --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                       href="{{ route('contact') }}">
                        Contact
                    </a>
                </li>

                {{-- Check Appointment --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('appointment.status') ? 'active' : '' }}"
                       href="{{ route('appointment.status') }}">
                        Check Appointment
                    </a>
                </li>

                {{-- Book Appointment --}}
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
                        Get in touch with {{ $clinicName }}.
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
                        <img src="{{ $logoPath ? asset('storage/' . $logoPath) : asset('images/logo.png') }}"
                             alt="{{ $clinicName }} Logo">

                        <div>
                            <h5>{{ $clinicName }}</h5>
                            <small>PHYSIOTHERAPY CENTER</small>
                        </div>
                    </div>

                    <p>
                        {{ $siteSettings->get('footer_text')?->value
                            ?? 'Helping people move better, recover stronger and live healthier through personalized physiotherapy and rehabilitation care.' }}
                    </p>

                    <div class="social-links footer-social-links">
                        @foreach($socialLinks as $key => $social)
                            @php
                                $socialUrl = $siteSettings->get($key)?->value;

                                if ($key === 'viber' && $socialUrl && !str_starts_with($socialUrl, 'http')) {
                                    $socialUrl = 'viber://chat?number=' . preg_replace('/\D+/', '', $socialUrl);
                                }
                            @endphp

                            @if($socialUrl)
                                <a href="{{ $socialUrl }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="{{ $social[0] }}">
                                    <i class="{{ $social[1] }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>

                <div class="col-lg-2 col-md-6">

                    <h5>Quick Links</h5>

                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('services') }}">Services</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
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
                        {{ $siteSettings->get('address')?->value ?? 'Mahendra Hwy, Bhandara, Bagmati Province 44202' }}
                    </p>

                    @if($siteSettings->get('phone')?->value)
                        <p>
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:{{ $siteSettings->get('phone')->value }}">
                                {{ $siteSettings->get('phone')->value }}
                            </a>
                        </p>
                    @endif

                    @if($siteSettings->get('email')?->value)
                        <p>
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:{{ $siteSettings->get('email')->value }}">
                                {{ $siteSettings->get('email')->value }}
                            </a>
                        </p>
                    @endif

                    @if($siteSettings->get('whatsapp')?->value)
                        <p>
                            <i class="fab fa-whatsapp me-2"></i>
                            <a href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSettings->get('whatsapp')->value) }}"
                               target="_blank"
                               rel="noopener noreferrer">
                                WhatsApp
                            </a>
                        </p>
                    @endif

                    <p>
                        <i class="fas fa-clock me-2"></i>
                        {{ $siteSettings->get('opening_hours')?->value ?? 'Opening hours coming soon' }}
                    </p>

                </div>

            </div>

            <hr>

            <div class="footer-bottom d-flex flex-column
                        flex-md-row justify-content-between gap-2">

                <p class="mb-0">
                    © {{ date('Y') }} {{ $clinicName }}.
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        /*
        |--------------------------------------------------------------------------
        | Dynamic Clinic Branding
        |--------------------------------------------------------------------------
        */

        $clinicName = $siteSettings->get('clinic_name')?->value
            ?: 'Arogya Physiotherapy Center';

        $clinicShortName = $siteSettings->get('clinic_short_name')?->value
            ?: 'AROGYA';

        $clinicTagline = $siteSettings->get('clinic_tagline')?->value
            ?: 'PHYSIOTHERAPY CENTER';

        $logoPath = $siteSettings->get('logo')?->value;
        $faviconPath = $siteSettings->get('favicon')?->value;

        $logoUrl = $logoPath
            ? asset('storage/' . $logoPath)
            : asset('images/logo.png');

        $faviconUrl = $faviconPath
            ? asset('storage/' . $faviconPath)
            : $logoUrl;

        $brandDisplayMode = $siteSettings->get('brand_display_mode')?->value
            ?: 'both';


        /*
        |--------------------------------------------------------------------------
        | Dynamic Website Theme Colors
        |--------------------------------------------------------------------------
        */

        $themeColors = [
    /* Main Brand Colors */
    '--primary' => $siteSettings->get('color_primary')?->value ?: '#244A9A',
    '--primary-dark' => 'color-mix(in srgb, var(--primary) 75%, #000000)',

    '--secondary' => $siteSettings->get('color_secondary')?->value ?: '#D92535',
    '--secondary-dark' => 'color-mix(in srgb, var(--secondary) 75%, #000000)',

    '--accent' => $siteSettings->get('color_accent')?->value ?: '#FF6B75',
    '--accent-light' => 'color-mix(in srgb, var(--accent) 35%, #FFFFFF)',

    /* Text */
    '--heading' => 'var(--primary-dark)',
    '--text' => '#263449',
    '--muted' => '#68778B',

    /* Backgrounds */
    '--light' => '#F5F8FC',
    '--white' => '#FFFFFF',
    '--surface' => '#FFFFFF',
    '--border' => '#E5EAF1',

    /* Dynamic Soft Brand Backgrounds */
    '--primary-light' => 'color-mix(in srgb, var(--primary) 9%, #FFFFFF)',
    '--secondary-light' => 'color-mix(in srgb, var(--secondary) 8%, #FFFFFF)',

    /* Hero */
    '--hero-bg-start' => 'color-mix(in srgb, var(--primary) 3%, #FFFFFF)',
    '--hero-bg-end' => 'color-mix(in srgb, var(--secondary) 5%, #FFFFFF)',
    '--hero-glow' => 'color-mix(in srgb, var(--primary) 10%, #FFFFFF)',

    /* Footer */
    '--footer-bg' => $siteSettings->get('color_footer')?->value ?: '#14294F',
    '--footer-text' => '#D7E0EF',
    '--footer-muted' => '#B7C5DC',
    '--footer-border' => '#405473',

    /* Special Sections */
    '--emergency-bg' => 'var(--secondary)',
    '--cta-overlay-start' => 'var(--primary-dark)',
    '--cta-overlay-end' => 'var(--primary)',

    /* Shadows */
    '--shadow-navbar' => '0 3px 20px rgba(20, 40, 80, 0.07)',
    '--shadow-card' => '0 12px 30px color-mix(in srgb, var(--primary) 9%, transparent)',
    '--shadow-image' => '0 20px 50px color-mix(in srgb, var(--primary) 15%, transparent)',
];


        /*
        |--------------------------------------------------------------------------
        | Dynamic Navbar Background
        |--------------------------------------------------------------------------
        */

        $navbarBackground = $siteSettings->get('color_navbar')?->value
            ?: '#FFFFFF';


        /*
        |--------------------------------------------------------------------------
        | SEO Settings
        |--------------------------------------------------------------------------
        */

        $defaultSeoTitle = $clinicName . ' | Physiotherapy in Bhandara, Nepal';

        $defaultSeoDescription = $clinicName
            . ' in Bhandara, Nepal, provides professional physiotherapy care, pain management and rehabilitation services.';

        $seoTitle = $siteSettings->get('seo_title')?->value
            ?: $defaultSeoTitle;

        $seoDescription = $siteSettings->get('seo_description')?->value
            ?: $defaultSeoDescription;


        /*
        |--------------------------------------------------------------------------
        | Social Media Links
        |--------------------------------------------------------------------------
        */

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

    <title>@yield('title', $seoTitle)</title>

    <meta name="description" content="@yield('description', $seoDescription)">
    <meta name="robots" content="index, follow">

    {{-- Favicon --}}
    <link rel="icon" href="{{ $faviconUrl }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $clinicName }}">
    <meta property="og:title" content="@yield('title', $seoTitle)">
    <meta property="og:description" content="@yield('description', $seoDescription)">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', $logoUrl)">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $seoTitle)">
    <meta name="twitter:description" content="@yield('description', $seoDescription)">
    <meta name="twitter:image" content="@yield('og_image', $logoUrl)">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

   <link rel="stylesheet" href="{{ asset('css/style.css') }}">

{{-- Dynamic Website Theme Colors --}}
<style>
    :root {
        @foreach($themeColors as $variable => $color)
            {{ $variable }}: {{ $color }};
        @endforeach

        --navbar-bg: {{ $navbarBackground }};
        --primary-color: var(--primary);
        --secondary-color: var(--secondary);
    }
</style>
    {{-- Navbar Branding CSS --}}
    <style>
        /*
        |--------------------------------------------------------------------------
        | Navbar Layout
        |--------------------------------------------------------------------------
        */

        .main-navbar {
            min-height: 105px;
            background: var(--navbar-bg) !important;
        }

        .main-navbar > .container {
            min-height: 105px;
            display: flex;
            align-items: center;
        }

        /*
        |--------------------------------------------------------------------------
        | Dynamic Navbar Branding
        |--------------------------------------------------------------------------
        */

        .main-navbar .navbar-brand {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            min-width: 0;
            max-width: 100%;
            padding: 8px 0;
            margin-right: 20px;
            text-decoration: none;
            flex-shrink: 1;
        }

        .main-navbar .brand-logo {
            display: block;
            width: auto !important;
            height: auto !important;
            max-width: min(280px, 35vw);
            max-height: 78px;
            object-fit: contain;
            object-position: left center;
            flex-shrink: 1;
        }

        .main-navbar .brand-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
            line-height: 1.2;
        }

        .main-navbar .brand-text strong {
            display: block;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--primary) !important;
        }

        .main-navbar .brand-text small {
            display: block;
            margin-top: 3px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.2px;
            color: #64748b;
        }

        /*
        |--------------------------------------------------------------------------
        | Logo Only
        |--------------------------------------------------------------------------
        */

        .main-navbar .navbar-brand.logo-only {
            margin-right: 25px;
        }

        /*
        |--------------------------------------------------------------------------
        | Name Only
        |--------------------------------------------------------------------------
        */

        .main-navbar .navbar-brand.name-only .brand-text {
            max-width: 260px;
        }

        /*
        |--------------------------------------------------------------------------
        | Both Logo and Name
        |--------------------------------------------------------------------------
        */

        .main-navbar .navbar-brand.logo-and-name .brand-logo {
            max-width: min(180px, 25vw);
            max-height: 65px;
        }

        /*
        |--------------------------------------------------------------------------
        | Navigation Alignment
        |--------------------------------------------------------------------------
        */

        .main-navbar .navbar-collapse {
            min-width: 0;
        }

        .main-navbar .navbar-nav {
            align-items: center;
        }

        /*
        |--------------------------------------------------------------------------
        | Tablet
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1199.98px) {
            .main-navbar {
                min-height: 90px;
            }

            .main-navbar > .container {
                min-height: 90px;
            }

            .main-navbar .brand-logo {
                max-width: min(230px, 30vw);
                max-height: 68px;
            }

            .main-navbar .navbar-brand.logo-and-name .brand-logo {
                max-width: min(150px, 22vw);
                max-height: 58px;
            }

            .main-navbar .brand-text strong {
                font-size: 19px;
            }

            .main-navbar .brand-text small {
                font-size: 10px;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991.98px) {
            .main-navbar {
                min-height: 82px;
            }

            .main-navbar > .container {
                min-height: 82px;
            }

            .main-navbar .navbar-brand {
                margin-right: 10px;
                gap: 9px;
            }

            .main-navbar .brand-logo {
                max-width: min(220px, 55vw);
                max-height: 65px;
            }

            .main-navbar .navbar-brand.logo-and-name .brand-logo {
                max-width: min(130px, 32vw);
                max-height: 55px;
            }

            .main-navbar .brand-text strong {
                font-size: 18px;
            }

            .main-navbar .brand-text small {
                font-size: 10px;
            }

            .main-navbar .navbar-collapse {
                padding-top: 15px;
                padding-bottom: 15px;
            }

            .main-navbar .navbar-nav {
                align-items: stretch;
                gap: 5px;
            }

            .main-navbar .navbar-nav .nav-link {
                padding: 10px 5px;
            }

            .main-navbar .navbar-nav .btn-book {
                display: inline-block;
                margin-top: 8px;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Small Mobile
        |--------------------------------------------------------------------------
        */

        @media (max-width: 575.98px) {
            .main-navbar {
                min-height: 75px;
            }

            .main-navbar > .container {
                min-height: 75px;
            }

            .main-navbar .navbar-brand {
                max-width: calc(100% - 55px);
            }

            .main-navbar .brand-logo {
                max-width: min(190px, 55vw);
                max-height: 55px;
            }

            .main-navbar .navbar-brand.logo-and-name .brand-logo {
                max-width: min(105px, 27vw);
                max-height: 48px;
            }

            .main-navbar .brand-text strong {
                font-size: 16px;
            }

            .main-navbar .brand-text small {
                font-size: 9px;
                letter-spacing: 0.7px;
            }

            .main-navbar .navbar-toggler {
                flex-shrink: 0;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Footer Logo
        |--------------------------------------------------------------------------
        */

        .footer-brand img {
            display: block;
            width: auto;
            height: auto;
            max-width: 100px;
            max-height: 65px;
            object-fit: contain;
        }

        /*
        |--------------------------------------------------------------------------
        | Dynamic Footer Background
        |--------------------------------------------------------------------------
        */

        .main-footer {
            background: var(--footer-bg) !important;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- Top Contact Bar --}}
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

    {{-- Main Navbar --}}
    <nav class="navbar navbar-expand-lg main-navbar sticky-top">
        <div class="container">

            <a class="navbar-brand
                {{ $brandDisplayMode === 'logo' ? 'logo-only' : '' }}
                {{ $brandDisplayMode === 'name' ? 'name-only' : '' }}
                {{ $brandDisplayMode === 'both' ? 'logo-and-name' : '' }}"
               href="{{ route('home') }}">

                @if(in_array($brandDisplayMode, ['logo', 'both'], true))
                    <img src="{{ $logoUrl }}"
                         alt="{{ $clinicName }} Logo"
                         class="brand-logo">
                @endif

                @if(in_array($brandDisplayMode, ['name', 'both'], true))
                    <div class="brand-text">
                        <strong>{{ $clinicShortName }}</strong>
                        <small>{{ $clinicTagline }}</small>
                    </div>
                @endif

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
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                           href="{{ route('about') }}">
                            About Us
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}"
                           href="{{ route('services') }}">
                            Services
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}"
                           href="{{ route('gallery') }}">
                            Gallery
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}"
                           href="{{ route('blog') }}">
                            Blog
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                           href="{{ route('contact') }}">
                            Contact
                        </a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('branches') ? 'active' : '' }}"
       href="{{ route('branches') }}">
        Branches
    </a>
</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('appointment.status') ? 'active' : '' }}"
                           href="{{ route('appointment.status') }}">
                            Check Appointment
                        </a>
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

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Emergency Contact Strip --}}
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

    {{-- Footer --}}
    <footer class="main-footer">
        <div class="container">

            <div class="row g-4">

                <div class="col-lg-4 col-md-6">

                    <div class="footer-brand d-flex align-items-center gap-2 mb-3">
                        <img src="{{ $logoUrl }}"
                             alt="{{ $clinicName }} Logo">

                        <div>
                            <h5>{{ $clinicName }}</h5>
                            <small>{{ $clinicTagline }}</small>
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

    {{-- Floating Appointment Button --}}
    <a href="{{ route('appointment.create') }}"
       class="floating-book"
       aria-label="Book appointment">

        <i class="fas fa-calendar-check"></i>
    </a>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>
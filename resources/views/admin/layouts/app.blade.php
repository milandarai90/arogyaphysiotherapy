
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#173f78">

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
    @endphp

    <title>@yield('title', 'Admin Dashboard') | {{ $clinicName }} Admin</title>

    <link rel="icon" href="{{ $faviconUrl }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --admin-primary: #173f78;
            --admin-primary-dark: #12325f;
            --admin-bg: #f4f6fb;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--admin-bg);
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--admin-primary);
            color: #fff;
            z-index: 1050;
            overflow-y: auto;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        .sidebar-brand h4 {
            font-weight: 800;
            letter-spacing: 1px;
            margin: 0;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,.7);
        }

        .sidebar-menu {
            padding: 18px 12px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 5px;
            border-radius: 8px;
            color: rgba(255,255,255,.82);
            text-decoration: none;
            font-size: 14px;
            transition: .2s;
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,.16);
            color: #fff;
        }

        .sidebar-section {
            color: rgba(255,255,255,.5);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 18px 14px 8px;
            text-transform: uppercase;
        }

        /* Main area */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left .3s ease;
        }

        /* Topbar */
        .admin-topbar {
            height: 72px;
            background: #fff;
            border-bottom: 1px solid #e9edf5;
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-content {
            padding: 28px;
        }

        .page-heading {
            margin-bottom: 25px;
        }

        .page-heading h3 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-heading p {
            color: #667085;
            margin: 0;
        }

        .card,
        .table-card,
        .stat-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(16,24,40,.04);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .table th {
            font-size: 13px;
            color: #667085;
            white-space: nowrap;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        /* Mobile hamburger */
        .mobile-menu-btn {
            display: none;
            width: 42px;
            height: 42px;
            border: 1px solid #e4e7ec;
            background: #fff;
            border-radius: 8px;
            color: var(--admin-primary);
            font-size: 19px;
            align-items: center;
            justify-content: center;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(16,24,40,.5);
            z-index: 1040;
        }

        .admin-footer {
            padding: 20px 28px;
            color: #98a2b3;
            font-size: 12px;
        }

        /* Mobile layout */
        @media (max-width: 991.98px) {

            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .admin-topbar {
                padding: 0 16px;
            }

            .admin-content {
                padding: 20px 16px;
            }

            .admin-footer {
                padding: 18px 16px;
            }
        }

        @media (max-width: 575.98px) {
            .page-heading {
                align-items: flex-start !important;
            }

            .page-heading h3 {
                font-size: 21px;
            }
        }

        @stack('styles')
    </style>
</head>

<body>

{{-- Mobile Sidebar Overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- Sidebar --}}
<aside class="admin-sidebar" id="adminSidebar">

    <div class="sidebar-brand d-flex align-items-center gap-3">

        <img src="{{ $logoUrl }}"
             alt="{{ $clinicName }} Logo"
             style="width:48px;height:48px;object-fit:contain;border-radius:8px;background:#fff;padding:3px;">

        <div>
            <h4>{{ $clinicShortName }}</h4>
            <small>{{ $clinicTagline }}</small>
        </div>

    </div>

    <nav class="sidebar-menu">

        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>

        <div class="sidebar-section">Management</div>

        <a href="{{ route('admin.appointments.index') }}"
           class="{{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i> Appointments
        </a>

        <a href="{{ route('admin.services.index') }}"
           class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <i class="fa-solid fa-hand-holding-medical"></i> Services
        </a>

        <a href="{{ route('admin.gallery.index') }}"
           class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
            <i class="fa-solid fa-images"></i> Gallery
        </a>

        <a href="{{ route('admin.blog.index') }}"
           class="{{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
            <i class="fa-solid fa-newspaper"></i> Blog
        </a>

        <a href="{{ route('admin.therapists.index') }}"
           class="{{ request()->routeIs('admin.therapists.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-doctor"></i> Therapists & Staff
        </a>

        <a href="{{ route('admin.testimonials.index') }}"
           class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
            <i class="fa-solid fa-star"></i> Testimonials
        </a>

        <a href="{{ route('admin.contact-messages.index') }}"
           class="{{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
            <i class="fa-solid fa-envelope"></i> Contact Messages
        </a>

        <div class="sidebar-section">Clinic Settings</div>

        <a href="{{ route('admin.operating-hours.index') }}"
           class="{{ request()->routeIs('admin.operating-hours.*', 'admin.holidays.*') ? 'active' : '' }}">
            <i class="fa-solid fa-clock"></i> Operating Hours
        </a>

        <a href="{{ route('admin.settings.index') }}"
           class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fa-solid fa-gear"></i> Website Settings
        </a>

        <div class="sidebar-section">Account</div>

        <a href="{{ route('admin.profile.edit') }}"
           class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-circle"></i> My Profile
        </a>

        <div class="sidebar-section">Website</div>

        <a href="{{ route('home') }}" target="_blank">
            <i class="fa-solid fa-globe"></i> View Website
        </a>

        <form method="POST" action="{{ route('admin.logout') }}" class="mt-3 px-2">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm w-100">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
            </button>
        </form>

    </nav>
</aside>

{{-- Main Content --}}
<div class="admin-main">

    {{-- Topbar --}}
    <header class="admin-topbar">

        <div class="d-flex align-items-center gap-3">

            {{-- Hamburger: mobile only --}}
            <button type="button"
                    class="mobile-menu-btn"
                    id="mobileMenuBtn"
                    aria-label="Open navigation menu"
                    aria-controls="adminSidebar"
                    aria-expanded="false">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div>
                <span class="fw-bold text-dark d-none d-sm-inline">
                    {{ $clinicName }} Admin Panel
                </span>

                <span class="fw-bold text-dark d-sm-none">
                    {{ $clinicShortName }}
                </span>
            </div>

        </div>

        <div class="d-flex align-items-center gap-3">

            <span class="text-muted small d-none d-sm-inline">
                {{ now()->format('d M Y') }}
            </span>

            <div class="d-flex align-items-center gap-2">

                @if(auth()->user()->profile_photo_path)
                    <img
                        src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                        alt="Profile"
                        class="rounded-circle"
                        style="width:36px;height:36px;object-fit:cover;"
                    >
                @else
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                         style="width:36px;height:36px;">
                        <i class="fa-solid fa-user"></i>
                    </div>
                @endif

                <a href="{{ route('admin.profile.edit') }}"
                   class="fw-semibold small text-dark text-decoration-none">
                    {{ auth()->user()->name }}
                </a>

            </div>
        </div>

    </header>

    <main class="admin-content">

        {{-- Page Heading --}}
        <div class="page-heading d-flex justify-content-between flex-wrap gap-3">
            <div>
                <h3>@yield('page-title', 'Dashboard')</h3>
                <p>@yield('page-description', 'Welcome to ' . $clinicName . ' Admin Panel.')</p>
            </div>

            <div>
                @yield('page-actions')
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please correct the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

    <footer class="admin-footer">
        &copy; {{ date('Y') }} {{ $clinicName }}. All rights reserved.
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuButton = document.getElementById('mobileMenuBtn');

        function openSidebar() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
            menuButton.setAttribute('aria-expanded', 'true');
            menuButton.setAttribute('aria-label', 'Close navigation menu');
            menuButton.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Open navigation menu');
            menuButton.innerHTML = '<i class="fa-solid fa-bars"></i>';
            document.body.style.overflow = '';
        }

        menuButton.addEventListener('click', function () {
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        overlay.addEventListener('click', closeSidebar);

        sidebar.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeSidebar);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                closeSidebar();
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>

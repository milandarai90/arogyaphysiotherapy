<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Website Settings | Arogya Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #172554;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 15px;
            color: white;
        }

        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            padding: 12px 15px;
            color: #dbeafe;
            text-decoration: none;
            border-radius: 7px;
            margin-bottom: 7px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2d53cf;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 35px;
        }

        .settings-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,.05);
        }

        .settings-card .card-header {
            border-bottom: 1px solid #edf0f5;
            border-radius: 12px 12px 0 0;
        }

        .form-label {
            font-weight: 600;
            color: #344054;
        }

        .form-control {
            padding: 11px 13px;
        }

        .section-heading {
            color: #2d53cf;
            font-weight: 700;
        }

        .save-button {
            background: #2d53cf;
            border: none;
            padding: 12px 30px;
            font-weight: 600;
        }

        .save-button:hover {
            background: #1e40af;
        }

        .image-preview {
            max-width: 100%;
            max-height: 220px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 4px;
            background: white;
        }

        .logo-preview {
            max-width: 140px;
            max-height: 120px;
            object-fit: contain;
        }

        .image-upload-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 18px;
        }

        @media(max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 20px 12px;
            }
        }
    </style>
</head>

<body>

@php
    $getSetting = function ($key, $default = '') use ($settings) {
        return old($key, $settings->get($key)?->value ?? $default);
    };
@endphp

<!-- Sidebar -->
<div class="sidebar">

    <h4>
        <i class="fas fa-heart-pulse me-2"></i>
        AROGYA ADMIN
    </h4>

    <a href="{{ route('admin.dashboard') }}">
        <i class="fas fa-gauge me-2"></i> Dashboard
    </a>

    <a href="{{ route('admin.appointments.index') }}">
        <i class="fas fa-calendar-check me-2"></i> Appointments
    </a>

    <a href="{{ route('admin.services.index') }}">
        <i class="fas fa-hand-holding-medical me-2"></i> Services
    </a>

    <a href="{{ route('admin.gallery.index') }}">
        <i class="fas fa-images me-2"></i> Gallery
    </a>

    <a href="{{ route('admin.blog.index') }}">
        <i class="fas fa-newspaper me-2"></i> Blog
    </a>

    <a href="{{ route('admin.settings.index') }}" class="active">
        <i class="fas fa-gear me-2"></i> Website Settings
    </a>

    <hr class="border-secondary">

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf

        <button type="submit" class="btn btn-outline-light w-100">
            <i class="fas fa-sign-out-alt me-2"></i>
            Logout
        </button>
    </form>

</div>

<!-- Main Content -->
<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Website Settings</h2>
            <p class="text-muted mb-0">
                Manage your clinic website content and information.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}

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

    <form action="{{ route('admin.settings.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- Clinic Information -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-hospital me-2"></i>
                    Clinic Information
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Clinic Name *</label>

                    <input type="text"
                           name="clinic_name"
                           class="form-control"
                           value="{{ $getSetting('clinic_name', 'Arogya Physiotherapy Center') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Clinic Logo</label>

                    <input type="file"
                           name="logo"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        JPG, PNG or WEBP. Maximum 2 MB.
                    </small>

                    @if($settings->get('logo')?->value)
                        <div class="mt-3">
                            <p class="small fw-semibold mb-2">Current Logo</p>

                            <img src="{{ asset('storage/' . $settings->get('logo')->value) }}"
                                 alt="Current logo"
                                 class="logo-preview">
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- SEO Settings -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-magnifying-glass me-2"></i>
                    Homepage SEO Settings
                </h5>
            </div>

            <div class="card-body">

                <p class="text-muted small mb-4">
                    These details help search engines understand your clinic and may appear in Google search results.
                </p>

                <div class="mb-3">
                    <label class="form-label">SEO Page Title</label>

                    <input type="text"
                           name="seo_title"
                           class="form-control"
                           maxlength="255"
                           value="{{ $getSetting('seo_title', 'Arogya Physiotherapy Center | Physiotherapy in Bhandara, Nepal') }}"
                           placeholder="Arogya Physiotherapy Center | Physiotherapy in Bhandara">

                    <small class="text-muted">
                        Recommended: around 50–60 characters.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">SEO Meta Description</label>

                    <textarea name="seo_description"
                              class="form-control"
                              rows="4"
                              maxlength="500"
                              placeholder="Describe your clinic, services and location for search engines.">{{ $getSetting('seo_description', 'Arogya Physiotherapy Center in Bhandara, Nepal, provides professional physiotherapy care, pain management and rehabilitation services.') }}</textarea>

                    <small class="text-muted">
                        Recommended: around 150–160 characters. Briefly describe your clinic and services.
                    </small>
                </div>

            </div>
        </div>

        <!-- Contact Information -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-address-book me-2"></i>
                    Contact Information
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ $getSetting('phone') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp" class="form-control"
                               value="{{ $getSetting('whatsapp') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ $getSetting('email') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Opening Hours</label>
                        <input type="text" name="opening_hours" class="form-control"
                               value="{{ $getSetting('opening_hours') }}"
                               placeholder="Sunday - Friday: 9 AM - 6 PM">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Clinic Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ $getSetting('address', 'Mahendra Hwy, Bhandara, Bagmati Province 44202, Nepal') }}</textarea>
                    </div>

                </div>

            </div>
        </div>

        <!-- Social Media -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-share-nodes me-2"></i>
                    Social Media & Online Presence
                </h5>
            </div>

            <div class="card-body">

                @php
                    $socialLinks = [
                        'facebook' => ['Facebook', 'https://facebook.com/yourpage'],
                        'instagram' => ['Instagram', 'https://instagram.com/yourpage'],
                        'tiktok' => ['TikTok', 'https://tiktok.com/@yourpage'],
                        'youtube' => ['YouTube', 'https://youtube.com/@yourchannel'],
                        'linkedin' => ['LinkedIn', 'https://linkedin.com/company/yourpage'],
                        'twitter' => ['X (Twitter)', 'https://x.com/yourpage'],
                        'threads' => ['Threads', 'https://threads.net/@yourpage'],
                    ];
                @endphp

                <div class="row">

                    @foreach($socialLinks as $key => $social)

                        <div class="col-md-6 mb-3">

                            <label class="form-label">{{ $social[0] }}</label>

                            <input type="url"
                                   name="{{ $key }}"
                                   class="form-control"
                                   value="{{ $getSetting($key) }}"
                                   placeholder="{{ $social[1] }}">

                        </div>

                    @endforeach

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Viber</label>

                        <input type="text"
                               name="viber"
                               class="form-control"
                               value="{{ $getSetting('viber') }}"
                               placeholder="Viber number or link">
                    </div>

                </div>

                <div class="alert alert-info small mb-0">
                    Leave unused social media fields empty.
                </div>

            </div>
        </div>

        <!-- Homepage Hero -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-house me-2"></i>
                    Homepage Hero Section
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Main Heading</label>

                    <input type="text"
                           name="homepage_heading"
                           class="form-control"
                           value="{{ $getSetting('homepage_heading') }}"
                           placeholder="Move Better. Live Better.">
                </div>

                <div class="mb-3">
                    <label class="form-label">Introduction</label>

                    <textarea name="homepage_intro"
                              class="form-control"
                              rows="4">{{ $getSetting('homepage_intro') }}</textarea>
                </div>

                <div class="image-upload-box">
                    <label class="form-label">Hero Background / Main Image</label>

                    <input type="file"
                           name="hero_image"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        JPG, PNG or WEBP. Maximum 5 MB.
                    </small>

                    @if($settings->get('hero_image')?->value)
                        <div class="mt-3">
                            <p class="small fw-semibold mb-2">Current Hero Image</p>

                            <img src="{{ asset('storage/' . $settings->get('hero_image')->value) }}"
                                 alt="Current hero image"
                                 class="image-preview">
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- About Section -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-circle-info me-2"></i>
                    Homepage About Section
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">About Heading</label>

                    <input type="text"
                           name="about_heading"
                           class="form-control"
                           value="{{ $getSetting('about_heading') }}"
                           placeholder="Helping You Get Back to Living Your Best Life">
                </div>

                <div class="mb-3">
                    <label class="form-label">First Paragraph</label>

                    <textarea name="about_paragraph_1"
                              class="form-control"
                              rows="4">{{ $getSetting('about_paragraph_1') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Second Paragraph</label>

                    <textarea name="about_paragraph_2"
                              class="form-control"
                              rows="4">{{ $getSetting('about_paragraph_2') }}</textarea>
                </div>

                <div class="image-upload-box">
                    <label class="form-label">About Section Image</label>

                    <input type="file"
                           name="about_image"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        JPG, PNG or WEBP. Maximum 5 MB.
                    </small>

                    @if($settings->get('about_image')?->value)
                        <div class="mt-3">
                            <p class="small fw-semibold mb-2">Current About Image</p>

                            <img src="{{ asset('storage/' . $settings->get('about_image')->value) }}"
                                 alt="Current about image"
                                 class="image-preview">
                        </div>
                    @endif
                </div>

            </div>
        </div>

        
<!-- Full About Us Page Settings -->
<div class="card settings-card mb-4">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-building me-2"></i>
            About Us Page Settings
        </h5>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Page Heading</label>
            <input type="text" name="about_page_title"
                   class="form-control"
                   value="{{ $getSetting('about_page_title', 'About Arogya Physiotherapy Center') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Page Introduction</label>
            <textarea name="about_page_intro" class="form-control" rows="4">{{ $getSetting('about_page_intro') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Our Story Heading</label>
            <input type="text" name="about_story_heading"
                   class="form-control"
                   value="{{ $getSetting('about_story_heading', 'Our Story') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Our Story</label>
            <textarea name="about_story" class="form-control" rows="5">{{ $getSetting('about_story') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Our Mission</label>
            <textarea name="about_mission" class="form-control" rows="3">{{ $getSetting('about_mission') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Our Vision</label>
            <textarea name="about_vision" class="form-control" rows="3">{{ $getSetting('about_vision') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Our Core Values</label>
            <textarea name="about_values" class="form-control" rows="4"
                      placeholder="Enter each value on a separate line.">{{ $getSetting('about_values') }}</textarea>
        </div>

        <div class="image-upload-box">
            <label class="form-label">About Page Image</label>
            <input type="file" name="about_page_image"
                   class="form-control" accept=".jpg,.jpeg,.png,.webp">

            <small class="text-muted">JPG, PNG or WEBP. Maximum 5 MB.</small>

            @if($settings->get('about_page_image')?->value)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $settings->get('about_page_image')->value) }}"
                         alt="About page image" class="image-preview">
                </div>
            @endif
        </div>

    </div>
</div>

<!-- Services Page Settings -->
<div class="card settings-card mb-4">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-hand-holding-medical me-2"></i>
            Services Page Settings
        </h5>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Page Heading</label>
            <input type="text" name="services_page_title"
                   class="form-control"
                   value="{{ $getSetting('services_page_title', 'Our Physiotherapy Services') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Page Introduction</label>
            <textarea name="services_page_intro" class="form-control" rows="4">{{ $getSetting('services_page_intro') }}</textarea>
        </div>

        <div class="alert alert-info mb-0">
            Individual services, descriptions, prices, duration and active status
            are managed from the existing Services section in your admin panel.
        </div>

    </div>
</div>

<!-- Contact Page Settings -->
<div class="card settings-card mb-4">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-address-card me-2"></i>
            Contact Us Page Settings
        </h5>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Page Heading</label>
            <input type="text" name="contact_page_title"
                   class="form-control"
                   value="{{ $getSetting('contact_page_title', 'Contact Arogya Physiotherapy Center') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Page Introduction</label>
            <textarea name="contact_page_intro" class="form-control" rows="4">{{ $getSetting('contact_page_intro') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Form Heading</label>
            <input type="text" name="contact_form_heading"
                   class="form-control"
                   value="{{ $getSetting('contact_form_heading', 'Send Us a Message') }}">
        </div>

        <div class="alert alert-info mb-0">
            Phone, WhatsApp, email, address and opening hours are managed
            in the existing Contact Information section above.
        </div>

    </div>
</div>



        <!-- Why Choose Us -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-star me-2"></i>
                    Why Choose Us Section
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Section Heading</label>

                    <input type="text"
                           name="why_heading"
                           class="form-control"
                           value="{{ $getSetting('why_heading') }}"
                           placeholder="Your Recovery Is Our Priority">
                </div>

                <div class="mb-4">
                    <label class="form-label">Introduction</label>

                    <textarea name="why_intro"
                              class="form-control"
                              rows="3">{{ $getSetting('why_intro') }}</textarea>
                </div>

                @for($i = 1; $i <= 3; $i++)

                    <div class="border rounded p-3 mb-3">

                        <h6 class="section-heading mb-3">
                            Feature {{ $i }}
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">Feature Title</label>

                            <input type="text"
                                   name="why_item_{{ $i }}_title"
                                   class="form-control"
                                   value="{{ $getSetting('why_item_'.$i.'_title') }}">
                        </div>

                        <div>
                            <label class="form-label">Feature Description</label>

                            <textarea name="why_item_{{ $i }}_description"
                                      class="form-control"
                                      rows="2">{{ $getSetting('why_item_'.$i.'_description') }}</textarea>
                        </div>

                    </div>

                @endfor

                <div class="image-upload-box mt-4">
                    <label class="form-label">Why Choose Us Image</label>

                    <input type="file"
                           name="why_image"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        JPG, PNG or WEBP. Maximum 5 MB.
                    </small>

                    @if($settings->get('why_image')?->value)
                        <div class="mt-3">
                            <p class="small fw-semibold mb-2">Current Why Choose Us Image</p>

                            <img src="{{ asset('storage/' . $settings->get('why_image')->value) }}"
                                 alt="Current why choose us image"
                                 class="image-preview">
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- Homepage Sections -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-layer-group me-2"></i>
                    Homepage Sections
                </h5>
            </div>

            <div class="card-body">

                <p class="text-muted small mb-4">
                    Customize the headings displayed above the Services, Gallery and Blog sections on your homepage.
                </p>

                <div class="mb-3">
                    <label class="form-label">Services Section Heading</label>

                    <input type="text"
                           name="services_heading"
                           class="form-control"
                           value="{{ $getSetting('services_heading', 'Our Physiotherapy Services') }}"
                           placeholder="Our Physiotherapy Services">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gallery Section Heading</label>

                    <input type="text"
                           name="gallery_heading"
                           class="form-control"
                           value="{{ $getSetting('gallery_heading', 'Our Gallery') }}"
                           placeholder="Our Gallery">
                </div>

                <div class="mb-3">
                    <label class="form-label">Blog Section Heading</label>

                    <input type="text"
                           name="blog_heading"
                           class="form-control"
                           value="{{ $getSetting('blog_heading', 'Latest News & Articles') }}"
                           placeholder="Latest News & Articles">
                </div>

            </div>
        </div>

        <!-- Appointment CTA -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-calendar-check me-2"></i>
                    Homepage Appointment Section
                </h5>
            </div>

            <div class="card-body">

                <p class="text-muted small mb-4">
                    Customize the call-to-action section that encourages visitors to book an appointment.
                </p>

                <div class="mb-3">
                    <label class="form-label">Appointment Heading</label>

                    <input type="text"
                           name="appointment_cta_heading"
                           class="form-control"
                           value="{{ $getSetting('appointment_cta_heading', 'Ready to Start Your Recovery?') }}"
                           placeholder="Ready to Start Your Recovery?">
                </div>

                <div class="mb-3">
                    <label class="form-label">Appointment Description</label>

                    <textarea name="appointment_cta_description"
                              class="form-control"
                              rows="3"
                              placeholder="Take the first step towards a healthier, pain-free life.">{{ $getSetting('appointment_cta_description', 'Book your appointment today and let our expert physiotherapy team help you get back to living your best life.') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Appointment Button Text</label>

                    <input type="text"
                           name="appointment_cta_button"
                           class="form-control"
                           value="{{ $getSetting('appointment_cta_button', 'Book an Appointment') }}"
                           placeholder="Book an Appointment">
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="card settings-card mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-shoe-prints me-2"></i>
                    Footer Settings
                </h5>
            </div>

            <div class="card-body">

                <label class="form-label">Footer Description</label>

                <textarea name="footer_text"
                          class="form-control"
                          rows="3">{{ $getSetting('footer_text') }}</textarea>

            </div>
        </div>

        <!-- Save -->
        <div class="text-end mb-5">

            <button type="submit" class="btn btn-primary save-button">
                <i class="fas fa-save me-2"></i>
                Save Website Settings
            </button>

        </div>

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

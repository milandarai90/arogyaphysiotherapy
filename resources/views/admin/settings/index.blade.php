
    @extends('admin.layouts.app')

    @section('title', 'Website Settings')
    @section('page-title', 'Website Settings')
    @section('page-description', 'Manage your clinic website content and information.')

@push('styles')
<style>
    /* =========================================
       WEBSITE SETTINGS - COMPLETE PAGE STYLING
    ========================================= */

    /* General settings cards */
    .settings-page .card,
    .card.border-0.shadow-sm.rounded-3 {
        border-radius: 14px !important;
        overflow: hidden;
    }

    .card-header {
        background: #fff !important;
        padding: 16px 20px !important;
    }

    .card-header h5 {
        color: #173f78;
        font-size: 16px;
        font-weight: 700;
    }

    .card-body {
        padding: 22px;
    }

    /* Form labels */
    .form-label {
        color: #26364a;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .form-control,
    .form-select {
        min-height: 43px;
        border: 1px solid #dce2eb;
        border-radius: 8px;
        font-size: 14px;
        padding: 10px 12px;
        box-shadow: none;
    }

    textarea.form-control {
        min-height: auto;
        line-height: 1.6;
        resize: vertical;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2d53cf;
        box-shadow: 0 0 0 3px rgba(45, 83, 207, .10);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
    }

    /* =========================================
       IMAGE UPLOAD CONTAINERS
    ========================================= */

    .image-upload-box {
        width: 100%;
        max-width: 100%;
        padding: 16px;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8faff;
    }

    .image-upload-box input[type="file"] {
        width: 100%;
        background: #fff;
        cursor: pointer;
    }

    .image-upload-box input[type="file"]::file-selector-button {
        margin: -10px 12px -10px -12px;
        padding: 11px 14px;
        border: 0;
        border-right: 1px solid #dce2eb;
        background: #edf2ff;
        color: #173f78;
        font-weight: 600;
        cursor: pointer;
    }

    .settings-image-label {
        margin: 0 0 8px;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    /* All image previews */
    .settings-image-preview {
        display: block;
        width: 100%;
        max-width: 260px;
        height: 160px;
        margin-top: 8px;
        padding: 4px;
        object-fit: cover;
        object-position: center;
        background: #fff;
        border: 1px solid #dce2eb;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .07);
    }

    /* 1. Clinic logo */
    .settings-logo-preview {
        width: 120px;
        height: 120px;
        max-width: 100%;
        object-fit: contain;
        object-position: center;
        background: #fff;
        padding: 8px;
    }

    /* 2. Homepage hero image */
    .settings-hero-preview {
        width: 100%;
        max-width: 420px;
        height: 220px;
        object-fit: cover;
        object-position: center;
    }

    /* 3. Homepage about image */
    .settings-about-preview {
        width: 100%;
        max-width: 320px;
        height: 210px;
        object-fit: cover;
    }

    /* 4. About page image */
    .settings-about-page-preview {
        width: 100%;
        max-width: 420px;
        height: 240px;
        object-fit: cover;
    }

    /* 5. Why choose us image */
    .settings-why-preview {
        width: 100%;
        max-width: 360px;
        height: 230px;
        object-fit: cover;
    }

    /* Image help text */
    .image-upload-box small {
        display: block;
        margin-top: 8px;
        color: #64748b !important;
        font-size: 12px;
    }

    /* =========================================
       INFORMATION AND ALERT BOXES
    ========================================= */

    .alert {
        border-radius: 9px;
        font-size: 13px;
    }

    .alert-info {
        background: #eff6ff;
        border-color: #dbeafe;
        color: #1e40af;
    }

    .alert-success {
        background: #ecfdf3;
        border-color: #bbf7d0;
        color: #166534;
    }

    .alert-danger {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    /* =========================================
       WHY CHOOSE US FEATURE BOXES
    ========================================= */

    .border.rounded-3.p-3.mb-3 {
        border-color: #e2e8f0 !important;
        background: #fbfcff;
        border-radius: 10px !important;
    }

    /* =========================================
       SAVE BUTTON
    ========================================= */

    button.btn.btn-primary.btn-lg {
        min-height: 46px;
        border: 0;
        border-radius: 9px;
        background: #2d53cf;
        font-size: 14px;
        font-weight: 600;
        transition: background .2s ease, transform .2s ease;
    }

    button.btn.btn-primary.btn-lg:hover {
        background: #1e40af;
        transform: translateY(-1px);
    }

    /* =========================================
       TABLET RESPONSIVENESS
    ========================================= */

    @media (max-width: 991.98px) {
        .card-body {
            padding: 18px;
        }

        .settings-hero-preview {
            max-width: 100%;
            height: 200px;
        }

        .settings-about-page-preview {
            max-width: 100%;
        }
    }

    /* =========================================
       MOBILE RESPONSIVENESS
    ========================================= */

    @media (max-width: 767.98px) {
        .card-header {
            padding: 14px 15px !important;
        }

        .card-header h5 {
            font-size: 14px;
            line-height: 1.5;
        }

        .card-body {
            padding: 15px;
        }

        .form-label {
            font-size: 12px;
        }

        .form-control,
        .form-select {
            min-height: 42px;
            font-size: 13px;
        }

        .image-upload-box {
            padding: 12px;
        }

        .settings-image-preview {
            max-width: 100%;
            height: 180px;
        }

        .settings-logo-preview {
            width: 105px;
            height: 105px;
        }

        .settings-hero-preview {
            height: 190px;
        }

        .settings-about-preview {
            height: 180px;
        }

        .settings-about-page-preview {
            height: 190px;
        }

        .settings-why-preview {
            height: 190px;
        }

        .d-flex.justify-content-end.mb-5 {
            display: block !important;
        }

        .d-flex.justify-content-end.mb-5 button {
            width: 100%;
        }
    }

    @media (max-width: 420px) {
        .settings-image-preview {
            height: 160px;
        }

        .settings-logo-preview {
            width: 95px;
            height: 95px;
        }

        .settings-hero-preview {
            height: 165px;
        }
    }
</style>
@endpush

    @section('content')

    @php
        $getSetting = function ($key, $default = '') use ($settings) {
            return old($key, $settings->get($key)?->value ?? $default);
        };

        $socialLinks = [
            'facebook' => ['Facebook', 'https://facebook.com/yourpage'],
            'instagram' => ['Instagram', 'https://instagram.com/yourpage'],
            'tiktok' => ['TikTok', 'https://tiktok.com/@yourpage'],
            'youtube' => ['YouTube', 'https://youtube.com/@yourchannel'],
            'linkedin' => ['LinkedIn', 'https://linkedin.com/company/yourpage'],
            'twitter' => ['X (Twitter)', 'https://x.com/yourpage'],
            'threads' => ['Threads', 'https://threads.net/@yourpage'],
        ];

        $savedInterval = (int) ($settings->get('appointment_slot_interval')?->value ?? 30);
        $standardIntervals = [10, 15, 20, 30, 45, 60];
        $isCustomInterval = !in_array($savedInterval, $standardIntervals, true);
    @endphp

  

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>
                <i class="fas fa-exclamation-circle me-2"></i>
                Please correct the following errors:
            </strong>
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

        {{-- Clinic Information --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-hospital text-primary me-2"></i>
                    Clinic Information
                </h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Clinic Name <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        name="clinic_name"
                        class="form-control @error('clinic_name') is-invalid @enderror"
                        value="{{ $getSetting('clinic_name', 'Arogya Physiotherapy Center') }}"
                        required>

                    @error('clinic_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Clinic Logo</label>

                    <div class="image-upload-box">
                        <input type="file"
                            name="logo"
                            class="form-control @error('logo') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,.webp">

                        <small class="text-muted">
                            JPG, PNG or WEBP. Maximum 2 MB.
                        </small>

                        @error('logo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        @if($settings->get('logo')?->value)
                            <div class="mt-3">
                                <p class="settings-image-label fw-semibold">Current Logo</p>
                                <img src="{{ asset('storage/' . $settings->get('logo')->value) }}"
                                    alt="Current logo"
                                    class="settings-image-preview settings-logo-preview">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO Settings --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-magnifying-glass text-primary me-2"></i>
                    Homepage SEO Settings
                </h5>
            </div>

            <div class="card-body">
                <p class="text-muted small mb-4">
                    These details help search engines understand your clinic and may appear in Google search results.
                </p>

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Page Title</label>
                    <input type="text"
                        name="seo_title"
                        class="form-control @error('seo_title') is-invalid @enderror"
                        maxlength="255"
                        value="{{ $getSetting('seo_title', 'Arogya Physiotherapy Center | Physiotherapy in Bhandara, Nepal') }}"
                        placeholder="Arogya Physiotherapy Center | Physiotherapy in Bhandara">

                    <small class="text-muted">Recommended: around 50–60 characters.</small>

                    @error('seo_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">SEO Meta Description</label>
                    <textarea name="seo_description"
                            class="form-control @error('seo_description') is-invalid @enderror"
                            rows="4"
                            maxlength="500"
                            placeholder="Describe your clinic, services and location for search engines.">{{ $getSetting('seo_description', 'Arogya Physiotherapy Center in Bhandara, Nepal, provides professional physiotherapy care, pain management and rehabilitation services.') }}</textarea>

                    <small class="text-muted">Recommended: around 150–160 characters.</small>

                    @error('seo_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-address-book text-primary me-2"></i>
                    Contact Information
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ $getSetting('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Emergency Contact Number</label>
                        <input type="text" name="emergency_phone"
                            class="form-control @error('emergency_phone') is-invalid @enderror"
                            value="{{ $getSetting('emergency_phone') }}"
                            placeholder="Emergency phone number">
                        @error('emergency_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Emergency Contact Label</label>
                        <input type="text" name="emergency_label"
                            class="form-control @error('emergency_label') is-invalid @enderror"
                            value="{{ $getSetting('emergency_label', 'Emergency Contact') }}"
                            maxlength="100"
                            placeholder="Emergency Contact">
                        @error('emergency_label')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Emergency Instructions</label>
                        <textarea name="emergency_instructions"
                                class="form-control @error('emergency_instructions') is-invalid @enderror"
                                rows="2" maxlength="500"
                                placeholder="Instructions for patients requiring urgent assistance">{{ $getSetting('emergency_instructions') }}</textarea>
                        @error('emergency_instructions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">WhatsApp Number</label>
                        <input type="text" name="whatsapp"
                            class="form-control @error('whatsapp') is-invalid @enderror"
                            value="{{ $getSetting('whatsapp') }}">
                        @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ $getSetting('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Opening Hours</label>
                        <input type="text" name="opening_hours"
                            class="form-control @error('opening_hours') is-invalid @enderror"
                            value="{{ $getSetting('opening_hours') }}"
                            placeholder="Sunday - Friday: 9 AM - 6 PM">
                        @error('opening_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Clinic Address</label>
                        <textarea name="address"
                                class="form-control @error('address') is-invalid @enderror"
                                rows="2">{{ $getSetting('address', 'Mahendra Hwy, Bhandara, Bagmati Province 44202, Nepal') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Google Maps Location --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white border-bottom p-3">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-map-location-dot text-primary me-2"></i>
            Google Maps Location
        </h5>
    </div>

    <div class="card-body">
        <div class="mb-3">
            <label class="form-label fw-semibold">Google Maps Embed URL</label>

            <input type="url"
                name="google_maps_embed_url"
                id="google_maps_embed_url"
                class="form-control @error('google_maps_embed_url') is-invalid @enderror"
                value="{{ $getSetting('google_maps_embed_url') }}"
                placeholder="https://www.google.com/maps/embed?pb=...">

            @error('google_maps_embed_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <small class="text-muted">
                Paste the URL from Google Maps → Share → Embed a map → Copy HTML.
                Copy only the URL inside the iframe's src attribute.
            </small>
        </div>

        <div class="alert alert-info small">
            <i class="fas fa-info-circle me-1"></i>
            This location will automatically appear on your public Contact page.
            You can change it anytime from this dashboard.
        </div>

        <div id="googleMapsPreviewContainer"
            class="{{ $getSetting('google_maps_embed_url') ? '' : 'd-none' }}">
            <label class="form-label fw-semibold">Map Preview</label>

            <div class="rounded-3 overflow-hidden border">
                <iframe
                    id="googleMapsPreview"
                    src="{{ $getSetting('google_maps_embed_url') }}"
                    width="100%"
                    height="300"
                    style="border:0;"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>

        {{-- Social Media --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-share-nodes text-primary me-2"></i>
                    Social Media & Online Presence
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    @foreach($socialLinks as $key => $social)
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ $social[0] }}</label>
                            <input type="url"
                                name="{{ $key }}"
                                class="form-control @error($key) is-invalid @enderror"
                                value="{{ $getSetting($key) }}"
                                placeholder="{{ $social[1] }}">
                            @error($key)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Viber</label>
                        <input type="text" name="viber"
                            class="form-control @error('viber') is-invalid @enderror"
                            value="{{ $getSetting('viber') }}"
                            placeholder="Viber number or link">
                        @error('viber')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info small mt-3 mb-0">
                    Leave unused social media fields empty.
                </div>
            </div>
        </div>

        {{-- Homepage Hero --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-house text-primary me-2"></i>
                    Homepage Hero Section
                </h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Main Heading</label>
                    <input type="text" name="homepage_heading"
                        class="form-control @error('homepage_heading') is-invalid @enderror"
                        value="{{ $getSetting('homepage_heading') }}"
                        placeholder="Move Better. Live Better.">
                    @error('homepage_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Introduction</label>
                    <textarea name="homepage_intro"
                            class="form-control @error('homepage_intro') is-invalid @enderror"
                            rows="4">{{ $getSetting('homepage_intro') }}</textarea>
                    @error('homepage_intro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="image-upload-box">
                    <label class="form-label fw-semibold">Hero Background / Main Image</label>
                    <input type="file" name="hero_image"
                        class="form-control @error('hero_image') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">JPG, PNG or WEBP. Maximum 5 MB.</small>

                    @error('hero_image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    @if($settings->get('hero_image')?->value)
                        <div class="mt-3">
                            <p class="settings-image-label fw-semibold">Current Hero Image</p>
                            <img src="{{ asset('storage/' . $settings->get('hero_image')->value) }}"
                                alt="Current hero image"
                                class="settings-image-preview settings-hero-preview">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Homepage About Section --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-circle-info text-primary me-2"></i>
                    Homepage About Section
                </h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">About Heading</label>
                    <input type="text" name="about_heading"
                        class="form-control @error('about_heading') is-invalid @enderror"
                        value="{{ $getSetting('about_heading') }}"
                        placeholder="Helping You Get Back to Living Your Best Life">
                    @error('about_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">First Paragraph</label>
                    <textarea name="about_paragraph_1"
                            class="form-control @error('about_paragraph_1') is-invalid @enderror"
                            rows="4">{{ $getSetting('about_paragraph_1') }}</textarea>
                    @error('about_paragraph_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Second Paragraph</label>
                    <textarea name="about_paragraph_2"
                            class="form-control @error('about_paragraph_2') is-invalid @enderror"
                            rows="4">{{ $getSetting('about_paragraph_2') }}</textarea>
                    @error('about_paragraph_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="image-upload-box">
                    <label class="form-label fw-semibold">About Section Image</label>
                    <input type="file" name="about_image"
                        class="form-control @error('about_image') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">JPG, PNG or WEBP. Maximum 5 MB.</small>

                    @error('about_image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    @if($settings->get('about_image')?->value)
                        <div class="mt-3">
                            <p class="settings-image-label fw-semibold">Current About Image</p>
                            <img src="{{ asset('storage/' . $settings->get('about_image')->value) }}"
                                alt="Current about image"
                                class="settings-image-preview">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- About Us Page --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-building text-primary me-2"></i>
                    About Us Page Settings
                </h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Heading</label>
                    <input type="text" name="about_page_title"
                        class="form-control @error('about_page_title') is-invalid @enderror"
                        value="{{ $getSetting('about_page_title', 'About Arogya Physiotherapy Center') }}">
                    @error('about_page_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Introduction</label>
                    <textarea name="about_page_intro"
                            class="form-control @error('about_page_intro') is-invalid @enderror"
                            rows="4">{{ $getSetting('about_page_intro') }}</textarea>
                    @error('about_page_intro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Our Story Heading</label>
                    <input type="text" name="about_story_heading"
                        class="form-control @error('about_story_heading') is-invalid @enderror"
                        value="{{ $getSetting('about_story_heading', 'Our Story') }}">
                    @error('about_story_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Our Story</label>
                    <textarea name="about_story"
                            class="form-control @error('about_story') is-invalid @enderror"
                            rows="5">{{ $getSetting('about_story') }}</textarea>
                    @error('about_story')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Our Mission</label>
                    <textarea name="about_mission"
                            class="form-control @error('about_mission') is-invalid @enderror"
                            rows="3">{{ $getSetting('about_mission') }}</textarea>
                    @error('about_mission')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Our Vision</label>
                    <textarea name="about_vision"
                            class="form-control @error('about_vision') is-invalid @enderror"
                            rows="3">{{ $getSetting('about_vision') }}</textarea>
                    @error('about_vision')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Our Core Values</label>
                    <textarea name="about_values"
                            class="form-control @error('about_values') is-invalid @enderror"
                            rows="4"
                            placeholder="Enter each value on a separate line.">{{ $getSetting('about_values') }}</textarea>
                    @error('about_values')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="image-upload-box">
                    <label class="form-label fw-semibold">About Page Image</label>
                    <input type="file" name="about_page_image"
                        class="form-control @error('about_page_image') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">JPG, PNG or WEBP. Maximum 5 MB.</small>

                    @error('about_page_image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    @if($settings->get('about_page_image')?->value)
                        <div class="mt-3">
                            <p class="settings-image-label fw-semibold">Current About Page Image</p>
                            <img src="{{ asset('storage/' . $settings->get('about_page_image')->value) }}"
                                alt="About page image"
                                class="settings-image-preview">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Services Page --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-hand-holding-medical text-primary me-2"></i>
                    Services Page Settings
                </h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Heading</label>
                    <input type="text" name="services_page_title"
                        class="form-control @error('services_page_title') is-invalid @enderror"
                        value="{{ $getSetting('services_page_title', 'Our Physiotherapy Services') }}">
                    @error('services_page_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Introduction</label>
                    <textarea name="services_page_intro"
                            class="form-control @error('services_page_intro') is-invalid @enderror"
                            rows="4">{{ $getSetting('services_page_intro') }}</textarea>
                    @error('services_page_intro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info mb-0">
                    Individual services, descriptions, prices, duration and active status
                    are managed from the existing Services section in your admin panel.
                </div>
            </div>
        </div>

        {{-- Contact Page --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-address-card text-primary me-2"></i>
                    Contact Us Page Settings
                </h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Heading</label>
                    <input type="text" name="contact_page_title"
                        class="form-control @error('contact_page_title') is-invalid @enderror"
                        value="{{ $getSetting('contact_page_title', 'Contact Arogya Physiotherapy Center') }}">
                    @error('contact_page_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Introduction</label>
                    <textarea name="contact_page_intro"
                            class="form-control @error('contact_page_intro') is-invalid @enderror"
                            rows="4">{{ $getSetting('contact_page_intro') }}</textarea>
                    @error('contact_page_intro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Contact Form Heading</label>
                    <input type="text" name="contact_form_heading"
                        class="form-control @error('contact_form_heading') is-invalid @enderror"
                        value="{{ $getSetting('contact_form_heading', 'Send Us a Message') }}">
                    @error('contact_form_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info mb-0">
                    Phone, WhatsApp, email, address and opening hours are managed
                    in the Contact Information section above.
                </div>
            </div>
        </div>

        {{-- Why Choose Us --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-star text-primary me-2"></i>
                    Why Choose Us Section
                </h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Section Heading</label>
                    <input type="text" name="why_heading"
                        class="form-control @error('why_heading') is-invalid @enderror"
                        value="{{ $getSetting('why_heading') }}"
                        placeholder="Your Recovery Is Our Priority">
                    @error('why_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Introduction</label>
                    <textarea name="why_intro"
                            class="form-control @error('why_intro') is-invalid @enderror"
                            rows="3">{{ $getSetting('why_intro') }}</textarea>
                    @error('why_intro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @for($i = 1; $i <= 3; $i++)
                    <div class="border rounded-3 p-3 mb-3">
                        <h6 class="text-primary fw-bold mb-3">Feature {{ $i }}</h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Feature Title</label>
                            <input type="text"
                                name="why_item_{{ $i }}_title"
                                class="form-control @error('why_item_'.$i.'_title') is-invalid @enderror"
                                value="{{ $getSetting('why_item_'.$i.'_title') }}">
                            @error('why_item_'.$i.'_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold">Feature Description</label>
                            <textarea name="why_item_{{ $i }}_description"
                                    class="form-control @error('why_item_'.$i.'_description') is-invalid @enderror"
                                    rows="2">{{ $getSetting('why_item_'.$i.'_description') }}</textarea>
                            @error('why_item_'.$i.'_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endfor

                <div class="image-upload-box mt-4">
                    <label class="form-label fw-semibold">Why Choose Us Image</label>
                    <input type="file" name="why_image"
                        class="form-control @error('why_image') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">JPG, PNG or WEBP. Maximum 5 MB.</small>

                    @error('why_image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    @if($settings->get('why_image')?->value)
                        <div class="mt-3">
                            <p class="settings-image-label fw-semibold">Current Why Choose Us Image</p>
                            <img src="{{ asset('storage/' . $settings->get('why_image')->value) }}"
                                alt="Current why choose us image"
                                class="settings-image-preview">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Homepage Sections --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-layer-group text-primary me-2"></i>
                    Homepage Sections
                </h5>
            </div>

            <div class="card-body">
                <p class="text-muted small mb-4">
                    Customize the headings displayed above the Services, Gallery and Blog sections on your homepage.
                </p>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Services Section Heading</label>
                    <input type="text" name="services_heading"
                        class="form-control @error('services_heading') is-invalid @enderror"
                        value="{{ $getSetting('services_heading', 'Our Physiotherapy Services') }}"
                        placeholder="Our Physiotherapy Services">
                    @error('services_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Gallery Section Heading</label>
                    <input type="text" name="gallery_heading"
                        class="form-control @error('gallery_heading') is-invalid @enderror"
                        value="{{ $getSetting('gallery_heading', 'Our Gallery') }}"
                        placeholder="Our Gallery">
                    @error('gallery_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Blog Section Heading</label>
                    <input type="text" name="blog_heading"
                        class="form-control @error('blog_heading') is-invalid @enderror"
                        value="{{ $getSetting('blog_heading', 'Latest News & Articles') }}"
                        placeholder="Latest News & Articles">
                    @error('blog_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Appointment Slot Settings --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-clock text-primary me-2"></i>
                    Appointment Slot Settings
                </h5>
            </div>

            <div class="card-body">
                <p class="text-muted small mb-3">
                    Choose how frequently patients can book appointment times.
                    This setting applies to future available appointment slots.
                </p>

                <div class="row align-items-end">
                    <div class="col-md-6 mb-3">
                        <label for="appointment_slot_interval" class="form-label fw-semibold">
                            Appointment Slot Interval
                        </label>

                        <select name="appointment_slot_interval"
                                id="appointment_slot_interval"
                                class="form-select @error('appointment_slot_interval') is-invalid @enderror"
                                required>
                            @foreach([10, 15, 20, 30, 45, 60] as $minutes)
                                <option value="{{ $minutes }}"
                                    {{ !$isCustomInterval && $savedInterval === $minutes ? 'selected' : '' }}>
                                    Every {{ $minutes }} minutes
                                </option>
                            @endforeach

                            <option value="custom" {{ $isCustomInterval ? 'selected' : '' }}>
                                Custom interval
                            </option>
                        </select>

                        @error('appointment_slot_interval')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3"
                        id="customIntervalContainer"
                        style="{{ $isCustomInterval ? '' : 'display: none;' }}">
                        <label for="appointment_slot_custom" class="form-label fw-semibold">
                            Custom Interval (minutes)
                        </label>

                        <input type="number"
                            name="appointment_slot_custom"
                            id="appointment_slot_custom"
                            class="form-control @error('appointment_slot_custom') is-invalid @enderror"
                            min="5" max="180" step="1"
                            value="{{ old('appointment_slot_custom', $isCustomInterval ? $savedInterval : 30) }}"
                            placeholder="Enter minutes">

                        <small class="text-muted">Enter a value between 5 and 180 minutes.</small>

                        @error('appointment_slot_custom')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info small mb-0">
                    <i class="fas fa-circle-info me-1"></i>
                    Example: A 30-minute interval creates appointment times such as
                    9:00 AM, 9:30 AM, 10:00 AM and 10:30 AM, within your clinic's
                    operating hours. Existing appointments will not be changed.
                </div>
            </div>
        </div>

        {{-- Homepage Appointment Section --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-calendar-check text-primary me-2"></i>
                    Homepage Appointment Section
                </h5>
            </div>

            <div class="card-body">
                <p class="text-muted small mb-4">
                    Customize the call-to-action section that encourages visitors to book an appointment.
                </p>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Appointment Heading</label>
                    <input type="text" name="appointment_cta_heading"
                        class="form-control @error('appointment_cta_heading') is-invalid @enderror"
                        value="{{ $getSetting('appointment_cta_heading', 'Ready to Start Your Recovery?') }}"
                        placeholder="Ready to Start Your Recovery?">
                    @error('appointment_cta_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Appointment Description</label>
                    <textarea name="appointment_cta_description"
                            class="form-control @error('appointment_cta_description') is-invalid @enderror"
                            rows="3"
                            placeholder="Take the first step towards a healthier, pain-free life.">{{ $getSetting('appointment_cta_description', 'Book your appointment today and let our expert physiotherapy team help you get back to living your best life.') }}</textarea>
                    @error('appointment_cta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Appointment Button Text</label>
                    <input type="text" name="appointment_cta_button"
                        class="form-control @error('appointment_cta_button') is-invalid @enderror"
                        value="{{ $getSetting('appointment_cta_button', 'Book an Appointment') }}"
                        placeholder="Book an Appointment">
                    @error('appointment_cta_button')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Footer Settings --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-shoe-prints text-primary me-2"></i>
                    Footer Settings
                </h5>
            </div>

            <div class="card-body">
                <label class="form-label fw-semibold">Footer Description</label>
                <textarea name="footer_text"
                        class="form-control @error('footer_text') is-invalid @enderror"
                        rows="3">{{ $getSetting('footer_text') }}</textarea>
                @error('footer_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Save Settings --}}
        <div class="d-flex justify-content-end mb-5">
            <button type="submit" class="btn btn-primary btn-lg px-4">
                <i class="fas fa-save me-2"></i>
                Save Website Settings
            </button>
        </div>

    </form>

    @endsection

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const intervalSelect = document.getElementById('appointment_slot_interval');
        const customContainer = document.getElementById('customIntervalContainer');
        const customInput = document.getElementById('appointment_slot_custom');

        if (!intervalSelect || !customContainer || !customInput) {
            return;
        }

        function updateCustomIntervalVisibility() {
            const isCustom = intervalSelect.value === 'custom';

            customContainer.style.display = isCustom ? '' : 'none';
            customInput.required = isCustom;
            customInput.disabled = !isCustom;
        }

        intervalSelect.addEventListener('change', updateCustomIntervalVisibility);
        updateCustomIntervalVisibility();
    });

    const mapUrlInput = document.getElementById('google_maps_embed_url');
const mapPreview = document.getElementById('googleMapsPreview');
const mapPreviewContainer = document.getElementById('googleMapsPreviewContainer');

if (mapUrlInput && mapPreview && mapPreviewContainer) {
    mapUrlInput.addEventListener('input', function () {
        const url = this.value.trim();

        if (url.startsWith('https://www.google.com/maps/embed') ||
            url.startsWith('https://google.com/maps/embed') ||
            url.startsWith('https://maps.google.com/maps')) {

            mapPreview.src = url;
            mapPreviewContainer.classList.remove('d-none');
        } else {
            mapPreview.src = 'about:blank';
            mapPreviewContainer.classList.add('d-none');
        }
    });
}
    </script>
    @endpush

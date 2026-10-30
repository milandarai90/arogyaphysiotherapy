
@extends('layouts.app')

@php
    $get = fn($key, $default = '') => $siteSettings->get($key)?->value ?: $default;

    $phone = $get('phone');
    $whatsapp = preg_replace('/\D/', '', $get('whatsapp', $phone));
    $email = $get('email');
    $address = $get('address', 'Mahendra Hwy, Bhandara, Bagmati Province 44202, Nepal');
    $hours = $get('opening_hours', 'Please contact us for opening hours.');
@endphp

@section('title', $get('contact_page_title', 'Contact Arogya Physiotherapy Center'))
@section('description', $get('contact_page_intro', 'Contact Arogya Physiotherapy Center in Bhandara, Nepal, for physiotherapy appointments and enquiries.'))

@section('content')

<section class="py-5 text-center" style="background:linear-gradient(135deg,#f1f5ff,#fff5f5);">
    <div class="container py-4">
        <span class="text-uppercase fw-bold" style="color:#d62828;letter-spacing:2px;">
            Get In Touch
        </span>

        <h1 class="display-5 fw-bold mt-3">
            {{ $get('contact_page_title', 'Contact Us') }}
        </h1>

        <p class="lead text-muted mx-auto mt-3" style="max-width:800px;">
            {{ $get('contact_page_intro', 'Have questions or need physiotherapy care? We are here to help.') }}
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <div class="row g-4">

            <!-- Contact Information -->
            <div class="col-lg-5">

                <h3 class="fw-bold mb-4">Contact Information</h3>

                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex gap-3">
                            <i class="fas fa-map-marker-alt fa-2x" style="color:#2d53cf;"></i>
                            <div>
                                <h5 class="fw-bold">Our Location</h5>
                                <p class="text-muted mb-0">{{ $address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($phone)
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex gap-3">
                                <i class="fas fa-phone fa-2x" style="color:#2d53cf;"></i>
                                <div>
                                    <h5 class="fw-bold">Phone</h5>
                                    <a href="tel:{{ $phone }}" class="text-decoration-none">
                                        {{ $phone }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($email)
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex gap-3">
                                <i class="fas fa-envelope fa-2x" style="color:#2d53cf;"></i>
                                <div>
                                    <h5 class="fw-bold">Email</h5>
                                    <a href="mailto:{{ $email }}" class="text-decoration-none">
                                        {{ $email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex gap-3">
                            <i class="fas fa-clock fa-2x" style="color:#2d53cf;"></i>
                            <div>
                                <h5 class="fw-bold">Opening Hours</h5>
                                <p class="text-muted mb-0" style="white-space:pre-line;">
                                    {{ $hours }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($whatsapp)
                    <a href="https://wa.me/{{ $whatsapp }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn btn-success w-100 py-3 mt-2">
                        <i class="fab fa-whatsapp me-2"></i>
                        Chat With Us on WhatsApp
                    </a>
                @endif

            </div>

            <!-- Enquiry Form -->
            <div class="col-lg-7">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <h3 class="fw-bold mb-4">
                            {{ $get('contact_form_heading', 'Send Us a Message') }}
                        </h3>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
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

                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name"
                                       class="form-control"
                                       value="{{ old('name') }}"
                                       maxlength="150" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email"
                                           class="form-control"
                                           value="{{ old('email') }}"
                                           maxlength="255">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone"
                                           class="form-control"
                                           value="{{ old('phone') }}"
                                           maxlength="20"
                                           placeholder="98XXXXXXXX">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject"
                                       class="form-control"
                                       value="{{ old('subject') }}"
                                       maxlength="200">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Your Message *</label>
                                <textarea name="message"
                                          class="form-control"
                                          rows="5"
                                          maxlength="3000"
                                          required>{{ old('message') }}</textarea>
                            </div>

                            <button type="submit"
                                    class="btn-primary-custom border-0 w-100">
                                <i class="fas fa-paper-plane me-2"></i>
                                Send Message
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="rounded-4 overflow-hidden shadow-sm">
            <iframe
                src="https://www.google.com/maps?q=Mahendra+Highway,+Bhandara,+Nepal&output=embed"
                width="100%"
                height="350"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

@endsection

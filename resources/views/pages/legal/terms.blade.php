@extends('layouts.app')

@section('title', 'Terms and Conditions | Aarogya Physiotherapy Center')
@section('description', 'Terms for using the Aarogya Physiotherapy Center website and requesting an appointment.')

@section('content')
<section class="legal-page section-padding">
    <div class="container legal-page-container">
        <h1>Terms and Conditions</h1>
        <p class="legal-updated">Last updated: November 7, 2026</p>

        <p>These terms apply to your use of this website. By using the site, you agree to use it lawfully and to provide information that is accurate to the best of your knowledge.</p>

        <h2>Website information</h2>
        <p>Website content is provided for general information about the clinic and its services. It is not a diagnosis, individual treatment plan, or substitute for advice from a qualified health professional. Do not use this website to seek emergency care.</p>

        <h2>Appointment requests</h2>
        <p>Submitting an appointment request does not confirm a booking. The request is subject to availability and clinic approval. The clinic will use the contact details you provide to respond and may approve, decline, or propose a different appointment time. Keep your booking reference private and use it with your registered phone number to check your appointment.</p>

        <h2>Acceptable use</h2>
        <p>Do not interfere with the website, attempt to access accounts or information that do not belong to you, submit malicious code, or use the site to harass, defraud, or harm others. The clinic may restrict access where necessary to protect the website and its users.</p>

        <h2>Content and availability</h2>
        <p>The clinic aims to keep the website available and information current, but content may change and the website may occasionally be unavailable. Service descriptions and schedules can be updated by the clinic. Contact the clinic to confirm current details.</p>

        <h2>External websites and maps</h2>
        <p>This website may link to social networks or display third-party maps and resources. Those services are operated by others and are governed by their own terms and privacy policies.</p>

        <h2>Contact</h2>
        <p>Questions about these terms can be sent through the <a href="{{ route('contact') }}">clinic contact page</a>.</p>
    </div>
</section>
@endsection

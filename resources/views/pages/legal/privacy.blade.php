@extends('layouts.app')

@section('title', 'Privacy Policy | Aarogya Physiotherapy Center')
@section('description', 'Learn how Aarogya Physiotherapy Center collects, uses, and protects information submitted through this website.')

@section('content')
<section class="legal-page section-padding">
    <div class="container legal-page-container">
        <h1>Privacy Policy</h1>
        <p class="legal-updated">Last updated: November 7, 2026</p>

        <p>This policy explains how Aarogya Physiotherapy Center handles information when you use this website, request an appointment, or contact the clinic. Please do not submit information that is not needed for your enquiry.</p>

        <h2>Information you provide</h2>
        <ul>
            <li><strong>Appointment requests:</strong> your name, phone number, age, selected service and branch, preferred date and time, and any optional symptoms or message you enter.</li>
            <li><strong>Contact enquiries:</strong> your name and any email address, phone number, subject, or message you choose to provide.</li>
            <li><strong>Website administration:</strong> authorised staff account details and profile information used to manage this website.</li>
        </ul>

        <h2>Website visit information</h2>
        <p>If you accept optional cookies, this site stores a random first-party visitor identifier and records the page path and time of a visit. The identifier is hashed before it is stored in the visit table, and query strings are not recorded there. We use these records to understand overall website use. If you reject optional cookies, this site does not create new visit records or use the visitor identifier.</p>

        <h2>How information is used</h2>
        <p>The clinic uses submitted information to respond to enquiries, arrange and manage appointment requests, provide requested services, operate the website, and protect the service from misuse. Appointment requests remain subject to confirmation by the clinic. Information in the optional visit statistics is used to review website traffic.</p>

        <h2>Health information</h2>
        <p>The appointment form includes an optional field for symptoms or health concerns. Please share only what is relevant to your request. The form is not an emergency service, and submitting it does not create a treatment relationship or confirm an appointment.</p>

        <h2>Service providers and external content</h2>
        <p>Information is stored by the providers that host and operate the website for the clinic. Some pages also request assets from Bootstrap and Font Awesome content delivery networks, display fallback photography from Unsplash, or embed Google Maps. When your browser loads those resources, the relevant provider may receive technical information such as your IP address and browser details under its own privacy terms. Embedded map content may use its own cookies.</p>

        <h2>Retention and security</h2>
        <p>Records are kept in the clinic's website database and retained for as long as the clinic needs them to manage requests, provide services, maintain the website, or meet applicable record-keeping obligations. Website visit records do not currently have an automatic deletion schedule. The clinic uses access controls and standard application security measures, but no internet transmission or storage system can be guaranteed completely secure.</p>

        <h2>Your choices and questions</h2>
        <p>You can reject optional analytics cookies or change your choice using the Cookie preferences control at the bottom of the page. For questions about information you submitted or to request that it be reviewed or removed, contact the clinic. Requests may be subject to applicable record-keeping requirements.</p>
        <p>Use the <a href="{{ route('contact') }}">contact page</a> to reach the clinic.</p>
    </div>
</section>
@endsection

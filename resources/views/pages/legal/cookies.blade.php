@extends('layouts.app')

@section('title', 'Cookie Policy | Aarogya Physiotherapy Center')
@section('description', 'A plain-language guide to the cookies this website uses, why they are needed, and how to change your choices.')

@section('content')
<section class="legal-page section-padding">
    <div class="container legal-page-container">
        <h1>Cookie Policy</h1>
        <p class="legal-updated">Last updated: November 7, 2026</p>

        <p>Cookies are small files your browser keeps for a website. This site uses a few cookies to keep forms and other essential features working. We ask before using an optional cookie to count website visits.</p>

        <h2>Cookies used on this website</h2>
        <div class="table-responsive legal-cookie-table">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">Cookie</th>
                        <th scope="col">What it does</th>
                        <th scope="col">How long it stays</th>
                        <th scope="col">Your choice</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Session and security cookies</th>
                        <td>Keep pages, forms, and secure staff sign-in working. They help the site recognise your browser during a visit and protect forms against forged requests.</td>
                        <td>For the session or as set by the site's session settings.</td>
                        <td>Essential. They are used when you use the site.</td>
                    </tr>
                    <tr>
                        <th scope="row">cookie_consent</th>
                        <td>Remembers whether you accepted or rejected optional visit statistics, so we do not ask again on every page.</td>
                        <td>Up to 12 months.</td>
                        <td>Set when you choose Accept optional or Reject optional.</td>
                    </tr>
                    <tr>
                        <th scope="row">arogya_visitor_id</th>
                        <td>Helps count repeat visits for the site's summary statistics. The random identifier is hashed before it is saved with a page path and visit time.</td>
                        <td>Up to 12 months.</td>
                        <td>Optional. Used only after you accept visit statistics.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h2>Your choice and your appointments</h2>
        <p>Choose <strong>Accept optional</strong> if you are comfortable helping us understand which pages people visit. Choose <strong>Reject optional</strong> to keep visit statistics off. Either choice lets you browse the site, send an appointment request, and contact the clinic. Your appointment and enquiry details are handled separately from these visit statistics.</p>

        <h2>Changing your choice</h2>
        <p>Use the <strong>Cookie preferences</strong> button at the bottom of any page to change your choice. If you reject or withdraw permission, we stop recording new visits and remove the optional visitor cookie from your browser. Statistics already saved may remain in the site's totals; rejecting cookies does not erase earlier records.</p>

        <h2>What staff can see</h2>
        <p>The website dashboard shows visit statistics from browsers that accepted the optional cookie. It does not show every person who visits the site, and it is not used to manage appointment requests. Staff manage appointments and enquiries in their own sections of the dashboard.</p>

        <h2>Maps and outside services</h2>
        <p>A map is loaded only if you choose to view it. Some pages also load fonts, styles, scripts, or images from other providers. Those providers may receive basic technical information from your browser and may use their own cookies. Our preference button does not control cookies set by another provider; you can review that provider's policy or change your browser settings.</p>

        <p>For more detail about how the clinic handles information, read the <a href="{{ route('privacy-policy') }}">Privacy Policy</a>. To ask a question, please use the <a href="{{ route('contact') }}">contact page</a>.</p>
    </div>
</section>
@endsection

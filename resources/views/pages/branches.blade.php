@extends('layouts.app')

@section('title', 'Our Branches | Aarogya Physiotherapy Center')

@section('content')

<section class="branches-hero">
    <div class="container text-center">
        <span class="branches-eyebrow">OUR LOCATIONS</span>
        <h1>Find an Aarogya Branch Near You</h1>
        <p>
            Visit one of our branches and let our physiotherapy team
            help you move better and live healthier.
        </p>
    </div>
</section>

<section class="branches-list-section">
    <div class="container">

        @if($branches->isNotEmpty())
            <div class="row g-4">

                @foreach($branches as $branch)
                    <div class="col-12">

                        <div class="branch-public-card">

                            {{-- LEFT SIDE: BRANCH DETAILS --}}
                            <div class="branch-public-body">

                                <div class="branch-heading">

                                    <div class="branch-public-image">
                                        @if($branch->image)
                                            <img
                                                src="{{ asset('storage/' . $branch->image) }}"
                                                alt="{{ $branch->name }}"
                                                loading="lazy"
                                            >
                                        @else
                                            <i class="fa-solid fa-hospital branch-image-placeholder"></i>
                                        @endif
                                    </div>

                                    <div>
                                        <h2>{{ $branch->name }}</h2>

                                        @if($branch->is_main)
                                            <span class="branch-main-badge">
                                                <i class="fa-solid fa-star me-1"></i>
                                                Main Branch
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                {{-- BASIC DETAILS: ALWAYS VISIBLE --}}
                                <div class="branch-contact-list">

                                    @if($branch->address || $branch->city || $branch->district || $branch->province)
                                        <div class="branch-contact-item">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <span>
                                                {{ $branch->address }}
                                                @if($branch->city || $branch->district || $branch->province)
                                                    <br>
                                                    {{ collect([$branch->city, $branch->district, $branch->province])->filter()->implode(', ') }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif

                                    @if($branch->phone)
                                        <div class="branch-contact-item">
                                            <i class="fa-solid fa-phone"></i>
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $branch->phone) }}">
                                                {{ $branch->phone }}
                                            </a>
                                        </div>
                                    @endif

                                    @if($branch->whatsapp)
                                        <div class="branch-contact-item">
                                            <i class="fa-brands fa-whatsapp"></i>
                                            <a
                                                href="https://wa.me/{{ preg_replace('/\D/', '', $branch->whatsapp) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                Contact on WhatsApp
                                            </a>
                                        </div>
                                    @endif

                                </div>

                                {{-- EXPANDABLE DETAILS --}}
                                <div class="branch-extra-details" id="branch-details-{{ $branch->id }}" hidden>

                                    @if($branch->email)
                                        <div class="branch-contact-item">
                                            <i class="fa-solid fa-envelope"></i>
                                            <a href="mailto:{{ $branch->email }}">
                                                {{ $branch->email }}
                                            </a>
                                        </div>
                                    @endif

                                    <div class="branch-hours">

                                        <h3>
                                            <i class="fa-regular fa-clock me-2"></i>
                                            Weekly Operating Hours
                                        </h3>

                                        @php
                                            $schedule = $branch->working_days ?? [];
                                            $days = [
                                                'Monday', 'Tuesday', 'Wednesday',
                                                'Thursday', 'Friday', 'Saturday', 'Sunday'
                                            ];
                                        @endphp

                                        @foreach($days as $day)
                                            @php
                                                $daySchedule = $schedule[$day] ?? [];
                                                $closed = $daySchedule['is_closed'] ?? false;
                                            @endphp

                                            <div class="branch-hour-row">
                                                <span>{{ $day }}</span>

                                                @if($closed)
                                                    <span class="branch-closed">Closed</span>
                                                @elseif(!empty($daySchedule['open']) && !empty($daySchedule['close']))
                                                    <span>
                                                        {{ \Carbon\Carbon::createFromFormat('H:i', $daySchedule['open'])->format('g:i A') }}
                                                        –
                                                        {{ \Carbon\Carbon::createFromFormat('H:i', $daySchedule['close'])->format('g:i A') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>

                                </div>

                                {{-- BUTTONS --}}
                                <div class="branch-card-actions">

                                    <button
                                        type="button"
                                        class="btn branch-show-more-button"
                                        aria-expanded="false"
                                        aria-controls="branch-details-{{ $branch->id }}"
                                        onclick="toggleBranchDetails(this)"
                                    >
                                        <span>Show More</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>

                                    @if($branch->google_maps_url)
                                        <a
                                            href="{{ $branch->google_maps_url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="btn branch-directions-button"
                                        >
                                            <i class="fa-solid fa-diamond-turn-right"></i>
                                            Get Directions
                                        </a>
                                    @elseif($branch->google_maps_embed_url)
                                        <a
                                            href="{{ $branch->google_maps_embed_url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="btn branch-directions-button"
                                        >
                                            <i class="fa-solid fa-map-location-dot"></i>
                                            Open Map
                                        </a>
                                    @endif

                                </div>

                            </div>

                            {{-- RIGHT SIDE: MAP --}}
                            <div class="branch-map">

                                @if($branch->google_maps_embed_url)
                                    <iframe
                                        src="{{ $branch->google_maps_embed_url }}"
                                        loading="lazy"
                                        allowfullscreen
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Map showing {{ $branch->name }}"
                                    ></iframe>
                                @else
                                    <div class="branch-map-unavailable">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                        <h5>Map unavailable</h5>
                                        <p>Map information for this branch has not been added yet.</p>
                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>
        @else

            <div class="branches-empty">
                <i class="fa-solid fa-location-dot"></i>
                <h3>Our Branches</h3>
                <p>Branch location information will be available soon.</p>
            </div>

        @endif

    </div>
</section>

<script>
    function toggleBranchDetails(button) {
        const detailsId = button.getAttribute('aria-controls');
        const details = document.getElementById(detailsId);
        const isExpanded = button.getAttribute('aria-expanded') === 'true';

        details.hidden = isExpanded;
        button.setAttribute('aria-expanded', String(!isExpanded));

        button.querySelector('span').textContent = isExpanded
            ? 'Show More'
            : 'Show Less';

        button.querySelector('i').classList.toggle('fa-chevron-down', isExpanded);
        button.querySelector('i').classList.toggle('fa-chevron-up', !isExpanded);
    }
</script>

@endsection
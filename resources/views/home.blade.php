@extends('layouts.app', ['footerVariant' => 'dark'])

@section('body_class', 'page-home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    {{-- HERO --}}
    @php
        $slides = [
            ['images/pages/about-2.jpg', 'Peserta menempelkan sticky notes pada sesi ideasi'],
            ['images/pages/hero.jpg', 'Peserta dan pembicara Forum Teknologi Pertanian Digital Indonesia'],
            ['images/pages/about-field.jpg', 'Kegiatan lapangan Digital Agtech Indonesia'],
            ['images/gallery/gallery-1.jpg', 'Galeri event Digital Agtech Indonesia'],
        ];
    @endphp
    <section class="hero">
        <div class="hero-slides">
            @foreach ($slides as [$image, $alt])
                <div @class(['hero-slide', 'active' => $loop->first])>
                    <img src="{{ asset($image) }}" alt="{{ $alt }}" @if (! $loop->first) loading="lazy" @endif>
                </div>
            @endforeach
        </div>
        <div class="hero-gradient"></div>
        <div class="hero-text">
            <div class="hero-content">
                <h1 class="hero-title">{{ __('Be the Next Agritech Changemaker.') }}</h1>
                <p class="hero-sub">{{ __('Join the next generation of agritech innovators — learn, connect, and build what matters.') }}</p>
                <a href="#events" class="btn btn-primary">{{ __('Discover More') }} <x-icon name="arrow-right" /></a>
            </div>
        </div>
        <div class="hero-dots">
            @foreach ($slides as $slide)
                <button @class(['hero-dot', 'active' => $loop->first]) data-slide="{{ $loop->index }}" aria-label="Slide {{ $loop->iteration }}"></button>
            @endforeach
        </div>
    </section>

    {{-- CURRENT EVENT --}}
    @if ($featuredEvent)
        <section class="current-event" id="program">
            <div class="wrap">
                <div class="current-event-grid">
                    <div>
                        <p class="current-event-label">{{ __('Current Event') }}</p>
                        <h2 class="current-event-title">{{ $featuredEvent->title }}</h2>
                        <div class="current-event-body">{!! $featuredEvent->description !!}</div>
                        @if ($featuredEvent->workshop_cities)
                            <div class="city-tags">
                                @foreach ($featuredEvent->workshop_cities as $city)
                                    <span class="city-tag">{{ $city }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="event-cta-row">
                            <a href="{{ route('events.show', $featuredEvent) }}#register" class="btn btn-primary">{{ __('Register to Join') }} <x-icon name="arrow-right" /></a>
                            <a href="{{ route('events.show', $featuredEvent) }}" class="btn btn-lime">{{ __('View Event') }} <x-icon name="arrow-right" /></a>
                        </div>
                    </div>
                    @if ($featuredEvent->flyer_url)
                        <div class="event-flyer">
                            <img src="{{ $featuredEvent->flyer_url }}" alt="Flyer {{ $featuredEvent->title }}" width="760" height="950">
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- EVENT SCHEDULE --}}
    @if ($events->isNotEmpty())
        <section class="event-schedule">
            <div class="wrap">
                <div class="schedule-grid">
                    <div class="schedule-left">
                        <p class="eyebrow">{{ __('Event Schedule') }}</p>
                        <h2 class="section-title">{{ __('Event Schedule') }}</h2>
                        <div class="schedule-events">
                            @foreach ($events as $event)
                                <a href="{{ route('events.show', $event) }}" class="schedule-event">
                                    <div class="schedule-date-card">
                                        <span class="day-num">{{ $event->starts_at->format('d') }}</span>
                                        <span class="day-month">{{ $event->starts_at->format('M Y') }}</span>
                                    </div>
                                    <div class="schedule-event-info">
                                        <h4>{{ $event->title }}</h4>
                                        <p>{{ $event->type->label() }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @if ($featuredEvent?->sessions->isNotEmpty())
                        @include('partials.rundown', ['sessions' => $featuredEvent->sessions])
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- SPEAKERS --}}
    @if ($speakers->isNotEmpty())
        <section class="speakers">
            <div class="wrap">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">{{ __('Our Speakers') }}</p>
                        <h2 class="section-title">{{ __('Meet Our Speakers') }}</h2>
                    </div>
                    <a href="{{ route('speakers.index') }}" class="btn btn-outline btn-sm">{{ __('View All Speakers') }} <x-icon name="arrow-right" /></a>
                </div>
                <div class="speakers-grid">
                    @foreach ($speakers as $speaker)
                        @include('partials.speaker-card', ['showExpertise' => true])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ABOUT --}}
    <section class="about" id="about">
        <div class="wrap">
            <div class="about-grid">
                <div class="about-stats">
                    @foreach (config('site.home_stats') as $stat)
                        <div @class(['stat-card', 'accent' => $stat['accent']])>
                            <span class="stat-icon"><x-icon :name="$stat['icon']" /></span>
                            <span class="stat-num">{{ $stat['value'] }}</span>
                            <span class="stat-label">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="about-content">
                    <p class="eyebrow">{{ __('About') }}</p>
                    <h2>{{ __('Your Gateway to the AgTech Ecosystem') }}</h2>
                    <p class="about-body">{{ __('A platform for discovering AgTech events and programs designed to help young innovators learn, connect, and grow.') }}</p>
                    <div class="about-images">
                        <div class="about-img"><img src="{{ asset('images/pages/about-1.jpg') }}" alt="Peserta event Digital Agtech Indonesia" loading="lazy"></div>
                        <div class="about-img"><img src="{{ asset('images/pages/about-2.jpg') }}" alt="Sesi brainstorming dengan sticky notes" loading="lazy"></div>
                    </div>
                    <a href="{{ route('programs.self-learning') }}" class="btn btn-primary">{{ __('Discover More') }} <x-icon name="arrow-right" /></a>
                </div>
            </div>
        </div>
    </section>

    {{-- UPCOMING EVENTS --}}
    <section class="upcoming-events" id="events">
        <div class="wrap">
            <div class="section-head section-head--center">
                <div>
                    <p class="eyebrow">{{ __('Upcoming Events') }}</p>
                    <h2 class="section-title">{{ __('Discover Events for Your Big Ideas') }}</h2>
                </div>
            </div>
            @if ($events->isNotEmpty())
                <div class="event-tabs" role="tablist">
                    <button class="tab-btn active" data-type="all">{{ __('All') }}</button>
                    @foreach (\App\Enums\EventType::cases() as $type)
                        <button class="tab-btn" data-type="{{ $type->value }}">{{ $type->label() }}</button>
                    @endforeach
                </div>
                <div class="events-grid" id="eventsGrid">
                    @foreach ($events as $event)
                        @include('partials.event-card')
                    @endforeach
                </div>
            @else
                <p class="empty-state">{{ __('New events are coming soon. Stay tuned!') }}</p>
            @endif
        </div>
    </section>

    {{-- GALLERY --}}
    @if ($photos->isNotEmpty())
        <section class="gallery" id="gallery">
            <div class="wrap">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">{{ __('Event Gallery') }}</p>
                        <h2 class="section-title">{{ __('Stories from Previous Events') }}</h2>
                    </div>
                    <a href="{{ route('gallery.index') }}" class="btn btn-outline btn-sm">{{ __('View All Photos') }} <x-icon name="arrow-right" /></a>
                </div>
                <div class="gallery-grid">
                    @foreach ($photos as $photo)
                        <div class="gallery-img"><img src="{{ $photo->image_url }}" alt="{{ $photo->caption }}" loading="lazy"></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- PARTNERS --}}
    @if ($partners->isNotEmpty())
        <section class="partners" id="partners">
            <div class="wrap">
                <p class="eyebrow">{{ __('Our Partners') }}</p>
                <h2 class="section-title">{{ __('Proudly Supported By') }}</h2>
                <div class="partners-logos">
                    @foreach ($partners as $partner)
                        @if ($partner->website_url)
                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener"><img class="partner-logo" src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" loading="lazy"></a>
                        @else
                            <img class="partner-logo" src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" loading="lazy">
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- NEWS --}}
    @if ($posts->isNotEmpty())
        <section class="news" id="news">
            <div class="wrap">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">{{ __('News') }}</p>
                        <h2 class="section-title">{{ __('Latest News & Insights') }}</h2>
                    </div>
                    <a href="{{ route('news.index') }}" class="btn btn-outline btn-sm">{{ __('View All News') }} <x-icon name="arrow-right" /></a>
                </div>
                <div class="news-grid">
                    @foreach ($posts as $post)
                        @include('partials.news-card')
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

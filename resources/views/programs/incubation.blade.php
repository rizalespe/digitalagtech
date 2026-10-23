@extends('layouts.app')

@section('title', 'Business Incubation')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', [
        'title' => __('Business Incubation'),
        'crumbs' => [__('Program') => route('programs.self-learning'), __('Business Incubation') => null],
    ])

    @include('programs._tabs')

    <section class="bi-intro">
        <p class="eyebrow-sm">{{ __('Program') }}</p>
        <h2>{{ __('Business Incubation Program') }}</h2>
        <p>{{ __('A structured program designed to support early-stage AgTech startups through practical mentorship, capacity building, and valuable network access. We help young innovators develop their ideas, strengthen their businesses, and turn agricultural challenges into scalable solutions for a more sustainable future.') }}</p>
        @if ($programs->isNotEmpty())
            <div class="bi-cards">
                @foreach ($programs as $program)
                    <div class="bi-card">
                        @if ($program->cover_image_url)
                            <img src="{{ $program->cover_image_url }}" alt="Kegiatan {{ $program->name }}" loading="lazy">
                        @endif
                        <h3>{{ $program->name }}</h3>
                        <a href="#{{ $program->slug }}" class="btn-view">{{ __('View More') }} <x-icon name="arrow-right" /></a>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="bi-numbers">
        <img src="{{ asset('images/pages/bi-numbers-bg.jpg') }}" alt="" loading="lazy">
        <p class="eyebrow-sm">{{ __('Achievement') }}</p>
        <h2>{{ __('Digital Agtech in Numbers') }}</h2>
        <div class="stats">
            @foreach ($stats as $stat)
                <div class="stat">
                    <x-icon name="group" />
                    <p class="stat-value">{{ $stat['value'] }}</p>
                    <p class="stat-label">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    @foreach ($programs as $program)
        <section class="bi-program" id="{{ $program->slug }}">
            <p class="eyebrow-sm">{{ __('Business Incubation Program') }}</p>
            <h2>{{ $program->name }}</h2>
            <p>{{ $program->description }}</p>
            @if ($program->photos->isNotEmpty())
                <div class="bi-gallery">
                    @foreach ($program->photos as $photo)
                        <img src="{{ $photo->image_url }}" alt="{{ $photo->caption }}" loading="lazy">
                    @endforeach
                </div>
            @endif
        </section>
    @endforeach
@endsection

@extends('layouts.app')

@section('title', 'Self-Learning Program')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', [
        'title' => __('Self-Learning Program'),
        'crumbs' => [__('Program') => route('programs.self-learning'), __('Self-Learning Program') => null],
    ])

    @include('programs._tabs')

    <section class="slp-intro">
        <p class="eyebrow-sm">{{ __('Program') }}</p>
        <h2>{{ __('Self-Learning Program') }}</h2>
        <p>{{ __('The Self-Learning Program is designed for aspiring AgTech entrepreneurs who want to develop and validate their ideas through structured self-paced toolkits. Each module walks you through a critical stage of the startup journey — from discovering real problems in agriculture to scaling a profitable venture.') }}</p>
        <div class="slp-photos">
            <img src="{{ asset('images/pages/slp-photo-1.jpg') }}" alt="Peserta menempel sticky notes di papan" loading="lazy">
            <img src="{{ asset('images/pages/slp-photo-2.jpg') }}" alt="Peserta bekerja dengan laptop" loading="lazy">
            <img src="{{ asset('images/pages/slp-photo-3.jpg') }}" alt="Peserta menulis catatan di meja" loading="lazy">
        </div>
    </section>

    <section class="assessment" id="assessment">
        <div>
            <span class="pill-label">{{ __('Startup Assessment') }}</span>
            <h2>{{ __('Where is Your Startup Today?') }}</h2>
            <p>{{ __('Take a short assessment to discover your current startup stage and get personalized learning recommendations tailored to where you are right now.') }}</p>
            <div class="assessment-cta">
                {{-- TODO: point to the assessment flow once it is built. --}}
                <a href="{{ auth()->check() ? '#assessment' : route('register') }}" class="btn-assess">
                    {{ auth()->check() ? __('Assessment Coming Soon') : __('Take the Assessment') }}
                    <x-icon name="arrow-right" />
                </a>
                <span class="duration"><x-icon name="clock" />{{ __('5–7 minutes') }}</span>
            </div>
        </div>

        <div class="assess-card">
            <div class="assess-head">
                <strong>{{ __('Assessment Preview') }}</strong>
                <span class="live-badge">{{ __('Live Result') }}</span>
            </div>
            @include('programs._radar-preview')
        </div>
    </section>

    <section class="toolkit" id="toolkit">
        <p class="eyebrow-sm">{{ __('Toolkit') }}</p>
        <h2>{{ __('Your Startup Journey, Step by Step') }}</h2>
        <p class="toolkit-sub">{{ __('Each toolkit is an interactive assessment that helps you make progress through a critical milestone in building your AgTech venture.') }}</p>

        <div class="toolkit-filter" role="tablist">
            <button class="active" data-stage="all">{{ __('All') }}</button>
            @foreach ($stages as $stage)
                <button data-stage="{{ $stage->value }}">{{ $stage->label() }}</button>
            @endforeach
        </div>

        <div class="toolkit-grid">
            @forelse ($toolkits as $toolkit)
                <article class="toolkit-card" data-stage="{{ $toolkit->stage->value }}">
                    <div class="toolkit-thumb">
                        @if ($toolkit->thumbnail_url)
                            <img src="{{ $toolkit->thumbnail_url }}" alt="Cover toolkit {{ $toolkit->title }}" loading="lazy">
                        @endif
                        @if ($toolkit->video_url)
                            <button type="button" class="play-btn" data-video="{{ $toolkit->video_url }}" aria-label="Putar video {{ $toolkit->title }}"><x-icon name="play" /></button>
                        @endif
                    </div>
                    <div class="toolkit-body">
                        <span class="stage-tag">{{ $toolkit->stage->label() }}</span>
                        <h3>{{ $toolkit->title }}</h3>
                        <p>{{ $toolkit->description }}</p>
                        <ul class="toolkit-meta">
                            <li><x-icon name="tool" />{{ $toolkit->tools_count }} {{ __('Tools') }}</li>
                            <li><x-icon name="activity" />{{ $toolkit->activities_count }} {{ __('Activities') }}</li>
                            @if ($toolkit->duration_label)
                                <li><x-icon name="clock" />{{ $toolkit->duration_label }}</li>
                            @endif
                        </ul>
                        @if ($toolkit->pdf_url)
                            <a href="{{ $toolkit->pdf_url }}" class="btn-download" download>{{ __('Download PDF') }} <x-icon name="arrow-right" /></a>
                        @else
                            <span class="btn-download is-disabled">{{ __('PDF Coming Soon') }}</span>
                        @endif
                    </div>
                </article>
            @empty
                <p class="empty-state">{{ __('Toolkits will be published soon.') }}</p>
            @endforelse
        </div>
    </section>

    <div class="page-spacer"></div>

    {{-- Video modal --}}
    <div id="videoModal" class="video-modal" role="dialog" aria-modal="true" aria-label="Video player" hidden>
        <div class="video-modal-backdrop"></div>
        <div class="video-modal-box">
            <button type="button" class="video-modal-close" aria-label="Tutup video">&times;</button>
            <div class="video-modal-ratio">
                <iframe id="videoFrame" src="" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
            <a id="videoExternalLink" href="#" target="_blank" rel="noopener" class="video-modal-external">
                {{ __('Watch on YouTube ↗') }}
            </a>
        </div>
    </div>
@endsection

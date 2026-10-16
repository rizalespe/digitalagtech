@extends('layouts.app')

@section('title', 'Self-Learning Program')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', [
        'title' => 'Self-Learning Program',
        'crumbs' => ['Program' => route('programs.self-learning'), 'Self-Learning Program' => null],
    ])

    @include('programs._tabs')

    <section class="slp-intro">
        <p class="eyebrow-sm">Program</p>
        <h2>Self-Learning Program</h2>
        <p>The Self-Learning Program is designed for aspiring AgTech entrepreneurs who want to develop and validate their ideas through structured self-paced toolkits. Each module walks you through a critical stage of the startup journey — from discovering real problems in agriculture to scaling a profitable venture.</p>
        <div class="slp-photos">
            <img src="{{ asset('images/pages/slp-photo-1.jpg') }}" alt="Peserta menempel sticky notes di papan" loading="lazy">
            <img src="{{ asset('images/pages/slp-photo-2.jpg') }}" alt="Peserta bekerja dengan laptop" loading="lazy">
            <img src="{{ asset('images/pages/slp-photo-3.jpg') }}" alt="Peserta menulis catatan di meja" loading="lazy">
        </div>
    </section>

    <section class="assessment" id="assessment">
        <div>
            <span class="pill-label">Startup Assessment</span>
            <h2>Where is Your<br><span>Startup Today?</span></h2>
            <p>Take a short assessment to discover your current startup stage and get personalized learning recommendations tailored to where you are right now.</p>
            <div class="assessment-cta">
                {{-- TODO: point to the assessment flow once it is built. --}}
                <a href="{{ auth()->check() ? '#assessment' : route('register') }}" class="btn-assess">
                    {{ auth()->check() ? 'Assessment Coming Soon' : 'Take the Assessment' }}
                    <x-icon name="arrow-right" />
                </a>
                <span class="duration"><x-icon name="clock" />5–7 minutes</span>
            </div>
        </div>

        <div class="assess-card">
            <div class="assess-head">
                <strong>Assessment Preview</strong>
                <span class="live-badge">Live Result</span>
            </div>
            @include('programs._radar-preview')
        </div>
    </section>

    <section class="toolkit" id="toolkit">
        <p class="eyebrow-sm">Toolkit</p>
        <h2>Your Startup Journey, Step by Step</h2>
        <p class="toolkit-sub">Each toolkit is an interactive assessment that helps you make progress through a critical milestone in building your AgTech venture.</p>

        <div class="toolkit-filter" role="tablist">
            <button class="active" data-stage="all">All</button>
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
                            <a href="{{ $toolkit->video_url }}" class="play-btn" target="_blank" rel="noopener" aria-label="Putar video {{ $toolkit->title }}"><x-icon name="play" /></a>
                        @endif
                    </div>
                    <div class="toolkit-body">
                        <span class="stage-tag">{{ $toolkit->stage->label() }}</span>
                        <h3>{{ $toolkit->title }}</h3>
                        <p>{{ $toolkit->description }}</p>
                        <ul class="toolkit-meta">
                            <li><x-icon name="tool" />{{ $toolkit->tools_count }} Tools</li>
                            <li><x-icon name="activity" />{{ $toolkit->activities_count }} Activities</li>
                            @if ($toolkit->duration_label)
                                <li><x-icon name="clock" />{{ $toolkit->duration_label }}</li>
                            @endif
                        </ul>
                        @if ($toolkit->pdf_url)
                            <a href="{{ $toolkit->pdf_url }}" class="btn-download" download>Download PDF <x-icon name="arrow-right" /></a>
                        @else
                            <span class="btn-download is-disabled">PDF Coming Soon</span>
                        @endif
                    </div>
                </article>
            @empty
                <p class="empty-state">Toolkits will be published soon.</p>
            @endforelse
        </div>
    </section>

    <div class="page-spacer"></div>
@endsection

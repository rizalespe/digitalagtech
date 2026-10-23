@extends('layouts.app')

@section('title', $showPast ? __('Past Events') : __('Events'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', [
        'title' => __('Discover Events for Your Big Ideas'),
        'crumbs' => [__('Events') => null],
    ])

    <section class="page-section">
        <nav class="event-tabs" aria-label="Event filter">
            <a href="{{ route('events.index') }}" @class(['tab-btn', 'active' => ! $showPast])>{{ __('Upcoming') }}</a>
            <a href="{{ route('events.index', ['when' => 'past']) }}" @class(['tab-btn', 'active' => $showPast])>{{ __('Past Events') }}</a>
        </nav>

        @if ($events->isNotEmpty())
            <div class="events-grid">
                @foreach ($events as $event)
                    @include('partials.event-card')
                @endforeach
            </div>
            {{ $events->links() }}
        @else
            <p class="empty-state">
                {{ $showPast ? __('No past events yet.') : __('No upcoming events right now. Check back soon!') }}
            </p>
        @endif
    </section>
@endsection

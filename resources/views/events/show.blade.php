@extends('layouts.app')

@section('title', $event->title)
@section('description', $event->summary)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', [
        'title' => $event->title,
        'crumbs' => [__('Events') => route('events.index'), $event->type->label() => null],
    ])

    <section class="page-section">
        <div class="event-detail">
            <div>
                @if ($event->thumbnail_url)
                    <div class="event-detail-cover"><img src="{{ $event->thumbnail_url }}" alt="{{ $event->title }}"></div>
                @endif

                <div class="prose">{!! $event->description !!}</div>

                @if ($event->workshop_cities)
                    <div class="prose" style="margin-top: 16px">
                        <p><strong>{{ __('Workshop cities:') }}</strong> {{ implode(', ', $event->workshop_cities) }}</p>
                    </div>
                @endif

                @if ($event->sessions->isNotEmpty())
                    <h2>{{ __('Rundown') }}</h2>
                    @include('partials.rundown', ['sessions' => $event->sessions])
                @endif

                @if ($event->speakers->isNotEmpty())
                    <h2>{{ __('Speakers') }}</h2>
                    <div class="speakers-grid">
                        @foreach ($event->speakers as $speaker)
                            @include('partials.speaker-card')
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="event-aside" id="register">
                <p class="event-type-label">{{ $event->type->label() }}</p>
                <div class="event-meta">
                    <div class="event-meta-row"><x-icon name="calendar" />{{ $event->starts_at->translatedFormat('l, j F Y') }}</div>
                    <div class="event-meta-row"><x-icon name="clock" />{{ $event->time_range }}</div>
                    @if ($event->location)
                        <div class="event-meta-row"><x-icon name="pin" />{{ $event->location }}</div>
                    @endif
                </div>

                @php($isRegistered = $registration && $registration->status !== \App\Enums\RegistrationStatus::Cancelled)

                @if ($isRegistered)
                    <span class="status-pill">{{ __("You're registered") }}</span>
                    <form method="POST" action="{{ route('events.registration.destroy', $event) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline">{{ __('Cancel Registration') }}</button>
                    </form>
                @elseif ($event->acceptsRegistrations())
                    @auth
                        <form method="POST" action="{{ route('events.registration.store', $event) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">{{ __('Register to Join') }} <x-icon name="arrow-right" /></button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login to Register') }} <x-icon name="arrow-right" /></a>
                        <p class="event-aside-note">{{ __('No account yet?') }} <a href="{{ route('register') }}"><strong>{{ __('Create one') }}</strong></a></p>
                    @endauth
                @else
                    <button type="button" class="btn btn-primary" disabled>{{ __('Registration Closed') }}</button>
                @endif

                @if ($event->quota)
                    <p class="event-aside-note">{{ __('Limited to :quota participants.', ['quota' => $event->quota]) }}</p>
                @endif
            </aside>
        </div>
    </section>
@endsection

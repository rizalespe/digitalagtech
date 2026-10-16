@extends('layouts.app')

@section('title', 'Our Speakers')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', ['title' => 'Meet Our Speakers', 'crumbs' => ['Our Speakers' => null]])

    <section class="page-section">
        @if ($speakers->isNotEmpty())
            <div class="speakers-grid speakers-grid--page">
                @foreach ($speakers as $speaker)
                    @include('partials.speaker-card')
                @endforeach
            </div>
            {{ $speakers->links() }}
        @else
            <p class="empty-state">Speakers will be announced soon.</p>
        @endif
    </section>
@endsection

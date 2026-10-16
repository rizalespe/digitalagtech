@extends('layouts.app')

@section('title', 'News & Insights')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', ['title' => 'Latest News & Insights', 'crumbs' => ['News' => null]])

    <section class="page-section">
        @if ($posts->isNotEmpty())
            <div class="news-grid">
                @foreach ($posts as $post)
                    @include('partials.news-card')
                @endforeach
            </div>
            {{ $posts->links() }}
        @else
            <p class="empty-state">No news yet.</p>
        @endif
    </section>
@endsection

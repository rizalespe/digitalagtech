@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->excerpt)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', ['title' => $post->title, 'crumbs' => ['News' => route('news.index'), 'Article' => null]])

    <section class="page-section">
        <article class="article">
            <div class="article-meta">
                <span>{{ $post->author_name }}</span>
                <span>{{ $post->published_at->translatedFormat('j F Y') }}</span>
            </div>
            @if ($post->thumbnail_url)
                <div class="article-cover"><img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"></div>
            @endif
            <div class="prose">{!! $post->body !!}</div>
        </article>
    </section>

    @if ($related->isNotEmpty())
        <section class="page-section page-section--soft">
            <div class="section-head">
                <div>
                    <p class="eyebrow">News</p>
                    <h2 class="section-title">More Stories</h2>
                </div>
                <a href="{{ route('news.index') }}" class="btn btn-outline btn-sm">View All News <x-icon name="arrow-right" /></a>
            </div>
            <div class="news-grid">
                @foreach ($related as $post)
                    @include('partials.news-card')
                @endforeach
            </div>
        </section>
    @endif
@endsection

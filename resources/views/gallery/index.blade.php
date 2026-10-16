@extends('layouts.app')

@section('title', 'Gallery')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    @include('partials.page-hero', ['title' => 'Stories from Previous Events', 'crumbs' => ['Gallery' => null]])

    <section class="page-section">
        @if ($photos->isNotEmpty())
            <div class="gallery-grid">
                @foreach ($photos as $photo)
                    <figure class="gallery-img">
                        <img src="{{ $photo->image_url }}" alt="{{ $photo->caption }}" loading="lazy">
                    </figure>
                @endforeach
            </div>
            {{ $photos->links() }}
        @else
            <p class="empty-state">Photos will be added after our next event.</p>
        @endif
    </section>
@endsection

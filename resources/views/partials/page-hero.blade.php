{{-- Usage: @include('partials.page-hero', ['title' => '...', 'crumbs' => ['Program' => url, 'Current' => null]]) --}}
<section class="page-hero">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">{{ __('Home') }}</a>
        @foreach ($crumbs as $label => $url)
            <x-icon name="chevron-right" />
            @if ($url)
                <a href="{{ $url }}">{{ $label }}</a>
            @else
                <span>{{ $label }}</span>
            @endif
        @endforeach
    </div>
    <h1 class="page-hero-title">{{ $title }}</h1>
</section>

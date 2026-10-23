<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')@yield('title') — @endif{{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', 'A platform for discovering AgTech events and programs designed to help young innovators learn, connect, and grow.')">
    <link rel="icon" type="image/png" href="{{ asset('images/brand/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    @stack('styles')
</head>
<body class="@yield('body_class')">
    @include('partials.collab-bar')
    @include('partials.navbar')
    @include('partials.flash')

    <main id="top">
        @yield('content')
    </main>

    @include('partials.footer', ['variant' => $footerVariant ?? 'brand'])

    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>

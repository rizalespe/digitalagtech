<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;0,700;1,400&display=swap">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-page">
        <div class="auth-left">
            <img class="auth-left-img" src="{{ asset('images/gallery/gallery-1.jpg') }}" alt="Peserta Digital Agtech Indonesia">
            <div class="auth-left-overlay"></div>
            <div class="auth-left-content">
                <h1 class="auth-left-headline">Build. <em>Learn.</em> Grow.</h1>
                <p class="auth-left-sub">Join the AgTech ecosystem and discover opportunities to learn, connect, and grow your startup.</p>
            </div>
        </div>

        <div class="auth-right">
            <nav class="auth-tabs">
                <a href="{{ route('login') }}" @class(['auth-tab', 'active' => request()->routeIs('login')])>Login</a>
                <a href="{{ route('register') }}" @class(['auth-tab', 'active' => request()->routeIs('register')])>Register</a>
            </nav>

            <div class="auth-body">
                <div class="auth-header">
                    <div class="auth-title-wrap">
                        <h2 class="auth-title">@yield('heading')</h2>
                        <p class="auth-subtitle">@yield('subheading')</p>
                    </div>
                    <a href="{{ route('home') }}" class="auth-home-icon" aria-label="Ke halaman utama">
                        <x-icon name="home" />
                    </a>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

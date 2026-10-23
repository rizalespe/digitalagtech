@php
    $onHome = request()->routeIs('home');
    $anchor = fn (string $id) => $onHome ? "#{$id}" : route('home')."#{$id}";
    $links = [
        ['label' => __('Home'), 'href' => $onHome ? '#top' : route('home'), 'active' => $onHome],
        ['label' => __('About'), 'href' => $anchor('about'), 'active' => false],
        ['label' => __('Events'), 'href' => $onHome ? '#events' : route('events.index'), 'active' => request()->routeIs('events.*')],
        ['label' => __('Gallery'), 'href' => $onHome ? '#gallery' : route('gallery.index'), 'active' => request()->routeIs('gallery.*')],
        ['label' => __('News'), 'href' => $onHome ? '#news' : route('news.index'), 'active' => request()->routeIs('news.*')],
    ];
    $menus = [
        [
            'label' => __('Program'),
            'active' => request()->routeIs('programs.*'),
            'items' => [
                ['label' => __('Self-Learning Program'), 'href' => route('programs.self-learning')],
                ['label' => __('Business Incubation'), 'href' => route('programs.incubation')],
            ],
        ],
        [
            'label' => __('Learning'),
            'active' => false,
            'items' => [
                ['label' => __('Diagnose Test'), 'href' => route('assessment.index')],
                ['label' => __('Courses'), 'href' => route('programs.self-learning').'#toolkit'],
            ],
        ],
    ];
@endphp

<nav class="navbar">
    <div class="wrap nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('images/brand/logo.png') }}" alt="{{ config('app.name') }}" width="114" height="72">
        </a>

        <ul class="nav-links">
            @foreach ($links as $link)
                <li><a href="{{ $link['href'] }}" @class(['active' => $link['active']])>{{ $link['label'] }}</a></li>
            @endforeach
            @foreach ($menus as $menu)
                <li class="nav-item">
                    <a href="#" @class(['nav-parent', 'active' => $menu['active']]) onclick="return false" aria-haspopup="true">{{ $menu['label'] }}</a>
                    <ul class="dropdown">
                        @foreach ($menu['items'] as $item)
                            <li><a href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

        <div class="nav-actions">
            <div class="lang-switch">
                @if (app()->getLocale() === 'id')
                    <a href="{{ route('locale.switch', 'en') }}" class="lang-btn" title="{{ __('Switch to English') }}">EN</a>
                @else
                    <a href="{{ route('locale.switch', 'id') }}" class="lang-btn" title="{{ __('Switch to Indonesian') }}">ID</a>
                @endif
            </div>
            @auth
                <span class="nav-user">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">{{ __('Logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">{{ __('Register') }}</a>
            @endauth
        </div>

        <button class="nav-toggle" id="navToggle" aria-label="Menu" aria-controls="mobileNav">
            <x-icon name="menu" />
        </button>
    </div>

    <div class="mobile-nav" id="mobileNav">
        @foreach ($links as $link)
            <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
        @endforeach
        @foreach ($menus as $menu)
            @foreach ($menu['items'] as $item)
                <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
            @endforeach
        @endforeach
        <div class="mobile-nav-actions">
            <div class="lang-switch">
                @if (app()->getLocale() === 'id')
                    <a href="{{ route('locale.switch', 'en') }}" class="lang-btn" title="{{ __('Switch to English') }}">EN</a>
                @else
                    <a href="{{ route('locale.switch', 'id') }}" class="lang-btn" title="{{ __('Switch to Indonesian') }}">ID</a>
                @endif
            </div>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">{{ __('Logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">{{ __('Register') }}</a>
            @endauth
        </div>
    </div>
</nav>

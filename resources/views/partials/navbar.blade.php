@php
    $onHome = request()->routeIs('home');
    $anchor = fn (string $id) => $onHome ? "#{$id}" : route('home')."#{$id}";
    $links = [
        ['label' => 'Home', 'href' => $onHome ? '#top' : route('home'), 'active' => $onHome],
        ['label' => 'About', 'href' => $anchor('about'), 'active' => false],
        ['label' => 'Events', 'href' => $onHome ? '#events' : route('events.index'), 'active' => request()->routeIs('events.*')],
        ['label' => 'Gallery', 'href' => $onHome ? '#gallery' : route('gallery.index'), 'active' => request()->routeIs('gallery.*')],
        ['label' => 'News', 'href' => $onHome ? '#news' : route('news.index'), 'active' => request()->routeIs('news.*')],
    ];
    $menus = [
        [
            'label' => 'Program',
            'active' => request()->routeIs('programs.*'),
            'items' => [
                ['label' => 'Self-Learning Program', 'href' => route('programs.self-learning')],
                ['label' => 'Business Incubation', 'href' => route('programs.incubation')],
            ],
        ],
        [
            'label' => 'Learning',
            'active' => false,
            'items' => [
                ['label' => 'Diagnose Test', 'href' => route('programs.self-learning').'#assessment'],
                ['label' => 'Courses', 'href' => route('programs.self-learning').'#toolkit'],
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
            @auth
                <span class="nav-user">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
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
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
            @endauth
        </div>
    </div>
</nav>

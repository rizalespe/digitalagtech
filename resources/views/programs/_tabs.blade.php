<div class="program-tabs">
    <a href="{{ route('programs.self-learning') }}" @class(['program-tab', 'active' => request()->routeIs('programs.self-learning')]) @if (request()->routeIs('programs.self-learning')) aria-current="page" @endif>{{ __('Self-Learning Program') }}</a>
    <a href="{{ route('programs.incubation') }}" @class(['program-tab', 'active' => request()->routeIs('programs.incubation')]) @if (request()->routeIs('programs.incubation')) aria-current="page" @endif>{{ __('Business Incubation') }}</a>
</div>

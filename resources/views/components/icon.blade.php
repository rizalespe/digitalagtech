@props(['name'])

@switch($name)
    @case('arrow-right')
        <svg {{ $attributes->merge(['class' => 'arrow-icon']) }} viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="9" x2="15" y2="9"/><polyline points="9 3 15 9 9 15"/></svg>
        @break
    @case('arrow-left')
        <svg {{ $attributes }} viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="15" y1="9" x2="3" y2="9"/><polyline points="9 3 3 9 9 15"/></svg>
        @break
    @case('chevron-right')
        <svg {{ $attributes }} width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><polyline points="4 2 8 6 4 10"/></svg>
        @break
    @case('menu')
        <svg {{ $attributes }} width="22" height="22" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="6" x2="19" y2="6"/><line x1="3" y1="11" x2="19" y2="11"/><line x1="3" y1="16" x2="19" y2="16"/></svg>
        @break
    @case('calendar')
        <svg {{ $attributes }} viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="1" y="2" width="14" height="13" rx="1.5"/><line x1="1" y1="6" x2="15" y2="6"/><line x1="5" y1="1" x2="5" y2="4"/><line x1="11" y1="1" x2="11" y2="4"/></svg>
        @break
    @case('clock')
        <svg {{ $attributes }} viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><polyline points="8 4.5 8 8 10.5 10.5"/></svg>
        @break
    @case('pin')
        <svg {{ $attributes }} viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M8 1.5C5.5 1.5 3 3.7 3 6.5c0 4 5 9 5 9s5-5 5-9c0-2.8-2.5-5-5-5z"/><circle cx="8" cy="6.5" r="2"/></svg>
        @break
    @case('user')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
        @break
    @case('linkedin')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
        @break
    @case('instagram')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        @break
    @case('x')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.23H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        @break
    @case('youtube')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 7.5s-.2-1.6-.9-2.3c-.9-.9-1.9-.9-2.3-1C16.6 4 12 4 12 4s-4.6 0-7.8.2c-.4.1-1.4.1-2.3 1C1.2 5.9 1 7.5 1 7.5S.8 9.4.8 11.2v1.7c0 1.9.2 3.7.2 3.7s.2 1.6.9 2.3c.9.9 2 .9 2.5 1 1.8.2 7.6.2 7.6.2s4.6 0 7.8-.2c.4-.1 1.4-.1 2.3-1 .7-.7.9-2.3.9-2.3s.2-1.9.2-3.7v-1.7c0-1.9-.2-3.7-.2-3.7zM9.7 15V8.6l6.1 3.2-6.1 3.2z"/></svg>
        @break
    @case('play')
        <svg {{ $attributes }} viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M5 3.5v13l11-6.5z"/></svg>
        @break
    @case('tool')
        <svg {{ $attributes }} viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M10.5 2.5a3 3 0 00-3.6 3.9L2.5 10.8v2.7h2.7l4.4-4.4a3 3 0 003.9-3.6l-1.9 1.9-1.9-.5-.5-1.9z"/></svg>
        @break
    @case('activity')
        <svg {{ $attributes }} viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="1.5 8 4.5 8 6.5 3 9.5 13 11.5 8 14.5 8"/></svg>
        @break
    @case('home')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
        @break
    @case('mail')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
        @break
    @case('lock')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        @break
    @case('person')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a8.38 8.38 0 0 1 13 0"/></svg>
        @break
    @case('phone')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3.09 4.18 2 2 0 0 1 5.07 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 23 17z"/></svg>
        @break
    @case('eye-off')
        <svg {{ $attributes->merge(['class' => 'eye-off']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20C7 20 2.73 16.39 1 11a10.94 10.94 0 0 1 2.06-3.94M6.53 6.53A10.88 10.88 0 0 1 12 4c5 0 9.27 3.61 11 9a10.95 10.95 0 0 1-1.33 2.79M1 1l22 22"/><circle cx="12" cy="12" r="3"/></svg>
        @break
    @case('eye-on')
        <svg {{ $attributes->merge(['class' => 'eye-on']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:none" aria-hidden="true"><path d="M1 12C2.73 6.61 7 3 12 3s9.27 3.61 11 9c-1.73 5.39-6 9-11 9S2.73 17.39 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
        @break
    @case('pen')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 16.5l-1 4 4-1L19 8a2.83 2.83 0 0 0-4-4L4.5 16.5z"/><path d="M15 5l4 4"/></svg>
        @break
    @case('building')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="7" width="18" height="14" rx="1"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><path d="M9 11h1m4 0h1M9 15h1m4 0h1"/></svg>
        @break
    @case('users')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="7" r="3"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><circle cx="17" cy="7" r="3"/><path d="M21 21v-2a4 4 0 0 0-3-3.87"/></svg>
        @break
    @case('sprout')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22V12"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/><circle cx="12" cy="5" r="3"/><path d="M12 12c0-3 3-5 3-5"/><path d="M12 12c0-3-3-5-3-5"/></svg>
        @break
    @case('group')
        <svg {{ $attributes }} viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="20" cy="11" r="4.5"/><circle cx="9" cy="15" r="3.5"/><circle cx="31" cy="15" r="3.5"/><path d="M12 33v-5a8 8 0 0116 0v5"/><path d="M3 31v-3a6 6 0 019-5.2"/><path d="M37 31v-3a6 6 0 00-9-5.2"/></svg>
        @break
@endswitch

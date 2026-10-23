<footer @class(['footer', 'footer--brand' => $variant === 'brand'])>
    <div class="wrap">
        <div class="footer-grid">
            <div>
                <div class="footer-logo">Agtech</div>
                <p class="footer-body">{{ __("Southeast Asia's leading platform for agritech founders, innovators, and young agricultural entrepreneurs.") }}</p>
                <div class="footer-socials">
                    @foreach (config('site.socials') as $network => $url)
                        <a href="{{ $url }}" class="footer-social-btn" aria-label="{{ ucfirst($network) }}" target="_blank" rel="noopener">
                            <x-icon :name="$network" />
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="footer-col">
                <h4>{{ __('Events') }}</h4>
                <ul class="footer-links">
                    @foreach ($footerEvents as $footerEvent)
                        <li><a href="{{ route('events.show', $footerEvent) }}">{{ $footerEvent->title }} ({{ $footerEvent->type->label() }})</a></li>
                    @endforeach
                    <li><a href="{{ route('events.index') }}">{{ __('View All Events') }}</a></li>
                    <li><a href="{{ route('events.index', ['when' => 'past']) }}">{{ __('Past Events') }}</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>{{ __('About') }}</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}#about">{{ __('About Us') }}</a></li>
                    <li><a href="{{ route('speakers.index') }}">{{ __('Speakers') }}</a></li>
                    <li><a href="{{ route('home') }}#partners">{{ __('Partners') }}</a></li>
                    <li><a href="{{ route('gallery.index') }}">{{ __('Gallery') }}</a></li>
                    <li><a href="mailto:{{ config('site.contact.email') }}">{{ __('Contact Us') }}</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>{{ __('Stay Updated') }}</h4>
                <p class="footer-note">{{ __('Get early access to events, speaker announcements, and agritech insights.') }}</p>
                <form class="footer-newsletter" method="POST" action="{{ route('newsletter.store') }}">
                    @csrf
                    <label for="footerEmail" class="visually-hidden">Email</label>
                    <input type="email" name="email" class="footer-input" id="footerEmail" placeholder="{{ __('Your email') }}" required>
                    <button type="submit" class="footer-go-btn">{{ __('Go') }}</button>
                </form>
                <div class="footer-contact">
                    <strong>{{ __('Contact') }}</strong>
                    {{ config('site.contact.email') }}<br>
                    {{ config('site.contact.location') }}
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>{{ __('© :year powered by Jagoan Indonesia. All rights reserved.', ['year' => now()->year]) }}</p>
            <ul class="footer-bottom-links">
                <li><a href="#">{{ __('Terms') }}</a></li>
                <li><a href="#">{{ __('Privacy') }}</a></li>
                <li><a href="#">{{ __('Cookies') }}</a></li>
            </ul>
        </div>
    </div>
</footer>

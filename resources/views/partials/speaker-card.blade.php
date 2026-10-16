{{-- $speaker, $showExpertise (bool) --}}
<div class="speaker-card">
    @if ($speaker->photo_url)
        <div class="speaker-photo"><img src="{{ $speaker->photo_url }}" alt="{{ $speaker->name }}" loading="lazy"></div>
    @else
        <div class="speaker-photo speaker-photo--empty" role="img" aria-label="{{ $speaker->name }}">{{ $speaker->initials }}</div>
    @endif
    <div class="speaker-info">
        <p class="speaker-name">{{ $speaker->name }}</p>
        <p class="speaker-role">{{ ($showExpertise ?? false) && $speaker->expertise ? $speaker->expertise : $speaker->title }}</p>
        <div class="speaker-socials">
            @if ($speaker->linkedin_url)
                <a href="{{ $speaker->linkedin_url }}" class="social-btn" aria-label="LinkedIn {{ $speaker->name }}" target="_blank" rel="noopener"><x-icon name="linkedin" /></a>
            @endif
            @if ($speaker->instagram_url)
                <a href="{{ $speaker->instagram_url }}" class="social-btn" aria-label="Instagram {{ $speaker->name }}" target="_blank" rel="noopener"><x-icon name="instagram" /></a>
            @endif
        </div>
    </div>
</div>

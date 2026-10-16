<div class="event-card" data-type="{{ $event->type->value }}">
    <div class="event-thumb">
        @if ($event->thumbnail_url)
            <img src="{{ $event->thumbnail_url }}" alt="{{ $event->type->label() }} {{ $event->title }}" loading="lazy">
        @endif
    </div>
    <div class="event-body">
        <p class="event-type-label">{{ $event->type->label() }}</p>
        <p class="event-title">{{ $event->title }}</p>
        <div class="event-meta">
            <div class="event-meta-row"><x-icon name="calendar" />{{ $event->starts_at->translatedFormat('j F Y') }}</div>
            <div class="event-meta-row"><x-icon name="clock" />{{ $event->time_range }}</div>
            @if ($event->location)
                <div class="event-meta-row"><x-icon name="pin" />{{ $event->location }}</div>
            @endif
        </div>
        <a href="{{ route('events.show', $event) }}" class="detail-btn">Detail Event →</a>
    </div>
</div>

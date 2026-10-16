<div class="rundown">
    @foreach ($sessions as $session)
        <div class="rundown-item">
            <span class="rundown-dot"></span>
            <span class="rundown-time">{{ $session->time_range }}</span>
            <span class="rundown-event">{{ $session->title }}</span>
        </div>
    @endforeach
</div>

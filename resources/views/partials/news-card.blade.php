<div class="news-card">
    <div class="news-thumb">
        @if ($post->thumbnail_url)
            <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" loading="lazy">
        @endif
    </div>
    <div class="news-body">
        <div class="news-author"><x-icon name="user" />{{ $post->author_name }}</div>
        <p class="news-title">{{ $post->title }}</p>
        <a href="{{ route('news.show', $post) }}" class="btn btn-ghost">View Details <x-icon name="arrow-right" /></a>
    </div>
</div>

@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="page-arrow disabled" aria-hidden="true"><x-icon name="arrow-left" /></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-arrow" rel="prev" aria-label="Previous page"><x-icon name="arrow-left" /></a>
        @endif

        <div class="page-numbers">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span aria-disabled="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-arrow" rel="next" aria-label="Next page"><x-icon name="arrow-right" /></a>
        @else
            <span class="page-arrow disabled" aria-hidden="true"><x-icon name="arrow-right" /></span>
        @endif
    </nav>
@endif

@if ($paginator->hasPages())
    &lt;
        {{-- Previous Page Link --}}
    {{--<span>上十頁</span>|--}}
    @if ($paginator->onFirstPage())
            <span>上一頁</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">上一頁</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span>{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span>[{{ $page }}]</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif |
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">下一頁</a>
        @else
            {{--<span>下一頁</span>--}}
        @endif
    &gt;
@endif

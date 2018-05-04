@if ($paginator->hasPages())
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <a href="javascript:void(0);" class="paginate_button previous disabled">Previous</a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="paginate_button previous">Previous</a>
    @endif

    {{-- Pagination Elements --}}
    <span>
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="javascript:void(0);" class="paginate_button current">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="paginate_button">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </span>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="paginate_button next">Next</a>
    @else
        <a href="javascript:void(0);" class="paginate_button next disabled">Next</a>
    @endif
@endif

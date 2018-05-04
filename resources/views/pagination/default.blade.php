@if ($paginator->lastPage() > 1)
    <ul class="kt-pagination">
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li><a href="{{ $paginator->url($i) }}" class="page-numbers">{{ $i }}</a></li>
        @endfor
        <li><a href="{{ $paginator->url($paginator->currentPage() + 1) }}" class="next page-numbers"></a></li>
    </ul>
@endif
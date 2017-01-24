@if ($paginator->hasPages())
  <nav class="pagination is-centered">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
      <a class="pagination-previous disabled"><span>&laquo;</span></a>
    @else
      <a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
    @endif

    <ul class="pagination-list">
      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        <li>
          {{-- "Three Dots" Separator --}}
          @if (is_string($element))
            <a class="pagination-ellipsis disabled"><span>{{ $element }}</span></a>
          @endif

          {{-- Array Of Links --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <a class="pagination-link is-current"><span class="text-white">{{ $page }}</span></a>
              @else
                <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
              @endif
            @endforeach
          @endif
        </li>
      @endforeach
    </ul>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
      <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
    @else
      <a class="pagination-next disabled"><span>&raquo;</span></a>
    @endif
  </nav>
@endif

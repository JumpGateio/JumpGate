@if ($paginator->hasPages())
    <ul class="uk-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="uk-disabled">
              <span class="uk-button uk-button-default uk-button-small uk-button-secondary uk-background-gray-light">&laquo;</span>
            </li>
        @else
            <li>
              <a class="uk-button uk-button-default uk-button-small uk-width-1-1" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="uk-padding-remove uk-disabled">
                  <span class="uk-button uk-button-default uk-button-small uk-button-secondary uk-background-gray-light">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="uk-padding-remove uk-active">
                          <span class="uk-button uk-button-default uk-button-small uk-button-primary uk-button-primary-light uk-text-white uk-width-1-1">{{ $page }}</span>
                        </li>
                    @else
                        <li class="uk-padding-remove">
                          <a class="uk-button uk-button-default uk-button-small uk-width-1-1" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li style="padding-left: 0;">
              <a class="uk-button uk-button-default uk-button-small" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        @else
            <li style="padding-left: 0;" class="uk-disabled">
              <span class="uk-button uk-button-default uk-button-small uk-button-secondary uk-background-gray-light">&raquo;</span>
            </li>
        @endif
    </ul>
@endif

<li class="{{ $item->active ? 'uk-active' : '' }}">
  @if ($item->getOption('text') == true)
    <p class="uk-nabbar-item">{!! $item->name !!}</p>
  @else
    {!! HTML::link($item->url, $item->name, $item->options) !!}
  @endif
</li>

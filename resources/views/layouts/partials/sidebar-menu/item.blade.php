<li class="{{ $item->active ? 'active' : '' }}">
  {!! HTML::link($item->url, $item->name, $item->options) !!}
</li>

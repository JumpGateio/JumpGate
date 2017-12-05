<li class="{{ $item->active ? 'active' : '' }}">
  @if ($item->getOption('text') == true)
    <p class="navbar-text">{!! $item->name !!}</p>
  @else
    {!! HTML::link($item->url, $item->name, $item->options) !!}
  @endif
</li>

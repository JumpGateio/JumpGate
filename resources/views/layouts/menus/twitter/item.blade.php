@if ($item->isDropDown() && $item->hasLinks())
  <li class="dropdown {!! $item->active ? 'active' : '' !!}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{!! $item->name !!}<b class="caret"></b></a>
    <ul class="dropdown-menu">
      @each('layouts.menus.twitter.item', $item->links, 'item')
    </ul>
  </li>
@else
  <li class="{{ $item->active ? 'active' : '' }}">
    @if ($item->getOption('text') == true)
      <p class="navbar-text">{!! $item->name !!}</p>
    @else
      {!! HTML::link($item->url, $item->name, $item->options) !!}
    @endif
  </li>
@endif

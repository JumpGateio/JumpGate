@if ($item->isDropDown() && $item->hasLinks())
  <div class="dropdown-item dropdown-submenu {{ $item->active ? 'active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
    <div class="dropdown-menu  {{ isset($rightDropDown) ? 'dropdown-menu-right' : null }}">
      @each('layouts.menus.twitter.sub-menu', $item->links, 'item')
    </div>
  </div>
@else
  @if ($item->getOption('text') == true)
    <p class="navbar-text">{!! $item->name !!}</p>
  @else
    {!! HTML::link($item->url, $item->name, $item->options + ['class' => $item->active ? 'dropdown-item active' : 'dropdown-item']) !!}
  @endif
@endif

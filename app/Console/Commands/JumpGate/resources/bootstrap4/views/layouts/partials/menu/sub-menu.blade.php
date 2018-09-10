@if ($item->isDropDown() && $item->hasLinks())
  <div class="dropdown-item {{ $item->active ? 'active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
    <div class="dropdown-menu  {{ isset($rightDropDown) ? 'dropdown-menu-right' : null }}">
      @each('layouts.partials.menu.sub-menu', $item->links, 'item')
    </div>
  </div>
@else
  @include('layouts.partials.menu.item')
@endif

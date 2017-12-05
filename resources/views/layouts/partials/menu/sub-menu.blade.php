@if ($item->isDropDown() && $item->hasLinks())
  <li class="dropdown {{ $item->active ? 'active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
    <ul class="dropdown-menu">
      @each('layouts.partials.menu.sub-menu', $item->links, 'item')
    </ul>
  </li>
@else
  @include('layouts.partials.menu.item')
@endif

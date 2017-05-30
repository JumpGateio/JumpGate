@if ($item->isDropDown() && $item->hasLinks())
  <li class="nav-item dropdown {{ $item->active ? 'active' : '' }}">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
    <div class="dropdown-menu dropdown-menu-right">
      @each('layouts.menus.twitter.sub-menu', $item->links, 'item')
    </div>
  </li>
@else
  @include('layouts.menus.twitter.item')
@endif

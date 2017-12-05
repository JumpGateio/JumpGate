@if ($item->isDropDown() && $item->hasLinks())
  <li data-toggle="collapse" data-target="#{{ $item->slug }}" class="collapsed  {{ $item->active ? 'active' : '' }}">
    <a>{{ $item->name }}  <span class="arrow"></span></a>
  </li>
  <ul class="sub-menu collapse {{ $item->active ? 'in' : '' }}" id="{{ $item->slug }}">
    @each('layouts.partials.sidebar-menu.item', $item->links, 'item')
  </ul>
@else
  @include('layouts.partials.sidebar-menu.item')
@endif

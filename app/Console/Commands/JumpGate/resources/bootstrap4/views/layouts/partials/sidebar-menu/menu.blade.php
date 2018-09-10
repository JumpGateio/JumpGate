@if ($item->isDropDown() && $item->hasLinks())
  <div class="nav-link nav-link-header">{{ $item->name }}</div>
  @each('layouts.partials.sidebar-menu.item', $item->links, 'item')
@else
  @include('layouts.partials.sidebar-menu.item')
@endif

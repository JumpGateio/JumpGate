@if ($item->isDropDown() && $item->hasLinks())
  <li class="{{ $item->active ? 'uk-active' : '' }}">
    <a href="#">{{ $item->name }}<i class="fa fa-fw fa-caret-down"></i></a>
    <div class="uk-navbar-dropdown">
      <ul class="uk-nav uk-navbar-dropdown-nav">
        @each('layouts.menus.uikit.sub-menu', $item->links, 'item')
      </ul>
    </div>
  </li>
@else
  @include('layouts.menus.uikit.item')
@endif

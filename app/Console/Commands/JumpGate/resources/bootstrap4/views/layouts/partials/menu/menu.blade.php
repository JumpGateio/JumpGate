@if ($item->isDropDown() && $item->hasLinks())
  <li class="nav-item dropdown {{ $item->active ? 'active' : '' }}">
    @if (isset($item->type) && $item->type === 'auth')
      <a href="#" class="nav-link dropdown-toggle img-navbar-user" id="{!! $item->name !!}" data-toggle="dropdown">
        <img src="{!! $item->name !!}" />
      </a>
    @else
      <a href="#" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" id="{!! $item->name !!}">
        {{ $item->name }}<b class="caret"></b>
      </a>
    @endif
    <div class="dropdown-menu {{ isset($item->right) ? 'dropdown-menu-right' : '' }}" aria-labelledby="{!! $item->name !!}">
      @each('layouts.partials.menu.dropdown-item', $item->links, 'item')
    </div>
  </li>
@else
  @include('layouts.partials.menu.item')
@endif

@if ($item->isDropDown() && $item->hasLinks())
  <div class="{{ $item->active ? 'uk-active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
    <div class="uk-navbar-dropdown">
      @each('layouts.menus.uikit.sub-menu', $item->links, 'item')
    </div>
  </div>
@else
  <div class="{{ $item->active ? 'uk-active' : '' }}">
    @if ($item->getOption('text') == true)
      <p>{!! $item->name !!}</p>
    @else
      {!! HTML::link($item->url, $item->name, $item->options + ['class' => $item->active ? 'uk-active' : null]) !!}
    @endif
  </div>
@endif

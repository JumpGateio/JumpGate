
<div class="brand">Brand Logo</div>
<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

<div class="menu-list">

  <ul id="menu-content" class="menu-content collapse out">
    {{--<li>--}}
      {{--<a href="#">--}}
        {{--<i class="fa fa-dashboard fa-lg"></i> Dashboard--}}
      {{--</a>--}}
    {{--</li>--}}

    @each('layouts.partials.sidebar-menu.menu', $menu->links, 'item')
  </ul>
</div>

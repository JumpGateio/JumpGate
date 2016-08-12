@if (Menu::count() > 0)
  @if (app()->environment() == 'dev')
    <div style="background-color: #333; background-image: repeating-linear-gradient(315deg, transparent, transparent 15px, rgba(255,255,0,1) 15px, rgba(255,255,0,1) 30px); width:100%; height: 10px;"></div>
  @endif
  <div id="header">
    @include('layouts.menus.twitter')
  </div>
@endif

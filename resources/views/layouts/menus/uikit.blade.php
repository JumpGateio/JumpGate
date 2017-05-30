<nav class="uk-navbar-container uk-padding-remove uk-navbar-hot" uk-navbar>
  <div class="uk-navbar-left uk-padding-remove">
    @if (app()->environment() == 'stage')
      <a href="{{ route('home') }}" class="uk-navbar-item uk-logo">Development Site</a>
    @else
      <a href="{{ route('home') }}" class="uk-navbar-item uk-logo uk-text-primary">
        <img src="/img/logos/hot_logo.png" style="width: 93px;" alt="">
      </a>
    @endif
    @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
      <ul class="uk-navbar-nav">
        @each('layouts.menus.uikit.menu', Menu::render('leftMenu')->links, 'item')
      </ul>
    @endif
  </div>
  @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
    <div class="uk-navbar-right">
      <ul class="uk-navbar-nav">
        @each('layouts.menus.uikit.menu', Menu::render('rightMenu')->links, 'item')
      </ul>
    </div>
  @endif
</nav>
<br style="clear: both;" />

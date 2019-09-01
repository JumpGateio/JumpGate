@if (Menu::count() > 0)
  @if (app()->environment() == 'dev')
    <div style="background-color: #333; background-image: repeating-linear-gradient(315deg, transparent, transparent 15px, rgba(255,255,0,1) 15px, rgba(255,255,0,1) 30px); width:100%; height: 10px;"></div>
  @endif
  <div id="header">
    <nav class="uk-navbar-container uk-padding-remove uk-navbar-hot" uk-navbar>
      <div class="uk-navbar-left uk-padding-remove">
        @if (app()->environment() == 'stage')
          <a href="{{ route('home') }}" class="uk-navbar-item uk-logo">Development Site</a>
        @else
          <a href="{{ route('home') }}" class="uk-navbar-item uk-logo uk-text-primary">
            site<strong>ROCKET</strong>Labs
          </a>
        @endif
        @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
          <ul class="uk-navbar-nav">
            @each('layouts.partials.menu.menu', Menu::render('leftMenu')->links, 'item')
          </ul>
        @endif
      </div>
      @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
        <div class="uk-navbar-right">
          <ul class="uk-navbar-nav">
            @each('layouts.partials.menu.menu', Menu::render('rightMenu')->links, 'item')
          </ul>
        </div>
      @endif
    </nav>
    <br style="clear: both;" />
  </div>
@endif

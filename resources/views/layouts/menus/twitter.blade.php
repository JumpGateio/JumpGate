<nav class="navbar navbar-toggleable-sm navbar-inverse bg-inverse fixed-top" role="navigation">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  @if (app()->environment() == 'stage')
    <a class="navbar-brand" href="{!! route('home') !!}">Development Site</a>
  @else
    <a class="navbar-brand" href="{!! route('home') !!}">{{ env('APP_NAME') }}</a>
  @endif
  <div class="collapse navbar-collapse" id="navbarResponsive">
    @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
      <ul class="navbar-nav">
        @each('layouts.menus.twitter.menu', Menu::render('leftMenu')->links, 'item')
      </ul>
    @endif
    <div class="hidden-md hidden-lg">
      @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
        <ul class="navbar-nav pull-xs-right">
          @each('layouts.menus.twitter.right-menu', Menu::render('rightMenu')->links, 'item')
        </ul>
      @endif
    </div>
    <div class="hidden-sm hidden-xs">
      <div class="container-fluid">
        @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
          <ul class="nav navbar-nav pull-xs-right">
            @each('layouts.menus.twitter.right-menu', Menu::render('rightMenu')->links, 'item')
          </ul>
        @endif
      </div>
    </div>
  </div>
</nav>
<br style="clear: both;"/>

<nav class="navbar navbar-dark bg-inverse navbar-fixed-top" role="navigation">
  <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    &#9776;
  </button>
  <div class="collapse navbar-toggleable-xs" id="navbarResponsive">
    @if (app()->environment() == 'stage')
      <a class="navbar-brand" href="{!! route('home') !!}">Development Site</a>
    @else
      <a class="navbar-brand" href="{!! route('home') !!}">{{ env('APP_NAME') }}</a>
    @endif
    @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
      <ul class="nav navbar-nav">
        @each('layouts.menus.twitter.menu', Menu::render('leftMenu')->links, 'item')
      </ul>
    @endif
    <div class="hidden-md hidden-lg">
      @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
        <ul class="nav navbar-nav pull-xs-right">
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

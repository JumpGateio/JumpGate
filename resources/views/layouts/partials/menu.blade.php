@if (Menu::count() > 0)
  @if (app()->environment() == 'dev')
    <div style="background-color: #333; background-image: repeating-linear-gradient(315deg, transparent, transparent 15px, rgba(255,255,0,1) 15px, rgba(255,255,0,1) 30px); width:100%; height: 10px;"></div>
  @endif
  <div id="header">
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        @if (app()->environment() == 'dev')
          <a class="navbar-brand" href="{!! route('home') !!}">Development Site</a>
        @else
          <a class="navbar-brand" href="{!! route('home') !!}">{{ env('APP_NAME') }}</a>
        @endif
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
          <ul class="nav navbar-nav">
            @each('layouts.partials.menu.menu', Menu::render('leftMenu')->links, 'item')
          </ul>
        @endif
        <div class="hidden-md hidden-lg">
          @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
            <ul class="nav navbar-nav navbar-right">
              @each('layouts.partials.menu.menu', Menu::render('rightMenu')->links, 'item')
            </ul>
          @endif
        </div>
        <div class="hidden-sm hidden-xs">
          <div class="container-fluid">
            @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
              <ul class="nav navbar-nav navbar-right">
                @each('layouts.partials.menu.menu', Menu::render('rightMenu')->links, 'item')
              </ul>
            @endif
          </div>
        </div>
      </div>
    </nav>
    <br style="clear: both;"/>
  </div>
@endif

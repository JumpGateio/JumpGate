@if (Menu::count() > 0)
  @if (app()->environment() == 'dev')
    <div style="background-color: #333; background-image: repeating-linear-gradient(315deg, transparent, transparent 15px, rgba(255,255,0,1) 15px, rgba(255,255,0,1) 30px); width:100%; height: 10px;"></div>
  @endif
  <div id="header">
    <nav class="navbar navbar-toggleable-sm navbar-expand-lg fixed-top navbar-dark bg-dark app-navbar">
      <button class="navbar-toggler navbar-toggler-right hidden-md-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="{!! route('home') !!}">
        <span class="icon icon-shareable navbar-brand-icon"></span>
        JumpGate
      </a>
      <div class="collapse navbar-collapse mr-auto w-100" id="navbarResponsive">
        @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
          <ul class="nav navbar-nav">
            @each('layouts.partials.menu.menu', Menu::render('leftMenu')->links, 'item')
          </ul>
        @endif
        @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
          <ul class="nav navbar-nav ml-auto">
            @each('layouts.partials.menu.menu', Menu::render('rightMenu')->links, 'item')
          </ul>
        @endif
      </div>
    </nav>
    <br style="clear: both;" />
  </div>
@endif

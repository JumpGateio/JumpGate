<!doctype html>
<html>
  <head>
    @include('layouts.partials.header')
  </head>

  <body>
    <div id="app">
      <div class="container-fluid" id="container" style="margin: 0; padding: 0;">
        <div class="row">
          @include('layouts.partials.menu')
        </div>

        <div id="content">
          <div class="section background-gray-darker">
            @yield('title')
          </div>
          <div class="nav-side-menu">
            @yield('sidebar')
          </div>
          @if (isset($content))
            {!! $content !!}
          @else
            @yield('content')
          @endif
        </div>

        @section('footer')
          @include('layouts.partials.footer')
        @show
      </div>

      @include('layouts.partials.modals')

    </div>
    @include('layouts.partials.javascript')
  </body>
</html>

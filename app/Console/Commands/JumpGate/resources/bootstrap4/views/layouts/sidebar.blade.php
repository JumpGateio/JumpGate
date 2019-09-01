<!doctype html>
<html>
  <head>
    @include('layouts.partials.header')
  </head>

  <body>
  <div id="app" class="admin">
      <div class="container-fluid" id="container" style="margin-top: -40px; padding: 0;">
        <div id="content">
          <div class="section background-gray-darker">
            @yield('title')
            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm float-right" style="margin-top: -3px;">
              Back to site
            </a>
          </div>
          <div class="nav-side-menu">
            @include('layouts.partials.sidebar-menu')
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

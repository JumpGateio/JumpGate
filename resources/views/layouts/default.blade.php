<!doctype html>
<html>
  <head>
    @include('layouts.partials.header')
  </head>

  <body>
    @include('layouts.partials.menu')

    <div class=container" id="content">
      @if (isset($content))
        {!! $content !!}
      @else
        @yield('content')
      @endif
    </div>

    @include('layouts.partials.modals')

    @section('footer')
      @include('layouts.partials.footer')
    @show

    @include('layouts.partials.javascript')

  </body>
</html>

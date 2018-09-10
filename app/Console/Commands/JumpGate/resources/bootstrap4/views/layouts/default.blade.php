<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    @include('layouts.partials.header')
  </head>

  <body class="{{ $bodyClass ?? null }}">
    <div id="app">
      <div class="container-fluid" id="container">
        <div class="row">
          @include('layouts.partials.menu')
        </div>

        <div id="content">
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

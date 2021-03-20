<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
  <head>
    {{-- Uncomment this if you plan to use analytics --}}
    {{--@include('layouts.partials.googleAnalytics')--}}
    @include('layouts.partials.header')
  </head>

  <body class="{{ $bodyClass ?? null }}">
    @inertia

    @include('layouts.partials.javascript')
  </body>
</html>

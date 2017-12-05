<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
  {{ ! isset($customPageTitle) || $customPageTitle === '' ? $pageTitle === '' ? null : $pageTitle : $customPageTitle }}
  {{ ! is_null(env('APP_NAME')) ? '| ' . env('APP_NAME') : null }}
</title>

{{--<link rel="shortcut icon" href="{{ URL::to('/favicon.ico') }}" />--}}

<!-- Local styles -->
{!! HTML::style('css/app.css') !!}
<link rel="shortcut icon" href="https://www.siterocket.com/img/favicon.png" type="image/png">
{{--<link rel="stylesheet" href="https://www.siterocket.com/css/default-1d54e52f.css">--}}

<!-- Css -->
@section('css')
@show
<!-- Css Form -->
@section('cssForm')
@show

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $pageTitle or null }} | {{ env('APP_NAME') }}!</title>

<link rel="shortcut icon" href="{{ URL::to('/favicon.ico') }}" />

<!-- Local styles -->
{!! HTML::style('css/app.css') !!}

<!-- Css -->
@section('css')
@show
<!-- Css Form -->
@section('cssForm')
@show

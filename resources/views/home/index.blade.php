@section('css')
  <style>
    html, body {
      background-color: #fff;
      color:            #636b6f;
      font-family:      'Raleway';
      font-weight:      100;
      height:           100vh;
      margin:           0;
    }

    .full-height {
      height: 50vh;
    }

    .flex-center {
      align-items:     center;
      display:         flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .top-right {
      position: absolute;
      right:    10px;
      top:      18px;
    }

    .content {
      text-align: center;
    }

    .title {
      font-size: 84px;
    }

    .sub-title {
      font-size: 24px;
    }

    .links > a {
      color:           #636b6f;
      padding:         0 25px;
      font-size:       12px;
      font-weight:     600;
      letter-spacing:  .1rem;
      text-decoration: none;
      /*text-transform: uppercase;*/
    }

    .m-b-md {
      margin-bottom: 30px;
    }
  </style>
@endsection
<div class="flex-center position-ref full-height">
  @if (Route::has('login'))
    <div class="top-right links">
      <a href="{{ url('/login') }}">Login</a>
      <a href="{{ url('/register') }}">Register</a>
    </div>
  @endif

  <div class="content">
    <div class="title m-b-md">
      Laravel <i class="fa fa-fw fa-html5"></i>
      <div class="sub-title">
        with NukaCode
      </div>
    </div>

    <div class="links">
      <a href="https://laravel.com/docs">Documentation</a>
      <a href="https://laravel-news.com">News</a>
      <a href="https://laracasts.com">Laracasts</a>
      <a href="https://forge.laravel.com">Forge</a>
      <a href="https://github.com/laravel/laravel">GitHub</a>
    </div>
  </div>
</div>

@section('css')
  <style>
    html, body {
      background-color: #fff;
      color:            #636b6f;
      font-family:      'Raleway';
      font-weight:      200;
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
      right: 10px;
      top: 18px;
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
      text-transform:  uppercase;
    }

    .m-b-md {
      margin-bottom: 30px;
    }

    .numbers {
      position: relative;
      bottom:   11px;
    }
  </style>
@endsection
<div class="flex-center position-ref full-height">
  @if (Route::has('auth.login') || Route::has('auth.social.login'))
    <div class="top-right links">
      @auth
        <a href="{{ route('home') }}">Home</a>
      @else
        <a href="{{ Route::has('auth.login') ? route('auth.login') : route('auth.social.login') }}">Login</a>

        @if (Route::has('auth.register'))
          <a href="{{ route('auth.register') }}">Register</a>
        @endif
      @endauth
    </div>
  @endif
  <div class="content">
    <div class="title m-b-md">
      Laravel <span class="numbers">6.0</span>
      <div class="sub-title">
        with JumpGate
      </div>
    </div>

    <div class="links">
      <a target="_blank" href="https://laravel.com/docs/6.0">Documentation</a>
      <a target="_blank" href="https://laravel-news.com">News</a>
      <a target="_blank" href="https://laracasts.com">Laracasts</a>
      <a target="_blank" href="https://github.com/jumpgateio/jumpgate">JumpGate</a>
      <a target="_blank" href="https://docs.nukacode.com/docs/1.0/overview">JumpGate Docs</a>
      <a target="_blank" href="https://github.com/laravel/laravel">GitHub</a>
    </div>

    <br/>

    <div class="links">
      <a target="_blank" href="https://github.com/JumpGateio">JumpGate</a>
      <a target="_blank" href="https://getbootstrap.com/docs/4.1/getting-started/introduction/">Bootstrap 4</a>
      <a target="_blank" href="http://vuejs.org/v2/guide/">VueJs 2</a>
    </div>
  </div>
</div>

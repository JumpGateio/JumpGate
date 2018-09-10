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
  <div class="content">
    <div class="title m-b-md">
      Laravel <span class="numbers">5.7</span>
      <div class="sub-title">
        with JumpGate
      </div>
    </div>

    <div class="links">
      <a target="_blank" href="https://laravel.com/docs/5.7">Documentation</a>
      <a target="_blank" href="https://laravel-news.com">News</a>
      <a target="_blank" href="https://laracasts.com">Laracasts</a>
      <a target="_blank" href="https://forge.laravel.com">Forge</a>
      <a target="_blank" href="https://github.com/laravel/laravel">GitHub</a>
    </div>

    <br/>

    <div class="links">
      <a target="_blank" href="https://github.com/JumpGateio">JumpGate</a>
      <a target="_blank" href="https://getuikit.com/docs">UI Kit</a>
      <a target="_blank" href="http://vuejs.org/v2/guide/">VueJs 2</a>
    </div>
  </div>
</div>

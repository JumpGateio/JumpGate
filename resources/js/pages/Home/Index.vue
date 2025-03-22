<template>
  <div class="flex-center position-ref full-height" id="home">
    <div class="content">
      <div class="title m-b-md">
        Laravel <span class="numbers">9.0</span>
        <div class="sub-title">
          with JumpGate
        </div>
      </div>

      <div class="columns">
        <div class="links column">
          <a class="lead text-black">Laravel: </a>
          <a target="_blank" href="https://laravel.com/docs/9.x">Documentation</a>
          <a target="_blank" href="https://laravel-news.com">News</a>
          <a target="_blank" href="https://laracasts.com">Laracasts</a>
          <a target="_blank" href="https://github.com/laravel/laravel">GitHub</a>
        </div>

        <div class="links column">
          <a class="lead text-black">JumpGate: </a>
          <a target="_blank" href="https://github.com/JumpGateio">Organization</a>
          <a target="_blank" href="https://github.com/jumpgateio/jumpgate">WebApp</a>
          <a target="_blank" href="https://docs.nukacode.com/docs/1.0/overview">Documentation</a>
        </div>

        <div class="links column">
          <a class="lead text-black">FrontEnd: </a>
          <a target="_blank" href="https://getbootstrap.com/docs/4.6/getting-started/introduction/">Bootstrap 4</a>
          <a target="_blank" href="http://vuejs.org/guide/">VueJs 3</a>
          <a target="_blank" href="https://inertiajs.com/">InertiaJs</a>
        </div>

        <div class="links column">
          <a class="lead text-black">Extras: </a>
          <a target="_blank" href="https://laratrust.santigarcor.me/docs/7.x/">Laratrust</a>
          <a target="_blank" href="https://console.developers.google.com/apis/credentials?pli">Google Api Console</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:     'Home-Index',
    metaInfo: {title: 'Home'},

    props: {
      loggedIn: Boolean,
    },

    data()
    {
      return {
        //
      }
    },

    methods: {
      //
    }
  }
</script>

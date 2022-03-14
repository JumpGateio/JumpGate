<template>
  <div class="flex-center position-ref full-height" id="home">
    <div class="content">
      <div class="title m-b-md">
        Laravel <span class="numbers">9.0</span>
        <div class="sub-title">
          with JumpGate
        </div>
      </div>

      <div class="links">
        <a class="lead text-black">Laravel: </a>
        <a target="_blank" href="https://laravel.com/docs/9.x">Documentation</a>
        <a target="_blank" href="https://laravel-news.com">News</a>
        <a target="_blank" href="https://laracasts.com">Laracasts</a>
        <a target="_blank" href="https://github.com/laravel/laravel">GitHub</a>
      </div>

      <br />

      <div class="links">
        <a class="lead text-black">JumpGate: </a>
        <a target="_blank" href="https://github.com/JumpGateio">Organization</a>
        <a target="_blank" href="https://github.com/jumpgateio/jumpgate">WebApp</a>
        <a target="_blank" href="https://docs.nukacode.com/docs/1.0/overview">Documentation</a>
      </div>

      <br />

      <div class="links">
        <a class="lead text-black">FrontEnd: </a>
        <a target="_blank" href="https://getbootstrap.com/docs/4.1/getting-started/introduction/">Bootstrap 4</a>
        <a target="_blank" href="http://vuejs.org/v2/guide/">VueJs 2</a>
        <a target="_blank" href="https://inertiajs.com/">InertiaJs</a>
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

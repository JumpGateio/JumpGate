<template>
  <div class="flex-center position-ref full-height" data-bs-theme="dark" id="home">
    <div class="content">
      <div class="title m-b-md">
        Laravel <span class="numbers">12</span>
        <div class="sub-title">
          with JumpGate
        </div>
      </div>

      <div class="columns">
        <div class="card feature-card">
          <div class="card-body">
            <div class="card-title">
              <i class="fa-brands fa-laravel text-laravel"></i>&nbsp;Laravel
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" target="_blank" href="https://laravel.com/docs/12.x">Documentation</a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://laracasts.com">Laracasts</a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://github.com/laravel/laravel">GitHub</a>
          </ul>
        </div>

        <div class="card feature-card">
          <div class="card-body">
            <div class="card-title">
              <i class="fa fa-shuttle-space text-jumpgate"></i>&nbsp;JumpGate
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" target="_blank" href="https://github.com/JumpGateio">Organization</a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://github.com/jumpgateio/jumpgate">WebApp</a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://jumpgateio.github.io">Documentation</a>
          </ul>
        </div>

        <div class="card feature-card">
          <div class="card-body">
            <div class="card-title">
              <i class="fa-solid fa-webhook text-pale-green"></i>&nbsp;Fontend
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" target="_blank" href="https://getbootstrap.com/docs/5.3/getting-started/introduction/">Bootstrap 5</a>
            <a class="list-group-item list-group-item-action" target="_blank" href="http://vuejs.org/guide/">VueJs 3</a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://inertiajs.com/">InertiaJs</a>
          </ul>
        </div>

        <div class="card feature-card">
          <div class="card-body">
            <div class="card-title">
              <i class="fa-solid fa-share-nodes text-pink"></i>&nbsp;Extras
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" target="_blank" href="https://laratrust.santigarcor.me/docs/8.x/">Laratrust</a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://console.developers.google.com/apis/credentials?pli">
              Google Api Console
            </a>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: 'Home-Index',
  metaInfo: {title: 'Home'},

  props: {
    loggedIn: Boolean,
  },

  data() {
    return {
      //
    }
  },

  methods: {
    //
  }
})
</script>

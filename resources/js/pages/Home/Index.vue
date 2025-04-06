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
            <a class="list-group-item list-group-item-action" target="_blank" href="https://laravel.com/docs/12.x">
              <span class="text-laravel">__</span>
              Documentation
            </a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://laracasts.com">
              <span class="text-laravel">__</span>
              Laracasts
            </a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://github.com/laravel/laravel">
              <span class="text-laravel">__</span>
              GitHub
            </a>
          </ul>
        </div>

        <div class="card feature-card">
          <div class="card-body">
            <div class="card-title">
              <i class="fa fa-shuttle-space text-jumpgate"></i>&nbsp;JumpGate
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" target="_blank" href="https://github.com/JumpGateio">
              <span class="text-jumpgate">__</span>
              Organization
            </a>
            <a class="list-group-item list-group-item-action" target="_blank"
               href="https://github.com/jumpgateio/jumpgate">
              <span class="text-jumpgate">__</span>
              WebApp
            </a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://jumpgateio.github.io">
              <span class="text-jumpgate">__</span>
              Documentation
            </a>
          </ul>
        </div>

        <div class="card feature-card">
          <div class="card-body">
            <div class="card-title">
              <i class="fa-solid fa-webhook text-pale-green"></i>&nbsp;Fontend
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" target="_blank"
               href="https://getbootstrap.com/docs/5.3/getting-started/introduction/">
              <span class="text-pale-green">__</span>
              Bootstrap 5
            </a>
            <a class="list-group-item list-group-item-action" target="_blank" href="http://vuejs.org/guide/">
              <span class="text-pale-green">__</span>
              VueJs 3
            </a>
            <a class="list-group-item list-group-item-action" target="_blank" href="https://inertiajs.com/">
              <span class="text-pale-green">__</span>
              InertiaJs
            </a>
          </ul>
        </div>

        <div class="card feature-card">
          <div class="card-body">
            <div class="card-title">
              <i class="fa-solid fa-share-nodes text-pink"></i>&nbsp;Extras
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" target="_blank" href="https://lodash.com/docs/4.17.15">
              <span class="text-pink">__</span>
              Lodash
            </a>
            <a class="list-group-item list-group-item-action" target="_blank"
               href="https://laratrust.santigarcor.me/docs/8.x/">
              <span class="text-pink">__</span>
              Laratrust
            </a>
            <a class="list-group-item list-group-item-action" target="_blank"
               href="https://console.developers.google.com/apis/credentials?pli">
              <span class="text-pink">__</span>
              Google Api Console
            </a>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Layout from "@/Shared/Layout.vue"

const name = 'Home-Index';

defineOptions({layout: Layout})

const props = defineProps({
  loggedIn: Boolean,
});
</script>

<template>
  <div id="header">
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark background-800">
      <div class="container-fluid">
        <Link class="navbar-brand" :href="route('home')">
          <span class="icon icon-shareable navbar-brand-icon">
            <i class="fa fa-fw fa-shuttle-space text-jumpgate"></i>
          </span>
          JumpGate
        </Link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav">
            <Menu v-for="(item, index) in page.props.leftMenu" :key="item.slug + '.' + index"
                       :item="item"></Menu>
          </ul>
          <ul class="navbar-nav ms-auto">
            <Menu v-for="(item, index) in page.props.rightMenu" :key="item.slug + '.' + index"
                       :item="item"></Menu>
          </ul>
        </div>
      </div>
    </nav>
    <br style="clear: both;"/>
  </div>
</template>

<script setup>
import Menu from '@/Shared/Menu/Menu.vue'
import {Link, usePage} from '@inertiajs/vue3'

defineOptions({
  name: 'Menu-Main',
});

const page = usePage();
</script>

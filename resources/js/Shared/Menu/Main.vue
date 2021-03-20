<template>
  <div id="header">
    <nav class="navbar navbar-toggleable-sm navbar-expand-lg fixed-top navbar-dark bg-dark app-navbar">
      <button class="navbar-toggler navbar-toggler-right hidden-md-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <inertia-link class="navbar-brand" :href="route('home')">
        <span class="icon icon-shareable navbar-brand-icon"></span>
        JumpGate
      </inertia-link>
      <div class="collapse navbar-collapse mr-auto w-100" id="navbarResponsive">
        <ul class="nav navbar-nav">
          <link-menu v-for="(item, index) in $page.props.leftMenu" :key="item.slug + '.' + index" :item="item"></link-menu>
        </ul>
        <ul class="nav navbar-nav ml-auto">
          <link-menu v-for="(item, index) in $page.props.rightMenu" :key="item.slug + '.' + index" :item="item"></link-menu>
        </ul>
      </div>
    </nav>
    <br style="clear: both;" />
  </div>
</template>

<script>
  import Menu from '@/Shared/Menu/Menu'

  export default {
    name: 'Menu-Main',

    components: {
      'link-menu': Menu,
    },
  }
</script>

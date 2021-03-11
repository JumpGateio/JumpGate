<template>
  <div :class="bodyClass">
    <div class="container-fluid" id="container">
      <div class="row">
        <top-menu></top-menu>
      </div>
      <div id="content">
        <slot></slot>
      </div>

      <footer></footer>
    </div>
  </div>
</template>

<script>
  import Menu from '@/Shared/Menu/Main'

  export default {
    name: 'Layout',

    components: {
      'top-menu': Menu,
    },

    props: {
      title:     String,
      bodyClass: {
        default: null,
        type:    String,
      },
    },

    computed: {
      fullTitle()
      {
        let title = this.title == null ? '' : this.title

        if (this.$page.title != null) {
          return title + ' ' + this.$page.title
        }

        return title
      }
    },
  }
</script>

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

<script lang="ts">
  import Menu from '@/Shared/Menu/Main.vue'
  import {defineComponent} from "vue"

  export default defineComponent({
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

    watch: {
      '$page.props.flash':       {
        handler(val, oldVal)
        {
          if (val.success !== null) {
            this.bootbox('success', val.success)
          } else if (val.error !== null) {
            this.bootbox('danger', val.error)
          }
        },
        deep: true,
      }
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
  })
</script>

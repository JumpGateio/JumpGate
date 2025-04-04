<template>
  <div :class="divClasses" style="min-height: 130px;">
    <span v-html="iconHtml"></span>
    <h4 class="tile-icon-title" :class="textColor" v-html="content"></h4>
    <span v-html="subHtml"></span>
  </div>
</template>

<script lang="ts">
  import {defineComponent} from "vue";

  export default defineComponent({
    name: 'Admin-Tile',

    props: {
      color:      String,
      textColor:  String,
      icon:       String,
      content:    String,
      subContent: {
        type:    String,
        default: null,
      }
    },

    computed: {
      iconHtml()
      {
        let html = '<i class="' + this.icon + '"></i>'

        if (!_.startsWith(this.icon, 'fa')) {
          html = '<img src="' + this.icon + '" />'
        }

        return html
      },

      padding()
      {
        let padding = 'p-5'

        if (this.subContent !== null) {
          padding = 'px-5 pt-4 pb-5'
        }

        return padding
      },

      subHtml()
      {
        let html = null

        if (this.subContent !== null) {
          html = '<p style="margin-bottom: -20px;">' + this.subContent + '</p>'
        }

        return html
      },

      divClasses()
      {
        let classes = [
          'tile',
          'tile-icon',
          this.color,
          this.textColor,
          this.padding
        ]

        return classes.join(' ')
      }
    }
  })
</script>

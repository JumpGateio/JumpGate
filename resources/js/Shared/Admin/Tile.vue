<template>
  <div :class="divClasses" style="min-height: 130px;">
    <span v-html="iconHtml"></span>
    <h4 class="tile-icon-title" v-html="content"></h4>
    <span v-html="subHtml"></span>
  </div>
</template>

<script>
  export default {
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
        let html = '<span class="' + this.icon + '"></span>'

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
  }
</script>

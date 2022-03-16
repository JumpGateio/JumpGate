<template>
  <div class="help-box" :style="{width: boxWidth, display: defaultDisplay}">
    <div class="help-title" v-html="title"></div>
    <div class="help-body">
      <span v-html="body"></span>
      <slot></slot>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Help-Box',

    props: {
      boxWidth:  {
        default: '600px',
        type:    String,
      },
      helpTitle: {
        default: null,
        type:    String,
      },
      helpBody:  {
        default: null,
        type:    String,
      },
      display:   {
        default: false,
        type:    Boolean,
      }
    },

    computed: {
      title()
      {
        if (this.helpTitle === null) {
          return this.$page.helpTitle
        }

        return this.helpTitle
      },
      body()
      {
        if (this.helpBody === null) {
          return this.$page.helpBody
        }

        return this.helpBody
      },
      defaultDisplay()
      {
        return this.display ? 'block' : 'none'
      },
    }
  }
</script>

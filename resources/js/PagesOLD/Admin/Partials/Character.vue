<template>
  <div class="comic-layout-card" :class="{'layout-thin': thinned}">
    <div class="top">
      <img :src="character.image" :class="{'grayscale': greyed}">
    </div>
    <div class="mid-action" v-if="action" v-text="action"></div>
    <div class="text">
      <slot name="above-split"></slot>
    </div>
    <div class="split-layout">
      <div class="split-panel">
        {{ character.name }}
      </div>
    </div>
    <slot name="below-split"></slot>
    <div class="button-group">
      <div class="button">
        <slot name="button"></slot>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>

<script>
  export default {
    name: 'Character-Box',

    props: {
      'character': Object,
      'action':    String,
      'thin':      Boolean,
      'greyed':    Boolean,
    },

    computed: {
      thinned()
      {
        return this.thin
      }
    }
  }
</script>

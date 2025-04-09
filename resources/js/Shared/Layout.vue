<template>
  <div :class="bodyClass">
    <div class="container-fluid" id="container">
      <div class="row">
        <Menu></Menu>
      </div>
      <div id="content">
        <slot></slot>
      </div>

      <footer></footer>
    </div>
  </div>
</template>

<script setup>
import Menu from '@/Shared/Menu/Main.vue'
import {computed} from "vue";

defineOptions({
  name: 'Layout',
});

const props = defineProps({
  title:     String,
  bodyClass: {
    default: null,
    type:    String,
  },
});

const fullTitle = computed(() => {
  let title = [
    props.title
  ];

  return _.filter(title).join(' ');
});
</script>

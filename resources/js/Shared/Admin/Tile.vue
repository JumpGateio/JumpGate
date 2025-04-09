<template>
  <div :class="divClasses" style="min-height: 130px;">
    <span v-html="iconHtml"></span>
    <h4 class="tile-icon-title" :class="textColor" v-html="content"></h4>
    <span v-html="subHtml"></span>
  </div>
</template>

<script setup>
import {computed} from "vue";

defineOptions({
  name: 'Admin-Tile',
});

const props = defineProps({
  color:      String,
  textColor:  String,
  icon:       String,
  content:    String,
  subContent: {
    type:    String,
    default: null,
  }
});

const iconHtml = computed(() => {
  let html = '<i class="' + props.icon + '"></i>';

  if (!_.startsWith(props.icon, 'fa')) {
    html = '<img src="' + props.icon + '" />';
  }

  return html;
});
const padding = computed(() => {
  let padding = 'p-5';

  if (props.subContent !== null) {
    padding = 'px-5 pt-4 pb-5';
  }

  return padding;
});
const subHtml = computed(() => {
  let html = null;

  if (props.subContent !== null) {
    html = '<p style="margin-bottom: -20px;">' + props.subContent + '</p>';
  }

  return html;
});
const divClasses = computed(() => {
  let classes = [
    'tile',
    'tile-icon',
    props.color,
    props.textColor,
    padding
  ];

  return classes.join(' ');
});
</script>

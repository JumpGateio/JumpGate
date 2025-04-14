<template>
  <a :href="item.url" class="side-menu-item" :class="{'active': item.active}">
    <i class="fa fa-fw" :class="item.icon"></i>&nbsp;
    {{ item.name }}
  </a>
</template>

<script setup>
defineOptions({
  name: 'Sidebar-Link-Standard',
});

const props = defineProps({
  item: Object,
});
</script>

<template>
  <a :href="item.url" class="nav-link logout" :class="{ active:  item.active }">
    <i :class="item.options"></i>
    <span>{{ item.name }}</span>
  </a>
</template>

<script setup>
defineOptions({
  name: 'Logout',
});

const props = defineProps(['item'])
</script>

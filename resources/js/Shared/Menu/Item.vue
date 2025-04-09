<template>
  <li class="nav-item" :class="{ active:  item.active }">
    <Link :href="item.url" class="nav-link" v-if="isInertia">{{ item.name }}</Link>
    <a :href="item.url" class="nav-link" v-else>{{ item.name }}</a>
  </li>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
import {computed} from "vue";

defineOptions({
  name: 'Menu-Item',
});

const props = defineProps(['item'])

const isInertia = computed(() => {
  return !props.item.hasOwnProperty('inertia') || props.item.inertia == true
});
</script>

<template>
  <Link :href="item.url" class="side-menu-item">
    <i class="fa fa-fw" :class="item.icon"></i>&nbsp;
    {{ item.name }}
  </Link>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";

defineOptions({
  name: 'Sidebar-Link-Inertia',
});

const props = defineProps({
  item: Object,
});
</script>

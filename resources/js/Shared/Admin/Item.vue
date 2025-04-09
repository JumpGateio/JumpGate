<template>
  <Link :href="item.url" class="nav-link" :class="{ active:  item.active }">
    {{ item.name }}
  </Link>

</template>

<script setup>
import {Link, usePage} from "@inertiajs/vue3";

const props = defineProps({
  item: Object,
})
</script>

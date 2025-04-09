<template>
  <Link :href="item.url" class="dropdown-item" :class="{ active:  item.active }">
    {{ item.name }}
  </Link>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'

defineOptions({
  name: 'Menu-DropDown-Item',
});

const props = defineProps(['item']);
</script>

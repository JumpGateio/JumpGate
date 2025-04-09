<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <template v-for="(link, key) in links">
        <li class="page-item" :class="{ active: link.active }">
          <div v-if="link.url === null" class="page-link" :key="key +'_nonLink'" v-html="link.label"/>
          <Link v-else class="page-link" :key="key" :href="link.url" v-html="link.label"/>
        </li>
      </template>
    </ul>
  </nav>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'

defineOptions({
  name: 'Pagination',
});

const props = defineProps({
  links: Array,
});
</script>

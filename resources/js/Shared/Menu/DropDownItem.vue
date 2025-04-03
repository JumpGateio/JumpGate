<template>
  <Link :href="item.url" class="dropdown-item" :class="{ active:  item.active }">
    {{ item.name }}
  </Link>
</template>

<script lang="ts">
import {Link} from '@inertiajs/vue3'
import {defineComponent} from "vue";

export default defineComponent({
  name: 'Menu-DropDown-Item',

  props: ['item'],

  components: {
    Link: Link,
  },
})
</script>

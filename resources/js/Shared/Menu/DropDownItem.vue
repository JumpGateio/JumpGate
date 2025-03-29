<template>
  <Link :href="item.url" class="dropdown-item" :class="{ active:  item.active }">
    {{ item.name }}
  </Link>
</template>

<script lang="ts">

import {defineComponent} from "vue";
import {Link} from '@inertiajs/vue3'

export default defineComponent({
  name: 'Menu-DropDown-Item',

  props: ['item'],

  components: {
    Link: Link,
  },

  components: [Link]
})
</script>

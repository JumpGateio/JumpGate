<template>
  <li class="nav-item" :class="{ active:  item.active }">
    <Link :href="item.url" class="nav-link" v-if="isInertia">{{ item.name }}</Link>
    <a :href="item.url" class="nav-link" v-else>{{ item.name }}</a>
  </li>
</template>

<script lang="ts">
import {defineComponent} from "vue"
import {Link} from '@inertiajs/vue3'

export default defineComponent({
  name: 'Menu-Item',

  props: ['item'],

  components: {
    Link: Link,
  },

  computed: {
    isInertia() {
      return !this.item.hasOwnProperty('inertia') || this.item.inertia == true
    }
  }
})
</script>

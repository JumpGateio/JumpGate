<template>
  <a :href="item.url" class="nav-link logout" :class="{ active:  item.active }">
    <i :class="item.options"></i>
    <span>{{ item.name }}</span>
  </a>
</template>

<script lang="ts">
import {defineComponent} from "vue"

export default defineComponent({
  props: ['item']
})
</script>

<template>
  <inertia-link :href="item.url" class="nav-link" :class="{ active:  item.active }">
    {{ item.name }}
  </inertia-link>

</template>

<script>
  export default {
    name: 'Admin-Menu-Item',

    props: {
      item: Object,
    },
  }
</script>

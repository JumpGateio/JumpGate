<template>
  <inertia-link :href="item.url" class="dropdown-item" :class="{ active:  item.active }">
    {{ item.name }}
  </inertia-link>
</template>

<script>
  export default {
    name: 'Menu-DropDown-Item',

    props: ['item'],
  }
</script>

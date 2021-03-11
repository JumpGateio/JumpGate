<template>
  <li class="nav-item" :class="{ active:  item.active }">
    <inertia-link :href="item.url" class="nav-link" v-if="isInertia">{{ item.name }}</inertia-link>
    <a :href="item.url" class="nav-link" v-else>{{ item.name }}</a>
  </li>
</template>

<script>
  export default {
    name: 'Menu-Item',

    props: ['item'],

    computed: {
      isInertia()
      {
        return ! this.item.hasOwnProperty('inertia') || this.item.inertia == true
      }
    }
  }
</script>

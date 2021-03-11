<template>
  <logout :item="item" :key="item.slug" v-if="item.name === 'Logout'"></logout>
  <drop-down :item="item" :key="item.slug" v-else-if="item.hasOwnProperty('links')"></drop-down>
  <item :item="item" :key="item.slug" v-else></item>
</template>

<script>
  import DropDown from '@/Shared/Menu/DropDown'
  import Logout from '@/Shared/Menu/Logout'
  import Item from '@/Shared/Menu/Item'

  export default {
    components: {
      'drop-down': DropDown,
      'logout':    Logout,
      'item':      Item,
    },

    props: ['item'],
  }
</script>

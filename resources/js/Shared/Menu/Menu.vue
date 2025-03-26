<template>
  <logout :item="item" v-if="item.name === 'Logout'"></logout>
  <drop-down :item="item" v-else-if="item.hasOwnProperty('links')"></drop-down>
  <item :item="item" v-else></item>
</template>

<script lang="ts">
  import DropDown from '@/Shared/Menu/DropDown.vue'
  import Logout from '@/Shared/Menu/Logout.vue'
  import Item from '@/Shared/Menu/Item.vue'
  import {defineComponent} from "vue"

  export default defineComponent({
    components: {
      'drop-down': DropDown,
      'logout':    Logout,
      'item':      Item,
    },

    props: ['item'],
  })
</script>

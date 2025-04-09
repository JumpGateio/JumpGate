<template>
  <Logout :item="item" v-if="item.name === 'Logout'"></Logout>
  <DropDown :item="item" v-else-if="item.hasOwnProperty('links')"></DropDown>
  <Item :item="item" v-else></Item>
</template>

<script setup>
import DropDown from '@/Shared/Menu/DropDown.vue'
import Logout from '@/Shared/Menu/Logout.vue'
import Item from '@/Shared/Menu/Item.vue'

defineOptions({
  name: 'Menu',
});

const props = defineProps(['item'])
</script>

<template>
  <li class="nav-item dropdown" :class="{ active:  item.active }">
    <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"
       :id="item.name">
      {{ item.name }}
    </a>
    <div class="dropdown-menu" :class="{ 'dropdown-menu-right': item.hasOwnProperty('right') }">
      <DropDownItem v-for="link in item.links" :item="link" :key="link.name +'.dropdown'"></DropDownItem>
    </div>
  </li>
</template>

<script setup>
import DropDownItem from '@/Shared/Menu/DropDownItem.vue'

defineOptions({
  name: 'Menu-DropDown',
});

const props = defineProps(['item']);
</script>

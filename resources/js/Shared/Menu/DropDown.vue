<template>
  <li class="nav-item dropdown" :class="{ active:  item.active }">
    <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"
       :id="item.name">
      {{ item.name }}<b class="caret"></b>
    </a>
    <div class="dropdown-menu" :class="{ 'dropdown-menu-right': item.hasOwnProperty('right') }"
         :aria-labelledby="item.name">
      <drop-down-item v-for="link in item.links" :item="link" :key="link.name +'.dropdown'"></drop-down-item>
    </div>
  </li>
</template>

<script lang="ts">
  import DropDownItem from '@/Shared/Menu/DropDownItem.vue'
  import {defineComponent} from "vue";

  export default defineComponent({
    name: 'Menu-DropDown',

    components: {
      'drop-down-item': DropDownItem,
    },

    props: ['item'],
  })
</script>

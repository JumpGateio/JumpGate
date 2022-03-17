<template>
  <li class="nav-item dropdown" :class="{ active:  item.active }">
    <a href="#" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"
       :id="item.name">
      {{ item.name }}<b class="caret"></b>
    </a>
    <div class="dropdown-menu" :class="{ 'dropdown-menu-right': item.hasOwnProperty('right') }"
         :aria-labelledby="item.name">
      <drop-down-item v-for="link in item.links" :item="link" :key="link.name +'.dropdown'"></drop-down-item>
    </div>
  </li>
</template>

<script>
  import DropDownItem from '@/Shared/Menu/DropDownItem'

  export default {
    name: 'Menu-DropDown',

    components: {
      'drop-down-item': DropDownItem,
    },

    props: ['item'],
  }
</script>

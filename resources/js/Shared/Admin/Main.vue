<template>
  <div class="nav d-flex flex-column nav-pills nav-sidebar" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <template v-for="menu in $page.props.adminMenu">
      <template v-if="menu.hasOwnProperty('links')">
        <div class="nav-link nav-link-header" v-text="menu.name"></div>
        <template v-for="item in menu.links">
          <admin-item :item="item" :key="item.slug"></admin-item>
        </template>
      </template>
      <admin-item :item="menu" :key="menu.slug" v-else></admin-item>
    </template>
  </div>
</template>

<script>
  import Item from '@/Shared/Admin/Item'

  export default {
    name: 'Admin-Menu-Main',

    components: {
      'admin-item': Item,
    },
  }
</script>

<template>
  <div class="nav d-flex flex-column nav-pills nav-sidebar" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <template v-for="menu in page.props.adminMenu">
      <template v-if="menu.hasOwnProperty('links')">
        <div class="nav-link nav-link-header" v-text="menu.name"></div>
        <template v-for="item in menu.links" :key="item.slug">
          <admin-item :item="item"></admin-item>
        </template>
      </template>
      <Item :item="menu" :key="menu.slug" v-else></Item>
    </template>
  </div>
</template>

<script setup>
import Item from '@/Shared/Admin/Item.vue'
import {usePage} from "@inertiajs/vue3";

defineOptions({
  name: 'Admin-Menu-Main',
});

const page = usePage();
</script>

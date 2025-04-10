<template>
  <div class="side-menu">
    <template v-for="item in menu">
      <InertiaLink v-if="item.inertia == true" :item="item"></InertiaLink>
      <StandardLink v-if="item.inertia == false" :item="item"></StandardLink>
      <template v-if="item.hasOwnProperty('links')">
        <div class="side-menu-heading">{{ item.name }}</div>
        <template v-for="link in item.links">
          <InertiaLink v-if="link.inertia == true" :item="link"></InertiaLink>
          <StandardLink v-if="link.inertia == false" :item="link"></StandardLink>
        </template>
      </template>
    </template>
  </div>
</template>

<script setup>
import InertiaLink from "@/Shared/SideMenu/InertiaLink.vue";
import StandardLink from "@/Shared/SideMenu/StandardLink.vue";
import {usePage} from "@inertiajs/vue3";

defineOptions({
  name: 'Sidebar-Main',
});

const page = usePage();

const menu = page.props.adminMenu;
</script>

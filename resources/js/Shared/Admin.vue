<template>
  <div class="page admin-page">
    <div class="container-fluid" id="container">
      <div id="content">
        <div class="admin-header">
          <div class="admin-title" v-text="fullTitle"></div>
          <slot name="admin-header-buttons"></slot>
          <a data-bs-target="#sidebar" data-bs-toggle="collapse" class="d-block d-md-none btn btn-outline-primary btn-sm">Menu</a>
          <Link :href="route('home')" class="btn btn-outline-primary btn-sm">
            Back to site
          </Link>
        </div>
        <div class="admin-content row">
          <div class="col-sm-2 col-auto nav-side-menu collapse collapse-horizontal show" id="sidebar">
            <SideMenu></SideMenu>
          </div>
          <div class="admin-body col-sm col">
            <slot></slot>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import SideMenu from '@/Shared/SideMenu/Main.vue'
import {Link, usePage} from "@inertiajs/vue3";
import {computed} from "vue";

defineOptions({
  name: 'Admin-Layout',
});

const page = usePage();

const props = defineProps({
  title: String,
});

const fullTitle = computed(() => {
  let title = [
    props.title
  ];

  return _.filter(title).join(' ');
});

function clearSearch() {
  page.props.search = null
}
</script>

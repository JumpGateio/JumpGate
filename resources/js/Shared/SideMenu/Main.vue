<template>
  <div class="side-menu">
    <Link :href="route('admin.index')" class="side-menu-item">
      <i class="fa fa-fw fa-chart-simple"></i>&nbsp;
      Dashboard
    </Link>
    <Link :href="route('admin.index')" class="side-menu-item">
      <i class="fa fa-fw fa-users"></i>&nbsp;
      Users
    </Link>
    <div class="side-menu-heading">Tools</div>
    <Link :href="route('admin.index')" class="side-menu-item">
      <i class="fa fa-fw fa-radar"></i>&nbsp;
      Pulse
    </Link>
    <Link :href="route('admin.index')" class="side-menu-item">
      <i class="fa fa-fw fa-telescope"></i>&nbsp;
      Telescope
    </Link>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {Link} from "@inertiajs/vue3";

export default defineComponent({
  name: 'Sidebar-Main',

  components: {
    Link: Link,
  }
})
</script>

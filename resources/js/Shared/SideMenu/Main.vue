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
    <a :href="route('pulse')" class="side-menu-item">
      <i class="fa fa-fw fa-radar"></i>&nbsp;
      Pulse
    </a>
    <a :href="route('telescope')" class="side-menu-item">
      <i class="fa fa-fw fa-telescope"></i>&nbsp;
      Telescope
    </a>
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

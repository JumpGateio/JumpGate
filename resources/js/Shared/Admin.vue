<template>
  <div class="page admin-page">
    <div class="container-fluid" id="container">
      <div id="content">
        <div class="admin-header">
          <div class="admin-title" v-text="fullTitle"></div>
          <portal-target name="admin-header-buttons"/>
          <a data-bs-target="#sidebar" data-bs-toggle="collapse" class="d-block d-md-none btn btn-outline-primary btn-sm">Menu</a>
          <Link :href="route('home')" class="btn btn-outline-primary btn-sm">
            Back to site
          </Link>
        </div>
        <div class="admin-content row">
          <div class="col-sm-2 col-auto nav-side-menu collapse collapse-horizontal show" id="sidebar">
            <admin-menu></admin-menu>
          </div>
          <div class="admin-body col-sm col">
            <slot/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import SideMenu from '@/Shared/SideMenu/Main.vue'
// import Search from '@/Shared/Partials/Search.vue'
import {defineComponent} from "vue";
import {Link, usePage} from "@inertiajs/vue3";
import _ from "lodash";

export default defineComponent({
  name: 'Admin',

  components: {
    'admin-menu': SideMenu,
    // 'search':     Search,
    Link: Link,
  },

  computed: {
    fullTitle() {
      let title = [
        this.page.props.title
      ]

      return _.filter(title).join(' ')
    }
  },

  data() {
    return {
      page: usePage(),
    }
  },

  watch: {
    'page.props.flash': {
      handler(val, oldVal) {
        if (val.success !== null) {
          // this.bootbox('success', val.success)
        } else if (val.error !== null) {
          // this.bootbox('danger', val.error)
        }
      },
      deep: true,
    }
  },

  methods: {
    clearSearch() {
      this.page.search = null
    }
  }
})
</script>

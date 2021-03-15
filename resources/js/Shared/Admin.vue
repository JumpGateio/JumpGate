<template>
  <div class="page admin-page">
    <div class="container-fluid" id="container">
      <div id="content">
        <div class="admin-header">
          <div class="admin-title" v-text="fullTitle"></div>
          <div class="search" v-if="useSearch == true">
            <input type="text" class="form-control" v-model="$page.search" placeholder="Search...">
            <span class="fa fa-fw fa-times-circle-o search-clear" @click="clearSearch()"></span>
          </div>
          <inertia-link :href="route('home')" class="btn btn-outline-primary btn-sm">
            Back to site
          </inertia-link>
        </div>
        <div class="nav-side-menu">
          <admin-menu></admin-menu>
        </div>
        <div class="admin-body">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin/Main'

  export default {
    name: 'Admin',

    props: {
      title:     String,
      useSearch: {
        type:    Boolean,
        default: false,
      }
    },

    components: {
      'admin-menu': Admin,
    },

    computed: {
      fullTitle()
      {
        let title = [
          this.title,
          this.$page.props.title
        ]

        return _.filter(title).join(' ')
      }
    },

    methods: {
      clearSearch()
      {
        this.$page.search = null
      }
    }
  }
</script>

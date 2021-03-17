<template>
  <div class="page admin-page">
    <div class="container-fluid" id="container">
      <div id="content">
        <div class="admin-header">
          <div class="admin-title" v-text="fullTitle"></div>
          <portal-target name="admin-header-buttons" />
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
  import Search from '@/Shared/Partials/Search'

  export default {
    name: 'Admin',

    components: {
      'admin-menu': Admin,
      'search':     Search,
    },

    computed: {
      fullTitle()
      {
        let title = [
          this.$page.props.title
        ]

        return _.filter(title).join(' ')
      }
    },

    watch: {
      '$page.props.flash':       {
        handler(val, oldVal)
        {
          if (val.success !== null) {
            this.bootbox('success', val.success)
          } else if (val.error !== null) {
            this.bootbox('danger', val.error)
          }
        },
        deep: true,
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

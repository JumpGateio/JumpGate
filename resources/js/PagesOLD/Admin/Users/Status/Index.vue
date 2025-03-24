<template>
  <div>
    <portal to="admin-header-buttons">
      <inertia-link :href="route('admin.users.status.create')" class="btn btn-sm btn-success btn-create mr-2">
        Create New
      </inertia-link>
    </portal>
    <div class="admin-search">
      <search v-model="form.search" @reset="reset"></search>
    </div>
    <div class="table-responsive table-admin">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>name</th>
            <th>Label</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="status in statuses.data">
            <tr>
              <td>{{ status.id }}</td>
              <td>{{ status.name }}</td>
              <td>{{ status.label }}</td>
              <td class="text-right">
                <div class="btn-toolbar float-right" role="toolbar">
                  <div class="btn-group">
                    <inertia-link :href="route('admin.users.status.edit', [status.id])"
                                  class="btn btn-sm btn-outline-purple">Edit</inertia-link>
                    <inertia-link :href="route('admin.users.status.confirm', [status.id, 'delete', 1])"
                                  class="btn btn-sm btn-outline-danger">Delete</inertia-link>
                  </div>
                </div>
              </td>
            </tr>
          </template>
          <tr v-if="statuses.data.length === 0">
            <td colspan="5">No statuses found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination :links="statuses.links"></pagination>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'
  import Pagination from '@/Shared/Partials/Pagination'
  import Search from '@/Shared/Partials/Search'

  export default {
    name:     'Admin-Users-Status-Index',
    metaInfo: {title: 'Status List'},

    layout: Admin,

    components: {
      'pagination': Pagination,
      'search':     Search,
    },

    props: {
      statuses: Object,
      filters:  Object,
    },

    data()
    {
      return {
        form: {
          search:  this.filters.search,
        },
      }
    },

    watch: {
      form: {
        handler: _.throttle(function () {
          let query = _.pickBy(this.form)
          this.$inertia.replace(this.route('admin.users.status.index', Object.keys(query).length ? query : {}))
        }, 150),
        deep:    true,
      },
    },

    methods: {
      reset()
      {
        this.form = _.mapValues(this.form, () => null)
      },
    },
  }
</script>

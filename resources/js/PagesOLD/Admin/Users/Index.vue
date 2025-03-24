<template>
  <div>
    <portal to="admin-header-buttons">
      <inertia-link :href="route('admin.users.create')" class="btn btn-sm btn-success btn-create mr-2">
        Create New
      </inertia-link>
    </portal>
    <div class="admin-search">
      <search v-model="form.search" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search>
    </div>
    <div class="table-responsive table-admin">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Status</th>
            <th>Roles</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="user in users.data">
            <tr :class="{ 'table-danger': user.deleted_at !== null }">
              <td>{{ user.id }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.status }}</td>
              <td>{{ user.roles }}</td>
              <td class="text-right">
                <user-toolbar :user="user"></user-toolbar>
              </td>
            </tr>
          </template>
          <tr v-if="users.data.length === 0">
            <td colspan="5">No users found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination :links="users.links"></pagination>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'
  import UserToolbar from '@/Shared/Admin/UserToolbar'
  import Pagination from '@/Shared/Partials/Pagination'
  import Search from '@/Shared/Partials/Search'

  export default {
    name:     'Admin-Users-Index',
    metaInfo: {title: 'User List'},

    layout: Admin,

    components: {
      'user-toolbar': UserToolbar,
      'pagination':   Pagination,
      'search':       Search,
    },

    props: {
      users:   Object,
      filters: Object,
    },

    data()
    {
      return {
        form: {
          search:  this.filters.search,
          trashed: this.filters.trashed,
        },
      }
    },

    watch: {
      form: {
        handler: _.throttle(function () {
          let query = _.pickBy(this.form)
          this.$inertia.replace(this.route('admin.users.index', Object.keys(query).length ? query : {}))
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

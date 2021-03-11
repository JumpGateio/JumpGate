<template>
  <div class="table-responsive" style="min-height: calc(100vh - 106px);">
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
        <template v-for="user in $page.searchResults.data">
          <tr :class="{ 'table-danger': user.deleted_at !== null }">
            <td>{{ user.id }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.status_label }}</td>
            <td>{{ user.role_list }}</td>
            <td class="text-right">
              <user-actions :user="user"></user-actions>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'
  import Search from '@/Shared/Admin/Search'
  import UserActions from '@/Shared/Admin/UserActions'

  export default {
    name: 'Admin-Users-Index',

    layout: (h, page) => h(Admin, {props: {title: 'Users', useSearch: true}},
      [h(Search, {props: {url: 'admin.users.search'}}, [page])]),

    components: {
      'user-actions': UserActions,
    },
  }
</script>

<template>
  <div class="tile-group">
    <tile color="background-success" textColor="text-black"
          icon="fa fa-4x fa-users" :content="count"
    ></tile>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Status</th>
            <th class="text-right">
              <inertia-link :href="route('admin.users.index')" class="btn btn-sm btn-outline-primary">
                <span class="fa fa-external-link"></span>
              </inertia-link>
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-for="user in users" v-if="Object.keys(users).length > 0">
            <tr :class="{ 'table-danger': user.deleted_at !== null }">
              <td>{{ user.id }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.status_label }}</td>
              <td class="text-right">
                <user-actions :user="user" :iconOnly="true"></user-actions>
              </td>
            </tr>
          </template>
          <template v-else>
            <tr>
              <td colspan="6">No users found.</td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import Tile from '@/Shared/Admin/Tile'
  import UserActions from '@/Shared/Admin/UserActions'

  export default {
    name: 'Admin-Index-Users',

    components: {
      'tile':         Tile,
      'user-actions': UserActions,
    },

    props: {
      users: Array,
      count: String,
    },
  }
</script>

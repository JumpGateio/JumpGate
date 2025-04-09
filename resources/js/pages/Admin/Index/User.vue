<template>
  <div class="tile-group">
    <Tile color="background-success" textColor="text-black"
          icon="fa fa-4x fa-users" :content="count"
    ></Tile>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Status</th>
          <th class="text-end">
            <Link :href="route('admin.users.index')">
              <span class="fa fa-external-link"></span>
            </Link>
          </th>
        </tr>
        </thead>
        <tbody>
        <template v-for="user in users" v-if="Object.keys(users).length > 0">
          <tr :class="{ 'table-danger': user.deleted_at !== null }">
            <td>{{ user.id }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.status }}</td>
            <td class="text-right">
              <UserActions :user="user" :iconOnly="true"></UserActions>
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

<script setup>
import Tile from '@/Shared/Admin/Tile.vue'
import UserActions from '@/Shared/Admin/UserActions.vue'
import {Link} from "@inertiajs/vue3";

defineOptions({
  name: 'Admin-Index-Users',
});

const props = defineProps({
  users: Array,
  count: String,
});
</script>

<template>
  <div>
    <Teleport defer to="#headerButtons" v-if="permissions.create">
      <Link :href="route('admin.users.create')" class="btn btn-sm btn-success mr-2">
        Create User
      </Link>
    </Teleport>
    <div class="admin-search">
      <Search v-model="form.search" @reset="reset()">
        <label class="block text-gray-200">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null"/>
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </Search>
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
            <td class="text-end">
              <UserToolbar :user="user" :permissions="permissions"></UserToolbar>
            </td>
          </tr>
        </template>
        <tr v-if="users.data.length === 0">
          <td colspan="5">No users found.</td>
        </tr>
        </tbody>
      </table>
    </div>
    <Pagination :links="users.links"></Pagination>
  </div>
</template>

<script setup>
import Admin from '@/Shared/Admin.vue';
import UserToolbar from '@/Shared/Admin/UserToolbar.vue';
import Pagination from '@/Shared/Partials/Pagination.vue';
import Search from '@/Shared/Partials/Search.vue';
import {watch} from "vue";
import {Link, router, useForm} from "@inertiajs/vue3";

defineOptions({
  name:   'Admin-Users-Index',
  layout: Admin,
});

const props = defineProps({
  users:       Object,
  permissions: Object,
  filters:     Object,
});

const form = useForm({
  search:  props.filters.search,
  trashed: props.filters.trashed,
});

watch(() => form.search,
  _.throttle(() => {
    let url = route('admin.users.index', _.pickBy(form.data()));

    router.get(url);
  }, 150), {deep: true});
watch(() => form.trashed,
  () => {
    router.get(route('admin.users.index', _.pickBy(form.data())))
  }, {deep: true});

function reset() {
  router.get(route('admin.users.index'));
}
</script>

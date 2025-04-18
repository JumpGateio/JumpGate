<template>
  <div>
    <Teleport defer to="#headerButtons">
      <button class="btn btn-sm btn-warning" data-bs-toggle="collapse" data-bs-target="#infobox">
        <i class="fa fa-fw fa-question-circle"></i>
      </button>
      <Link :href="route('admin.users.status.create')" class="btn btn-sm btn-success btn-create mr-2"
      v-if="permissions.create">
        Create Status
      </Link>
    </Teleport>
    <div class="admin-search">
      <Search v-model="form.search" @reset="reset"></Search>
    </div>
    <div class="row mx-1">
      <div class="col-12">
        <div class="collapse" id="infobox">
          <div class="card card-body b-warning">
            Only certain statuses have built in uses in the code. Blocked will stop
            the user from viewing ANY page. Other than that, it is only there for tracking.
          </div>
        </div>
      </div>
    </div>
    <div class="table-responsive table-admin">
      <table class="table table-striped table-hover">
        <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
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
            <td class="text-end">
              <div class="btn-toolbar justify-content-end" role="toolbar">
                <div class="btn-group">
                  <Link :href="route('admin.users.status.edit', [status.id])"
                        class="btn btn-sm btn-outline-purple" v-if="permissions.update">
                    Edit
                  </Link>
                  <Link :href="route('admin.users.status.confirm', [status.id, 'delete', 1])"
                        class="btn btn-sm btn-outline-danger" v-if="permissions.delete">
                    Delete
                  </Link>
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
    <Pagination :links="statuses.links"></Pagination>
  </div>
</template>

<script setup>
import Admin from '@/Shared/Admin.vue'
import Pagination from '@/Shared/Partials/Pagination.vue'
import Search from '@/Shared/Partials/Search.vue'
import {watch} from "vue";
import {Link, router, useForm} from "@inertiajs/vue3";

defineOptions({
  name:   'Admin-Users-Status-Index',
  layout: Admin,
});

const props = defineProps({
  statuses:    Object,
  permissions: Object,
  filters:     Object,
});

const form = useForm({
  search: props.filters.search,
});

watch(() => form.search,
  _.throttle(() => {
    let url = route('admin.users.status.index', _.pickBy(form.data()));

    router.get(url);
  }, 150), {deep: true});

function reset() {
  router.get(route('admin.users.status.index'));
}
</script>

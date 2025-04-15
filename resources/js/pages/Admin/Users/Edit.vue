<template>
  <div class="card-body pl-2 pt-2 pb-3">
    <form @submit.prevent="submit" class="form-horizontal">
      <div class="form-floating mb-3">
        <input type="text" id="email" v-model="form.user.email" class="form-control" placeholder="Email">
        <label for="email">Email Address</label>
      </div>
      <div class="form-group row mb-3">
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" id="displayName" v-model="form.details.display_name" class="form-control"
                   placeholder="Display Name">
            <label for="displayName">Display Name</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" id="firstName" v-model="form.details.first_name" class="form-control"
                   placeholder="First Name">
            <label for="firstName">First Name</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" id="middleName" v-model="form.details.middle_name" class="form-control"
                   placeholder="Middle Name">
            <label for="middleName">Middle Name</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" id="lastName" v-model="form.details.last_name" class="form-control"
                   placeholder="Last Name">
            <label for="lastName">Last Name</label>
          </div>
        </div>
      </div>
      <div class="form-group row mb-3">
        <div class="col-md-6">
          <label for="roles">Select Roles</label>
          <select id="roles" v-model="form.roles" class="form-control" multiple>
            <option :value="parseInt(id)" v-for="(text, id) in roleOptions" v-text="text"></option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="roles">Select Permissions</label>
          <select id="roles" v-model="form.permissions" class="form-control" multiple>
            <option :value="parseInt(id)" v-for="(text, id) in permissionOptions" v-text="text"></option>
          </select>
        </div>
      </div>
      <div class="form-group row mb-3">
        <div class="col-md-6">
          <div class="form-floating">
            <select id="status" v-model="form.status_id" class="form-control">
              <option :value="parseInt(id)" v-for="(text, id) in statusOptions" v-text="text"></option>
            </select>
            <label for="status">Status</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="number" id="failedLoginAttempts" v-model="form.failed_login_attempts" class="form-control"
                   placeholder="Failed Logins">
            <label for="failedLoginAttempts">Failed Login Attempts</label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="submit" :disabled="form.processing" value="Save" class="btn btn-primary">
        <UserActions :user="user" btnSize="btn"></UserActions>
        <Link :href="route('admin.users.index')" class="btn btn-link">Cancel</Link>
      </div>
    </form>
  </div>
</template>

<script setup>
import Admin from '@/Shared/Admin.vue'
import UserActions from '@/Shared/Admin/UserActions.vue'
import {useForm} from "@inertiajs/vue3";

defineOptions({
  name:   'Admin-Users-Edit',
  layout: Admin,
});

const props = defineProps({
  user:              Object,
  roleOptions:       Object,
  permissionOptions: Object | Array,
  statusOptions:     Object,
});

const form = useForm({
  user:                  {
    email: props.user.email,
  },
  details:               {
    display_name: props.user.details.display_name,
    first_name:   props.user.details.first_name,
    middle_name:  props.user.details.middle_name,
    last_name:    props.user.details.last_name,
  },
  status_id:             props.user.status_id,
  failed_login_attempts: props.user.failed_login_attempts,
  roles:                 props.user.role_ids,
  permissions:           props.user.permission_ids,
});

function submit() {
  form.post(route('admin.users.update', props.user.id))
}
</script>

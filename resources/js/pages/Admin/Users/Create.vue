<template>
  <div class="card-body pl-2 pt-2 pb-3">
    <form @submit.prevent="submit" class="form-horizontal">
      <div class="form-floating mb-3">
        <input type="text" id="email" v-model="form.email" class="form-control" placeholder="Email">
        <label for="email">Email Address</label>
        <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
      </div>
      <div class="form-group">
        <label for="roles">Select Roles</label>
        <select id="roles" v-model="form.roles" class="form-control" multiple>
          <option :value="parseInt(id)" v-for="(text, id) in roleOptions" v-text="text"></option>
        </select>
        <small class="form-text text-danger" v-if="form.errors.roles">{{ form.errors.roles }}</small>
      </div>
      <div class="form-group">
        <label for="invite">How should we add the user?</label>
        <select id="invite" v-model="form.invite" class="form-control">
          <option :value="id" v-for="(text, id) in invitationOptions" v-text="text"></option>
        </select>
        <small class="form-text text-danger" v-if="form.errors.invite">{{ form.errors.invite }}</small>
        <p id="emailHelp" class="form-text text-muted">
          If you select invite or send activation, these will send an email to the user to allow them to finish
          activation.
        </p>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" :disabled="form.processing" value="Save">
        <Link :href="route('admin.users.index')" class="btn btn-link">Cancel</Link>
      </div>
    </form>
  </div>
</template>

<script setup>
import Admin from '@/Shared/Admin.vue'
import {Link, useForm} from "@inertiajs/vue3";

defineOptions({
  name:   'Admin-Users-Create',
  layout: Admin,
});

const props = defineProps({
  roleOptions:       Object,
  invitationOptions: Object,
  selected:          Number,
});

const form = useForm({
  email:  null,
  roles:  [],
  invite: props.selected,
});

function submit() {
  form.post(route('admin.users.store'));
}
</script>

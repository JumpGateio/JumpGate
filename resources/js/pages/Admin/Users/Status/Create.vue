<template>
  <div class="card-body pl-2 pt-2 pb-3">
    <form @submit.prevent="submit" class="form-horizontal">
      <div class="form-floating mb-3">
        <input type="text" id="name" v-model="form.name" class="form-control" placeholder="Name">
        <label for="name">Name</label>
        <small class="form-text text-danger" v-if="form.errors.name">{{ form.errors.name }}</small>
      </div>
      <div class="form-floating mb-3">
        <input type="text" id="label" v-model="form.label" class="form-control" placeholder="Label">
        <label for="name">Label</label>
        <small class="form-text text-danger" v-if="form.errors.label">{{ form.errors.label }}</small>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" :disabled="form.processing" value="Save">
        <Link :href="route('admin.users.status.index')" class="btn btn-link">Cancel</Link>
      </div>
    </form>
  </div>
</template>

<script setup>
import Admin from '@/Shared/Admin.vue'
import {Link, useForm} from "@inertiajs/vue3";

defineOptions({
  name:   'Admin-Users-Status-Create',
  layout: Admin,
});

const form = useForm({
  name:  null,
  label: null,
});

function submit() {
  form.post(route('admin.users.status.store'))
}
</script>

<template>
  <div class="card-body pl-2 pt-2 pb-3">
    <form @submit.prevent="submit" class="form-horizontal">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" v-model="form.name" class="form-control" placeholder="Name">
        <small class="form-text text-danger" v-if="form.errors.name">{{ form.errors.name }}</small>
      </div>
      <div class="form-group">
        <label for="name">Label</label>
        <input type="text" id="label" v-model="form.label" class="form-control" placeholder="Label">
        <small class="form-text text-danger" v-if="form.errors.label">{{ form.errors.label }}</small>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" :disabled="form.processing" value="Save">
        <inertia-link :href="route('admin.users.status.index')" class="btn btn-link">Cancel</inertia-link>
      </div>
    </form>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'

  export default {
    name:     'Admin-Users-Status-Create',
    metaInfo: {title: 'Status Create'},

    layout: Admin,

    data()
    {
      return {
        form: this.$inertia.form({
          name:  null,
          label:  null,
        })
      }
    },

    methods: {
      submit()
      {
        this.form.post(this.route('admin.users.status.store'))
      },
    }
  }
</script>

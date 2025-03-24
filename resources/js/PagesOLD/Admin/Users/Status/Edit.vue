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
        <input type="submit" :disabled="form.processing" value="Save" class="btn btn-primary">
        <inertia-link :href="route('admin.users.status.index')" class="btn btn-link">Cancel</inertia-link>
      </div>
    </form>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'

  export default {
    name:     'Admin-Users-Edit',
    metaInfo: {title: 'User Edit'},

    layout: Admin,

    props: {
      status: Object,
    },

    data()
    {
      return {
        form: this.$inertia.form({
          name:  this.status.name,
          label: this.status.label,
        })
      }
    },

    methods: {
      submit()
      {
        this.form.post(this.route('admin.users.status.update', this.status.id))
      },
    }
  }
</script>

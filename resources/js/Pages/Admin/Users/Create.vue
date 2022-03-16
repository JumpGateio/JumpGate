<template>
  <div class="card-body pl-2 pt-2 pb-3">
    <form @submit.prevent="submit" class="form-horizontal">
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" id="email" v-model="form.email" class="form-control" placeholder="Email">
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
        <inertia-link :href="route('admin.users.index')" class="btn btn-link">Cancel</inertia-link>
      </div>
    </form>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'

  export default {
    name:     'Admin-Users-Create',
    metaInfo: {title: 'User Create'},

    layout: Admin,

    props: {
      roleOptions:       Object,
      invitationOptions: Object,
      selected:          Number,
    },

    data()
    {
      return {
        form: this.$inertia.form({
          email:  null,
          roles:  [],
          invite: this.selected,
        })
      }
    },

    methods: {
      submit()
      {
        this.form.post(this.route('admin.users.store'))
      },
    }
  }
</script>

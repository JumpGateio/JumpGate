<template>
  <div class="p-2">
    <p class="lead">Add a new user</p>
    <div class="hr-divider"></div>
    <div class="card-body p-1 py-3">
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" id="email" v-model="form.email" class="form-control" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="roles">Select Roles</label>
        <select id="roles" v-model="form.roles" class="form-control" multiple>
          <option :value="parseInt(id)" v-for="(text, id) in roleOptions" v-text="text"></option>
        </select>
      </div>
      <div class="form-group">
        <label for="invite">How should we add the user?</label>
        <select id="invite" v-model="form.invite" class="form-control">
          <option :value="id" v-for="(text, id) in invitationOptions" v-text="text"></option>
        </select>
        <p id="emailHelp" class="form-text text-muted">
          If you select invite or send activation, these will send an email to the user to allow them to finish
          activation.
        </p>
      </div>
      <div class="form-group">
        <div class="btn btn-primary" @click="submit()">Save</div>
        <inertia-link :href="route('admin.users.index')" class="btn btn-link">Cancel</inertia-link>
      </div>
    </div>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'

  export default {
    name: 'Admin-Users-Create',

    layout: (h, page) => h(Admin, {props: {title: 'Add User'}}, [page]),

    props: {
      roleOptions:       Object,
      invitationOptions: Object,
      selected:          Number,
    },

    data()
    {
      return {
        form: {
          email:  null,
          roles:  [],
          invite: this.selected,
        }
      }
    },

    methods: {
      submit()
      {
        axios.post(this.route('admin.users.store'), this.form)
             .then((message) => {
               this.$inertia.replace(this.route('admin.users.index'))
                   .then(() => this.bootbox('success', message.data))
             })
             .catch((error) => {
               this.bootbox('danger', error.response.data.message)
             })
      },
    }
  }
</script>

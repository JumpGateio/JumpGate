<template>
  <div class="card-body pl-2 pt-2 pb-3">
    <form @submit.prevent="submit" class="form-horizontal">
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" id="email" v-model="form.user.email" class="form-control" placeholder="Email">
      </div>
      <div class="form-group row">
        <div class="col-md-3">
          <label for="displayName">Display Name</label>
          <input type="text" id="displayName" v-model="form.details.display_name" class="form-control" placeholder="Display Name">
        </div>
        <div class="col-md-3">
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" v-model="form.details.first_name" class="form-control" placeholder="First Name">
        </div>
        <div class="col-md-3">
          <label for="middleName">Middle Name</label>
          <input type="text" id="middleName" v-model="form.details.middle_name" class="form-control" placeholder="Middle Name">
        </div>
        <div class="col-md-3">
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" v-model="form.details.last_name" class="form-control" placeholder="Last Name">
        </div>
      </div>
      <div class="form-group">
        <label for="roles">Select Roles</label>
        <select id="roles" v-model="form.roles" class="form-control" multiple>
          <option :value="parseInt(id)" v-for="(text, id) in roleOptions" v-text="text"></option>
        </select>
      </div>
      <div class="form-group row">
        <div class="col-md-6">
          <label for="status">Status</label>
          <select id="status" v-model="form.status_id" class="form-control">
            <option :value="parseInt(id)" v-for="(text, id) in statusOptions" v-text="text"></option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="failedLoginAttempts">Failed Login Attempts</label>
          <input type="number" id="failedLoginAttempts" v-model="form.failed_login_attempts" class="form-control" placeholder="Failed Logins">
        </div>
      </div>
      <div class="form-group">
        <input type="submit" :disabled="form.processing" value="Save" class="btn btn-primary">
        <user-actions :user="user" btnSize="btn"></user-actions>
        <inertia-link :href="route('admin.users.index')" class="btn btn-link">Cancel</inertia-link>
      </div>
    </form>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'
  import UserActions from '@/Shared/Admin/UserActions'

  export default {
    name:     'Admin-Users-Edit',
    metaInfo: {title: 'User Edit'},

    layout: Admin,

    props: {
      user:          Object,
      roleOptions:   Object,
      statusOptions: Object,
    },

    components: {
      'user-actions': UserActions,
    },

    data()
    {
      return {
        form: this.$inertia.form({
          user:                  {
            email: this.user.email,
          },
          details:               {
            display_name: this.user.details.display_name,
            first_name:   this.user.details.first_name,
            middle_name:  this.user.details.middle_name,
            last_name:    this.user.details.last_name,
          },
          status_id:             this.user.status_id,
          failed_login_attempts: this.user.failed_login_attempts,
          roles:                 _.map(this.user.roles, 'id'),
        })
      }
    },

    methods: {
      submit()
      {
        this.form.post(this.route('admin.users.update', this.user.id))
      },
    }
  }
</script>

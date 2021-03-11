<template>
  <div class="card-body pl-2 pt-2 pb-3">
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
    <div class="form-group row">
      <div class="col-2">
        <label for="actionCap">Action Cap</label>
        <input type="number" id="actionCap" v-model="form.config.action_cap" class="form-control">
      </div>
      <div class="col-2">
        <label for="activeCharacterId">Active Character</label>
        <select id="activeCharacterId" v-model="form.config.active_character_id" class="form-control">
          <option v-for="(name, id) in characters" :value="parseInt(id)" v-text="name"></option>
        </select>
      </div>
      <div class="col-2">
        <label for="tutorialCompletedFlag">Tutorial Complete</label>
        <select id="tutorialCompletedFlag" v-model="form.config.tutorial_completed_flag" class="form-control">
          <option value="0">No</option>
          <option value="1">Yes</option>
        </select>
      </div>
      <div class="col-2">
        <label for="tutorialStep">Tutorial Step</label>
        <input type="number" id="tutorialStep" v-model="form.config.tutorial_step" class="form-control">
      </div>
      <div class="col-2">
        <label for="testLevel">Test Level</label>
        <select id="testLevel" v-model="form.config.test_level_id" class="form-control">
          <option :value="null">None</option>
          <option v-for="level in testLevels" :value="level.id" v-text="level.display_name"></option>
        </select>
      </div>
      <div class="col-2">
        <label for="requestTest">Test Requested</label>
        <select id="requestTest" v-model="form.config.request_test_flag" class="form-control">
          <option value="0">No</option>
          <option value="1">Yes</option>
        </select>
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
      <div class="btn btn-primary" @click="submit()">Save</div>
      <inertia-link :href="route('admin.users.index')" class="btn btn-link">Cancel</inertia-link>
    </div>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'

  export default {
    name: 'Admin-Users-Edit',

    layout: (h, page) => h(Admin, {props: {title: 'Edit User: '}}, [page]),

    props: {
      user:          Object,
      characters:    Object,
      roleOptions:   Object,
      statusOptions: Object,
      testLevels:    Object,
    },

    data()
    {
      return {
        form: {
          user:                  {
            email: this.user.email,
          },
          details:               {
            display_name: this.user.details.display_name,
            first_name:   this.user.details.first_name,
            middle_name:  this.user.details.middle_name,
            last_name:    this.user.details.last_name,
          },
          config:                {
            action_cap:              this.user.config.action_cap,
            active_character_id:     this.user.config.active_character_id,
            tutorial_step:           this.user.config.tutorial_step,
            tutorial_completed_flag: this.user.config.tutorial_completed_flag,
            test_level_id:           this.user.config.test_level_id,
            request_test_flag:       this.user.config.request_test_flag,
          },
          status_id:             this.user.status_id,
          failed_login_attempts: this.user.failed_login_attempts,
          roles:                 _.map(this.user.roles, 'id'),
        }
      }
    },

    methods: {
      submit()
      {
        axios.post(this.route('admin.users.update', this.user.id), this.form)
             .then((response) => {
               this.$inertia.replace(this.route('admin.users.index'))
                   .then(() => this.bootbox('success', response.data.message))
             })
             .catch((error) => {
               this.bootbox('danger', error.response.data.message)
             })
      },
    }
  }
</script>

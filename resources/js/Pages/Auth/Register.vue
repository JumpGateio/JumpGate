<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6">
        <div class="card">
          <form @submit.prevent="submit" class="form-horizontal">
            <div class="card-header">Register</div>
            <div class="card-body pb-0">
              <div class="form-group row">
                <label for="email" class="col-3 col-form-label">Email</label>
                <div class="col-9">
                  <input type="text" id="email" class="form-control" v-model="form.email" required>
                  <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="display_name" class="col-3 col-form-label">Display Name</label>
                <div class="col-9">
                  <input type="display_name" id="display_name" class="form-control" v-model="form.display_name" required>
                  <small class="form-text text-danger" v-if="form.errors.display_name">
                    {{ form.errors.display_name }}
                  </small>
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-3 col-form-label">Password</label>
                <div class="col-9">
                  <input type="password" id="password" class="form-control" v-model="form.password" required>
                  <small class="form-text text-danger" v-if="form.errors.password">{{ form.errors.password }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="password_confirmation" class="col-3 col-form-label">Confirm Password</label>
                <div class="col-9">
                  <input type="password" id="password_confirmation" class="form-control"
                         v-model="form.password_confirmation" required>
                  <small class="form-text text-danger" v-if="form.errors.password_confirmation">
                    {{ form.errors.password_confirmation }}
                  </small>
                </div>
              </div>
              <div class="card-footer">
                <input type="submit" :disabled="form.processing" value="Register" class="btn btn-primary">
                <inertia-link :href="route().has('auth.login') ? route('auth.login') : route('auth.social.login')"
                              class="btn btn-link">
                  Login
                </inertia-link>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:     'Auth-Register',
    metaInfo: {title: 'Register'},

    data()
    {
      return {
        form: this.$inertia.form({
          email:                 null,
          password:              null,
          password_confirmation: null,
        })
      }
    },

    methods: {
      submit()
      {
        this.form.post(this.route('auth.register'))
      }
    }
  }
</script>

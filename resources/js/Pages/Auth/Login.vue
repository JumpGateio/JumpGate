<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6">
        <div class="card">
          <form @submit.prevent="submit" class="form-horizontal">
            <div class="card-header">Login</div>
            <div class="card-body pb-0">
              <div class="form-group row">
                <label for="email" class="col-3 col-form-label">Email</label>
                <div class="col-9">
                  <input type="text" id="email" class="form-control" v-model="form.email" required>
                  <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-3 col-form-label">Password</label>
                <div class="col-9">
                  <input type="password" id="password" class="form-control" v-model="form.password" required>
                  <small class="form-text text-danger" v-if="form.errors.password">{{ form.errors.password }}</small>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <input type="submit" :disabled="form.processing" value="Login" class="btn btn-primary">
              <inertia-link :href="route('auth.register')" class="btn btn-link" v-if="route().has('auth.register')">
                Register
              </inertia-link>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:     'Auth-Login',
    metaInfo: {title: 'Login'},

    data()
    {
      return {
        form: this.$inertia.form({
          email:    null,
          password: null,
        })
      }
    },

    methods: {
      submit()
      {
        this.form.post(this.route('auth.login'))
      }
    }
  }
</script>

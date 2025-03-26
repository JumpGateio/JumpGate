<template>
  <div class="container-fluid vh-100 mt-5">
    <div class="row">
      <div class="offset-lg-3 col-lg-6">
        <div class="card">
          <form @submit.prevent="submit">
            <div class="card-header">Login</div>
            <div class="card-body pb-0">
              <div class="row mb-3">
                <label for="email" class="col-3 col-form-label">Email</label>
                <div class="col-9">
                  <input type="text" id="email" class="form-control" v-model="form.email" required>
                  <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
                </div>
              </div>
              <div class="row mb-3">
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

<script lang="ts">
  import {defineComponent} from "vue";
  import {useForm} from "@inertiajs/vue3";
  import Layout from "@/Shared/Layout.vue";

  export default defineComponent({
    name:     'Auth-Login',

    layout: Layout,

    data()
    {
      return {
        form: useForm({
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
  })
</script>

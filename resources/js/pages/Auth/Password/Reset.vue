<template>
  <div class="container">
    <div class="row">
      <div class="offset-2 col-8 mt-4">
        <div class="card">
          <div class="card-header">
            <strong>Reset Password</strong>
          </div>
          <div class="card-body pb-0">
            <form @submit.prevent="submit" class="form-horizontal">
              <div class="form-group row" :class="{ 'has-error': form.errors.email != null }">
                <label for="email" class="col-3 col-form-label">E-Mail Address</label>
                <div class="col-9">
                  <input id="email" type="email" class="form-control" name="email" v-model="form.email" required autofocus>
                  <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
                </div>

                <div class="form-group row" :class="{ 'has-error': form.errors.password != null }">
                  <label for="password" class="col-3 col-form-label">Password</label>\
                  <div class="col-9">
                    <input id="password" type="password" class="form-control" name="password" v-model="form.password" required>
                    <small class="form-text text-danger" v-if="form.errors.password">{{ form.errors.password }}</small>
                  </div>
                </div>

                <div class="form-group row" :class="{ 'has-error': form.errors.password_confirmation != null }">
                  <label for="password-confirm" class="col-3 col-form-label">Confirm Password</label>
                  <div class="col-9">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           v-model="form.password_confirmation" required>
                    <small class="form-text text-danger" v-if="form.errors.password_confirmation">
                      {{ form.errors.password_confirmation }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" :disabled="form.processing" class="btn btn-primary">
                  Reset Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import {defineComponent} from "vue";
  import Layout from "@/Shared/Layout.vue";
  import {useForm} from "@inertiajs/vue3";

  export default defineComponent({
    name:     'Auth-Password-Reset',

    layout: Layout,

    props: {
      tokenString: String,
    },

    data()
    {
      return {
        form: useForm({
          email:                 null,
          password:              null,
          password_confirmation: null,
        })
      }
    },

    methods: {
      submit()
      {
        this.form.post(this.route('auth.password.handle', this.tokenString))
      }
    }
  })
</script>

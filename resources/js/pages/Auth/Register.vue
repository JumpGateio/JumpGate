<template>
  <Head title="Register"/>
  <div class="container-fluid vh-100 mt-5 registration auth">
    <div class="combo-box">
      <div class="site-image">
        <img src="/img/site_logo.png" alt="Site Logo">
      </div>
      <div class="vr"></div>
      <div class="auth-form">
        <h3 class="bb-600 text-center">
          Create an Account
        </h3>
        <div class="social-box" v-if="socialEnabled">
          <Link :href="route('auth.social.login', 'google')" class="btn btn-google w-100 text-white mb-3"
          >
            <i class="fa-brands fa-google"></i>&nbsp;Google
          </Link>
        </div>
        <div class="or-line" v-if="socialEnabled">
          <hr>
          <div class="text-circle">OR</div>
        </div>
        <form @submit.prevent="submit">
          <div class="form-floating mb-3">
            <input type="text" id="email" class="form-control" v-model="form.email" placeholder="Email" required>
            <label for="email">Email</label>
            <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
          </div>
          <div class="form-floating mb-3">
            <input type="display_name" id="display_name" class="form-control" v-model="form.display_name"
                   placeholder="Display Name" required>
            <label for="display_name">Display Name</label>
            <small class="form-text text-danger" v-if="form.errors.display_name">
              {{ form.errors.display_name }}
            </small>
          </div>
          <div class="form-floating mb-3">
            <input type="password" placeholder="Password" id="password" class="form-control"
                   v-model="form.password" required>
            <label for="password">Password</label>
            <small class="form-text text-danger" v-if="form.errors.password">{{ form.errors.password }}</small>
          </div>
          <div class="form-floating mb-3">
            <input type="password" id="password_confirmation" class="form-control" placeholder="Confirm Password"
                   v-model="form.password_confirmation" required>
            <label for="password_confirmation">Confirm Password</label>
            <small class="form-text text-danger" v-if="form.errors.password_confirmation">
              {{ form.errors.password_confirmation }}
            </small>
          </div>
          <input type="submit" :disabled="form.processing" value="Register" class="btn btn-primary w-100">
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3"
import Layout from "@/Shared/Layout.vue";

defineOptions({
  name:   'Auth-Register',
  layout: Layout,
});

const props = defineProps({
  socialEnabled: Boolean,
})

const form = useForm({
  email:                 null,
  display_name:          null,
  password:              null,
  password_confirmation: null,
})

function submit() {
  form.post(route('auth.register'))
}
</script>

<template>
  <Head title="Register"/>
  <div class="container-fluid vh-100 mt-5 registration auth">
    <div class="combo-box">
      <div class="site-image">
        <img src="https://place-hold.it/300x300" alt="Site Logo">
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
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" class="form-control" v-model="form.email" required>
            <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
          </div>
          <div class="mb-3">
            <label for="display_name" class="form-label">Display Name</label>
            <input type="display_name" id="display_name" class="form-control" v-model="form.display_name" required>
            <small class="form-text text-danger" v-if="form.errors.display_name">
              {{ form.errors.display_name }}
            </small>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" class="form-control" v-model="form.password" required>
            <small class="form-text text-danger" v-if="form.errors.password">{{ form.errors.password }}</small>
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" class="form-control"
                   v-model="form.password_confirmation" required>
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

<script setup lang="ts">
import {Head, Link, useForm} from "@inertiajs/vue3"
import Layout from "@/Shared/Layout.vue";

declare const name: 'Auth-Register';

defineOptions({layout: Layout})

defineProps({
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

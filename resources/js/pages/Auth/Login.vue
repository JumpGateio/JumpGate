<template>
  <div class="container-fluid vh-100 mt-5 login auth">
    <div class="combo-box">
      <div class="flex">
        <img src="/img/site_logo.png" alt="Site Logo">
      </div>
      <div class="vr"></div>
      <div class="auth-form">
        <h3 class="bb-600 text-center">
          Sign In
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
            <input type="password" id="password" class="form-control" v-model="form.password" placeholder="Password"
                   required>
            <label for="password">Password</label>
            <small class="form-text text-danger" v-if="form.errors.password">{{ form.errors.password }}</small>
          </div>
          <input type="submit" :disabled="form.processing" value="Login" class="btn btn-primary w-100">
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import Layout from "@/Shared/Layout.vue";
import {Link} from "@inertiajs/vue3"

defineOptions({
  name:   'Auth-Login',
  layout: Layout,
});

const props = defineProps({
  socialEnabled: Boolean,
});

const form = useForm({
  email:    null,
  password: null,
});

function submit() {
  form.post(route('auth.login'))
}
</script>

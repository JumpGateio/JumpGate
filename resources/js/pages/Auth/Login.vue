<template>
  <div class="container-fluid vh-100 mt-5">
    <div class="d-flex flex-column flex-md-row  gap-5 justify-content-center align-items-center">
      <div class="flex">
        <img src="https://place-hold.it/300x300" alt="Site Logo">
      </div>
      <div class="vr d-none d-sm-block"></div>
      <div class="flex">
        <form @submit.prevent="submit">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" class="form-control" v-model="form.email" required>
            <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" class="form-control" v-model="form.password" required>
            <small class="form-text text-danger" v-if="form.errors.password">{{ form.errors.password }}</small>
          </div>
          <div class="btn-group w-100 mb-3">
            <input type="submit" :disabled="form.processing" value="Login" class="btn btn-primary">
            <Link :href="route('auth.register')" class="btn btn-jumpgate" v-if="route().has('auth.register')">
              Register
            </Link>
          </div>
          <Link :href="route('auth.social.login', 'google')" class="btn btn-google w-100 text-white mb-3"
                v-if="socialEnabled">
            <i class="fa-brands fa-google"></i>&nbsp;Sign In with Google
          </Link>
        </form>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {useForm} from "@inertiajs/vue3";
import Layout from "@/Shared/Layout.vue";
import {Link} from "@inertiajs/vue3"

export default defineComponent({
  name: 'Auth-Login',

  layout: Layout,

  components: {
    Link: Link,
  },

  props: {
    socialEnabled: Boolean,
  },

  data() {
    return {
      form: useForm({
        email:    null,
        password: null,
      })
    }
  },

  methods: {
    submit() {
      this.form.post(this.route('auth.login'))
    }
  }
})
</script>

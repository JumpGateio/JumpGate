<template>
  <div class="container-fluid vh-100 mt-5">
    <div class="d-flex flex-column flex-md-row  gap-5 justify-content-center align-items-center">
      <div class="flex">
        <img src="https://place-hold.it/300x300" alt="Site Logo">
      </div>
      <div class="vr d-none d-sm-block" style="height: 400px;"></div>
      <div class="flex">
        <form @submit.prevent="submit">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" class="form-control" v-model="form.email" required>
            <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" class="form-control" v-model="form.password" required>
            <small class="form-text text-danger" v-if="form.errors.password">{{ form.errors.password }}</small>
          </div>
          <input type="submit" :disabled="form.processing" value="Login" class="btn btn-primary">
          <Link :href="route('auth.register')" class="btn btn-link" v-if="route().has('auth.register')">
            Register
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
    name:     'Auth-Login',

    layout: Layout,

    components: {
      Link: Link,
    },

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

<template>
  <div class="container">
    <div class="row">
      <div class="offset-2 col-8 mt-4">
        <div class="card">
          <div class="card-header">
            <strong>Reset Password</strong>
          </div>
          <form @submit.prevent="submit" class="form-horizontal">
            <div class="card-body pb-0">
              <div class="form-group row" :class="{ 'has-error': form.errors.email != null }">
                <label for="email" class="col-3 col-form-label">E-Mail Address</label>
                <div class="col-9">
                  <input id="email" type="email" class="form-control" name="email" v-model="form.email" required>
                  <small class="form-text text-danger" v-if="form.errors.email">{{ form.errors.email }}</small>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" :disabled="form.processing" class="btn btn-primary">
                Send Password Reset Link
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Layout from "@/Shared/Layout.vue";
import {useForm} from "@inertiajs/vue3";

defineOptions({
  name:   'Auth-Password-Forgot',
  layout: Layout,
});

const form = useForm({
  email: null,
});

function submit() {
  form.post(route('auth.password.sendEmail'))
}
</script>

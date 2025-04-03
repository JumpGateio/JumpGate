<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6 mt-4">
        <div class="card">
          <div class="card-header">
            <strong>Failed to activate your account</strong>
          </div>
          <div class="card-body" v-if="token != null && token.isExpired">
            Your token has expired. Please click the relevant link below to generate a new one.
            <br />
            <br />
            <div class="btn-toolbar">
              <div class="btn-group mr-2">
                <inertia-link :href="route('auth.password.reset')" class="btn btn-sm btn-primary">
                  Forgot Password
                </inertia-link>
              </div>
              <div class="btn-group">
                <inertia-link :href="route('auth.activation.resend', token.token)" class="btn btn-sm btn-primary">
                  Re-Send Activation Email
                </inertia-link>
              </div>
            </div>
          </div>
          <div class="card-body" v-else>
            Please check that you have the URL correct (same as the one in your email).
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import {defineComponent} from "vue";
  import Layout from "@/Shared/Layout.vue";

  export default defineComponent({
    name:     'Auth-Activation-Failed',

    layout: Layout,

    props: {
      pageTitle: String,
      token:     String,
    }
  })
</script>

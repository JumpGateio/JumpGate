<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6 mt-4">
        <div class="card">
          <div class="card-header">
            <strong>Your account is not activated</strong>
          </div>
          <div class="card-body" v-if="token != null">
            <inertia-link :href="route('auth.activation.resend', token.token)"
                          class="btn btn-sm btn-primary">
              Re-Send Activation Email
            </inertia-link>
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
    name:     'Auth-Activation-Inactive',

    layout: Layout,

    props: {
      pageTitle: String,
      token:     String,
    }
  })
</script>

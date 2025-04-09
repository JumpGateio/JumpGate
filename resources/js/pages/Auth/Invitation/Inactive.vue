<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6 mt-4">
        <div class="card">
          <div class="card-header">
            <strong>Your account is not activated</strong>
          </div>
          <div class="card-body pb-0" v-if="token != null">
            <inertia-link :href="route('auth.invitation.resend', token.token)"
                          class="btn btn-sm btn-primary">
              Re-Send Activation Email
            </inertia-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Layout from "@/Shared/Layout.vue";

defineOptions({
  name:   'Auth-Invitation-Inactive',
  layout: Layout,
});

const props = defineProps({
  pageTitle: String,
  token:     String,
});
</script>

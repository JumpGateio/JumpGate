<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6 mt-4">
        <div class="card">
          <div class="card-header">
            <strong>Please verify your email</strong>
          </div>
          <div class="card-body">
            An email has been sent to your account. Please follow the link in that email to activate your account.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Layout from "@/Shared/Layout.vue";

defineOptions({
  name:   'Auth-Activation-Sent',
  layout: Layout,
});

const props = defineProps({
  pageTitle: String,
});
</script>

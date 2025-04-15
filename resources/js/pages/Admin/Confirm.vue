<template>
  <div>
    <div class="row row-inside background-red text-white p-3">
      <h3>WARNING! You are about to perform a dangerous action.</h3>
    </div>
    <div class="row row-inside background-600 text-white p-5 pl-3 mb-3">
      <div class="lead text-white">{{ message }}</div>
    </div>
    <div class="btn-group w-50">
      <Link :href="cancel" class="btn btn-danger w-25">
        Cancel
      </Link>
      <Link :href="proceed" class="btn btn-primary w-25" method="post">
        Continue
      </Link>
    </div>
  </div>
</template>

<script setup>
import Admin from '@/Shared/Admin.vue'
import {Link} from "@inertiajs/vue3";

defineOptions({
  name:   'Admin-Confirm',
  layout: Admin,
});

const props = defineProps({
  message: String,
  proceed: String,
  cancel:  String,
});
</script>

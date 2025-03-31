<template>
  <Head title="Blocked" />
  <div class="container-fluid mt-5 auth">
    <div class="combo-box">
      <div class="site-image">
        <img src="https://place-hold.it/300x300" alt="Site Logo">
      </div>
      <div class="vr"></div>
      <div class="flex">
        <div class="lead pb-4 bb-300 mb-4">
          Your account has been blocked from accessing this site
        </div>
        <span>Please contact a manager or site developer for assistance.</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Layout from "@/Shared/Layout.vue";

declare const name: 'Auth-Blocked';

defineOptions({ layout: Layout })
</script>

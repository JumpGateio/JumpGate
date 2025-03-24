<template>
  <div>
    <div class="row row-inside background-red text-white p-3 text-center font-weight-bold">
      WARNING! You are about to perform a dangerous action.
    </div>
    <div class="row row-inside background-600 text-white p-5 pl-3 mb-3">
      <div class="lead text-white">{{ message }}</div>
    </div>
    <inertia-link :href="cancel" class="btn btn-danger w-25">
      Cancel
    </inertia-link>
    <inertia-link :href="proceed" class="btn btn-primary w-25" method="post">
      Continue
    </inertia-link>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'

  export default {
    name: 'Admin-Confirm',
    metaInfo: {title: 'Confirm Action'},

    layout: Admin,

    props: {
      message: String,
      proceed: String,
      cancel:  String,
    },
  }
</script>

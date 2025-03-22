<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6">
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

<script>
  export default {
    name:     'Auth-Activation-Inactive',
    metaInfo: {title: 'Inactive'},

    props: {
      pageTitle: String,
      token:     String,
    }
  }
</script>

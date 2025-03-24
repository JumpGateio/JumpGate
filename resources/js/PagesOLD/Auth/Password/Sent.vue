<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6">
        <div class="card">
          <div class="card-header">
            <strong>Password reset email sent</strong>
          </div>
          <div class="card-body">
            An email has been sent to your account.  Please follow the link in that email to reset your password.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:     'Auth-Password-Sent',
    metaInfo: {title: 'Forgot Password'},

    props: {
      pageTitle: String,
    }
  }
</script>

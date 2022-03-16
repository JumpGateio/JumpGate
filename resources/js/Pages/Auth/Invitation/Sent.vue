<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6">
        <div class="card">
          <div class="card-header">
            <strong>Have them verify their email</strong>
          </div>
          <div class="card-body pb-0">
            An email has been sent to the email you specified. Please ask them to follow the link in that email to
            activate their account.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:     'Auth-Invitation-Sent',
    metaInfo: {title: 'Invitation'},

    props: {
      pageTitle: String,
    }
  }
</script>

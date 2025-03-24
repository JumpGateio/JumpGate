<template>
  <div class="container-fluid">
    <div class="row">
      <div class="offset-lg-3 col-lg-6">
        <div class="card">
          <div class="card-header">
            <strong>Your account has been blocked from accessing this site</strong>
          </div>
          <div class="card-body">
            Please contact a manager or site developer for assistance.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:     'Auth-Blocked',
    metaInfo: {title: 'Account Blocked'},
  }
</script>

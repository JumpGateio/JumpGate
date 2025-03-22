<template>
  <div class="user-profile">
    <portal to="admin-header-buttons">
      <user-actions :user="user" btnColor="btn-dark"></user-actions>
      <inertia-link :href="route('admin.users.edit', user.id)" class="btn btn-sm btn-primary mr-2">
        Edit
      </inertia-link>
      <inertia-link :href="route('admin.users.confirm', [user.id, 'delete', 1])" class="btn btn-sm btn-danger mr-2">
        Delete
      </inertia-link>
    </portal>
    <div class="details">
      <div class="title">Details</div>
      <div class="user-data">
        <div class="d-flex flex-row w-100">
          <div class="flex-fill w-50">
            <dl class="row">
              <dt class="col-sm-4">Email</dt>
              <dd class="col-sm-8">{{ getText(user, 'email') }}</dd>
              <dt class="col-sm-4">Display Name</dt>
              <dd class="col-sm-8">{{ getText(user, 'details.display_name') }}</dd>
              <dt class="col-sm-4">Location</dt>
              <dd class="col-sm-8">{{ getText(user, 'details.location') }}</dd>
              <dt class="col-sm-4">Timezone</dt>
              <dd class="col-sm-8">{{ getText(user, 'details.timezone') }}</dd>
              <dt class="col-sm-4">URL</dt>
              <dd class="col-sm-8">{{ getText(user, 'details.url') }}</dd>
              <dt class="col-sm-4">Status</dt>
              <dd class="col-sm-8">{{ getText(user, 'status.label') }}</dd>
            </dl>
          </div>
          <div class="flex-fill w-50">
            <dl class="row">
              <dt class="col-sm-4">First Name</dt>
              <dd class="col-sm-8">{{ getText(user, 'details.first_name') }}</dd>
              <dt class="col-sm-4">Middle Name</dt>
              <dd class="col-sm-8">{{ getText(user, 'details.middle_name') }}</dd>
              <dt class="col-sm-4">Last Name</dt>
              <dd class="col-sm-8">{{ getText(user, 'details.last_name') }}</dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
    <div class="tokens">
      <div class="title">Tokens</div>
      <div class="user-data">
        <table class="table" v-if="user.tokens.length > 0">
          <thead>
            <tr>
              <th>Type</th>
              <th class="token">token</th>
              <th>Created</th>
              <th>Expires</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="token in user.tokens">
              <td>{{ token.type }}</td>
              <td class="token d-inline-block text-truncate" :title="token.token">
                {{ token.token }}
              </td>
              <td>{{ getTime(token, 'created_at') }}</td>
              <td>{{ getTime(token, 'expires_at') }}</td>
            </tr>
          </tbody>
        </table>
        <div v-if="user.tokens.length == 0" class="p-2">
          No tokens for this user.
        </div>
      </div>
    </div>
    <div class="timestamps">
      <div class="title">Timestamps</div>
      <div class="user-data">
        <dl class="row">
          <dt class="col-sm-4">Created At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'created_at') }}</dd>
          <dt class="col-sm-4">Updated At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'updated_at') }}</dd>
          <dt class="col-sm-4">Deleted At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'deleted_at') }}</dd>
        </dl>
        <dl class="row">
          <dt class="col-sm-4">Activated At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'action_timestamps.activated_at') }}</dd>
          <dt class="col-sm-4">Invited At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'action_timestamps.invited_at') }}</dd>
          <dt class="col-sm-4">Blocked At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'action_timestamps.blocked_at') }}</dd>
          <dt class="col-sm-4">Password Updated At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'action_timestamps.password_updated_at') }}</dd>
          <dt class="col-sm-4">Deleted At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'action_timestamps.deleted_at') }}</dd>
        </dl>
      </div>
    </div>
    <div class="socials">
      <div class="title">Authentication</div>
      <div class="user-data">
        <dl class="row">
          <dt class="col-sm-4">Failed Login Attempts</dt>
          <dd class="col-sm-8">{{ getText(user, 'failed_login_attempts') }}</dd>
          <dt class="col-sm-4">Authenticated At</dt>
          <dd class="col-sm-8">{{ getTime(user, 'authenticated_at') }}</dd>
          <dt class="col-sm-4">Authenticated As</dt>
          <dd class="col-sm-8">{{ getText(user, 'authenticated_as') }}</dd>
        </dl>
        <dl class="row" v-for="social in user.socials">
          <dt class="col-sm-4 capitalize">{{ social.provider }} ID</dt>
          <dd class="col-sm-8">{{ getText(social, 'social_id') }}</dd>
          <dt class="col-sm-4 capitalize">{{ social.provider }} Email</dt>
          <dd class="col-sm-8">{{ getText(social, 'email') }}</dd>
          <dt class="col-sm-4">{{ social.provider }} Expires</dt>
          <dd class="col-sm-8">{{ getText(social, 'expires_in') }}</dd>
          <dt class="col-sm-4">{{ social.provider }} Updated At</dt>
          <dd class="col-sm-8">{{ getTime(social, 'updated_at') }}</dd>
        </dl>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>

<script>
  import Admin from '@/Shared/Admin'
  import UserActions from '@/Shared/Admin/UserActions'
  import moment from 'moment'

  export default {
    name:     'User-Show',
    metaInfo: {title: 'User Details'},

    layout: Admin,

    props: {
      user: Object,
    },

    components: {
      'user-actions': UserActions,
    },

    methods: {
      getText(object, property)
      {
        let text = _.get(object, property, 'None')

        if (text == null) {
          text = 'None'
        }

        return text
      },

      getTime(object, property)
      {
        let time = _.get(object, property)

        if (time == null) {
          return 'Never'
        }

        return moment(time).format('MMM Do YYYY hh:mma')
      }
    }
  }
</script>

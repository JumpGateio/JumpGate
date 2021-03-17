<template>
  <div class="btn-toolbar float-right" role="toolbar">
    <template v-if="isTrashed">
      <inertia-link :href="route('admin.users.confirm', [user.id, 'delete', 0])" class="btn btn-sm btn-outline-danger">
        Restore
      </inertia-link>
    </template>
    <template v-else>
      <user-actions :user="user" :iconOnly="iconOnly"></user-actions>
      <div class="btn-group">
        <inertia-link :href="route('admin.users.show', [user.id])" class="btn btn-sm btn-outline-purple"
                      v-html="text.show"
        ></inertia-link>
        <inertia-link :href="route('admin.users.edit', [user.id])" class="btn btn-sm btn-outline-purple"
                      v-html="text.edit"
        ></inertia-link>
        <inertia-link :href="route('admin.users.confirm', [user.id, 'delete', 1])"
                      class="btn btn-sm btn-outline-danger"
                      v-html="text.delete"
        ></inertia-link>
      </div>
    </template>
  </div>

</template>

<script>
  import UserActions from '@/Shared/Admin/UserActions'

  export default {
    name: 'User-Toolbar',

    props: {
      user:     Object,
      iconOnly: {
        type:    Boolean,
        default: false,
      }
    },

    components: {
      'user-actions': UserActions,
    },

    computed: {
      isTrashed()
      {
        return this.user.deleted_at !== null
      },

      text()
      {
        let text = {
          show:    'Show',
          edit:    'Edit',
          delete:  'Delete',
        }

        if (this.iconOnly === true) {
          text = {
            show:    '<span class="fa fa-eye"></span>',
            edit:    '<span class="fa fa-pencil"></span>',
            delete:  '<span class="fa fa-trash"></span>',
          }
        }

        return text
      },
    },
  }
</script>

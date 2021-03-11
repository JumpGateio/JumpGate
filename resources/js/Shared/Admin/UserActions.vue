<template>
  <div class="btn-toolbar float-right" role="toolbar">
    <template v-if="isTrashed">
      <inertia-link :href="route('admin.users.confirm', [user.id, 'delete', 0])" class="btn btn-sm btn-outline-danger">
        Restore
      </inertia-link>
    </template>
    <template v-else>
      <div class="btn-group mr-2" v-if="user.admin_actions && user.admin_actions.length > 0">
        <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                v-html="text.actions"
        ></button>
        <div class="dropdown-menu dropdown-menu-right">
          <inertia-link :href="action.route" class="dropdown-item p-2" v-for="action in user.admin_actions"
                        :key="action.text">
            <span class="fa text-500" :class="action.icon"></span>&nbsp;&nbsp;{{ action.text }}
          </inertia-link>
        </div>
      </div>
      <div class="btn-group">
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
  export default {
    name: 'User-Actions',

    props: {
      user:     Object,
      iconOnly: {
        type:    Boolean,
        default: false,
      }
    },

    computed: {
      isTrashed()
      {
        return this.user.deleted_at !== null
      },

      text()
      {
        let text = {
          actions: 'Actions',
          edit:    'Edit',
          delete:  'Delete',
        }

        if (this.iconOnly === true) {
          text = {
            actions: '<span class="fa fa-cog"></span>',
            edit:    '<span class="fa fa-pencil"></span>',
            delete:  '<span class="fa fa-trash"></span>',
          }
        }

        return text
      },
    },
  }
</script>

<template>
  <div class="btn-toolbar float-right" role="toolbar">
    <template v-if="isTrashed">
      <div class="btn-group mr-2">
        <inertia-link :href="route('admin.' + area + '.confirm', [model.id, 'delete', '0'])" class="btn btn-sm btn-outline-danger">
          {{ text.restore }}
        </inertia-link>
        <inertia-link :href="route('admin.' + area + '.confirm', [model.id, 'delete', '2'])" class="btn btn-sm btn-outline-danger">
          {{ text.permDelete }}
        </inertia-link>
      </div>
    </template>
    <template v-else>
      <div class="btn-group mr-2" v-if="model.admin_actions">
        <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                v-html="text.actions"
        ></button>
        <div class="dropdown-menu dropdown-menu-right">
          <inertia-link :href="action.route" class="dropdown-item p-2" v-for="action in model.admin_actions"
                        :key="action.text">
            <span class="fa text-500" :class="action.icon"></span>&nbsp;&nbsp;{{ action.text }}
          </inertia-link>
        </div>
      </div>
      <div class="btn-group">
        <inertia-link :href="route('admin.' + area + '.edit', [model.id])" class="btn btn-sm btn-outline-purple"
                      v-html="text.edit"
        ></inertia-link>
        <inertia-link :href="route('admin.' + area + '.confirm', [model.id, 'delete', 1])"
                      class="btn btn-sm btn-outline-danger"
                      v-html="text.delete"
        ></inertia-link>
      </div>
    </template>
  </div>

</template>

<script>
  export default {
    name: 'Admin-Actions',

    props: {
      model:    Object,
      area:     String,
      iconOnly: {
        type:    Boolean,
        default: false,
      }
    },

    computed: {
      isTrashed()
      {
        return this.model.hasOwnProperty('deleted_at') && this.model.deleted_at !== null
      },

      text()
      {
        let text = {
          actions:    'Actions',
          restore:    'Restore',
          permDelete: 'Full Delete',
          edit:       'Edit',
          delete:     'Delete',
        }

        if (this.iconOnly === true) {
          text = {
            actions:    '<span class="fa fa-cog"></span>',
            restore:    '<span class="fa fa-refresh"></span>',
            permDelete: '<span class="fa fa-trash"></span>',
            edit:       '<span class="fa fa-pencil"></span>',
            delete:     '<span class="fa fa-trash"></span>',
          }
        }

        return text
      },
    },
  }
</script>

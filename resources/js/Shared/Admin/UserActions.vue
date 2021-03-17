<template>
  <div class="btn-group mr-2" v-if="user.admin_actions && user.admin_actions.length > 0">
    <button type="button" class="btn dropdown-toggle" :class="[btnSize, btnColor]"
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
</template>

<script>
  export default {
    name: 'User-Actions',

    props: {
      user:     Object,
      iconOnly: {
        type:    Boolean,
        default: false,
      },
      btnSize: {
        type:    String,
        default: 'btn-sm',
      },
      btnColor: {
        type:    String,
        default: 'btn-outline-dark',
      },
    },

    computed: {
      text()
      {
        let text = {
          actions: 'Actions',
        }

        if (this.iconOnly === true) {
          text = {
            actions: '<span class="fa fa-cog"></span>',
          }
        }

        return text
      },
    },
  }
</script>

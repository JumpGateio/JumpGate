<template>
  <div class="btn-toolbar float-right" role="toolbar">
    <template v-if="isTrashed">
      <Link :href="route('admin.users.confirm', [user.id, 'delete', 0])" class="btn btn-sm btn-outline-danger">
        Restore
      </Link>
    </template>
    <template v-else>
      <UserActions :user="user" :iconOnly="iconOnly"></UserActions>
      <div class="btn-group">
        <Link :href="route('admin.users.show', [user.id])" class="btn btn-sm btn-outline-purple"
              v-html="text.show"
        ></Link>
        <Link :href="route('admin.users.edit', [user.id])" class="btn btn-sm btn-outline-purple"
              v-html="text.edit"
        ></Link>
        <Link :href="route('admin.users.confirm', [user.id, 'delete', 1])"
              class="btn btn-sm btn-outline-danger"
              v-html="text.delete"
        ></Link>
      </div>
    </template>
  </div>

</template>

<script setup>
import UserActions from '@/Shared/Admin/UserActions.vue'
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

defineOptions({
  name: 'User-Toolbar',
});

const props = defineProps({
  user:     Object,
  iconOnly: {
    type:    Boolean,
    default: false,
  }
});

const isTrashed = computed(() => {
  return props.user.deleted_at !== null;
});

const text = computed(() => {
  let text = {
    show:   'Show',
    edit:   'Edit',
    delete: 'Delete',
  };

  if (props.iconOnly === true) {
    text = {
      show:   '<span class="fa fa-eye"></span>',
      edit:   '<span class="fa fa-pencil"></span>',
      delete: '<span class="fa fa-trash"></span>',
    };
  }

  return text;
});
</script>

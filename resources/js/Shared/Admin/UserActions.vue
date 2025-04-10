<template>
  <div class="btn-group mr-2" v-if="user.admin_actions && user.admin_actions.length > 0">
    <button type="button" class="btn dropdown-toggle" :class="[btnSize, btnColor]"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-bs-toggle="dropdown" v-html="text.actions"
    ></button>
    <div class="dropdown-menu dropdown-menu-right">
      <Link :href="action.route" class="dropdown-item p-2" v-for="action in user.admin_actions"
            :key="action.text">
        <span class="fa text-500" :class="action.icon"></span>&nbsp;&nbsp;{{ action.text }}
      </Link>
    </div>
  </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

defineOptions({
  name: 'User-Actions',
});

const props = defineProps({
  user:     Object,
  iconOnly: {
    type:    Boolean,
    default: false,
  },
  btnSize:  {
    type:    String,
    default: 'btn-sm',
  },
  btnColor: {
    type:    String,
    default: 'btn-outline',
  },
})

const text = computed(() => {
  let text = {
    actions: 'Actions',
  };

  if (props.iconOnly === true) {
    text = {
      actions: '<span class="fa fa-cog"></span>',
    };
  }

  return text;
});
</script>

<template>
  <div>
    <div class="input-group">
      <div class="input-group-prepend" v-if="hasFilters">
        <dropdown :auto-close="false" placement="bottom-start" btnClass="btn-info">
          Filters
          <template v-slot:dropdown name="dropdown">
            <slot />
          </template>
        </dropdown>
      </div>
      <input class="form-control" autocomplete="off" type="text" name="search" placeholder="Search…"
             :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" id="admin_search" />
      <button class="btn btn-sm btn-dark search-clear" type="button" @click="$emit('reset')">Reset</button>
    </div>
  </div>
</template>

<script lang="ts">
  import Dropdown from '@/Shared/Partials/Dropdown.vue'
  import {defineComponent} from "vue";

  export default defineComponent({
    name: 'Search',

    components: {
      'dropdown': Dropdown,
    },

    props: {
      maxWidth:   {
        type:    Number,
        default: 300,
      },
      modelValue: String,
    },

    emits: [
      'update:modelValue'
    ],

    computed: {
      hasFilters()
      {
        return this.$slots.default
      }
    },

    mounted() {
      $('#admin_search').focus()
    }
  })
</script>

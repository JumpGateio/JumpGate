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
             :value="value" @input="$emit('input', $event.target.value)" />
      <button class="btn btn-sm btn-dark search-clear" type="button" @click="$emit('reset')">Reset</button>
    </div>
  </div>
</template>

<script>
  import Dropdown from '@/Shared/Partials/Dropdown'

  export default {
    name: 'Search',

    components: {
      'dropdown': Dropdown,
    },

    props: {
      value:    String,
      maxWidth: {
        type:    Number,
        default: 300,
      },
    },

    computed: {
      hasFilters() {
        return this.$slots.default
      }
    }
  }
</script>

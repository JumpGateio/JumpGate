<template>
  <div>
    <div class="input-group">
      <div class="input-group-prepend" v-if="hasFilters">
        <Dropdown :auto-close="false" placement="bottom-start" btnClass="btn-info">
          Filters
          <template v-slot:dropdown name="dropdown">
            <slot/>
          </template>
        </Dropdown>
      </div>
      <input class="form-control" autocomplete="off" type="text" name="search" placeholder="Search…"
             :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" id="admin_search"/>
      <button class="btn btn-sm btn-dark search-clear" type="button" @click="$emit('reset')">Reset</button>
    </div>
  </div>
</template>

<script setup>
import Dropdown from '@/Shared/Partials/Dropdown.vue'
import {computed, onMounted} from "vue";

defineOptions({
  name: 'Search',
});

const props = defineProps({
  maxWidth:   {
    type:    Number,
    default: 300,
  },
  modelValue: String,
});

const hasFilters = computed(() => {
  return slots.default
});

onMounted(() => {
  $('#admin_search').focus()
});

const emit = defineEmits(['update:modelValue', 'reset']);
</script>

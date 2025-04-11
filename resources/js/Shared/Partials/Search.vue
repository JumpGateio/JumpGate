<template>
  <div>
    <div class="input-group">
      <div class="input-group-prepend" v-if="hasFilters">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true"
                aria-expanded="false">
          Filters
        </button>
        <div class="dropdown-menu" id="adminSearchDropdown">
          <slot></slot>
        </div>
      </div>
      <input class="form-control" autocomplete="off" type="text" name="search" placeholder="Search…"
             :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" id="admin_search"/>
      <button class="btn btn-sm btn-dark search-clear" type="button" @click="$emit('reset')">Reset</button>
    </div>
  </div>
</template>

<script setup>
import {computed, onMounted, useSlots } from "vue";

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

const slots = useSlots();

const hasFilters = computed(() => {
  return slots.default
});

onMounted(() => {
  document.getElementById('admin_search').focus();
});

const emit = defineEmits(['update:modelValue', 'reset']);
</script>

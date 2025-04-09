<template>
  <div>
    <slot></slot>
    <Pagination class="ml-2" :data="page.props.searchResults" :show-disabled="true"
                @pagination-change-page="getResults"></Pagination>
  </div>
</template>

<script setup>
import Pagination from 'laravel-vue-pagination'
import {usePage} from "@inertiajs/vue3";
import {watch} from "vue";

defineOptions({
  name: 'Admin-Search',
});

const page = usePage();
const props = defineProps({
  url: String,
});

watch('page.props.search', (newValue, oldValue) => {
  _.throttle(function () {
    getResults()
  }, 500);
}, {
  deep:      true,
  immediate: true,
});

function getResults(page = 1) {
  let query = {}

  if (page.props.search != null) {
    query = {term: page.props.search}
  }

  axios.get(route(props.url, query) + '?page=' + page)
    .then((response) => {
      page.props.searchResults = response.data.data
    })
}
</script>

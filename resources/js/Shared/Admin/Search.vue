<template>
  <div>
    <slot></slot>
    <pagination class="ml-2" :data="$page.searchResults" :show-disabled="true" @pagination-change-page="getResults"></pagination>
  </div>
</template>

<script>
  import Pagination from 'laravel-vue-pagination'

  export default {
    name: 'Admin-Search',

    components: {
      'pagination': Pagination,
    },

    props: {
      url: String,
    },

    watch: {
      '$page.search': {
        handler:   _.throttle(function () {
          this.getResults()
        }, 500),
        deep:      true,
        immediate: true,
      },
    },

    methods: {
      getResults(page = 1)
      {
        let query = {}

        if (this.$page.search != null) {
          query = {term: this.$page.search}
        }

        axios.get(this.route(this.url, query) + '?page=' + page)
             .then((response) => {
               this.$page.searchResults = response.data
             })
      }
    }
  }
</script>

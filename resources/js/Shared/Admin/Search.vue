<template>
  <div>
    <slot></slot>
    <pagination class="ml-2" :data="$page.props.searchResults" :show-disabled="true"
                @pagination-change-page="getResults"></pagination>
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
      '$page.props.search': {
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

        if (this.$page.props.search != null) {
          query = {term: this.$page.props.search}
        }

        axios.get(this.route(this.url, query) + '?page=' + page)
             .then((response) => {
               this.$page.props.searchResults = response.data.data
             })
      }
    }
  }
</script>

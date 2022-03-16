<template>
  <div class="tiles">
    <user-index :users="tiles.users.data" :count="tiles.users.count" v-if="hasTile('users')"></user-index>
    <div class="tile-group" v-else>
      <div class="loading-bars">
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'
  import UserIndex from '@/Pages/Admin/Index/User'

  export default {
    name: 'Admin-Index',

    layout: (h, page) => h(Admin, {props: {title: 'Admin Dashboard'}}, [page]),

    components: {
      'admin':      Admin,
      'user-index': UserIndex,
    },

    props: {
      routes: Object,
    },

    data()
    {
      return {
        tiles: {},
      }
    },

    mounted()
    {
      _.forEach(this.routes, (route, title) => {
        this.getData(route, title)
      })
    },

    methods: {
      getData(route, title)
      {
        axios.get(route)
             .then((response) => {
               this.$set(this.tiles, title, response.data.message)
             })
      },

      hasTile(name)
      {
        return this.tiles.hasOwnProperty(name)
      }
    },
  }
</script>

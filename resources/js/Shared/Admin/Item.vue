<template>
  <inertia-link :href="item.url" class="nav-link" :class="{ active:  item.active }">
    {{ fullName }}
  </inertia-link>

</template>

<script>
    export default {
        name: 'Admin-Menu-Item',

      props: {
        item: Object,
      },

      computed: {
          fullName()
          {
            if (this.item.reporting == true) {
              return this.item.name + ' (' + this.$page.unreadReports + ')'
            }

            return this.item.name
          }
      }
    }
</script>

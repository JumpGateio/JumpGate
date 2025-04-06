<template>
  <div class="tiles">
    <!--    <user-index :users="tiles.users.data" :count="tiles.users.count" v-if="hasTile('users')"></user-index>-->
    <div class="tile-group">
      <div class="loading-bars">
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Admin from '@/Shared/Admin.vue';
import {onMounted, ref} from "vue";
// import UserIndex from '@/Pages/Admin/Index/User.vue'

const name = 'Admin-Index';

defineOptions({layout: Admin})

const props = defineProps({
  routes: Object
})

const tiles = ref({});

onMounted(() => {
  Echo.channel(`testing`)
    .listen('TestBroadcasting', (e) => {
      console.log('got event');
      console.log(e);
    });
  _.forEach(props.routes, (route, title) => {
    getData(route, title)
  })
});

function getData(route, title) {
  axios.get(route)
    .then((response) => {
      tiles[title] = response.data.message
    })
}

function hasTile(name) {
  return tiles.hasOwnProperty(name)
}
</script>

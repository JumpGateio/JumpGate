<template>
  <div class="tiles">
    <UserIndex :users="tiles.users.data" :count="tiles.users.count" v-if="hasTile('users')"></UserIndex>
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
import {onMounted, reactive} from "vue";
import UserIndex from '@/pages/Admin/Index/User.vue'

defineOptions({
  name:   'Admin-Index',
  layout: Admin,
});

const props = defineProps({
  routes: Object
});

const tiles = reactive({});

onMounted(() => {
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

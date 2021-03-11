<template>
  <div>
    <div class="row row-inside background-red text-white p-3 text-center font-weight-bold">
      WARNING! You are about to perform a dangerous action.
    </div>
    <div class="row row-inside background-600 text-white p-5 pl-3 mb-3">
      <div class="lead text-white">{{ message }}</div>
    </div>
    <inertia-link :href="cancel" class="btn btn-danger w-25">
      Cancel
    </inertia-link>
    <div @click="performAction()" class="btn btn-primary w-25">Continue</div>
  </div>
</template>

<script>
  import Admin from '@/Shared/Admin'

  export default {
    name: 'Admin-Confirm',

    layout: (h, page) => h(Admin, {props: {title: 'Confirm Action'}}, [page]),

    props: {
      message: String,
      proceed: String,
      cancel:  String,
    },

    methods: {
      performAction()
      {
        axios.post(this.proceed)
             .then((message) => {
               this.$inertia.replace(this.cancel)
                   .then(() => this.bootbox('success', message.data))
             })
             .catch((error) => {
               this.bootbox('danger', error.response.data)
             })
      }
    }
  }
</script>

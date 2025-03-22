<template>
  <div v-if="shouldDisplay">
    <div class="mode-bar">
      <div class="test-level">{{ display }}</div>
      <div class="description">
        This game is still under development. Use the light bulb to the right to let us know any bugs you found or
        suggestions you have
      </div>
      <div class="interact interact-create">
        <i class="fa fa-fw fa-lightbulb-exclamation" data-toggle="modal"
           data-target="#feedback-modal"></i>
      </div>
      <div class="interact interact-list">
        <inertia-link :href="route('feedback.index')">
          <i class="fa fa-fw fa-list"></i>&nbsp;({{ $page.unreadReports }})
        </inertia-link>
      </div>
    </div>
    <div class="modal modal-xl comic-modal feedback-modal" id="feedback-modal" tabindex="-1" role="dialog"
         aria-labelledby="feedback-modal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Feedback form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="type">Type</label>
              <select id="type" v-model="form.type" class="form-control">
                <option value="bug">Bug</option>
                <option value="suggestion">Suggestion</option>
              </select>
            </div>
            <div class="form-group">
              <label for="title">Title</label>
              <input id="title" type="text" class="form-control" v-model="form.title">
              <small id="titleHelpBlock" class="form-text text-muted">
                A simple title to track the image by
              </small>
            </div>
            <div class="form-group">
              <label for="details">Details</label>
              <textarea id="details" cols="30" rows="10" v-model="form.details" class="form-control"></textarea>
              <small id="detailsHelpBlock" class="form-text text-muted">
                Give us as much details as you can on the bug you found or the suggestion you have.
              </small>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm action-btn positive" @click.prevent="submitFeedback()">
              Submit Feedback
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>

<script>
  export default {
    name: 'TestMode-Bar',

    data()
    {
      return {
        form: {
          type:    'bug',
          title:   null,
          route:   null,
          details: null,
        }
      }
    },

    computed: {
      shouldDisplay()
      {
        return this.$page.testMode != null
      },

      display()
      {
        return _.startCase(this.$page.testMode)
      },
    },

    methods: {
      submitFeedback()
      {
        this.form.route = window.location

        axios.post(this.route('feedback.store'), this.form)
             .then((response) => {
               this.form.type    = 'bug'
               this.form.title   = null
               this.form.details = null
               this.form.route   = null

               $('#feedback-modal').modal('hide')

               this.bootbox('success', response.data.message)
             })
             .catch((error) => {
               this.bootbox('danger', error.response.data.message)
             })
      }
    }
  }
</script>

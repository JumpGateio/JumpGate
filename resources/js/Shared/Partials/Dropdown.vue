<template>
  <div class="dropdown" @click="show = !show">
    <button class="btn" :class="btnClass" type="button" id="dropdownMenuButton"
            aria-haspopup="true" aria-expanded="false">
      <slot />
    </button>
    <div v-if="show">
      <div class="screen" @click="hideDropdown()" />
      <div class="dropdown-menu" ref="dropdown" @click.stop="show = autoClose ? false : true">
        <slot name="dropdown" />
      </div>
    </div>
  </div>
</template>

<script>
  import Popper from 'popper.js'

  export default {
    props: {
      btnClass:  {
        type:    String,
        default: 'btn-light',
      },
      placement: {
        type:    String,
        default: 'bottom-end',
      },
      boundary:  {
        type:    String,
        default: 'scrollParent',
      },
      autoClose: {
        type:    Boolean,
        default: true,
      },
    },
    data()
    {
      return {
        show: false,
      }
    },

    watch: {
      show(show)
      {
        if (show) {
          this.$nextTick(() => {
            $('.dropdown-menu').addClass('show')
            this.popper = new Popper(this.$el, this.$refs.dropdown, {
              placement: this.placement,
              modifiers: {
                preventOverflow: {boundariesElement: this.boundary},
              },
            })
          })
        } else if (this.popper) {
          $('.dropdown-menu').removeClass('show')
          setTimeout(() => this.popper.destroy(), 100)
        }
      },
    },
    mounted()
    {
      document.addEventListener('keydown', e => {
        if (e.keyCode === 27) {
          this.show = false
        }
      })
    },

    methods: {
      hideDropdown()
      {
        this.$nextTick(() => {
          this.show = false
        })
      }
    }
  }
</script>

<template>
  <div class="dropdown" @click="show = !show">
    <button class="btn" :class="btnClass" type="button" id="dropdownMenuButton"
            aria-haspopup="true" aria-expanded="false">
      <slot/>
    </button>
    <div v-if="show">
      <div class="screen" @click="hideDropdown()"/>
      <div class="dropdown-menu" ref="dropdown" @click.stop="show = autoClose ? false : true">
        <slot name="dropdown"/>
      </div>
    </div>
  </div>
</template>

<script setup>
import {createPopper} from "@popperjs/core";
import {watch, onMounted, reactive} from "vue";

defineOptions({
  name: 'DropDown',
});

const props = defineProps({
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
});

const show = reactive(false);
const popper = reactive(null);

watch(show, (newValue, oldValue) => {
  if (newValue) {
    this.$nextTick(() => {
      $('.dropdown-menu').addClass('show')
      popper = createPopper(el, refs.dropdown, {
        placement: props.placement,
        modifiers: {
          preventOverflow: {boundariesElement: props.boundary},
        },
      })
    })
  } else if (popper) {
    $('.dropdown-menu').removeClass('show')
    setTimeout(() => popper.destroy(), 100)
  }
});

onMounted(() => {
  document.addEventListener('keydown', e => {
    if (e.keyCode === 27) {
      show = false
    }
  })
});

function hideDropdown() {
  nextTick(() => {
    show = false
  })
}
</script>

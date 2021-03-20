// Required packages
require('./bootstrap')

import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import MomentVue from 'vue-moment'
import {App, plugin} from '@inertiajs/inertia-vue'
import {InertiaProgress} from '@inertiajs/progress/src'
import route from 'ziggy-js'

import {closable} from '@/directives/closable'
import Pluralize from '@/filters/pluralize'
import Capitalize from '@/filters/capitalize'
import Offset from '@/filters/offset'
import Limit from '@/filters/limit'
import {bootbox} from '@/mixins/bootbox'
import Layout from '@/Shared/Layout'

Vue.config.productionTip = false
// Plugins
Vue.use(plugin)
Vue.use(PortalVue)
Vue.use(MomentVue)
Vue.use(VueMeta)

// Mixins
Vue.mixin(bootbox)

// Directives
Vue.directive('closable', closable)

// Filters
Vue.filter('pluralize', Pluralize)
Vue.filter('capitalize', Capitalize)
Vue.filter('limit', Limit)
Vue.filter('offset', Offset)

InertiaProgress.init()

// Handle routes
const response = await fetch('/api/ziggy')
const Ziggy = await response.json()

Vue.mixin({
  methods: {
    route: (name, params, absolute) => route(name, params, absolute, Ziggy),
  },
});

// Initialize Vue
const el = document.getElementById('app')

new Vue({
  metaInfo: {
    titleTemplate: title => (title ? `${title} - JumpGate` : 'JumpGate'),
  },
  render:   h => h(App, {
    props: {
      initialPage:      JSON.parse(el.dataset.page),
      resolveComponent: name => import(`@/Pages/${name}`)
        .then(({default: page}) => {
          if (page.layout === undefined) {
            page.layout = Layout
          }
          return page
        }),
    },
  })
}).$mount(el)

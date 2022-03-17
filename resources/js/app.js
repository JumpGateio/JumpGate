// Required packages
require('./bootstrap')

import {createApp, h} from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress/src'
import Portal from 'vue3-portal'
import route from 'ziggy-js'

import {closable} from '@/directives/closable'
import Pluralize from '@/filters/pluralize'
import Capitalize from '@/filters/capitalize'
import Offset from '@/filters/offset'
import Limit from '@/filters/limit'
import {bootbox} from '@/mixins/bootbox'
import Layout from '@/Shared/Layout'

InertiaProgress.init()

// Handle routes
const response = await fetch('/api/ziggy')
const Ziggy    = await response.json()

// Initialize Vue
const el = document.getElementById('app')

createInertiaApp({
  title:   title => (title ? `${title} - JumpGate` : 'JumpGate'),
  resolve: name => import(`./Pages/${name}`)
    .then(({default: page}) => {
      if (page.layout === undefined) {
        page.layout = Layout
      }
      return page
    }),
  setup({el, App, props, plugin})
  {
    const app = createApp({render: () => h(App, props)})
      .use(plugin)

    app.config.productionTip = false

    app.config.warnHandler = (msg, instance, trace) => {
      // `trace` is the component hierarchy trace
      if (msg == 'Non-function value encountered for default slot. Prefer function slots for better performance.') {
        return false
      }
    }

    // Filters
    app.config.globalProperties.filters = {
      pluralize:  Pluralize,
      capitalize: Capitalize,
      limit:      Limit,
      offset:     Offset,
    }

    app.use(Portal)

    // Plugins

    // Mixins
    app.mixin(bootbox)

    // Directives
    app.directive('closable', closable)

    // Components
    app.component('inertia-head', Head)
    app.component('inertia-link', Link)

    app.mixin({
      methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
      },
    })

    app.mount(el)
  },
})

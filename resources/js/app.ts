import './bootstrap'
import '../css/app.css'

import 'primeicons/primeicons.css'

import 'primevue/resources/themes/aura-light-blue/theme.css'

import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import PrimeVue from 'primevue/config'
import ToastService from 'primevue/toastservice'
import DataTable from 'primevue/datatable'
import Button from 'primevue/button'
import Tooltip from 'primevue/tooltip'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./Pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(PrimeVue)
      .use(ToastService)
      .component('DataTable', DataTable)
      .component('Button', Button)
      .directive('tooltip', Tooltip)
      .mount(el)
  },
  progress: {
    color: '#4B5563'
  }
})
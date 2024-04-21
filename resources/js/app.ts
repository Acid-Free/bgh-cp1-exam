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
import ConfirmationService from 'primevue/confirmationservice'
import DataTable from 'primevue/datatable'
import Button from 'primevue/button'
import Tooltip from 'primevue/tooltip'
import Dialog from 'primevue/dialog'
import { createPinia } from 'pinia'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

const pinia = createPinia()

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
      .use(pinia)
      .use(PrimeVue)
      .use(ToastService)
      .use(ConfirmationService)
      .component('DataTable', DataTable)
      .component('Button', Button)
      .component('Dialog', Dialog)
      .directive('tooltip', Tooltip)
      .mount(el)
  },
  progress: {
    color: '#4B5563'
  }
})

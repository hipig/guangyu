require('./bootstrap')
import { createApp } from 'vue'
import store from '@/store'
import router from '@/router'

import lazy from "@/directives/lazy"

const app = createApp()
app.use(store)
  .use(router)
  .use(lazy)
  .mount('#app')

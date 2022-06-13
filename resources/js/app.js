require('./bootstrap')
import { createApp } from 'vue'
import store from '@/store'
import router from '@/router'

const app = createApp()
app.use(store).use(router).mount('#app')

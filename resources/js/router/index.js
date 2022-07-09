import { createRouter, createWebHistory } from "vue-router"
import routes from './routes'

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach(before)
router.afterEach(after)

export default router

function before(to, from, next) {
  if (to.meta && to.meta.title) {
    document.title = to.meta.title
  }
  next()
}

function after() {
  //
}

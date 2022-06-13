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
  //
  next()
}

function after() {
  //
}

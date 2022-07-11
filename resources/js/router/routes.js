import BlankLayout from "@/layout/BlankLayout"

function view (view) {
  return () => import(/* webpackChunkName: '' */ `@/views/${view}.vue`).then(m => m.default || m)
}

const Goods = view('store/Index')
const GoodsDetail = view('store/Detail')
const Evaluator = view('evaluator/Index')

export default [
  {
    path: '',
    name: 'main',
    component: BlankLayout,
    redirect: '/store',
    children: [
      {
        path: '/store',
        name: 'goods',
        component: Goods
      },
      {
        path: '/store/detail',
        name: 'store.detail',
        component: GoodsDetail
      },
      {
        path: '/evaluator',
        name: 'evaluator',
        component: Evaluator,
        meta: {
          title: "糖花光遇淘宝店铺官方指定估价器"
        }
      },
    ]
  }
]

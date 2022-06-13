import service from '@/utils/request'
import { sprintf } from '@/utils/util'

const api = {
  goods: '/goods',
  goodsAttributes: '/goods-attributes',
  goodsShow: '/goods/%s',
}

export const getGoods = (params) => service({
  url: api.goods,
  method: 'get',
  params: params
})

export const getGoodsAttributes = () => service({
  url: api.goodsAttributes,
  method: 'get'
})

export const getGoodsShow = (id) => service({
  url: sprintf(api.goodsShow, id),
  method: 'get'
})

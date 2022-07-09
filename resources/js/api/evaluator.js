import service from '@/utils/request'

const api = {
  evaluatorAttributes: '/evaluator-attributes',
  evaluatorRecords: '/evaluator-records',
}

export const getEvaluatorAttributes = () => service({
  url: api.evaluatorAttributes,
  method: 'get'
})

export const storeEvaluatorRecords = (data) => service({
  url: api.evaluatorRecords,
  method: 'post',
  data: data
})

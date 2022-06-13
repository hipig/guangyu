import axios from 'axios'

// 创建 axios 实例
const service = axios.create({
  baseURL: window.config.api_url,
  timeout: 6000
})

service.interceptors.response.use((response) => {
  return response.data
}, (error) => {
  const response = error.response

  switch (response.status) {
    case 401:
      console.log('尚未登录，请您先登录！')
      break;
    case 403:
      console.log('您的权限不足，拒绝访问！')
      break;
    case 422:
      console.log(Object.values(response.data.errors)[0][0])
      break;
    case 429:
      console.log('重复访问次数过多！')
      break;
    case 400:
    case 500:
      console.log(response.data.message || '请求出现错误或服务器异常，请稍后再试！')
      break;
  }
  return Promise.reject(response)
})

export default service

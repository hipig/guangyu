<template>
  <ul class="flex items-center space-x-2" v-if="pages > 0">
    <li>
      <button @click="prev" class="py-1 px-3 border rounded" :class="[localPage === 1 ? 'bg-orange-400 border-orange-400 bg-opacity-50 text-white cursor-not-allowed' : 'bg-orange-600 border-orange-600 text-white cursor-pointer']" :disabled="localPage === 1">上一页</button>
    </li>
    <li v-if="showPrevMore">
      <span class="block py-1 px-3 text-gray-500">...</span>
    </li>
    <li v-for="pager in pagers" @click="go(pager)">
      <span class="block py-1 px-3 border rounded" :class="[localPage === pager ? 'bg-orange-600 text-white border-orange-600' : 'border-gray-300 cursor-pointer']">{{ pager }}</span>
    </li>
    <li v-if="showNextMore">
      <span class="block py-1 px-3 text-gray-500">...</span>
    </li>
    <li>
      <button @click="next" class="py-1 px-3 border rounded" :class="[localPage === pages ? 'bg-orange-400 border-orange-400 bg-opacity-50 text-white cursor-not-allowed' : 'bg-orange-600 border-orange-600 text-white cursor-pointer']" :disabled="localPage === pages">下一页</button>
    </li>
  </ul>
</template>

<script>
export default {
  name: "pageination",
  props: {
    perPages : {
      type : Number,
      default : 5
    },
    page: {
      type: Number,
      default: 1
    },
    pageSize: {
      type: Number,
      default: 20
    },
    total: {
      type: Number,
      default: 0
    },
  },
  data () {
    return {
      localPage: this.page || 1,
      localPageSize: this.pageSize || 20,
      localTotal: this.total || 0,
      showPrevMore: false,
      showNextMore: false
    }
  },
  computed : {
    pages(){
      return Math.ceil(this.localTotal / this.localPageSize)
    },
    pagers () {
      const array = []
      const perPages = this.perPages
      const pageCount = this.pages
      let current = this.localPage
      const _offset = (perPages - 1) / 2


      const offset = {
        start : current - _offset,
        end   : current + _offset
      }

      //-1, 3
      if (offset.start < 1) {
        offset.end = offset.end + (1 - offset.start)
        offset.start = 1
      }
      if (offset.end > pageCount) {
        offset.start = offset.start - (offset.end - pageCount)
        offset.end = pageCount
      }
      if (offset.start < 1) offset.start = 1

      this.showPrevMore = (offset.start > 1)
      this.showNextMore = (offset.end < pageCount)

      for (let i = offset.start; i <= offset.end; i++) {
        array.push(i)
      }

      return array
    }
  },
  watch: {
    page(val) {
      this.localPage = val || 1
    },
    pageSize(val) {
      this.localPageSize = val || 20
    },
    total(val) {
      this.localTotal = val || 0
    }
  },
  methods : {
    prev(){
      if (this.localPage > 1) {
        this.go(this.localPage - 1)
      }
    },
    next(){
      if (this.localPage < this.pages) {
        this.go(this.localPage + 1)
      }
    },
    go (page) {
      if (this.localPage !== page) {
        this.localPage = page
        //父组件通过change方法来接受当前的页码
        this.$emit('change', this.localPage)
      }
    }
  }
}
</script>

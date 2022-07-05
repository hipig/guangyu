<template>
  <div>
    <div class="py-3 text-center bg-orange-600"><a href="/" class="text-xl text-white">选号商城</a></div>
    <div class="space-y-4">
      <div class="sticky top-0 w-full bg-white shadow-sm z-10">
        <div class="px-3 relative">
          <div class="grid grid-cols-4">
            <div class="flex justify-center cursor-pointer" v-for="(label, key) in stateList" :key="key" @click="handleToggleState(key)">
              <div class="flex items-center space-x-0.5 py-3" :class="stateStore[key] ? 'font-semibold' : ''">
                <span>{{ label }}</span>
                <svg v-if="stateStore[key]" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
          </div>
          <!--    排序    -->
          <transition
            enter-from-class="transform -translate-y-6 opacity-0"
            enter-active-class="transition ease-out duration-300"
            enter-to-class="transform translate-y-0 opacity-100"
            leave-from-class="transform translate-y-0 opacity-100"
            leave-active-class="transition ease-in duration-100 bg-transparent"
            leave-to-class="transform -translate-y-6 opacity-0"
          >
            <div class="absolute top-full inset-x-0 bg-white shadow-md" v-show="stateStore.sort">
              <div class="pb-2">
                <div class="flex flex-col text-base">
                  <div class="px-3 py-2 cursor-pointer" :class="(filters.sort_type || 0) == key ? 'text-orange-500' : ''" v-for="(label, key) in sortList" :key="key" @click="handleSort(key)">{{ label }}</div>
                </div>
              </div>
            </div>
          </transition>
          <!--     区服     -->
          <transition
            enter-from-class="transform -translate-y-6 opacity-0"
            enter-active-class="transition ease-out duration-300"
            enter-to-class="transform translate-y-0 opacity-100"
            leave-from-class="transform translate-y-0 opacity-100"
            leave-active-class="transition ease-in duration-100 bg-transparent"
            leave-to-class="transform -translate-y-6 opacity-0"
          >
            <div class="absolute top-full inset-x-0 bg-white shadow-sm" v-show="stateStore.platform">
              <div class="px-3 space-y-3">
                <div class="py-1">
                  <div class="flex flex-col space-y-4">
                    <div class="space-y-1" v-for="(attribute, key) in baseAttributeList" :key="key">
                      <div class="text-sm text-gray-500">{{ attribute.name }}</div>
                      <div class="grid grid-cols-3 gap-3">
                        <div class="py-1.5 text-center text-sm rounded-full cursor-pointer" :class="filters[key] == value ? 'bg-orange-100 text-orange-600' : 'bg-gray-200'" v-for="(label, value) in attribute.items" :key="value" @click="handleSelectBase(key, value)">{{ label }}</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="py-3">
                  <div class="grid grid-cols-2 gap-5 text-base">
                    <div class="bg-gray-200 py-2.5 text-center rounded cursor-pointer" @click="resetBaseAttribute">重置</div>
                    <div class="bg-orange-600 text-white py-2.5 text-center rounded cursor-pointer" @click="submitBaseAttribute">完成</div>
                  </div>
                </div>
              </div>
            </div>
          </transition>
          <!--     价格     -->
          <transition
            enter-from-class="transform -translate-y-6 opacity-0"
            enter-active-class="transition ease-out duration-300"
            enter-to-class="transform translate-y-0 opacity-100"
            leave-from-class="transform translate-y-0 opacity-100"
            leave-active-class="transition ease-in duration-100 bg-transparent"
            leave-to-class="transform -translate-y-6 opacity-0"
          >
            <div class="absolute top-full inset-x-0 bg-white shadow-md" v-show="stateStore.price">
              <div class="px-3 space-y-3">
                <div class="py-1">
                  <div class="flex flex-col space-y-5">
                    <div class="space-y-1" v-for="(attribute, key) in priceAttributeList" :key="key">
                      <div class="text-sm text-gray-500">{{ attribute.name }}</div>
                      <div class="grid grid-cols-3 gap-3">
                        <div class="py-1.5 text-center text-sm rounded-full cursor-pointer" :class="filters[key] == value ? 'bg-orange-100 text-orange-600' : 'bg-gray-200'" v-for="(label, value) in attribute.items" :key="value" @click="handleSelectPrice(key, value)">{{ label }}</div>
                      </div>
                    </div>
                    <label class="inline-flex items-center space-x-2">
                      <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-offset-0 focus:ring-orange-200 focus:ring-opacity-50" v-model="filters.is_special">
                      <span>是否有折扣</span>
                    </label>
                  </div>
                </div>
                <div class="py-3">
                  <div class="grid grid-cols-2 gap-5 text-base">
                    <div class="bg-gray-200 py-2.5 text-center rounded cursor-pointer" @click="resetPriceAttribute">重置</div>
                    <div class="bg-orange-600 text-white py-2.5 text-center rounded cursor-pointer" @click="submitPriceAttribute">完成</div>
                  </div>
                </div>
              </div>
            </div>
          </transition>
          <!--     筛选     -->
          <transition
            enter-from-class="transform -translate-y-6 opacity-0"
            enter-active-class="transition ease-out duration-300"
            enter-to-class="transform translate-y-0 opacity-100"
            leave-from-class="transform translate-y-0 opacity-100"
            leave-active-class="transition ease-in duration-100 bg-transparent"
            leave-to-class="transform -translate-y-6 opacity-0"
          >
            <div class="absolute top-full inset-x-0 bg-white shadow-md" v-show="stateStore.filter">
              <div class="px-3 space-y-3">
                <div class="py-1 max-h-[30rem] overflow-y-scroll">
                  <div class="flex flex-col space-y-4">
                    <div class="space-y-1" v-for="(attribute, key) in mainAttributeList" :key="key">
                      <div class="text-sm text-gray-500">{{ attribute.name }}</div>
                      <div class="grid grid-cols-3 gap-3">
                        <div class="py-1.5 text-center text-sm rounded cursor-pointer" :class="filters[key] && filters[key].indexOf(String(item.id)) > -1 ? 'bg-orange-100 text-orange-600' : 'bg-gray-200'" v-for="(item, index) in attribute.items" :key="index" @click="handleSelectMain(key, String(item.id))">{{ item.value }}</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="py-3">
                  <div class="grid grid-cols-2 gap-5 text-base">
                    <div class="bg-gray-200 py-2.5 text-center rounded cursor-pointer" @click="resetMainAttribute">重置</div>
                    <div class="bg-orange-600 text-white py-2.5 text-center rounded cursor-pointer" @click="submitMainAttribute">完成</div>
                  </div>
                </div>
              </div>
            </div>
          </transition>
        </div>
      </div>
      <div>
        <div class="grid grid-cols-2 gap-x-4 gap-y-6 px-4" v-if="total > 0">
          <div class="bg-white rounded-md shadow p-3 cursor-pointer" v-for="item in goodsList" :key="item.id" @click="handleDetail(item.id)">
            <div class="space-y-1">
              <h3 class="text-xl text-center">{{ item.no }}</h3>
              <div class="space-y-2">
                <div class="relative w-full pb-[100%]">
                  <div class="absolute inset-0 bg-gray-200">
                    <img class="w-full" v-lazy="item.cover_url" :alt="item.no">
                  </div>
                </div>
                <p class="text-lg text-orange-500">￥{{ item.fixed_price }}</p>
              </div>
            </div>
          </div>
        </div>
        <div v-if="total === 0 && loading === true" class="py-10 text-center text-gray-500">没有数据哦~</div>
      </div>
      <div class="pt-4 pb-10">
        <div class="flex justify-center">
          <pageination :page="currentPage" :page-size="pageSize" :total="total" @change="changePage"></pageination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {getGoods, getGoodsAttributes} from "@/api/store"
import Pageination from "@/components/Pageination"

export default {
  name: "goods",
  components: {
    Pageination
  },
  data () {
    return {
      filters: {
        platform: "",
        account_type: "",
        maps: [],
        seasons: [],
        gift_bags: [],
        hot_items: [],
        height: [],
        price_range: "",
        is_special:false,
        sort_type: 0
      },
      stateList : {
        sort: "排序",
        platform: "区服",
        price: "价格",
        filter: "筛选"
      },
      stateStore: {
        sort: false,
        platform: false,
        price: false,
        filter: false
      },
      goodsList: [],
      sortList: {
        0: "默认排序",
        1: "最新上架",
        2: "最早上架",
        3: "价格从低到高",
        4: "价格从高到低"
      },
      priceAttributeList: {
        price_range: {
          name: "价格",
          items: {
            1: "1000以下",
            2: "1001-2000",
            3: "2001-3000",
            4: "3001-5000",
            5: "5000以上"
          }
        }
      },
      baseAttributeList: {},
      mainAttributeList: {},
      pageSize: 20,
      currentPage: 1,
      total: 0,
      loading: false
    }
  },
  created() {
    this.getGoodsAttributeList()

    this.filters = {...this.$route.query}
    this.currentPage = parseInt(this.$route.query.page || 1)
    this.getGoodsList()
  },
  methods: {
    setFilter({key ,value}) {
      this.filters[key] = value
    },
    getGoodsList() {
      let filters = this.filters
      filters.page = this.currentPage

      getGoods(filters)
        .then(res => {
          this.goodsList = res.data
          this.total = res.meta.total
          this.loading = true
        })
    },
    getGoodsAttributeList() {
      getGoodsAttributes()
        .then(res => {
          this.baseAttributeList = res.base
          this.mainAttributeList = res.main
        })
    },
    refreshUrl(page = 1) {
      let filters = this.filters
      filters.page = page

      let router = this.$router.resolve({ path: '/store', query: {...filters} })
      window.location = router.href
    },
    handleToggleState(state) {
      _.forEach(this.stateStore, (_, key) => {
        this.stateStore[key] = key !== state ? false : !this.stateStore[key]
      })
    },
    handleCloseState() {
      _.forEach(this.stateStore, (_, key) => {
        this.stateStore[key] = false
      })
    },
    handleSort(key) {
      console.log(key)
      this.setFilter({key: 'sort_type', value: key})
      this.handleCloseState()
      this.refreshUrl()
    },
    handleSelectBase(key, value) {
      this.setFilter({key, value})
    },
    handleSelectPrice(key, value) {
      this.setFilter({key, value})
    },
    handleSelectMain(key, value) {
      let data = _.isArray(this.filters[key] || []) ? (this.filters[key] || []) : this.filters[key].split(" ")

      let index = _.indexOf(data, value)
      if (index > -1) {
        data.splice(index, 1)
      } else {
        data.push(value)
      }
      this.setFilter({key, value: data})
    },
    handleDetail(id) {
      this.$router.push({ path: '/store/detail', query: { id } })
    },
    resetBaseAttribute() {
      _.forEach(this.baseAttributeList, (_, key) => {
        this.setFilter({key, value: ""})
      })
    },
    submitBaseAttribute() {
      this.handleCloseState()
      this.refreshUrl()
    },
    resetPriceAttribute() {
      _.forEach(this.priceAttributeList, (_, key) => {
        this.setFilter({key, value: ""})
      })
      this.setFilter({key: 'is_special', value: false})
    },
    submitPriceAttribute() {
      this.handleCloseState()
      this.refreshUrl()
    },
    resetMainAttribute() {
      _.forEach(this.mainAttributeList, (_, key) => {
        this.setFilter({key, value: []})
      })
    },
    submitMainAttribute() {
      this.handleCloseState()
      this.refreshUrl()
    },
    changePage(page) {
      this.currentPage = page
      this.refreshUrl(this.currentPage)
    }
  }
}
</script>

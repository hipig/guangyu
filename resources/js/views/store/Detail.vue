<template>
  <div>
    <div class="fixed bottom-6 left-6">
      <button class="flex items-center justify-center w-10 h-10 bg-gray-900 bg-opacity-80 text-white rounded-full shadow" @click="$router.back()">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
    </div>
    <div class="space-y-2">
      <div class="bg-[#3d4667] text-gray-50 text-lg py-6 space-y-4" :style="{backgroundImage: 'url(' +mainBg+ ')'}">
        <div class="flex justify-between px-10 text-2xl">
          <h3>{{ goods.platform_text }}{{ goods.account_type_text }}</h3>
          <span>编号 {{ goods.no }}</span>
        </div>
        <div class="space-y-4">
          <div class="flex items-center">
            <div class="grow h-px bg-yellow-400"></div>
            <div class="px-6 text-center text-yellow-400">基础信息</div>
            <div class="grow h-px bg-yellow-400"></div>
          </div>
          <div class="grid grid-cols-2 gap-x-3 gap-y-1 px-6">
            <span>蜡烛数量：{{ goods.candle_count }}</span>
            <span>翼数量：{{ goods.wing_count }}</span>
            <span>爱心数量：{{ goods.love_count }}</span>
            <span v-if="goods.progress_name">{{ goods.progress_name }}进度：{{ goods.progress_value }}%</span>
          </div>
        </div>
        <div class="space-y-4">
          <div class="flex items-center">
            <div class="grow h-px bg-yellow-400"></div>
            <div class="px-6 text-center text-yellow-400">主要信息</div>
            <div class="grow h-px bg-yellow-400"></div>
          </div>
          <div class="px-6 space-y-2">
            <div>
              <span class="flex-shrink-0 text-[#df6311]">已毕业地图：</span>
              <span>{{ goods.maps_text }}</span>
            </div>
            <div>
              <span class="flex-shrink-0 text-[#df6311]">已毕业季节：</span>
              <span>{{ goods.seasons_text }}</span>
            </div>
            <div>
              <span class="flex-shrink-0 text-[#df6311]">稀有礼包：</span>
              <span class="text-yellow-200">{{ goods.gift_bags_text }}</span>
            </div>
            <div>
              <span class="flex-shrink-0 text-[#df6311]">热门物品：</span>
              <span class="text-yellow-200">{{ goods.hot_items_text }}</span>
            </div>
            <div v-if="goods.height > 0">
              <span class="flex-shrink-0 text-[#df6311]">身高：</span>
              <span class="text-yellow-200">{{ goods.height_text }}</span>
            </div>
          </div>
        </div>
        <div class="space-y-2" v-if="goods.description">
          <div class="flex items-center">
            <div class="grow h-px bg-yellow-400"></div>
            <div class="px-6 text-center text-yellow-400">其他亮点</div>
            <div class="grow h-px bg-yellow-400"></div>
          </div>
          <div class="px-6">{{ goods.description }}</div>
        </div>
      </div>
      <div class="flex flex-col space-y-px">
        <simple-gallery gallery-id="detail" :images="goods.screenshot_images_url"></simple-gallery>
      </div>
    </div>
  </div>
</template>

<script>
import SimpleGallery from "@/components/SimpleGallery";
import { getGoodsShow } from "@/api/store"

export default {
  name: "goodsDetail",
  components: {
    SimpleGallery
  },
  data () {
    return {
      id: 0,
      mainBg: window.config.main_bg || "",
      goods: {}
    }
  },
  created() {
    this.id = this.$route.query.id
    this.getGoodsDetail()
  },
  methods: {
    getGoodsDetail() {
      getGoodsShow(this.id)
        .then(res => {
          this.goods = res
        })
    }
  }
}
</script>

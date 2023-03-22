<template>
  <div class="bg-gray-50 min-h-screen relative">
    <div class="py-3 text-center bg-orange-600"><a href="https://item.taobao.com/item.htm?spm=a230r.1.14.22.3ad64608WHoABB&id=676077614556&ns=1&abbucket=14#detail" class="text-xl text-white" target="_blank">三级头店铺官方指定估价器</a></div>
    <div class="space-y-5 pt-8 pb-20 px-6">
      <div class="space-y-1" v-for="attribute in attributeList" :key="attribute.id">
        <div class="text-sm font-semibold">{{ attribute.label }}</div>
        <template v-if="attribute.type === 'radio'">
          <div class="grid grid-cols-3 gap-3">
            <div class="py-1.5 text-center text-sm rounded-full cursor-pointer" :class="form[attribute.key] && form[attribute.key] == option.key ? 'bg-orange-100 text-orange-600' : 'bg-gray-200'" v-for="option in attribute.options" :key="option.key" @click="handleSingleSelect(attribute.key, option.key)">{{ option.label }}</div>
          </div>
        </template>
        <template v-if="attribute.type === 'checkbox'">
          <div class="grid grid-cols-3 gap-3">
            <div class="py-1.5 text-center text-sm rounded cursor-pointer"  :class="form[attribute.key] && form[attribute.key].indexOf(option.key) > -1 ? 'bg-orange-100 text-orange-600' : 'bg-gray-200'" v-for="option in attribute.options" :key="option.key" @click="handleMultipleSelect(attribute.key, option.key)">{{ option.label }}</div>
          </div>
        </template>
        <template v-if="attribute.type === 'input'">
          <input type="text" v-model="form[attribute.key]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50" placeholder="">
        </template>
        <template v-if="attribute.type === 'textarea'">
          <textarea v-model="form[attribute.key]" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50" placeholder=""></textarea>
        </template>
      </div>
    </div>
    <div class="fixed bottom-0 left-0 right-0">
      <div class="max-w-2xl mx-auto py-3 px-6">
        <button class="block w-full bg-orange-600 text-white py-2.5 text-center rounded-md cursor-pointer hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" @click="submit">开始估价</button>
      </div>
    </div>

    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <transition
        enter-from-class="opacity-0"
        enter-active-class="ease-out duration-300"
        enter-to-class="opacity-100"
        leave-from-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-to-class="opacity-0"
      >
        <div v-show="resultShow" class="z-20 fixed inset-0 overflow-y-auto flex items-end sm:items-center overflow-x-hidden bg-gray-900 bg-opacity-75 p-4 lg:p-6">
          <transition
            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-active-class="ease-out duration-300"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-active-class="ease-in duration-200"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <div v-show="resultShow" class="relative flex flex-col rounded-md shadow-sm bg-white overflow-hidden w-full max-w-lg mx-auto">
              <div class="py-3 px-5 grow w-full flex items-center justify-between">
                <h3 class="text-lg">估价内容</h3>
                <button
                  type="button"
                  class="inline-flex justify-center items-center space-x-2 border font-semibold focus:outline-none px-2 py-1 leading-5 text-sm rounded border-transparent text-gray-600 hover:text-gray-400 focus:ring focus:ring-gray-500 focus:ring-opacity-25 active:text-gray-600"
                  @click="resultShow = false"
                >
                  <svg class="hi-solid hi-x inline-block w-5 h-5 -mx-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </button>
              </div>
              <div class="py-2 px-5 grow w-full">
                <div class="space-y-1">
                  <textarea v-model="result" rows="5" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50" placeholder=""></textarea>
                  <div class="py-2">
                    <button :data-clipboard-text="result" class="copy-result block w-full bg-orange-600 text-white py-2.5 text-center rounded-md cursor-pointer hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" @click="copy">复制结果</button>
                  </div>
                </div>
              </div>
            </div>
          </transition>
        </div>
      </transition>
    </div>
    <transition
      enter-from-class="transform -translate-y-6 opacity-0"
      enter-active-class="transition ease-out duration-300"
      enter-to-class="transform translate-y-0 opacity-100"
      leave-from-class="transform translate-y-0 opacity-100"
      leave-active-class="transition ease-in duration-100 bg-transparent"
      leave-to-class="transform -translate-y-6 opacity-0"
    >
      <div v-show="messageShow" class="z-50 fixed top-0 inset-x-0 py-1.5 px-3 text-center text-white" :class="[messageType === 'success' ? 'bg-green-500' : 'bg-red-500']">{{ messageText }}</div>
    </transition>
  </div>
</template>

<script>
import {getEvaluatorAttributes, storeEvaluatorRecords} from "@/api/evaluator"
import Clipboard from "clipboard"

export default {
  name: "evaluator",
  components: {
    Clipboard
  },
  data () {
    return {
      attributeList: [],
      form: {},
      result: "",
      resultShow: false,
      messageShow: false,
      messageText: '',
      messageType: '',
    }
  },
  created() {
    this.getEvaluatorAttributeList()
  },
  methods: {
    getEvaluatorAttributeList() {
      getEvaluatorAttributes()
        .then(res => {
          this.attributeList = res
        })
    },
    submit() {
      storeEvaluatorRecords({content: this.form})
        .then(res => {
          this.result = res.content_result
          this.resultShow = true
        })
    },
    handleSingleSelect(key, value) {
      this.form[key] = value
    },
    handleMultipleSelect(key, value) {
      let data = this.form[key] || []

      let index = _.indexOf(data, value)
      if (index > -1) {
        data.splice(index, 1)
      } else {
        data.push(value)
      }

      this.form[key] = data
    },
    copy() {

      let clipboard = new Clipboard(".copy-result")
      clipboard.on('success', _ => {
        this.resultShow = false
        this.showMessage('复制成功', 'success')
        clipboard.destroy()
      })
      clipboard.on('error', _ => {
        this.showMessage('复制失败，请手动复制', 'error')
        clipboard.destroy()
      })
    },
    showMessage(text, type) {
      this.messageText = text
      this.messageType = type
      this.messageShow = true

      setTimeout(() => {
        this.messageShow = false
      }, 2000)
    },
    closeResultDialog() {
      this.resultShow = false
    }
  }
}
</script>

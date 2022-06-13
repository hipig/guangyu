const isServer= typeof window ==='undefined'
const nodeList = new Map();
let startClick = null;

if(!isServer){
  document.addEventListener('mousedown', e =>{ startClick = e })
  document.addEventListener('mouseup', e =>{
    for( const { documentHandler } of nodeList.values()){
      //  将⿏标按下、松开的返回值传给 documentHandler 函数
      documentHandler(e, startClick )
    }
  })
}

function createDocumentHandler(el, binding) {
  let excludes = [];
  if (Array.isArray(binding.arg)) {
    excludes = binding.arg
  } else {
    excludes.push(binding.arg)
  }
  return function (mouseup, mousedown) {
    // 获取实例
    const popperRef = binding.instance.popperRef
    const mouseUpTarget = mouseup.target
    const mouseDownTarget = mousedown?.target
    const isBound = !binding || !binding.instance
    const isTargetExists = !mouseUpTarget || !mouseDownTarget
    const isContainedByEl = el.contains(mouseUpTarget) || el.contains(mouseDownTarget)
    const isSelf = el === mouseUpTarget
    const isTargetExcluded = (excludes.length && excludes.some(item => item?.contains(mouseUpTarget))) ||
      (excludes.length && excludes.includes(mouseDownTarget))
    const isContainedByPopper = (popperRef && (popperRef.contains(mouseUpTarget) || popperRef.contains(mouseDownTarget)))
    if (
      isBound ||  // 边缘
      isTargetExists ||   // 对象不存在
      isContainedByEl ||  // 对象被包含在实例中
      isSelf ||           // 对象是实例本⾝
      isTargetExcluded ||
      isContainedByPopper
    ) {
      return
    }
    // 点击了外部，执⾏绑定函数
    binding.value()
  }
}

const ClickOutside ={
  // 当指令第⼀次绑定到元素并且挂载⽗元素之前调⽤
  beforeMount(el, binding){
    nodeList.set(el, {
      documentHandler: createDocumentHandler(el, binding),
      bindingFn: binding.value()
    })
  },
  // 在包含组件的 VNode 及其⼦组件的VNode更新后调⽤
  updated(el, binding){
    nodeList.set(el, {
      documentHandler: createDocumentHandler(el, binding),
      bindingFn: binding.value()
    })
  },
  // 当指令与元素接触绑定并且⽗组件已卸载时，只调⽤⼀次
  unmounted(el){
    nodeList.delete(el)
  }
}
export default ClickOutside

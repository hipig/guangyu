
const defineDirective = (app) => {
  app.directive('lazy', {
    mounted(el, binding) {
      let io = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          let lazyImage = entry.target
          if (entry.intersectionRatio > 0) {
            lazyImage.src = binding.value
            io.unobserve(lazyImage)
          }
        })
      })
      io.observe(el)
    }
  })
}

export default {
  install(app) {
    defineDirective(app)
  }
}

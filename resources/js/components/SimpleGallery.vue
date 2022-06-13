<template>
  <div :id="galleryId">
    <a
      v-for="(image, index) in images"
      :key="index"
      :href="image.src"
      target="_blank"
      :data-pswp-width="image.width"
      :data-pswp-height="image.height"
      rel="noreferrer"
    >
      <img :src="image.src" alt="" />
    </a>
  </div>
</template>

<script>
import PhotoSwipeLightbox from 'photoswipe/lightbox'
import 'photoswipe/style.css'

export default {
  name: "simpleGallery",
  props: {
    galleryId: String,
    images: Array,
  },
  data () {
    return {
      lightbox: null
    }
  },
  mounted() {
    if (!this.lightbox) {
      this.lightbox = new PhotoSwipeLightbox({
        gallery: '#' + this.galleryId,
        children: 'a',
        pswpModule: () => import('photoswipe'),
      });
      this.lightbox.init();
    }
  },
  unmounted() {
    if (this.lightbox) {
      this.lightbox.destroy();
      this.lightbox = null;
    }
  },
}
</script>

<script setup lang="ts">
import { onMounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const heroImage = ref('')

onMounted(() => {
  heroImage.value = props.themeUri
    ? `${props.themeUri}/src/assets/images/hero/light-hero3.png`
    : ''
  requestAnimationFrame(() => {
    isVisible.value = true
  })
})
</script>

<template>
  <section class="relative min-h-[100vh] overflow-hidden bg-gray-950">
    <!-- Image Side -->
    <div
      class="absolute inset-0 md:left-[45%] transition-all duration-1200 ease-out"
      :class="isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-110'"
    >
      <img
        v-if="heroImage"
        :src="heroImage"
        alt=""
        class="w-full h-full object-cover"
      >
      <div class="absolute inset-0 bg-gradient-to-r from-gray-950 via-gray-950/80 to-transparent" />
    </div>

    <!-- Diagonal Overlay -->
    <div class="absolute inset-0 hero-diagonal-clip bg-gray-950 md:block hidden" />

    <!-- Content Side -->
    <div class="relative z-10 min-h-[100vh] flex items-center">
      <div
        class="px-8 md:px-16 lg:px-24 max-w-2xl transition-all duration-1000 delay-300 ease-out"
        :class="isVisible ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'"
      >
        <div class="inline-block px-4 py-1.5 rounded-full border border-sky-400/30 bg-sky-400/10 text-sky-400 text-sm font-500 mb-6">
          Vue 3 + WordPress
        </div>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-800 text-white leading-[1.1] mb-6">
          <span class="block">モダンな</span>
          <span class="block text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-500">
            {{ siteName || 'Cielos' }}
          </span>
          <span class="block">テーマ</span>
        </h1>
        <p class="text-lg text-gray-400 mb-8 leading-relaxed max-w-lg">
          {{ tagline || '次世代のWordPressテーマで、あなたのサイトを一新しましょう。Vue.jsの力でインタラクティブな体験を。' }}
        </p>
        <div class="flex flex-wrap gap-4">
          <a
            href="#"
            class="group inline-flex items-center gap-2 px-7 py-3.5 bg-sky-500 text-white rounded-lg font-600 hover:bg-sky-400 transition-all duration-300"
          >
            はじめる
            <span class="i-carbon-arrow-right transition-transform group-hover:translate-x-1" aria-hidden="true" />
          </a>
          <a
            href="#"
            class="inline-flex items-center gap-2 px-7 py-3.5 border border-gray-700 text-gray-300 rounded-lg font-600 hover:border-gray-500 hover:text-white transition-all duration-300"
          >
            <span class="i-carbon-play-outline" aria-hidden="true" />
            デモを見る
          </a>
        </div>

        <!-- Stats -->
        <div class="flex gap-8 mt-12 pt-8 border-t border-gray-800">
          <div>
            <div class="text-2xl font-700 text-white">100+</div>
            <div class="text-sm text-gray-500">コンポーネント</div>
          </div>
          <div>
            <div class="text-2xl font-700 text-white">50K+</div>
            <div class="text-sm text-gray-500">ダウンロード</div>
          </div>
          <div>
            <div class="text-2xl font-700 text-white">4.9</div>
            <div class="text-sm text-gray-500">評価</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero-diagonal-clip {
  clip-path: polygon(0 0, 55% 0, 40% 100%, 0 100%);
}
</style>

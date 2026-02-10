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
    ? `${props.themeUri}/src/assets/images/hero/dark-hero3.png`
    : ''
  setTimeout(() => {
    isVisible.value = true
  }, 300)
})
</script>

<template>
  <section class="relative min-h-[100vh] bg-black overflow-hidden flex flex-col">
    <!-- Letterbox Top -->
    <div class="h-[12vh] md:h-[15vh] bg-black relative z-20 flex items-end px-8 md:px-16 pb-4">
      <div
        class="flex items-center justify-between w-full transition-all duration-1000 ease-out"
        :class="isVisible ? 'opacity-100' : 'opacity-0'"
      >
        <span class="text-white/30 text-xs tracking-[0.3em] uppercase">WordPress Theme</span>
        <span class="text-white/30 text-xs tracking-wider">2025</span>
      </div>
    </div>

    <!-- Main Image Area -->
    <div class="relative flex-1">
      <!-- Background Image with Slow Zoom -->
      <div
        class="absolute inset-0 transition-all duration-[3000ms] ease-out"
        :class="isVisible ? 'scale-100' : 'scale-110'"
      >
        <img
          v-if="heroImage"
          :src="heroImage"
          alt=""
          class="w-full h-full object-cover"
        >
        <!-- Vignette -->
        <div class="absolute inset-0 shadow-[inset_0_0_150px_rgba(0,0,0,0.8)]" />
        <!-- Color Grade -->
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/50 opacity-60" />
      </div>

      <!-- Content Overlay -->
      <div class="relative z-10 h-full flex items-end px-8 md:px-16 pb-8">
        <div
          class="max-w-3xl transition-all duration-1500 delay-500 ease-out"
          :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <h1 class="text-6xl md:text-8xl lg:text-9xl font-900 text-white leading-none mb-4 tracking-tight">
            {{ siteName || 'Cielos' }}
          </h1>
          <p class="text-lg md:text-xl text-white/60 max-w-xl leading-relaxed font-300">
            {{ tagline || '映画のような没入感を、ウェブに。シネマティックなビジュアルで訪問者を魅了する。' }}
          </p>

          <!-- Bottom Bar -->
          <div class="flex items-center gap-8 mt-8">
            <a
              href="#"
              class="group flex items-center gap-3 text-white font-500"
            >
              <span class="w-12 h-12 rounded-full border-2 border-white/30 flex items-center justify-center group-hover:bg-white/10 transition-all duration-300">
                <span class="i-carbon-play-filled-alt text-lg" aria-hidden="true" />
              </span>
              プレビューを再生
            </a>
            <div class="hidden md:block w-px h-8 bg-white/20" />
            <a
              href="#"
              class="hidden md:inline-flex items-center gap-2 text-white/50 hover:text-white transition-colors font-400"
            >
              詳細を見る
              <span class="i-carbon-arrow-right text-sm" aria-hidden="true" />
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Letterbox Bottom -->
    <div class="h-[12vh] md:h-[15vh] bg-black relative z-20 flex items-start px-8 md:px-16 pt-4">
      <div
        class="flex items-center justify-between w-full transition-all duration-1000 delay-700 ease-out"
        :class="isVisible ? 'opacity-100' : 'opacity-0'"
      >
        <div class="flex gap-4">
          <span class="text-white/20 text-xs">Vue.js</span>
          <span class="text-white/20 text-xs">UnoCSS</span>
          <span class="text-white/20 text-xs">Vite</span>
        </div>
        <a href="#" class="text-white/30 text-xs hover:text-white/60 transition-colors">
          ダウンロード →
        </a>
      </div>
    </div>
  </section>
</template>

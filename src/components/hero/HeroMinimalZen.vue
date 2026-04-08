<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const isDark = ref(false)
let themeObserver: MutationObserver | null = null

const sunImage = computed(() => {
  if (!props.themeUri) {
    return ''
  }

  const file = isDark.value ? 'hero-sun-dark.png' : 'hero-sun-light.png'
  return `${props.themeUri}/src/assets/images/${file}`
})

onMounted(() => {
  const root = document.documentElement
  const syncTheme = () => {
    isDark.value = root.classList.contains('dark')
  }

  syncTheme()
  themeObserver = new MutationObserver(syncTheme)
  themeObserver.observe(root, { attributes: true, attributeFilter: ['class'] })

  requestAnimationFrame(() => {
    isVisible.value = true
  })
})

onUnmounted(() => {
  if (themeObserver) {
    themeObserver.disconnect()
    themeObserver = null
  }
})
</script>

<template>
  <section class="hero-surface-soft relative min-h-[100vh] bg-[#faf9f6] dark:bg-[#23364d] overflow-hidden flex items-center" aria-label="Minimal Zen Hero">
    <!-- Subtle Texture -->
    <div class="absolute inset-0 opacity-[0.015] hero-noise" />

    <!-- Decorative Circle -->
    <div
      class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[60vmin] h-[60vmin] rounded-full border border-gray-200 dark:border-gray-800 transition-all duration-2000 ease-out"
      :class="isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-90'"
    />
    <div
      class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[50vmin] h-[50vmin] rounded-full border border-gray-200/50 dark:border-gray-800/50 transition-all duration-2000 delay-200 ease-out"
      :class="isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-90'"
    />

    <!-- Sun Icon -->
    <div
      class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[65%] w-24 h-24 md:w-32 md:h-32 transition-all duration-1500 delay-500 ease-out"
      :class="isVisible ? 'opacity-60 translate-y-[-65%]' : 'opacity-0 translate-y-[-55%]'"
    >
      <img
        v-if="sunImage"
        :src="sunImage"
        alt=""
        class="w-full h-full object-contain"
      >
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-4xl mx-auto px-6 text-center">
      <div
        class="transition-all duration-1200 delay-300 ease-out"
        :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
      >
        <!-- Japanese Vertical Accent -->
        <p class="text-sm tracking-[0.5em] text-gray-400 dark:text-gray-300 mb-12 font-300">
          空 の テ ー マ
        </p>

        <h1 class="hero-minimal-zen-title text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-200 text-gray-800 dark:text-gray-200 leading-none mb-8 tracking-tight">
          {{ siteName || 'Cielos' }}
        </h1>

        <div class="w-16 h-px bg-gray-300 dark:bg-gray-700 mx-auto mb-8" />

        <p class="hero-minimal-zen-tagline text-lg md:text-xl text-gray-500 dark:text-gray-200 max-w-lg mx-auto mb-12 leading-relaxed font-300">
          {{ tagline || '余白が語る、静寂のデザイン。必要なものだけを、美しく配置する。' }}
        </p>

        <div class="hero-cta-row justify-center">
          <a
            href="https://github.com/annrie/cielos"
            target="_blank"
            rel="noopener"
            class="hero-cta-primary"
          >
            ダウンロード
            <span class="i-carbon-download" aria-hidden="true" />
          </a>
          <a
            href="/hero-showcase/"
            class="hero-cta-secondary"
          >
            デモを見る
            <span class="i-carbon-arrow-right" aria-hidden="true" />
          </a>
        </div>
      </div>
    </div>

    <!-- Bottom Accent -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2">
      <div class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-700" />
      <div class="w-1 h-1 rounded-full bg-gray-400 dark:bg-gray-600" />
      <div class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-700" />
    </div>
  </section>
</template>

<style scoped>
.hero-noise {
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}

.hero-minimal-zen-title {
  font-family: 'Lobster', cursive;
}

@media (max-width: 639.98px) {
  .hero-minimal-zen-tagline {
    margin-top: 4rem;
  }
}
</style>

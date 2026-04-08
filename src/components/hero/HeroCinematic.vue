<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const isDark = ref(false)
const currentYear = new Date().getFullYear()
let themeObserver: MutationObserver | null = null

const heroImage = computed(() => {
  if (!props.themeUri) {
    return ''
  }
  const file = isDark.value ? 'dark-hero3.png' : 'light-hero4.png'
  return `${props.themeUri}/src/assets/images/hero/${file}`
})

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
  <section class="hero-surface-soft relative min-h-[100vh] bg-slate-100 dark:bg-black overflow-hidden flex flex-col" aria-label="Cinematic Hero">
    <!-- Letterbox Top -->
    <div class="h-[9vh] md:h-[12vh] bg-white/80 dark:bg-black relative z-20 flex items-end px-5 md:px-16 pb-3 md:pb-4 border-b border-slate-200/70 dark:border-black/0 backdrop-blur-sm">
      <div
        class="flex items-center justify-between w-full transition-all duration-1000 ease-out"
        :class="isVisible ? 'opacity-100' : 'opacity-0'"
      >
        <span class="text-slate-600 dark:text-white/30 text-xs tracking-[0.3em] uppercase">WordPress Theme</span>
        <span class="text-slate-500 dark:text-white/30 text-xs tracking-wider">{{ currentYear }}</span>
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
          :style="{ objectPosition: isDark ? '72% 78%' : '50% 50%' }"
        >
        <!-- Vignette -->
        <div class="absolute inset-0 shadow-[inset_0_0_120px_rgba(15,23,42,0.55)] dark:shadow-[inset_0_0_150px_rgba(0,0,0,0.8)]" />
        <!-- Color Grade -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/75 via-transparent to-slate-900/45 dark:from-black dark:to-black/50 opacity-60" />
      </div>

      <!-- Content Overlay -->
      <div class="relative z-10 h-full flex items-center justify-center px-5 md:px-16 py-6 md:py-8">
        <div
          class="hero-cinematic-content max-w-2xl w-full text-center transition-all duration-1500 delay-500 ease-out"
          :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <h1 class="text-6xl md:text-8xl lg:text-9xl font-900 text-slate-900 dark:text-white leading-none mb-4 tracking-tight">
            <span class="hero-cinematic-site-row">
              <img
                v-if="sunImage"
                :src="sunImage"
                alt=""
                class="hero-cinematic-site-row__sun"
              >
              <span class="hero-cinematic-site-row__logo">
                {{ siteName || 'Cielos' }}
              </span>
            </span>
          </h1>
          <p class="text-base sm:text-lg md:text-xl text-slate-800 dark:text-white/70 max-w-xl md:max-w-none mx-auto leading-relaxed font-300 md:whitespace-nowrap">
            {{ tagline || '映画のような没入感を、ウェブに。シネマティックなビジュアルで訪問者を魅了する。' }}
          </p>

          <!-- Bottom Bar -->
          <div class="flex items-center justify-center gap-6 sm:gap-8 mt-8">
            <a
              href="https://github.com/annrie/cielos"
              target="_blank"
              rel="noopener"
              class="group flex items-center gap-3 text-slate-900 dark:text-white font-500"
            >
              <span class="w-12 h-12 rounded-full border-2 border-slate-700/40 dark:border-white/30 flex items-center justify-center group-hover:bg-slate-900/8 dark:group-hover:bg-white/10 transition-all duration-300">
                <span class="i-carbon-download text-lg" aria-hidden="true" />
              </span>
              ダウンロード
            </a>
            <div class="hidden md:block w-px h-8 bg-white/20" />
            <a
              href="/hero-showcase/"
              class="hidden md:inline-flex items-center gap-2 text-slate-700 dark:text-white/50 hover:text-slate-900 dark:hover:text-white transition-colors font-400"
            >
              デモを見る
              <span class="i-carbon-arrow-right text-sm" aria-hidden="true" />
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Letterbox Bottom -->
    <div class="h-[9vh] md:h-[12vh] bg-white/80 dark:bg-black relative z-20 flex items-start px-5 md:px-16 pt-3 md:pt-4 border-t border-slate-200/70 dark:border-black/0 backdrop-blur-sm">
      <div
        class="flex items-center justify-between w-full transition-all duration-1000 delay-700 ease-out"
        :class="isVisible ? 'opacity-100' : 'opacity-0'"
      >
        <div class="flex gap-4">
          <span class="text-slate-500 dark:text-white/20 text-xs">Vue.js</span>
          <span class="text-slate-500 dark:text-white/20 text-xs">UnoCSS</span>
          <span class="text-slate-500 dark:text-white/20 text-xs">Vite</span>
        </div>
        <a href="/hero-showcase/" class="text-slate-600 dark:text-white/30 text-xs hover:text-slate-900 dark:hover:text-white/60 transition-colors">
          デモを見る →
        </a>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero-cinematic-site-row {
  position: relative;
  display: inline-block;
  padding: 0.08em 0.12em;
}

.hero-cinematic-site-row__sun {
  position: absolute;
  left: 56%;
  top: 50%;
  width: 1.8em;
  height: 1.8em;
  transform: translate(-50%, -50%);
  object-fit: contain;
  pointer-events: none;
  z-index: 0;
}

.hero-cinematic-site-row__logo {
  position: relative;
  z-index: 1;
  display: inline-block;
  font-family: 'Lobster', cursive;
  font-size: 1.2em;
  letter-spacing: 0.02em;
  color: #f8fafc;
  text-shadow:
    0 2px 12px rgba(56, 189, 248, 0.34),
    0 0 18px rgba(59, 130, 246, 0.3);
}

:global(html.dark) .hero-cinematic-site-row__logo {
  color: #f8fafc;
  text-shadow:
    0 2px 14px rgba(2, 6, 23, 0.35),
    0 0 20px rgba(56, 189, 248, 0.34),
    0 0 28px rgba(59, 130, 246, 0.22);
}

:global(.hero-cinematic-content) {
  width: 100%;
}

@media (max-width: 639.98px) {
  .hero-cinematic-content {
    margin-top: 5rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  * {
    transition-duration: 0ms !important;
    animation: none !important;
  }
}
</style>

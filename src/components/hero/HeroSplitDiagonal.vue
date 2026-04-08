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

const heroImage = computed(() => {
  if (!props.themeUri) {
    return ''
  }
  const file = isDark.value ? 'dark-hero3.png' : 'light-hero3.png'
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
  <section class="relative min-h-[100vh] overflow-hidden" aria-label="Split Diagonal Hero">
    <!-- Image Side -->
    <div
      class="absolute inset-0 md:left-[58%] transition-all duration-1200 ease-out"
      :class="isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-110'"
    >
      <img
        v-if="heroImage"
        :src="heroImage"
        alt=""
        class="hero-split-hero-image w-full h-full object-cover"
      >
      <div class="absolute inset-0 bg-gradient-to-r from-white/96 via-white/76 via-42% to-transparent dark:from-slate-950/90 dark:via-slate-900/62 dark:to-slate-900/8" />
    </div>

    <!-- Desktop only: diagonal notch overlay -->
    <div class="absolute inset-0 hero-diagonal-clip bg-white dark:bg-slate-900 hidden md:block" />

    <!-- Content Side -->
    <div class="relative z-10 min-h-[100vh] flex items-center">
      <div
        class="w-full md:w-[66.666%] px-8 md:px-16 lg:px-24 max-w-none text-center md:text-left transition-all duration-1000 delay-300 ease-out"
        :class="isVisible ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'"
      >
        <div class="hero-split-badge px-3.5 md:px-4 py-1.5 rounded-full border border-sky-400/35 bg-sky-400/10 text-sky-600 dark:text-sky-400 text-xs md:text-sm leading-none font-500 mb-6">
          Vue 3 + WordPress
        </div>
        <h1 class="inline-block md:block font-800 text-gray-900 dark:text-slate-50 leading-[1.05] mb-6 hero-split-readability">
          <span class="block w-fit text-[clamp(2.4rem,4.6vw,4.8rem)]">モダンな</span>
          <span class="hero-split-site-row block w-fit mt-2 md:mt-4 ml-10 md:ml-24">
            <img
              v-if="sunImage"
              :src="sunImage"
              alt=""
              class="hero-split-site-row__sun"
            >
            <span class="hero-split-site-row__logo">
              {{ siteName || 'Cielos' }}
            </span>
          </span>
          <span class="block w-fit mt-4 md:mt-6 ml-20 md:ml-40 text-[clamp(2.6rem,5.1vw,5.3rem)]">テーマ</span>
        </h1>
        <p class="text-base md:text-lg text-gray-700 dark:text-slate-100 mb-8 leading-relaxed max-w-none whitespace-nowrap hero-split-readability">
          {{ tagline || '次世代のWordPressテーマで、あなたのサイトを一新しましょう。Vue.jsの力でインタラクティブな体験を。' }}
        </p>
        <div class="hero-cta-row">
          <a
            href="https://github.com/annrie/cielos"
            target="_blank"
            rel="noopener"
            class="hero-cta-primary"
          >
            ダウンロード
            <span class="i-carbon-arrow-right" aria-hidden="true" />
          </a>
          <a
            href="/hero-showcase/"
            class="hero-cta-secondary hero-cta-secondary--inverse"
          >
            <span class="i-carbon-play-outline" aria-hidden="true" />
            デモを見る
          </a>
        </div>

        <!-- Stats -->
        <div class="flex flex-nowrap justify-between gap-4 md:gap-8 mt-12 pt-8 border-t border-gray-200 dark:border-slate-500/40 hero-split-readability">
          <div class="flex-1 min-w-0">
            <div
              class="font-700 text-gray-900 dark:text-slate-50 whitespace-nowrap leading-none"
              style="font-size: clamp(1.8rem, 2.6vw, 2.8rem);"
            >
              設計済み
            </div>
            <div class="text-sm text-gray-500 dark:text-slate-100 whitespace-nowrap">デザイントークン</div>
          </div>
          <div class="flex-1 min-w-0">
            <div
              class="font-700 text-gray-900 dark:text-slate-50 whitespace-nowrap leading-none"
              style="font-size: clamp(1.8rem, 2.6vw, 2.8rem);"
            >
              高速
            </div>
            <div class="text-sm text-gray-500 dark:text-slate-100 whitespace-nowrap">Vite + UnoCSS</div>
          </div>
          <div class="flex-1 min-w-0">
            <div
              class="font-700 text-gray-900 dark:text-slate-50 whitespace-nowrap leading-none"
              style="font-size: clamp(1.8rem, 2.6vw, 2.8rem);"
            >
              安全
            </div>
            <div class="text-sm text-gray-500 dark:text-slate-100 whitespace-nowrap">型付き実装</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>

.hero-diagonal-clip {
  clip-path: polygon(0 0, 64% 0, 50% 100%, 0 100%);
}

@media (prefers-reduced-motion: reduce) {
  .hero-diagonal-clip {
    clip-path: none;
  }
}

.hero-split-hero-image {
  /* mobile only: shift image left (show more right side subjects) */
  object-position: 72% center;
}

@media (min-width: 768px) {
  .hero-split-hero-image {
    object-position: center center;
  }
}

.hero-split-readability {
  text-shadow: 0 2px 8px rgba(2, 6, 23, 0.28);
}

.hero-split-site-row {
  position: relative;
  padding: 0.25em 0.18em;
}

.hero-split-site-row__sun {
  position: absolute;
  left: 50%;
  top: 50%;
  width: clamp(7rem, 16vw, 12rem);
  height: clamp(7rem, 16vw, 12rem);
  transform: translate(-50%, -50%);
  object-fit: contain;
  pointer-events: none;
  z-index: 0;
}

.hero-split-site-row__logo {
  position: relative;
  z-index: 1;
  display: inline-block;
  font-family: "Lobster", cursive;
  font-size: clamp(3.8rem, 7vw, 7.4rem);
  line-height: 0.95;
  letter-spacing: 0.02em;
  background: linear-gradient(90deg, #38bdf8 0%, #3b82f6 100%);
  background-clip: text;
  -webkit-background-clip: text;
  color: transparent;
  -webkit-text-fill-color: transparent;
  text-shadow: none;
}

.hero-split-badge {
  display: block;
  width: -moz-fit-content;
  width: fit-content;
  white-space: nowrap;
  margin-inline: auto;
}

@media (min-width: 768px) {
  .hero-split-badge {
    margin-inline: 0;
  }
}

:global(html.dark) .hero-split-site-row__logo {
  background: none;
  color: #fff;
  -webkit-text-fill-color: currentColor;
  text-shadow:
    0 2px 14px rgba(2, 6, 23, 0.35),
    0 0 22px rgba(56, 189, 248, 0.35);
}
</style>

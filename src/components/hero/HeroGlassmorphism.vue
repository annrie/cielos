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

  const file = isDark.value ? 'dark-hero3.png' : 'light-hero-4.png'
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

const features = [
  { icon: 'i-carbon-code', title: 'Vue 3対応', desc: 'Composition APIとTypeScriptで型安全' },
  { icon: 'i-carbon-paint-brush', title: 'UnoCSS + LiftKit', desc: '設計済みトークンで一貫したUIを高速構築' },
  { icon: 'i-carbon-lightning', title: '超高速', desc: 'Viteビルドで瞬時のHMR' },
]
</script>

<template>
  <section class="hero-surface-soft relative min-h-[100vh] overflow-hidden flex items-center justify-center" aria-label="Glassmorphism Hero">
    <!-- Background Image -->
    <div class="absolute inset-0">
      <img
        v-if="heroImage"
        :src="heroImage"
        alt=""
        class="hero-glassmorphism-image w-full h-full object-cover"
      >
      <div class="absolute inset-0 bg-white/25 dark:bg-slate-900/25 backdrop-blur-sm" />
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-6xl mx-auto px-5 md:px-6 py-14 md:py-20">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <!-- Left: Text -->
        <div
          class="hero-glass-panel--featured p-6 md:p-8 rounded-2xl text-center transition-all duration-1000 ease-out"
          :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <h1 class="hero-glass-readability mb-6">
            <span class="hero-glass-site-row block w-fit mx-auto">
              <img
                v-if="sunImage"
                :src="sunImage"
                alt=""
                class="hero-glass-site-row__sun"
              >
              <span class="hero-glass-site-row__logo">
                {{ siteName || 'Cielos' }}
              </span>
            </span>
          </h1>
          <p class="text-xl text-gray-700 dark:text-white/80 mb-8 leading-relaxed">
            {{ tagline || '透明感のあるデザインと、最新のフロントエンド技術が融合した WordPress テーマ。' }}
          </p>
          <div class="hero-cta-row justify-center">
            <a
              href="https://github.com/annrie/cielos"
              target="_blank"
              rel="noopener"
              class="hero-cta-primary"
            >
              <span class="i-carbon-download" aria-hidden="true" />
              ダウンロード
            </a>
            <a
              href="/hero-showcase/"
              class="hero-cta-secondary hero-cta-secondary--inverse"
            >
              デモを見る
              <span class="i-carbon-arrow-right" aria-hidden="true" />
            </a>
          </div>
        </div>

        <!-- Right: Glass Cards -->
        <div
          class="space-y-4 transition-all duration-1000 delay-300 ease-out"
          :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
        >
          <div
            v-for="(feature, i) in features"
            :key="i"
            class="group p-6 rounded-2xl bg-white/55 dark:bg-white/10 backdrop-blur-lg border border-white/70 dark:border-white/20 hover:bg-white/70 dark:hover:bg-white/20 transition-all duration-300 cursor-default"
            :style="{ transitionDelay: `${(i + 2) * 150}ms` }"
          >
            <div class="flex items-start gap-4">
              <div class="shrink-0 w-12 h-12 rounded-xl bg-white/60 dark:bg-white/20 flex items-center justify-center">
                <span :class="feature.icon" class="text-2xl text-slate-700 dark:text-white" aria-hidden="true" />
              </div>
              <div>
                <h3 class="text-lg font-600 text-slate-900 dark:text-white mb-1">
                  {{ feature.title }}
                </h3>
                <p class="text-slate-700 dark:text-white/70 text-sm leading-relaxed">
                  {{ feature.desc }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
  .hero-glass-panel--featured {
    position: relative;
    overflow: hidden;
    isolation: isolate;
    background:
      linear-gradient(145deg, rgba(255, 255, 255, 0.14), rgba(255, 255, 255, 0.05)),
      color-mix(in srgb, #ffffff 22%, transparent);
    border: 1px solid rgba(255, 255, 255, 0.28);
    box-shadow:
      0 22px 56px rgba(15, 48, 95, 0.11),
      inset 0 1px 0 rgba(255, 255, 255, 0.3),
      inset 0 -1px 0 rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(28px) saturate(120%) brightness(1.02);
    -webkit-backdrop-filter: blur(28px) saturate(120%) brightness(1.02);
  }

  .hero-glass-panel--featured::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background:
      radial-gradient(circle at 14% 10%, rgba(255, 255, 255, 0.18), transparent 20%),
      radial-gradient(circle at 82% 18%, rgba(125, 211, 252, 0.06), transparent 24%),
      radial-gradient(circle at 56% 110%, rgba(255, 255, 255, 0.03), transparent 32%),
      linear-gradient(180deg, rgba(255, 255, 255, 0.08), transparent 26%),
      linear-gradient(90deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0));
    opacity: 0.55;
    pointer-events: none;
    z-index: 0;
  }

  .hero-glass-panel--featured::after {
    content: '';
    position: absolute;
    inset: 1px;
    border-radius: inherit;
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow:
      inset 0 1px 0 rgba(255, 255, 255, 0.12),
      inset 0 0 0 1px rgba(255, 255, 255, 0.04);
    background:
      linear-gradient(120deg, rgba(255, 255, 255, 0.05), transparent 32%),
      linear-gradient(0deg, rgba(255, 255, 255, 0.03), transparent 18%);
    opacity: 0.5;
    pointer-events: none;
    z-index: 0;
  }

  .hero-glass-panel--featured > * {
    position: relative;
    z-index: 1;
  }

  .hero-glass-readability {
    text-shadow: 0 2px 8px rgba(2, 6, 23, 0.22);
  }

  .hero-glass-site-row {
    position: relative;
    padding: 0.2em 0.12em;
  }

  .hero-glass-site-row__sun {
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

  .hero-glass-site-row__logo {
    position: relative;
    z-index: 1;
    display: inline-block;
    font-family: 'Lobster', cursive;
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

:global(html.dark) .hero-glass-site-row__logo {
    background: none;
    color: #fff;
    -webkit-text-fill-color: currentColor;
    text-shadow:
      0 2px 14px rgba(2, 6, 23, 0.35),
      0 0 22px rgba(56, 189, 248, 0.35);
  }

html.dark .hero-glass-panel--featured {
    background:
      linear-gradient(145deg, rgba(15, 23, 42, 0.18), rgba(30, 41, 59, 0.08)),
      rgba(15, 23, 42, 0.12);
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow:
      0 24px 72px rgba(0, 0, 0, 0.28),
      inset 0 1px 0 rgba(255, 255, 255, 0.05),
      inset 0 -1px 0 rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(30px) saturate(115%) brightness(1.01);
    -webkit-backdrop-filter: blur(30px) saturate(115%) brightness(1.01);
  }

html.dark .hero-glass-panel--featured::before {
    background:
      radial-gradient(circle at 14% 10%, rgba(255, 255, 255, 0.04), transparent 20%),
      radial-gradient(circle at 82% 18%, rgba(56, 189, 248, 0.05), transparent 24%),
      radial-gradient(circle at 56% 110%, rgba(255, 255, 255, 0.015), transparent 32%),
      linear-gradient(180deg, rgba(255, 255, 255, 0.03), transparent 26%),
      linear-gradient(90deg, rgba(255, 255, 255, 0.015), rgba(255, 255, 255, 0));
  }

html.dark .hero-glass-panel--featured::after {
    border-color: rgba(255, 255, 255, 0.05);
    box-shadow:
      inset 0 1px 0 rgba(255, 255, 255, 0.04),
      inset 0 0 0 1px rgba(255, 255, 255, 0.03);
  }

@media (max-width: 767.98px) {
  .hero-glassmorphism-image {
    object-position: 78% center;
  }
}

@media (min-width: 768px) {
  .hero-glassmorphism-image {
    object-position: center center;
  }
}

@media (prefers-reduced-motion: reduce) {
  * {
    transition-duration: 0ms !important;
    animation: none !important;
  }
}
</style>

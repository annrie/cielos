<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const currentWord = ref(0)
const isDark = ref(false)
const words = ['美しい', '速い', '柔軟な', 'モダンな']
let wordTimer: number | null = null
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

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  requestAnimationFrame(() => {
    isVisible.value = true
  })
  if (!reduceMotion) {
    wordTimer = window.setInterval(() => {
      currentWord.value = (currentWord.value + 1) % words.length
    }, 2500)
  }
})

onUnmounted(() => {
  if (wordTimer) {
    window.clearInterval(wordTimer)
  }
  if (themeObserver) {
    themeObserver.disconnect()
    themeObserver = null
  }
})
</script>

<template>
  <section class="hero-surface-soft relative min-h-[100vh] bg-[#f3f9ff] dark:bg-[#1a2d45] overflow-hidden flex items-center" aria-label="Typography Hero">
    <!-- Grid Pattern -->
    <div class="absolute inset-0 hero-grid-pattern opacity-[0.06] dark:opacity-[0.03]" />

    <!-- Accent Line -->
    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-transparent via-amber-400 to-transparent opacity-60" />

    <!-- Content -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-5 md:px-16 lg:px-24">
      <div
        class="transition-all duration-1200 ease-out"
        :class="isVisible ? 'opacity-100' : 'opacity-0'"
      >
        <!-- Eyebrow -->
        <div class="flex items-center gap-3 mb-8">
          <div class="w-12 h-px bg-slate-600/70 dark:bg-amber-400" />
          <span class="text-slate-700 dark:text-amber-300 text-sm tracking-[0.2em] uppercase font-600">WordPress テーマ</span>
        </div>

        <!-- Main Typography -->
        <h1 class="hero-typography-title mb-8">
          <span class="hero-typography-title__main block text-5xl sm:text-5xl md:text-7xl lg:text-[9rem] font-900 text-gray-900 dark:text-white leading-none tracking-tight">
            <span class="hero-typography-site-row">
              <img
                v-if="sunImage"
                :src="sunImage"
                alt=""
                class="hero-typography-site-row__sun"
              >
              <span class="hero-typography-site-row__logo">
                {{ siteName || 'Cielos' }}
              </span>
            </span>
          </span>
          <span class="hero-typography-title__sub block mt-4 text-3xl sm:text-3xl md:text-5xl lg:text-6xl font-300 text-gray-600 dark:text-gray-300 leading-tight">
            <transition name="word-fade" mode="out-in">
              <span :key="currentWord" class="inline-block text-amber-400 font-600">
                {{ words[currentWord] }}
              </span>
            </transition>
            テーマを作ろう
          </span>
        </h1>

        <!-- Description -->
        <p class="text-gray-600 dark:text-gray-300 text-base sm:text-lg md:text-xl max-w-xl leading-relaxed mb-12">
          {{ tagline || 'タイポグラフィの力を最大限に活かした、洗練されたWordPressテーマ。文字そのものがデザインになる。' }}
        </p>

        <!-- CTA Row -->
        <div class="hero-cta-row">
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
            class="hero-cta-secondary hero-cta-secondary--inverse"
          >
            デモを見る
            <span class="i-carbon-arrow-right" aria-hidden="true" />
          </a>
        </div>
      </div>
    </div>

    <!-- Large Background Letter -->
    <div
      class="hero-typography-bg-letter absolute -right-8 top-1/2 -translate-y-1/2 text-[24vw] md:text-[20vw] font-900 text-gray-900/[0.03] dark:text-white/[0.02] leading-none pointer-events-none select-none"
    >
      C
    </div>
  </section>
</template>

<style scoped>
.hero-grid-pattern {
  background-image:
    linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);
  background-size: 60px 60px;
}

.word-fade-enter-active,
.word-fade-leave-active {
  transition: all 0.4s ease;
}
.word-fade-enter-from {
  opacity: 0;
  transform: translateY(8px);
}
.word-fade-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}

.hero-typography-title {
  max-width: 100%;
}

.hero-typography-site-row {
  position: relative;
  display: inline-block;
  padding: 0.08em 0.12em;
}

.hero-typography-site-row__sun {
  position: absolute;
  left: 56%;
  top: 50%;
  width: 1.3em;
  height: 1.3em;
  transform: translate(-50%, -50%);
  object-fit: contain;
  pointer-events: none;
  z-index: 0;
}

.hero-typography-site-row__logo {
  position: relative;
  z-index: 1;
  display: inline-block;
  font-family: 'Lobster', cursive;
  font-size: inherit;
  line-height: inherit;
  letter-spacing: 0.02em;
  color: #f8fafc;
  text-shadow:
    0 2px 12px rgba(56, 189, 248, 0.34),
    0 0 18px rgba(59, 130, 246, 0.3);
}

:global(html.dark) .hero-typography-site-row__logo {
  color: #f8fafc;
  text-shadow:
    0 2px 14px rgba(2, 6, 23, 0.35),
    0 0 20px rgba(56, 189, 248, 0.34),
    0 0 28px rgba(59, 130, 246, 0.22);
}

:where(.hero-typography-bg-letter) {
  will-change: transform;
}

:global(html.dark) .hero-typography-bg-letter {
  opacity: 0.8;
}

@media (max-width: 639.98px) {
  .hero-typography-title__main {
    font-size: clamp(2.1rem, 13vw, 3rem);
    letter-spacing: 0;
  }

  .hero-typography-title__sub {
    font-size: clamp(1.1rem, 5.4vw, 1.5rem);
    line-height: 1.1;
    white-space: nowrap;
  }

  .hero-typography-site-row {
    padding: 0.05em 0.08em;
  }

  .hero-typography-site-row__sun {
    width: 1.18em;
    height: 1.18em;
  }

  .hero-typography-bg-letter {
    left: -0.08em;
    right: auto;
    top: 54%;
    transform: translateY(-50%);
    font-size: 46vw;
    opacity: 0.12;
  }
}

@media (prefers-reduced-motion: reduce) {
  .word-fade-enter-active,
  .word-fade-leave-active {
    transition: none;
  }
}
</style>

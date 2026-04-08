<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const activeCard = ref(-1)
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

const cards = [
  {
    icon: 'i-carbon-application-web',
    title: 'レスポンシブ',
    desc: 'あらゆるデバイスで美しく表示されるデザイン',
    color: 'from-blue-500 to-cyan-400',
    bg: 'bg-blue-500/10',
  },
  {
    icon: 'i-carbon-accessibility',
    title: 'アクセシビリティ',
    desc: 'WCAG 2.1 AA準拠のインクルーシブデザイン',
    color: 'from-green-500 to-emerald-400',
    bg: 'bg-green-500/10',
  },
  {
    icon: 'i-carbon-flash',
    title: 'ハイパフォーマンス',
    desc: '軽量設計で快適な表示速度を実現',
    color: 'from-amber-500 to-orange-400',
    bg: 'bg-amber-500/10',
  },
  {
    icon: 'i-carbon-security',
    title: 'セキュリティ',
    desc: 'エンタープライズグレードの堅牢なセキュリティ',
    color: 'from-purple-500 to-pink-400',
    bg: 'bg-purple-500/10',
  },
]
</script>

<template>
  <section class="hero-surface-soft relative min-h-[100vh] bg-gray-50 dark:bg-slate-900 overflow-hidden flex items-center" aria-label="Interactive Cards Hero">
    <!-- Background Pattern -->
    <div class="absolute inset-0 hero-dot-pattern opacity-[0.03]" />

    <!-- Content -->
    <div class="relative z-10 w-full max-w-6xl mx-auto px-5 md:px-6 py-14 md:py-20">
      <!-- Header -->
      <div
        class="text-center mb-12 md:mb-14 transition-all duration-1000 ease-out"
        :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-200 mb-6">
          <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse" />
          新バージョンリリース
        </div>
        <h1 class="hero-interactive-title text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-800 text-gray-900 dark:text-white leading-tight mb-4">
          <span class="hero-interactive-site-row">
            <img
              v-if="sunImage"
              :src="sunImage"
              alt=""
              class="hero-interactive-site-row__sun"
            >
            <span class="hero-interactive-site-row__logo">
              {{ siteName || 'Cielos' }}
            </span>
          </span>
          <span class="hero-interactive-theme-word text-2xl sm:text-4xl md:text-5xl lg:text-6xl text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500">テーマ</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-500 dark:text-gray-200 max-w-2xl mx-auto">
          {{ tagline || 'インタラクティブなカードで機能を探索。ホバーして詳細を確認しましょう。' }}
        </p>
      </div>

      <!-- Interactive Cards Grid -->
      <div class="hero-interactive-cards-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div
          v-for="(card, i) in cards"
          :key="i"
          class="hero-interactive-card group relative p-6 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/70 cursor-default transition-all duration-500 ease-out hover:shadow-xl hover:-translate-y-2"
          :class="[
            isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12',
            activeCard === i ? 'ring-2 ring-blue-500/30' : '',
          ]"
          :style="{ transitionDelay: `${(i + 1) * 150}ms` }"
          @mouseenter="activeCard = i"
          @mouseleave="activeCard = -1"
        >
          <!-- Icon -->
          <div
            class="hero-interactive-card__icon w-14 h-14 rounded-xl flex items-center justify-center mb-4 transition-all duration-300"
            :class="card.bg"
          >
            <span :class="card.icon" class="hero-interactive-card__icon-mark text-2xl text-gray-700 dark:text-gray-100 group-hover:scale-110 transition-transform" aria-hidden="true" />
          </div>

          <!-- Title -->
          <h3 class="hero-interactive-card__title text-lg font-700 text-gray-900 dark:text-white mb-2">
            {{ card.title }}
          </h3>

          <!-- Description -->
          <p class="hero-interactive-card__desc text-sm text-gray-500 dark:text-gray-200 leading-relaxed">
            {{ card.desc }}
          </p>

          <!-- Hover Gradient Line -->
          <div
            class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl bg-gradient-to-r opacity-0 group-hover:opacity-100 transition-opacity duration-300"
            :class="card.color"
          />
        </div>
      </div>

      <!-- CTA -->
      <div
        class="text-center mt-12 transition-all duration-1000 delay-700 ease-out"
        :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
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
  </section>
</template>

<style scoped>
.hero-dot-pattern {
  background-image: radial-gradient(circle, currentColor 1px, transparent 1px);
  background-size: 24px 24px;
}

.hero-interactive-site-row {
  position: relative;
  display: inline-block;
  padding: 0.08em 0.12em;
}

.hero-interactive-site-row__sun {
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

.hero-interactive-site-row__logo {
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

:global(html.dark) .hero-interactive-site-row__logo {
  color: #f8fafc;
  text-shadow:
    0 2px 14px rgba(2, 6, 23, 0.35),
    0 0 20px rgba(56, 189, 248, 0.34),
    0 0 28px rgba(59, 130, 246, 0.22);
}

@media (max-width: 639.98px) {
  .hero-interactive-title {
    font-size: clamp(2rem, 11vw, 2.9rem);
    line-height: 1.05;
  }

  .hero-interactive-site-row {
    padding: 0.05em 0.08em;
  }

  .hero-interactive-site-row__logo {
    font-size: 1.08em;
  }

  .hero-interactive-site-row__sun {
    width: 1.15em;
    height: 1.15em;
  }

  .hero-interactive-theme-word {
    display: inline-block;
    font-size: 0.72em;
    line-height: 1;
  }

  .hero-interactive-cards-grid {
    gap: 0.75rem;
  }

  .hero-interactive-card {
    padding: 1rem;
    border-radius: 1rem;
  }

  .hero-interactive-card__icon {
    width: 2.75rem;
    height: 2.75rem;
    margin-bottom: 0.75rem;
    border-radius: 0.875rem;
  }

  .hero-interactive-card__icon-mark {
    font-size: 1.35rem;
  }

  .hero-interactive-card__title {
    font-size: 0.98rem;
    line-height: 1.25;
    margin-bottom: 0.35rem;
  }

  .hero-interactive-card__desc {
    font-size: 0.82rem;
    line-height: 1.45;
  }

}
</style>

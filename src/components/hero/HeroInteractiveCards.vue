<script setup lang="ts">
import { onMounted, ref } from 'vue'

defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const activeCard = ref(-1)

onMounted(() => {
  requestAnimationFrame(() => {
    isVisible.value = true
  })
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
    desc: 'Core Web Vitals完全対応の高速表示',
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
  <section class="relative min-h-[100vh] bg-gray-50 dark:bg-gray-900 overflow-hidden flex items-center">
    <!-- Background Pattern -->
    <div class="absolute inset-0 hero-dot-pattern opacity-[0.03]" />

    <!-- Content -->
    <div class="relative z-10 w-full max-w-6xl mx-auto px-6 py-20">
      <!-- Header -->
      <div
        class="text-center mb-16 transition-all duration-1000 ease-out"
        :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-400 mb-6">
          <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse" />
          新バージョンリリース
        </div>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-800 text-gray-900 dark:text-white leading-tight mb-4">
          {{ siteName || 'Cielos' }}
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500">テーマ</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
          {{ tagline || 'インタラクティブなカードで機能を探索。ホバーして詳細を確認しましょう。' }}
        </p>
      </div>

      <!-- Interactive Cards Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div
          v-for="(card, i) in cards"
          :key="i"
          class="group relative p-6 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-800/50 cursor-default transition-all duration-500 ease-out hover:shadow-xl hover:-translate-y-2"
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
            class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 transition-all duration-300"
            :class="card.bg"
          >
            <span :class="card.icon" class="text-2xl text-gray-700 dark:text-gray-300 group-hover:scale-110 transition-transform" aria-hidden="true" />
          </div>

          <!-- Title -->
          <h3 class="text-lg font-700 text-gray-900 dark:text-white mb-2">
            {{ card.title }}
          </h3>

          <!-- Description -->
          <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
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
        <a
          href="#"
          class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl font-600 text-lg hover:opacity-90 transition-all duration-300 shadow-lg"
        >
          すべての機能を見る
          <span class="i-carbon-arrow-right" aria-hidden="true" />
        </a>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero-dot-pattern {
  background-image: radial-gradient(circle, currentColor 1px, transparent 1px);
  background-size: 24px 24px;
}
</style>

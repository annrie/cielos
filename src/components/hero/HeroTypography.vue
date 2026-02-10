<script setup lang="ts">
import { onMounted, ref } from 'vue'

defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const currentWord = ref(0)
const words = ['美しい', '速い', '柔軟な', 'モダンな']

onMounted(() => {
  requestAnimationFrame(() => {
    isVisible.value = true
  })
  setInterval(() => {
    currentWord.value = (currentWord.value + 1) % words.length
  }, 2500)
})
</script>

<template>
  <section class="relative min-h-[100vh] bg-[#0a0a0a] overflow-hidden flex items-center">
    <!-- Grid Pattern -->
    <div class="absolute inset-0 hero-grid-pattern opacity-[0.03]" />

    <!-- Accent Line -->
    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-transparent via-amber-400 to-transparent opacity-60" />

    <!-- Content -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-8 md:px-16 lg:px-24">
      <div
        class="transition-all duration-1200 ease-out"
        :class="isVisible ? 'opacity-100' : 'opacity-0'"
      >
        <!-- Eyebrow -->
        <div class="flex items-center gap-3 mb-8">
          <div class="w-12 h-px bg-amber-400" />
          <span class="text-amber-400 text-sm tracking-[0.2em] uppercase font-500">WordPress テーマ</span>
        </div>

        <!-- Main Typography -->
        <h1 class="mb-8">
          <span class="block text-6xl md:text-8xl lg:text-[10rem] font-900 text-white leading-none tracking-tight">
            {{ siteName || 'Cielos' }}
          </span>
          <span class="block mt-4 text-3xl md:text-5xl lg:text-6xl font-300 text-gray-500 leading-tight">
            <transition name="word-fade" mode="out-in">
              <span :key="currentWord" class="inline-block text-amber-400 font-600">
                {{ words[currentWord] }}
              </span>
            </transition>
            テーマを作ろう
          </span>
        </h1>

        <!-- Description -->
        <p class="text-gray-500 text-lg md:text-xl max-w-xl leading-relaxed mb-12">
          {{ tagline || 'タイポグラフィの力を最大限に活かした、洗練されたWordPressテーマ。文字そのものがデザインになる。' }}
        </p>

        <!-- CTA Row -->
        <div class="flex flex-wrap items-center gap-6">
          <a
            href="#"
            class="group inline-flex items-center gap-3 px-8 py-4 bg-amber-400 text-black rounded-none font-700 text-lg hover:bg-amber-300 transition-all duration-300"
          >
            テーマを取得
            <span class="i-carbon-arrow-right transition-transform group-hover:translate-x-1" aria-hidden="true" />
          </a>
          <a
            href="#"
            class="text-gray-500 hover:text-white transition-colors font-500 underline underline-offset-4 decoration-gray-700 hover:decoration-white"
          >
            ドキュメントを読む
          </a>
        </div>
      </div>
    </div>

    <!-- Large Background Letter -->
    <div
      class="absolute -right-20 top-1/2 -translate-y-1/2 text-[40vw] font-900 text-white/[0.02] leading-none pointer-events-none select-none"
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
</style>

<script setup lang="ts">
import { onMounted, ref } from 'vue'

defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)

onMounted(() => {
  requestAnimationFrame(() => {
    isVisible.value = true
  })
})
</script>

<template>
  <section class="relative min-h-[100vh] bg-white dark:bg-gray-950 overflow-hidden flex items-center">
    <!-- Geometric Background Shapes -->
    <div class="absolute inset-0 pointer-events-none">
      <!-- Large Triangle -->
      <div
        class="absolute -top-20 -right-20 w-[50vw] h-[50vw] transition-all duration-1500 ease-out"
        :class="isVisible ? 'opacity-100 rotate-0' : 'opacity-0 rotate-12'"
      >
        <svg viewBox="0 0 500 500" class="w-full h-full">
          <polygon points="250,50 450,400 50,400" fill="none" stroke="currentColor" stroke-width="0.5" class="text-gray-200 dark:text-gray-800" />
        </svg>
      </div>

      <!-- Circle -->
      <div
        class="absolute bottom-[10%] left-[5%] w-[30vw] h-[30vw] transition-all duration-1500 delay-200 ease-out"
        :class="isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-80'"
      >
        <svg viewBox="0 0 400 400" class="w-full h-full">
          <circle cx="200" cy="200" r="180" fill="none" stroke="currentColor" stroke-width="0.5" class="text-gray-200 dark:text-gray-800" />
        </svg>
      </div>

      <!-- Animated Dots -->
      <div class="hero-geo-dots" />

      <!-- Colored Accent Shapes -->
      <div
        class="absolute top-[20%] right-[20%] w-4 h-4 bg-sky-400 rounded-full animate-pulse"
        :class="isVisible ? 'opacity-60' : 'opacity-0'"
      />
      <div
        class="absolute bottom-[30%] left-[15%] w-3 h-3 bg-amber-400 rotate-45 animate-bounce"
        :class="isVisible ? 'opacity-60' : 'opacity-0'"
      />
      <div
        class="absolute top-[60%] right-[10%] w-6 h-1 bg-rose-400"
        :class="isVisible ? 'opacity-60' : 'opacity-0'"
      />
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-6xl mx-auto px-8 md:px-16">
      <div class="grid md:grid-cols-[1fr,auto] gap-16 items-center">
        <!-- Left Content -->
        <div
          class="transition-all duration-1200 ease-out"
          :class="isVisible ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-8'"
        >
          <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 border-2 border-sky-400 rotate-45" />
            <span class="text-sm text-gray-400 dark:text-gray-500 tracking-wider uppercase">
              デザインシステム
            </span>
          </div>

          <h1 class="text-5xl md:text-6xl lg:text-7xl font-800 text-gray-900 dark:text-white leading-[1.05] mb-6">
            幾何学的な<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 via-blue-500 to-indigo-500">
              {{ siteName || 'Cielos' }}
            </span>
          </h1>

          <p class="text-lg text-gray-500 dark:text-gray-400 max-w-lg mb-8 leading-relaxed">
            {{ tagline || 'シンプルな図形が織りなす洗練されたデザイン。幾何学模様が空間にリズムを生み出す。' }}
          </p>

          <div class="flex flex-wrap gap-4">
            <a
              href="#"
              class="inline-flex items-center gap-2 px-7 py-3.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-600 hover:opacity-90 transition-all duration-300"
            >
              はじめる
              <span class="i-carbon-arrow-up-right" aria-hidden="true" />
            </a>
            <a
              href="#"
              class="inline-flex items-center gap-2 px-7 py-3.5 border border-gray-200 dark:border-gray-800 text-gray-700 dark:text-gray-300 font-600 hover:border-gray-400 dark:hover:border-gray-600 transition-all duration-300"
            >
              デモ
            </a>
          </div>
        </div>

        <!-- Right: Geometric Composition -->
        <div
          class="hidden md:block w-72 h-72 lg:w-96 lg:h-96 relative transition-all duration-1500 delay-300 ease-out"
          :class="isVisible ? 'opacity-100 rotate-0' : 'opacity-0 rotate-6'"
        >
          <div class="absolute inset-0 border border-gray-200 dark:border-gray-800 rotate-12" />
          <div class="absolute inset-4 border border-gray-200 dark:border-gray-800 -rotate-6" />
          <div class="absolute inset-8 bg-gradient-to-br from-sky-50 to-blue-50 dark:from-sky-900/20 dark:to-blue-900/20 rotate-3" />
          <div class="absolute inset-12 flex items-center justify-center">
            <span class="text-8xl font-900 text-transparent bg-clip-text bg-gradient-to-br from-sky-400 to-indigo-500">
              C
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero-geo-dots {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(148, 163, 184, 0.15) 1px, transparent 1px);
  background-size: 40px 40px;
}
</style>

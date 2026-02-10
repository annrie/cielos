<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const scrollY = ref(0)
const sectionRef = ref<HTMLElement | null>(null)

function handleScroll() {
  if (!sectionRef.value) return
  const rect = sectionRef.value.getBoundingClientRect()
  if (rect.bottom > 0 && rect.top < window.innerHeight) {
    scrollY.value = -rect.top
  }
}

onMounted(() => {
  requestAnimationFrame(() => {
    isVisible.value = true
  })
  window.addEventListener('scroll', handleScroll, { passive: true })
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
  <section
    ref="sectionRef"
    class="relative min-h-[100vh] overflow-hidden bg-indigo-950"
  >
    <!-- Layer 1: Far Background -->
    <div
      class="absolute inset-0"
      :style="{ transform: `translateY(${scrollY * 0.1}px)` }"
    >
      <div class="absolute inset-0 bg-gradient-to-b from-indigo-950 via-purple-900/50 to-indigo-950" />
      <!-- Stars -->
      <div class="hero-stars" />
    </div>

    <!-- Layer 2: Mountains/Shapes -->
    <div
      class="absolute bottom-0 left-0 right-0"
      :style="{ transform: `translateY(${scrollY * 0.25}px)` }"
    >
      <svg viewBox="0 0 1440 400" class="w-full" preserveAspectRatio="none">
        <path d="M0,400 L0,250 Q360,100 720,200 Q1080,300 1440,150 L1440,400 Z" fill="rgba(99,102,241,0.2)" />
      </svg>
    </div>

    <!-- Layer 3: Mid Shapes -->
    <div
      class="absolute bottom-0 left-0 right-0"
      :style="{ transform: `translateY(${scrollY * 0.4}px)` }"
    >
      <svg viewBox="0 0 1440 300" class="w-full" preserveAspectRatio="none">
        <path d="M0,300 L0,200 Q240,100 480,180 Q720,260 960,140 Q1200,20 1440,120 L1440,300 Z" fill="rgba(139,92,246,0.3)" />
      </svg>
    </div>

    <!-- Layer 4: Sun/Moon -->
    <div
      class="absolute top-[15%] right-[15%] w-32 h-32 md:w-48 md:h-48 rounded-full"
      :style="{ transform: `translateY(${scrollY * 0.05}px)` }"
    >
      <img
        v-if="themeUri"
        :src="`${themeUri}/src/assets/images/hero-sun-light.png`"
        alt=""
        class="w-full h-full object-contain opacity-80"
      >
    </div>

    <!-- Content Layer -->
    <div class="relative z-10 min-h-[100vh] flex items-center justify-center text-center px-6">
      <div
        class="transition-all duration-1200 ease-out"
        :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
      >
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-800 text-white mb-6 drop-shadow-2xl">
          {{ siteName || 'Cielos' }}
        </h1>
        <p class="text-xl md:text-2xl text-indigo-200/80 max-w-2xl mx-auto mb-10 leading-relaxed">
          {{ tagline || '奥行きのある世界観を、スクロールで体験する。パララックスが生み出す没入感。' }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a
            href="#"
            class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-500 text-white rounded-xl font-600 text-lg hover:bg-indigo-400 transition-all duration-300 shadow-lg shadow-indigo-500/30"
          >
            <span class="i-carbon-rocket" aria-hidden="true" />
            体験する
          </a>
          <a
            href="#"
            class="inline-flex items-center gap-2 px-8 py-4 border border-indigo-400/30 text-indigo-200 rounded-xl font-600 text-lg hover:bg-indigo-500/10 transition-all duration-300"
          >
            ソースコード
            <span class="i-carbon-logo-github" aria-hidden="true" />
          </a>
        </div>

        <!-- Scroll Indicator -->
        <div class="mt-16 animate-bounce">
          <span class="i-carbon-chevron-down text-2xl text-indigo-300/50" aria-hidden="true" />
        </div>
      </div>
    </div>

    <!-- Foreground Layer -->
    <div
      class="absolute bottom-0 left-0 right-0"
      :style="{ transform: `translateY(${scrollY * 0.6}px)` }"
    >
      <svg viewBox="0 0 1440 200" class="w-full" preserveAspectRatio="none">
        <path d="M0,200 L0,120 Q360,60 720,100 Q1080,140 1440,80 L1440,200 Z" fill="rgba(30,27,75,0.8)" />
      </svg>
    </div>
  </section>
</template>

<style scoped>
.hero-stars {
  position: absolute;
  inset: 0;
  background-image:
    radial-gradient(2px 2px at 20% 30%, rgba(255,255,255,0.8), transparent),
    radial-gradient(1px 1px at 40% 70%, rgba(255,255,255,0.5), transparent),
    radial-gradient(1.5px 1.5px at 60% 20%, rgba(255,255,255,0.6), transparent),
    radial-gradient(1px 1px at 80% 50%, rgba(255,255,255,0.4), transparent),
    radial-gradient(2px 2px at 10% 80%, rgba(255,255,255,0.7), transparent),
    radial-gradient(1px 1px at 70% 90%, rgba(255,255,255,0.3), transparent),
    radial-gradient(1.5px 1.5px at 50% 10%, rgba(255,255,255,0.5), transparent),
    radial-gradient(1px 1px at 90% 40%, rgba(255,255,255,0.4), transparent);
  animation: twinkle 4s ease-in-out infinite alternate;
}

@keyframes twinkle {
  0% { opacity: 0.6; }
  100% { opacity: 1; }
}
</style>

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
  <section class="hero-surface-soft relative min-h-[100vh] overflow-hidden flex items-center justify-center" aria-label="Gradient Mesh Hero">
    <!-- Animated Mesh Gradient Background -->
    <div class="absolute inset-0 hero-mesh-bg" />

    <!-- Floating Orbs -->
    <div class="absolute inset-0 pointer-events-none">
      <div class="hero-orb hero-orb-1" />
      <div class="hero-orb hero-orb-2" />
      <div class="hero-orb hero-orb-3" />
    </div>

    <!-- Content -->
    <div
      class="relative z-10 text-center px-6 max-w-4xl mx-auto transition-all duration-1000 ease-out hero-content-readability"
      :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
    >
      <p class="text-sm tracking-[0.3em] uppercase text-sky-700/85 dark:text-white/70 mb-4 font-500">
        WordPress &times; Vue.js テーマ
      </p>
      <h1 class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-800 text-slate-900 dark:text-white leading-none mb-6">
        <span class="hero-gradient-site-row">
          <img
            v-if="sunImage"
            :src="sunImage"
            alt=""
            class="hero-gradient-site-row__sun"
          >
          <span class="hero-gradient-site-row__logo">
            {{ siteName || 'Cielos' }}
          </span>
        </span>
      </h1>
      <p class="text-lg md:text-xl text-slate-700 dark:text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
        {{ tagline || '空のように広がる可能性を、あなたのウェブサイトに。' }}
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
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

    <!-- Sun Backdrop -->
    <div class="hero-gradient-sun-backdrop absolute left-1/2 top-[20%] -translate-x-1/2 w-[72vw] max-w-[46rem] h-[72vw] max-h-[46rem] pointer-events-none" :class="isVisible ? 'opacity-35 scale-100' : 'opacity-0 scale-90'">
      <img
        v-if="sunImage"
        :src="sunImage"
        alt=""
        class="w-full h-full object-contain"
      >
    </div>

    <!-- Bottom Fade -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white/65 to-transparent dark:from-slate-900/20" />
  </section>
</template>

<style scoped>
.hero-gradient-site-row {
  position: relative;
  display: inline-block;
  padding: 0.08em 0.12em;
}

.hero-gradient-site-row__sun {
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

.hero-gradient-site-row__logo {
  position: relative;
  z-index: 1;
  display: inline-block;
  font-family: 'Lobster', cursive;
  color: #f8fafc;
  text-shadow:
    0 2px 12px rgba(56, 189, 248, 0.34),
    0 0 18px rgba(59, 130, 246, 0.3);
}

:global(html.dark) .hero-gradient-site-row__logo {
  color: #f8fafc;
  text-shadow:
    0 2px 14px rgba(2, 6, 23, 0.35),
    0 0 20px rgba(56, 189, 248, 0.34),
    0 0 28px rgba(59, 130, 246, 0.22);
}

.hero-gradient-sun-backdrop {
  z-index: 0;
  opacity: 0.28;
  transition: opacity 1200ms ease, transform 1200ms ease;
}

.hero-gradient-sun-backdrop img {
  filter: drop-shadow(0 0 40px rgba(6, 182, 212, 0.3));
}

:global(html.dark) .hero-gradient-sun-backdrop {
  opacity: 0.2;
}

.hero-mesh-bg {
  background: linear-gradient(135deg, #e0f2fe 0%, #bfdbfe 52%, #dbeafe 100%);
  animation: meshShiftLight 10s ease-in-out infinite alternate;
}

@keyframes meshShiftLight {
  0% { background: linear-gradient(135deg, #e0f2fe 0%, #bfdbfe 52%, #dbeafe 100%); }
  50% { background: linear-gradient(135deg, #dbeafe 0%, #bae6fd 48%, #cffafe 100%); }
  100% { background: linear-gradient(135deg, #e0f7ff 0%, #c7e9ff 50%, #dbf4ff 100%); }
}

html.dark .hero-mesh-bg {
  background: linear-gradient(135deg, #27405c 0%, #314c69 52%, #3a5978 100%);
  animation-name: meshShiftDark;
}

@keyframes meshShiftDark {
  0% { background: linear-gradient(135deg, #27405c 0%, #314c69 52%, #3a5978 100%); }
  50% { background: linear-gradient(135deg, #294666 0%, #35567a 52%, #3d6487 100%); }
  100% { background: linear-gradient(135deg, #2f4c6c 0%, #395a7e 50%, #43698d 100%); }
}

.hero-orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.4;
}

.hero-orb-1 {
  width: 400px;
  height: 400px;
  background: #7dd3fc;
  top: -10%;
  left: -5%;
  animation: float1 12s ease-in-out infinite;
  opacity: 0.32;
}

.hero-orb-2 {
  width: 300px;
  height: 300px;
  background: #93c5fd;
  bottom: -5%;
  right: -5%;
  animation: float2 10s ease-in-out infinite;
  opacity: 0.3;
}

.hero-orb-3 {
  width: 200px;
  height: 200px;
  background: #67e8f9;
  top: 40%;
  left: 60%;
  animation: float3 14s ease-in-out infinite;
  opacity: 0.28;
}

html.dark .hero-orb-1 {
  background: #a855f7;
  opacity: 0.24;
}

html.dark .hero-orb-2 {
  background: #22d3ee;
  opacity: 0.2;
}

html.dark .hero-orb-3 {
  background: #3b82f6;
  opacity: 0.22;
}

@keyframes float1 {
  0%, 100% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(80px, 40px) scale(1.1); }
}

@keyframes float2 {
  0%, 100% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(-60px, -30px) scale(1.15); }
}

@keyframes float3 {
  0%, 100% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(40px, -50px) scale(0.9); }
}

@media (prefers-reduced-motion: reduce) {
  .hero-mesh-bg,
  .hero-orb-1,
  .hero-orb-2,
  .hero-orb-3 {
    animation: none !important;
  }
}

.hero-content-readability {
  text-shadow: 0 1px 2px rgba(15, 23, 42, 0.18);
}

html.dark .hero-content-readability {
  text-shadow: 0 2px 10px rgba(2, 6, 23, 0.45);
}
</style>

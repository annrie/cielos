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
  <section class="hero-surface-soft relative min-h-[100vh] bg-[#ecf7ff] dark:bg-[#2a425e] overflow-hidden flex items-center justify-center" aria-label="Aurora Wave Hero">
    <!-- Aurora Waves -->
    <div class="absolute inset-0">
      <div class="hero-aurora hero-aurora-1" />
      <div class="hero-aurora hero-aurora-2" />
      <div class="hero-aurora hero-aurora-3" />
    </div>

    <!-- Sun Image -->
    <div
      class="hero-aurora-sun absolute left-1/2 top-[22%] -translate-x-1/2 w-[72vw] max-w-[44rem] h-[72vw] max-h-[44rem] transition-all duration-2000 ease-out"
      :class="isVisible ? 'opacity-50 scale-100' : 'opacity-0 scale-80'"
    >
      <img
        v-if="sunImage"
        :src="sunImage"
        alt=""
        class="w-full h-full object-contain hero-glow"
      >
    </div>

    <!-- Content -->
    <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
      <div
        class="transition-all duration-1200 ease-out"
        :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
      >
        <!-- Logo Mark -->
        <div class="mx-auto w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 via-cyan-400 to-blue-500 flex items-center justify-center mb-8 shadow-lg shadow-cyan-500/20">
          <span class="text-3xl font-900 text-white">C</span>
        </div>

        <h1 class="text-6xl sm:text-7xl md:text-9xl lg:text-[10rem] font-800 leading-none mb-6">
          <span class="hero-aurora-site-logo">
            {{ siteName || 'Cielos' }}
          </span>
        </h1>

        <p class="text-lg md:text-xl text-slate-700 dark:text-slate-100 max-w-2xl mx-auto mb-10 leading-relaxed hero-aurora-readability">
          {{ tagline || 'オーロラのように美しく、波のように流れるデザイン。自然の神秘をウェブに閉じ込めた。' }}
        </p>

        <!-- Feature Pills -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
          <span class="px-4 py-2 rounded-full text-sm font-500 bg-emerald-500/12 text-emerald-700 dark:text-emerald-100 border border-emerald-500/25">
            Vue 3 Composition API
          </span>
          <span class="px-4 py-2 rounded-full text-sm font-500 bg-cyan-500/12 text-cyan-700 dark:text-cyan-100 border border-cyan-500/25">
            TypeScript
          </span>
          <span class="px-4 py-2 rounded-full text-sm font-500 bg-blue-500/12 text-blue-700 dark:text-blue-100 border border-blue-500/25">
            WordPress REST API
          </span>
        </div>

        <!-- CTA -->
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
    </div>

    <!-- Bottom Wave -->
    <div class="absolute bottom-0 left-0 right-0">
      <svg viewBox="0 0 1440 120" class="w-full" preserveAspectRatio="none">
        <path
          d="M0,80 C360,20 720,100 1080,40 C1260,10 1360,60 1440,50 L1440,120 L0,120 Z"
          fill="rgba(15,23,42,0.8)"
        />
      </svg>
    </div>
  </section>
</template>

<style scoped>
.hero-aurora {
  position: absolute;
  width: 200%;
  height: 200%;
  opacity: 0.15;
  filter: blur(100px);
}

.hero-aurora-1 {
  top: -50%;
  left: -50%;
  background: radial-gradient(ellipse at 30% 50%, #10b981, transparent 70%);
  animation: aurora1 10s ease-in-out infinite alternate;
}

.hero-aurora-2 {
  top: -30%;
  left: -30%;
  background: radial-gradient(ellipse at 60% 40%, #06b6d4, transparent 70%);
  animation: aurora2 12s ease-in-out infinite alternate;
}

.hero-aurora-3 {
  top: -40%;
  left: -20%;
  background: radial-gradient(ellipse at 50% 60%, #3b82f6, transparent 70%);
  animation: aurora3 14s ease-in-out infinite alternate;
}

@keyframes aurora1 {
  0% { transform: translate(0, 0) rotate(0deg); }
  100% { transform: translate(10%, 5%) rotate(5deg); }
}

@keyframes aurora2 {
  0% { transform: translate(0, 0) rotate(0deg); }
  100% { transform: translate(-8%, 8%) rotate(-3deg); }
}

@keyframes aurora3 {
  0% { transform: translate(0, 0) rotate(0deg); }
  100% { transform: translate(5%, -5%) rotate(4deg); }
}

.hero-glow {
  filter: drop-shadow(0 0 40px rgba(6, 182, 212, 0.3));
}

.hero-aurora-sun {
  z-index: 0;
  pointer-events: none;
}

.hero-aurora-sun img {
  opacity: 0.28;
}

.hero-aurora-sun :deep(img) {
  opacity: 0.28;
}

.hero-aurora-site-logo {
  font-family: 'Lobster', cursive;
  color: #f8fafc;
  text-shadow:
    0 2px 12px rgba(6, 182, 212, 0.28),
    0 0 18px rgba(59, 130, 246, 0.22);
}

:global(html.dark) .hero-aurora-site-logo {
  color: #f8fafc;
  text-shadow:
    0 2px 14px rgba(2, 6, 23, 0.35),
    0 0 20px rgba(56, 189, 248, 0.34),
    0 0 28px rgba(59, 130, 246, 0.22);
}

.hero-aurora-readability {
  text-shadow: 0 2px 9px rgba(2, 6, 23, 0.3);
}

@media (prefers-reduced-motion: reduce) {
  .hero-aurora-1,
  .hero-aurora-2,
  .hero-aurora-3 {
    animation: none !important;
  }
}
</style>

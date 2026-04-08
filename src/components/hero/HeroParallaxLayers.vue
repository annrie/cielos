<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const scrollY = ref(0)
const sectionRef = ref<HTMLElement | null>(null)
const reduceMotion = ref(false)
const isDark = ref(false)
let themeObserver: MutationObserver | null = null

const sunImage = computed(() => {
  if (!props.themeUri) {
    return ''
  }

  const file = isDark.value ? 'hero-sun-dark.png' : 'hero-sun-light.png'
  return `${props.themeUri}/src/assets/images/${file}`
})

function handleScroll() {
  if (!sectionRef.value)
    return
  const rect = sectionRef.value.getBoundingClientRect()
  if (rect.bottom > 0 && rect.top < window.innerHeight) {
    scrollY.value = -rect.top
  }
}

onMounted(() => {
  const root = document.documentElement
  const syncTheme = () => {
    isDark.value = root.classList.contains('dark')
  }

  syncTheme()
  themeObserver = new MutationObserver(syncTheme)
  themeObserver.observe(root, { attributes: true, attributeFilter: ['class'] })

  reduceMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  requestAnimationFrame(() => {
    isVisible.value = true
  })
  if (!reduceMotion.value) {
    window.addEventListener('scroll', handleScroll, { passive: true })
  }
})

onUnmounted(() => {
  if (!reduceMotion.value) {
    window.removeEventListener('scroll', handleScroll)
  }
  if (themeObserver) {
    themeObserver.disconnect()
    themeObserver = null
  }
})
</script>

<template>
  <section
    ref="sectionRef"
    class="hero-surface-soft relative min-h-[100vh] overflow-hidden bg-sky-50 dark:bg-slate-900"
    aria-label="Parallax Layers Hero"
  >
    <!-- Layer 1: Far Background -->
    <div
      class="absolute inset-0"
      :style="{ transform: `translateY(${scrollY * 0.1}px)` }"
    >
      <div class="absolute inset-0 bg-gradient-to-b from-sky-100 via-blue-100/55 to-sky-50 dark:from-slate-900 dark:via-slate-800/55 dark:to-slate-900" />
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
        v-if="sunImage"
        :src="sunImage"
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
        <h1 class="text-6xl sm:text-7xl md:text-8xl lg:text-9xl font-800 text-slate-900 dark:text-white mb-6 drop-shadow-2xl">
          <span class="hero-parallax-site-row">
            <span class="hero-parallax-site-row__logo">
              {{ siteName || 'Cielos' }}
            </span>
          </span>
        </h1>
        <p class="text-xl md:text-2xl text-slate-600 dark:text-indigo-200/80 max-w-2xl mx-auto mb-10 leading-relaxed">
          {{ tagline || '奥行きのある世界観を、スクロールで体験する。パララックスが生み出す没入感。' }}
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

        <!-- Scroll Indicator -->
        <div class="mt-16" :class="reduceMotion ? '' : 'animate-bounce'">
          <span class="i-carbon-chevron-down text-2xl text-slate-400 dark:text-indigo-300/50" aria-hidden="true" />
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

.hero-parallax-site-row {
  display: inline-block;
}

.hero-parallax-site-row__logo {
  display: inline-block;
  font-family: 'Lobster', cursive;
  font-size: 1.05em;
  letter-spacing: 0.02em;
  color: #f8fafc;
  text-shadow:
    0 2px 12px rgba(56, 189, 248, 0.32),
    0 0 18px rgba(59, 130, 246, 0.24);
}

:global(html.dark) .hero-parallax-site-row__logo {
  color: #f8fafc;
  text-shadow:
    0 2px 14px rgba(2, 6, 23, 0.35),
    0 0 20px rgba(56, 189, 248, 0.3);
}

@keyframes twinkle {
  0% { opacity: 0.6; }
  100% { opacity: 1; }
}

@media (prefers-reduced-motion: reduce) {
  .hero-stars {
    animation: none !important;
  }
}
</style>

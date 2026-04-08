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
  <section class="hero-surface-soft relative min-h-[100vh] bg-white dark:bg-slate-900 overflow-hidden flex items-center" aria-label="Geometric Hero">
    <!-- Geometric Background Shapes -->
    <div class="absolute inset-0 pointer-events-none">
      <!-- Large Triangle -->
      <div
        class="hero-geometric-triangle absolute -top-20 -right-20 w-[50vw] h-[50vw] transition-all duration-1500 ease-out"
        :class="isVisible ? 'opacity-100 rotate-0' : 'opacity-0 rotate-12'"
      >
        <svg viewBox="0 0 500 500" class="hero-geometric-triangle__svg w-full h-full">
          <polygon points="250,50 450,400 50,400" fill="none" stroke="currentColor" stroke-width="1.2" class="text-slate-500 dark:text-gray-800" />
        </svg>
      </div>

      <!-- Circle -->
      <div
        class="hero-geometric-circle absolute bottom-[10%] left-[5%] w-[30vw] h-[30vw] transition-all duration-1500 delay-200 ease-out"
        :class="isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-80'"
      >
        <svg viewBox="0 0 400 400" class="hero-geometric-circle__svg w-full h-full">
          <circle cx="200" cy="200" r="180" fill="none" stroke="currentColor" stroke-width="0.6" class="text-slate-400 dark:text-gray-800" />
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
    <div class="relative z-10 w-full max-w-6xl mx-auto px-5 md:px-16">
      <div class="grid md:grid-cols-[1fr_auto] gap-16 items-center">
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

          <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-800 text-gray-900 dark:text-white leading-[1.05] mb-6">
            幾何学的な<br>
            <span class="hero-geometric-site-row">
              <img
                v-if="sunImage"
                :src="sunImage"
                alt=""
                class="hero-geometric-site-row__sun"
              >
              <span class="hero-geometric-site-row__logo">
                {{ siteName || 'Cielos' }}
              </span>
            </span>
          </h1>

          <p class="text-lg text-gray-500 dark:text-gray-200 max-w-lg mb-8 leading-relaxed">
            {{ tagline || 'シンプルな図形が織りなす洗練されたデザイン。幾何学模様が空間にリズムを生み出す。' }}
          </p>

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
              class="hero-cta-secondary"
            >
              デモを見る
              <span class="i-carbon-arrow-right" aria-hidden="true" />
            </a>
          </div>
        </div>

        <!-- Right: Geometric Composition -->
        <div
          class="hidden md:block w-72 h-72 lg:w-96 lg:h-96 relative transition-all duration-1500 delay-300 ease-out"
          :class="isVisible ? 'opacity-100 rotate-0' : 'opacity-0 rotate-6'"
        >
          <div class="absolute inset-0 border border-gray-300 dark:border-gray-800 rotate-12" />
          <div class="absolute inset-4 border border-gray-300 dark:border-gray-800 -rotate-6" />
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
  background-image: radial-gradient(circle, rgba(148, 163, 184, 0.24) 1px, transparent 1px);
  background-size: 40px 40px;
}

.hero-geometric-site-row {
  position: relative;
  display: inline-block;
  padding: 0.08em 0.12em;
}

.hero-geometric-site-row__sun {
  position: absolute;
  left: 56%;
  top: 50%;
  width: 2.1em;
  height: 2.1em;
  transform: translate(-50%, -50%);
  object-fit: contain;
  pointer-events: none;
  z-index: 0;
}

.hero-geometric-site-row__logo {
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

:global(html.dark) .hero-geometric-site-row__logo {
  color: #f8fafc;
  text-shadow:
    0 2px 14px rgba(2, 6, 23, 0.35),
    0 0 20px rgba(56, 189, 248, 0.34),
    0 0 28px rgba(59, 130, 246, 0.22);
}

@media (prefers-reduced-motion: reduce) {
  .animate-pulse,
  .animate-bounce {
    animation: none !important;
  }
}

@media (max-width: 639.98px) {
  .hero-geometric-triangle {
    top: 1rem;
    right: 1rem;
    width: 46vw;
    height: 46vw;
  }

  .hero-geometric-circle {
    bottom: 12%;
    left: 12%;
    width: 40vw;
    height: 40vw;
  }

  .hero-geometric-triangle__svg,
  .hero-geometric-circle__svg {
    color: rgb(71 85 105 / 0.9);
  }

  .hero-geo-dots {
    background-image: radial-gradient(circle, rgba(148, 163, 184, 0.48) 1px, transparent 1px);
    background-size: 28px 28px;
  }

  .hero-geometric-site-row__sun {
    width: 1.85em;
    height: 1.85em;
  }

  .hero-geometric-site-row__logo {
    font-size: 1.1em;
  }

  .hero-geometric-triangle {
    opacity: 0.55 !important;
  }

  .hero-geometric-circle {
    opacity: 0.5 !important;
  }
}
</style>

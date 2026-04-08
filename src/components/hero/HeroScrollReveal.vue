<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const scrollProgress = ref(0)
const sectionRef = ref<HTMLElement | null>(null)
const isDark = ref(false)
let themeObserver: MutationObserver | null = null

const heroImage = computed(() => {
  if (!props.themeUri) {
    return ''
  }

  const file = isDark.value ? 'dark-hero3.png' : 'light-hero3.png'
  return `${props.themeUri}/src/assets/images/hero/${file}`
})

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
  const sectionHeight = sectionRef.value.offsetHeight
  const viewportHeight = window.innerHeight

  if (rect.top < viewportHeight && rect.bottom > 0) {
    const progress = Math.min(1, Math.max(0, (viewportHeight - rect.top) / (viewportHeight + sectionHeight)))
    scrollProgress.value = progress
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

  requestAnimationFrame(() => {
    isVisible.value = true
  })
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()
})

onUnmounted(() => {
  if (themeObserver) {
    themeObserver.disconnect()
    themeObserver = null
  }
  window.removeEventListener('scroll', handleScroll)
})

const techStack = [
  { name: 'Vue 3', icon: 'i-carbon-logo-vue' },
  { name: 'TypeScript', icon: 'i-carbon-code' },
  { name: 'UnoCSS', icon: 'i-carbon-paint-brush' },
  { name: 'Vite', icon: 'i-carbon-flash' },
  { name: 'WordPress', icon: 'i-carbon-blog' },
]
</script>

<template>
  <section
    ref="sectionRef"
    class="relative min-h-[120vh] overflow-hidden"
  >
    <!-- Sticky Container -->
    <div class="sticky top-0 min-h-[100vh] flex items-center bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
      <!-- Background Image with Scroll Parallax -->
      <div
        class="hero-scroll-reveal-bg-layer absolute inset-0 transition-opacity duration-300"
        :style="{ opacity: (isDark ? 0.34 : 0.4) + scrollProgress * 0.12 }"
      >
        <img
          v-if="heroImage"
          :src="heroImage"
          alt=""
          class="w-full h-full object-cover hero-scroll-reveal-bg-image"
        >
      </div>
      <div class="hero-scroll-reveal-tone-layer absolute inset-0 bg-gradient-to-br from-white/58 via-white/30 to-white/68 dark:from-slate-950/68 dark:via-slate-900/34 dark:to-slate-950/72" />
      <div class="hero-scroll-reveal-glow-layer absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.24),transparent_42%),radial-gradient(circle_at_bottom_right,rgba(14,165,233,0.1),transparent_38%)] dark:bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.06),transparent_42%),radial-gradient(circle_at_bottom_right,rgba(14,165,233,0.14),transparent_38%)]" />

      <!-- Content -->
      <div class="relative z-10 w-full max-w-6xl mx-auto px-6 py-20">
        <!-- Top Section: Always Visible -->
        <div
          class="text-center mb-16 transition-all duration-1000 ease-out"
          :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <h1 class="hero-scroll-reveal-site-row text-center mb-6">
            <img
              v-if="sunImage"
              :src="sunImage"
              alt=""
              class="hero-scroll-reveal-site-row__sun"
            >
            <span class="hero-scroll-reveal-site-row__logo">
              {{ siteName || 'Cielos' }}
            </span>
          </h1>
          <p class="text-xl text-slate-700 dark:text-slate-300 max-w-2xl mx-auto">
            {{ tagline || 'スクロールで体験が始まる。段階的に現れるコンテンツで、ストーリーを伝える。' }}
          </p>
        </div>

        <!-- Progressive Reveal: Tech Stack -->
        <div
          class="flex flex-wrap justify-center gap-4 mb-12 transition-all duration-700"
          :style="{
            opacity: Math.min(1, scrollProgress * 4),
            transform: `translateY(${Math.max(0, 30 - scrollProgress * 120)}px)`,
          }"
        >
          <div
            v-for="(tech, i) in techStack"
            :key="i"
            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white/75 border border-slate-300/80 text-slate-700 shadow-[0_1px_2px_rgba(15,23,42,0.08)] backdrop-blur-sm dark:bg-white/5 dark:border-white/10 dark:text-white/80 dark:shadow-none"
            :style="{
              opacity: Math.min(1, Math.max(0, (scrollProgress * 5) - (i * 0.3))),
              transform: `translateY(${Math.max(0, 20 - (scrollProgress * 5 - i * 0.3) * 40)}px)`,
            }"
          >
            <span :class="tech.icon" class="text-lg text-sky-500 dark:text-sky-400" aria-hidden="true" />
            <span class="text-sm font-500">{{ tech.name }}</span>
          </div>
        </div>

        <!-- Progressive Reveal: CTA -->
        <div
          class="text-center transition-all duration-700"
          :style="{
            opacity: Math.min(1, Math.max(0, scrollProgress * 3 - 0.5)),
            transform: `translateY(${Math.max(0, 40 - (scrollProgress * 3 - 0.5) * 80)}px)`,
          }"
        >
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
              class="hero-cta-secondary"
            >
              デモを見る
              <span class="i-carbon-arrow-right" aria-hidden="true" />
            </a>
          </div>
          <p class="mt-4 text-slate-500 text-sm">
            無料・オープンソース・MITライセンス
          </p>
        </div>

        <!-- Scroll Progress Bar -->
        <div class="fixed bottom-0 left-0 right-0 h-1 bg-slate-800 z-50">
          <div
            class="h-full bg-gradient-to-r from-sky-400 to-blue-500 transition-all duration-100"
            :style="{ width: `${scrollProgress * 100}%` }"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero-scroll-reveal-site-row {
  position: relative;
  padding: 0.2em 0.14em;
}

.hero-scroll-reveal-site-row__sun {
  position: absolute;
  left: 50%;
  top: 50%;
  width: clamp(8rem, 16vw, 12.5rem);
  height: clamp(8rem, 16vw, 12.5rem);
  transform: translate(-50%, -50%);
  object-fit: contain;
  pointer-events: none;
  z-index: 0;
}

.hero-scroll-reveal-site-row__logo {
  position: relative;
  z-index: 1;
  display: inline-block;
  font-family: "Lobster", cursive;
  font-size: clamp(3.8rem, 7.2vw, 7.6rem);
  line-height: 0.95;
  letter-spacing: 0.02em;
  color: #f8fafc;
  text-shadow: 0 2px 10px rgba(15, 23, 42, 0.26), 0 0 26px rgba(14, 165, 233, 0.16);
}

.hero-scroll-reveal-bg-image {
  object-position: center center;
}

@media (max-width: 639.98px) {
  .hero-scroll-reveal-bg-layer {
    opacity: 0.56 !important;
  }

  .hero-scroll-reveal-tone-layer {
    background: linear-gradient(135deg, rgba(248, 250, 252, 0.42), rgba(241, 245, 249, 0.22), rgba(248, 250, 252, 0.46)) !important;
  }

  .dark .hero-scroll-reveal-tone-layer {
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.52), rgba(15, 23, 42, 0.22), rgba(15, 23, 42, 0.58)) !important;
  }

  .hero-scroll-reveal-glow-layer {
    background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.14), transparent 42%), radial-gradient(circle at bottom right, rgba(14, 165, 233, 0.06), transparent 38%) !important;
  }

  .dark .hero-scroll-reveal-glow-layer {
    background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.04), transparent 42%), radial-gradient(circle at bottom right, rgba(14, 165, 233, 0.08), transparent 38%) !important;
  }
  .hero-scroll-reveal-site-row__sun {
    width: 7.6rem;
    height: 7.6rem;
  }

  .hero-scroll-reveal-site-row__logo {
    font-size: clamp(3.1rem, 14vw, 4.8rem);
  }

  .hero-scroll-reveal-bg-image {
    object-position: 70% center;
  }
}
</style>

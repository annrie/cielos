<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const scrollProgress = ref(0)
const sectionRef = ref<HTMLElement | null>(null)
const heroImage = ref('')

function handleScroll() {
  if (!sectionRef.value) return
  const rect = sectionRef.value.getBoundingClientRect()
  const sectionHeight = sectionRef.value.offsetHeight
  const viewportHeight = window.innerHeight

  if (rect.top < viewportHeight && rect.bottom > 0) {
    const progress = Math.min(1, Math.max(0, (viewportHeight - rect.top) / (viewportHeight + sectionHeight)))
    scrollProgress.value = progress
  }
}

onMounted(() => {
  heroImage.value = props.themeUri
    ? `${props.themeUri}/src/assets/images/hero/light-hero.webp`
    : ''
  requestAnimationFrame(() => {
    isVisible.value = true
  })
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()
})

onUnmounted(() => {
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
    <div class="sticky top-0 min-h-[100vh] flex items-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
      <!-- Background Image with Scroll Parallax -->
      <div
        class="absolute inset-0 transition-opacity duration-300"
        :style="{ opacity: 0.15 + scrollProgress * 0.2 }"
      >
        <img
          v-if="heroImage"
          :src="heroImage"
          alt=""
          class="w-full h-full object-cover"
        >
      </div>

      <!-- Content -->
      <div class="relative z-10 w-full max-w-6xl mx-auto px-6 py-20">
        <!-- Top Section: Always Visible -->
        <div
          class="text-center mb-16 transition-all duration-1000 ease-out"
          :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <h1 class="text-5xl md:text-7xl lg:text-8xl font-800 text-white leading-none mb-6">
            {{ siteName || 'Cielos' }}
          </h1>
          <p class="text-xl text-slate-400 max-w-2xl mx-auto">
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
            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white/5 border border-white/10"
            :style="{
              opacity: Math.min(1, Math.max(0, (scrollProgress * 5) - (i * 0.3))),
              transform: `translateY(${Math.max(0, 20 - (scrollProgress * 5 - i * 0.3) * 40)}px)`,
            }"
          >
            <span :class="tech.icon" class="text-lg text-sky-400" aria-hidden="true" />
            <span class="text-sm text-white/80 font-500">{{ tech.name }}</span>
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
          <a
            href="#"
            class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-2xl font-600 text-lg shadow-xl shadow-sky-500/20 hover:shadow-sky-500/40 hover:scale-105 transition-all duration-300"
          >
            <span class="i-carbon-download" aria-hidden="true" />
            今すぐダウンロード
          </a>
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

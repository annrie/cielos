<script setup lang="ts">
import { onMounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const heroImage = ref('')

onMounted(() => {
  heroImage.value = props.themeUri
    ? `${props.themeUri}/src/assets/images/hero/light-hero-4.png`
    : ''
  requestAnimationFrame(() => {
    isVisible.value = true
  })
})

const features = [
  { icon: 'i-carbon-code', title: 'Vue 3対応', desc: 'Composition APIとTypeScriptで型安全' },
  { icon: 'i-carbon-paint-brush', title: 'UnoCSS', desc: 'アトミックCSSで高速スタイリング' },
  { icon: 'i-carbon-lightning', title: '超高速', desc: 'Viteビルドで瞬時のHMR' },
]
</script>

<template>
  <section class="relative min-h-[100vh] overflow-hidden flex items-center justify-center">
    <!-- Background Image -->
    <div class="absolute inset-0">
      <img
        v-if="heroImage"
        :src="heroImage"
        alt=""
        class="w-full h-full object-cover"
      >
      <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" />
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-6xl mx-auto px-6 py-20">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <!-- Left: Text -->
        <div
          class="transition-all duration-1000 ease-out"
          :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <h1 class="text-5xl md:text-6xl lg:text-7xl font-800 text-white leading-[1.05] mb-6">
            {{ siteName || 'Cielos' }}
          </h1>
          <p class="text-xl text-white/80 mb-8 leading-relaxed">
            {{ tagline || '透明感のあるデザインと、最新のフロントエンド技術が融合した WordPress テーマ。' }}
          </p>
          <a
            href="#"
            class="inline-flex items-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-md border border-white/30 text-white rounded-2xl font-600 text-lg hover:bg-white/30 transition-all duration-300 shadow-lg"
          >
            <span class="i-carbon-download" aria-hidden="true" />
            無料で始める
          </a>
        </div>

        <!-- Right: Glass Cards -->
        <div
          class="space-y-4 transition-all duration-1000 delay-300 ease-out"
          :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
        >
          <div
            v-for="(feature, i) in features"
            :key="i"
            class="group p-6 rounded-2xl bg-white/10 backdrop-blur-lg border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-default"
            :style="{ transitionDelay: `${(i + 2) * 150}ms` }"
          >
            <div class="flex items-start gap-4">
              <div class="shrink-0 w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                <span :class="feature.icon" class="text-2xl text-white" aria-hidden="true" />
              </div>
              <div>
                <h3 class="text-lg font-600 text-white mb-1">{{ feature.title }}</h3>
                <p class="text-white/70 text-sm leading-relaxed">{{ feature.desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

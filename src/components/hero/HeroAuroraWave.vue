<script setup lang="ts">
import { onMounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const sunDarkImage = ref('')

onMounted(() => {
  sunDarkImage.value = props.themeUri
    ? `${props.themeUri}/src/assets/images/hero-sun-dark.png`
    : ''
  requestAnimationFrame(() => {
    isVisible.value = true
  })
})
</script>

<template>
  <section class="relative min-h-[100vh] bg-[#0f172a] overflow-hidden flex items-center justify-center">
    <!-- Aurora Waves -->
    <div class="absolute inset-0">
      <div class="hero-aurora hero-aurora-1" />
      <div class="hero-aurora hero-aurora-2" />
      <div class="hero-aurora hero-aurora-3" />
    </div>

    <!-- Sun Image -->
    <div
      class="absolute top-[10%] right-[10%] w-40 h-40 md:w-56 md:h-56 transition-all duration-2000 ease-out"
      :class="isVisible ? 'opacity-50 scale-100' : 'opacity-0 scale-80'"
    >
      <img
        v-if="sunDarkImage"
        :src="sunDarkImage"
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

        <h1 class="text-5xl md:text-7xl lg:text-8xl font-800 leading-none mb-6">
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-cyan-300 to-blue-400">
            {{ siteName || 'Cielos' }}
          </span>
        </h1>

        <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
          {{ tagline || 'オーロラのように美しく、波のように流れるデザイン。自然の神秘をウェブに閉じ込めた。' }}
        </p>

        <!-- Feature Pills -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
          <span class="px-4 py-2 rounded-full text-sm font-500 bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">
            Vue 3 Composition API
          </span>
          <span class="px-4 py-2 rounded-full text-sm font-500 bg-cyan-500/10 text-cyan-300 border border-cyan-500/20">
            TypeScript
          </span>
          <span class="px-4 py-2 rounded-full text-sm font-500 bg-blue-500/10 text-blue-300 border border-blue-500/20">
            WordPress REST API
          </span>
        </div>

        <!-- CTA -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a
            href="#"
            class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-600 text-lg hover:opacity-90 transition-all duration-300 shadow-lg shadow-emerald-500/20"
          >
            <span class="i-carbon-download" aria-hidden="true" />
            ダウンロード
          </a>
          <a
            href="#"
            class="inline-flex items-center gap-2 px-8 py-4 bg-white/5 border border-white/10 text-white/80 rounded-xl font-600 text-lg hover:bg-white/10 transition-all duration-300"
          >
            <span class="i-carbon-logo-github" aria-hidden="true" />
            GitHub
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
</style>

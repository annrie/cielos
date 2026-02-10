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
  <section class="relative min-h-[100vh] overflow-hidden flex items-center justify-center">
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
      class="relative z-10 text-center px-6 max-w-4xl mx-auto transition-all duration-1000 ease-out"
      :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
    >
      <p class="text-sm tracking-[0.3em] uppercase text-white/70 mb-4 font-500">
        WordPress &times; Vue.js テーマ
      </p>
      <h1 class="text-5xl md:text-7xl lg:text-8xl font-800 text-white leading-none mb-6">
        {{ siteName || 'Cielos' }}
      </h1>
      <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
        {{ tagline || '空のように広がる可能性を、あなたのウェブサイトに。' }}
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a
          href="#"
          class="inline-flex items-center gap-2 px-8 py-4 bg-white text-gray-900 rounded-full font-600 text-lg hover:bg-white/90 transition-all duration-300 hover:scale-105 shadow-xl"
        >
          <span class="i-carbon-download" aria-hidden="true" />
          ダウンロード
        </a>
        <a
          href="#"
          class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white/40 text-white rounded-full font-600 text-lg hover:bg-white/10 transition-all duration-300"
        >
          詳しく見る
          <span class="i-carbon-arrow-right" aria-hidden="true" />
        </a>
      </div>
    </div>

    <!-- Bottom Fade -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-black/20 to-transparent" />
  </section>
</template>

<style scoped>
.hero-mesh-bg {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  animation: meshShift 8s ease-in-out infinite alternate;
}

@keyframes meshShift {
  0% { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
  33% { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
  66% { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
  100% { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
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
  background: #f093fb;
  top: -10%;
  left: -5%;
  animation: float1 12s ease-in-out infinite;
}

.hero-orb-2 {
  width: 300px;
  height: 300px;
  background: #4facfe;
  bottom: -5%;
  right: -5%;
  animation: float2 10s ease-in-out infinite;
}

.hero-orb-3 {
  width: 200px;
  height: 200px;
  background: #43e97b;
  top: 40%;
  left: 60%;
  animation: float3 14s ease-in-out infinite;
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
</style>

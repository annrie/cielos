<script setup lang="ts">
import { onMounted, ref } from 'vue'

const props = defineProps<{
  siteName?: string
  tagline?: string
  themeUri?: string
}>()

const isVisible = ref(false)
const sunLightImage = ref('')
const sunDarkImage = ref('')

// Week-based effect toggle: odd weeks = falling, even weeks = constellation
const weekNumber = Math.floor(Date.now() / (7 * 24 * 60 * 60 * 1000))
const heroEffect = weekNumber % 2 === 0 ? 'constellation' : 'falling'

onMounted(() => {
  if (props.themeUri) {
    sunLightImage.value = `${props.themeUri}/src/assets/images/hero-sun-light.png`
    sunDarkImage.value = `${props.themeUri}/src/assets/images/hero-sun-dark.png`
  }
  requestAnimationFrame(() => {
    isVisible.value = true
  })
})

// Tech icons for constellation nodes
const techIcons = [
  'i-logos-wordpress-icon',
  'i-logos-php',
  'i-logos-html-5',
  'i-logos-css-3',
  'i-logos-javascript',
  'i-logos-typescript-icon',
  'i-logos-vue',
  'i-logos-vitejs',
]

// Constellation network nodes (x,y in viewBox 1280x720 coords)
const constellationNodes = [
  { x: 180, y: 120, delay: 0.2, icon: techIcons[0] },
  { x: 350, y: 80, delay: 0.5, icon: techIcons[1] },
  { x: 520, y: 160, delay: 0.8, icon: techIcons[2] },
  { x: 700, y: 100, delay: 0.3, icon: techIcons[3] },
  { x: 880, y: 180, delay: 1.0, icon: techIcons[4] },
  { x: 1050, y: 90, delay: 0.6, icon: techIcons[5] },
  { x: 250, y: 320, delay: 1.2, icon: techIcons[6] },
  { x: 450, y: 380, delay: 0.4, icon: techIcons[7] },
  { x: 640, y: 300, delay: 0.9, icon: techIcons[0] },
  { x: 830, y: 400, delay: 0.7, icon: techIcons[1] },
  { x: 1000, y: 340, delay: 1.1, icon: techIcons[2] },
  { x: 150, y: 520, delay: 0.3, icon: techIcons[3] },
  { x: 380, y: 560, delay: 1.4, icon: techIcons[4] },
  { x: 600, y: 500, delay: 0.6, icon: techIcons[5] },
  { x: 780, y: 580, delay: 1.0, icon: techIcons[6] },
  { x: 950, y: 520, delay: 0.8, icon: techIcons[7] },
  { x: 1120, y: 450, delay: 0.5, icon: techIcons[3] },
]

// Lines connecting nodes (indices into constellationNodes)
const nodeConnections = [
  [0, 1], [1, 2], [2, 3], [3, 4], [4, 5],
  [0, 6], [6, 7], [7, 8], [8, 9], [9, 10],
  [2, 8], [3, 9], [5, 10],
  [6, 11], [11, 12], [12, 13], [13, 14], [14, 15], [15, 16],
  [7, 13], [8, 14], [10, 16],
  [1, 7], [4, 10], [9, 15],
]

const constellationLines = nodeConnections.map(([a, b], i) => ({
  x1: constellationNodes[a].x,
  y1: constellationNodes[a].y,
  x2: constellationNodes[b].x,
  y2: constellationNodes[b].y,
  delay: i * 0.12,
}))

// Falling icons data (candidate 1)
const fallingIcons = [
  { class: 'i-logos-wordpress-icon', left: '15%', delay: 0, duration: 12 },
  { class: 'i-logos-php', left: '35%', delay: 2, duration: 14 },
  { class: 'i-logos-html-5', left: '52%', delay: 4.5, duration: 11 },
  { class: 'i-logos-css-3', left: '68%', delay: 1.5, duration: 13 },
  { class: 'i-logos-javascript', left: '82%', delay: 3, duration: 10 },
  { class: 'i-logos-typescript-icon', left: '25%', delay: 6, duration: 15 },
  { class: 'i-logos-vue', left: '45%', delay: 7.5, duration: 12.5 },
  { class: 'i-logos-vitejs', left: '75%', delay: 5, duration: 11.5 },
]

const features = [
  { icon: 'i-logos-vue', title: 'Vue 3対応', desc: 'Composition APIとTypeScriptで型安全' },
  { icon: 'i-logos-unocss', title: 'UnoCSS', desc: 'アトミックCSSで高速スタイリング' },
  { icon: 'i-logos-vitejs', title: '超高速', desc: 'Viteビルドで瞬時のHMR' },
]
</script>

<template>
  <div class="hero-definitive">
    <!-- Subtitle (full-width centered) -->
    <p class="hero-definitive__subtitle" :class="isVisible ? 'is-visible' : ''">
      <span class="hero-definitive__subtitle-line" aria-hidden="true" />
      <span class="hero-definitive__subtitle-text">WordPress &times; Vue.js テーマ</span>
      <span class="hero-definitive__subtitle-line" aria-hidden="true" />
    </p>

    <!-- Effect A: Falling Tech Icons (odd weeks) -->
    <div
      v-if="heroEffect === 'falling'"
      class="hero-definitive__falling-icons"
      :class="isVisible ? 'is-visible' : ''"
      aria-hidden="true"
    >
      <span
        v-for="(icon, i) in fallingIcons"
        :key="i"
        class="hero-definitive__fall-icon"
        :class="icon.class"
        :style="{
          left: icon.left,
          animationDelay: `${icon.delay}s`,
          animationDuration: `${icon.duration}s`,
        }"
      />
    </div>

    <!-- Effect B: Constellation Network (even weeks) -->
    <div
      v-if="heroEffect === 'constellation'"
      class="hero-definitive__constellation"
      :class="isVisible ? 'is-visible' : ''"
      aria-hidden="true"
    >
      <svg
        class="hero-definitive__constellation-svg"
        viewBox="0 0 1280 720"
        preserveAspectRatio="xMidYMid slice"
      >
        <line
          v-for="(line, i) in constellationLines"
          :key="'l'+i"
          :x1="line.x1" :y1="line.y1"
          :x2="line.x2" :y2="line.y2"
          class="hero-definitive__cline"
          :style="{ animationDelay: `${line.delay}s` }"
        />
      </svg>
      <span
        v-for="(node, i) in constellationNodes"
        :key="'n'+i"
        class="hero-definitive__cnode-icon"
        :class="node.icon"
        :style="{
          left: `${(node.x / 1280) * 100}%`,
          top: `${(node.y / 720) * 100}%`,
          animationDelay: `${node.delay}s`,
        }"
      />
    </div>

    <!-- Main Content Area -->
    <div class="hero-definitive__content">
      <div
        class="hero-definitive__inner"
        :class="isVisible ? 'is-visible' : ''"
      >
        <!-- Sun Image + Title Group -->
        <div class="hero-definitive__center">
          <div class="hero-definitive__sun">
            <img
              v-if="sunLightImage"
              :src="sunLightImage"
              alt=""
              class="hero-sun-light"
            >
            <img
              v-if="sunDarkImage"
              :src="sunDarkImage"
              alt=""
              class="hero-sun-dark"
            >
          </div>
          <h1 class="hero-definitive__title font-lobster">
            {{ siteName || 'cielos' }}
          </h1>
        </div>

        <!-- Tagline -->
        <p v-if="tagline" class="hero-definitive__tagline">
          {{ tagline }}
        </p>

        <!-- Feature Pills -->
        <div class="hero-definitive__pills">
          <span class="hero-definitive__pill hero-definitive__pill--green">
            Vue 3 Composition API
          </span>
          <span class="hero-definitive__pill hero-definitive__pill--cyan">
            TypeScript
          </span>
          <span class="hero-definitive__pill hero-definitive__pill--blue">
            WordPress REST API
          </span>
        </div>

        <!-- CTA -->
        <div class="hero-definitive__cta">
          <a href="https://github.com/annrie/cielos" class="hero-definitive__btn hero-definitive__btn--primary" target="_blank" rel="noopener">
            <span class="i-carbon-download" aria-hidden="true" />
            ダウンロード
          </a>
          <a href="https://github.com/annrie/cielos" class="hero-definitive__btn hero-definitive__btn--secondary" target="_blank" rel="noopener">
            <span class="i-carbon-logo-github" aria-hidden="true" />
            GitHub
          </a>
        </div>
      </div>

      <!-- Glass Cards -->
      <div
        class="hero-definitive__cards"
        :class="isVisible ? 'is-visible' : ''"
      >
        <div
          v-for="(feature, i) in features"
          :key="i"
          class="hero-definitive__card"
          :style="{ transitionDelay: `${(i + 2) * 150}ms` }"
        >
          <div class="hero-definitive__card-icon">
            <span :class="feature.icon" class="text-2xl" aria-hidden="true" />
          </div>
          <div>
            <h3 class="hero-definitive__card-title">{{ feature.title }}</h3>
            <p class="hero-definitive__card-desc">{{ feature.desc }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Override parent .section-hero: full viewport + background crop */
:global(.section-hero) {
  min-height: 100dvh;
  display: flex;
  flex-direction: column;
  padding-block: 1rem !important;
}
:global(.section-hero .hero-definitive-mount) {
  flex: 1;
  display: flex;
  flex-direction: column;
}
:global(.section-hero::before) {
  background-position: center 65% !important;
}
@media (min-width: 768px) {
  :global(.section-hero) {
    padding-block: 1.5rem !important;
  }
}

/* Container - fits inside existing .section-hero */
.hero-definitive {
  position: relative;
  z-index: 10;
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  width: 100%;
  max-width: min(1280px, 92vw);
  margin-inline: auto;
  padding: 0.5rem 1rem;
}

@media (min-width: 768px) {
  .hero-definitive {
    padding: 1rem 1.5rem;
  }
}

/* Content layout: stacked on mobile, side-by-side on desktop */
.hero-definitive__content {
  display: flex;
  flex-direction: column;
  gap: 2.5rem;
  align-items: center;
  width: 100%;
}

@media (min-width: 1024px) {
  .hero-definitive__content {
    flex-direction: row;
    gap: 3rem;
    align-items: flex-start;
  }
}

/* Left/main column */
.hero-definitive__inner {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  opacity: 0;
  transform: translateY(1.5rem);
  transition: opacity 1s ease-out, transform 1s ease-out;
}

.hero-definitive__inner.is-visible {
  opacity: 1;
  transform: translateY(0);
}

@media (min-width: 1024px) {
  .hero-definitive__inner {
    align-items: flex-start;
    text-align: left;
  }
}

/* Sun + Title group */
.hero-definitive__center {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-bottom: clamp(3rem, 8vw, 5rem);
}

.hero-definitive__sun {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: clamp(10rem, 30vw, 22rem);
  height: clamp(10rem, 30vw, 22rem);
  pointer-events: none;
  z-index: 0;
}

.hero-definitive__sun img {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: contain;
  transition: opacity 0.5s ease;
}

/* Light/dark sun switching uses global .hero-sun-light / .hero-sun-dark
   classes from preflight/sections.ts */

/* Title */
.hero-definitive__title {
  position: relative;
  z-index: 1;
  font-family: "Lobster", cursive;
  font-size: clamp(3rem, 8vw, 5.5rem);
  font-weight: 400;
  line-height: 1.1;
  color: var(--section-hero-fg, #fff);
  text-shadow:
    0 2px 15px rgba(0,0,0,0.5),
    0 0 40px rgba(255, 255, 255, 0.4);
  letter-spacing: 0.05em;
  margin: 0;
}

/* Subtitle (full-width centered, outside content columns) */
.hero-definitive__subtitle {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  margin: 0 0 clamp(5rem, 12vw, 8rem);
  width: 100%;
  opacity: 0;
  transform: translateY(1rem);
  transition: opacity 1s ease-out, transform 1s ease-out;
}

.hero-definitive__subtitle.is-visible {
  opacity: 1;
  transform: translateY(0);
}

.hero-definitive__subtitle-line {
  flex: 0 0 clamp(1.5rem, 5vw, 3.5rem);
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6));
}

.hero-definitive__subtitle-line:last-child {
  background: linear-gradient(90deg, rgba(255,255,255,0.6), transparent);
}

.hero-definitive__subtitle-text {
  font-size: 1.02rem;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.85);
  font-weight: 500;
  text-shadow: 0 0 20px rgba(255,255,255,0.3);
  white-space: nowrap;
}

/* Tagline */
.hero-definitive__tagline {
  font-size: clamp(1rem, 2vw, 1.25rem);
  font-weight: 300;
  line-height: 1.6;
  color: rgba(255,255,255,0.85);
  margin-bottom: 1.5rem;
  max-width: 32rem;
}

/* Feature Pills */
.hero-definitive__pills {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
}

@media (min-width: 1024px) {
  .hero-definitive__pills {
    justify-content: flex-start;
  }
}

.hero-definitive__pill {
  padding: 0.4rem 0.9rem;
  border-radius: 9999px;
  font-size: 0.8rem;
  font-weight: 500;
  backdrop-filter: blur(8px);
}

.hero-definitive__pill--green {
  background: rgba(16, 185, 129, 0.15);
  color: #6ee7b7;
  border: 1px solid rgba(16, 185, 129, 0.25);
}

.hero-definitive__pill--cyan {
  background: rgba(6, 182, 212, 0.15);
  color: #67e8f9;
  border: 1px solid rgba(6, 182, 212, 0.25);
}

.hero-definitive__pill--blue {
  background: rgba(59, 130, 246, 0.15);
  color: #93c5fd;
  border: 1px solid rgba(59, 130, 246, 0.25);
}

/* CTA buttons */
.hero-definitive__cta {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

@media (min-width: 480px) {
  .hero-definitive__cta {
    flex-direction: row;
  }
}

.hero-definitive__btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.75rem;
  border-radius: 0.75rem;
  font-weight: 600;
  font-size: 1rem;
  text-decoration: none;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.hero-definitive__btn--primary {
  background: rgba(255,255,255,0.95);
  color: var(--c-primary-dark, #0369a1);
  box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.hero-definitive__btn--primary:hover {
  background: #fff;
  color: var(--c-primary, #0ea5e9);
  box-shadow: 0 6px 20px rgba(0,0,0,0.2);
  transform: translateY(-1px);
}

.hero-definitive__btn--secondary {
  background: rgba(255,255,255,0.08);
  color: rgba(255,255,255,0.85);
  border: 1px solid rgba(255,255,255,0.15);
  backdrop-filter: blur(8px);
}

.hero-definitive__btn--secondary:hover {
  background: rgba(255,255,255,0.15);
  color: #fff;
}

/* Glass Cards column */
.hero-definitive__cards {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  width: 100%;
  max-width: 24rem;
  opacity: 0;
  transform: translateY(2rem);
  transition: opacity 1s ease-out, transform 1s ease-out;
  transition-delay: 0.3s;
}

.hero-definitive__cards.is-visible {
  opacity: 1;
  transform: translateY(0);
}

@media (min-width: 1024px) {
  .hero-definitive__cards {
    flex-shrink: 0;
    width: 22rem;
  }
}

.hero-definitive__card {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.25rem;
  border-radius: 1rem;
  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(16px);
  border: 1px solid rgba(255,255,255,0.2);
  transition: background 0.3s ease, transform 0.3s ease;
  cursor: default;
}

.hero-definitive__card:hover {
  background: rgba(255,255,255,0.18);
  transform: translateY(-2px);
}

.hero-definitive__card-icon {
  flex-shrink: 0;
  width: 2.75rem;
  height: 2.75rem;
  border-radius: 0.75rem;
  background: rgba(255,255,255,0.25);
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-definitive__card-title {
  font-size: 1rem;
  font-weight: 600;
  color: #fff;
  margin: 0 0 0.2rem;
}

.hero-definitive__card-desc {
  font-size: 0.8rem;
  color: rgba(255,255,255,0.7);
  line-height: 1.5;
  margin: 0;
}

/* Falling Tech Icons (Effect A) */
.hero-definitive__falling-icons {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  pointer-events: none;
  z-index: 5;
  opacity: 0;
  transition: opacity 1.5s ease-out;
  transition-delay: 1s;
}

.hero-definitive__falling-icons.is-visible {
  opacity: 1;
}

.hero-definitive__fall-icon {
  position: absolute;
  top: -2.5rem;
  font-size: 1.5rem;
  opacity: 0;
  animation: hero-fall linear infinite;
}

@keyframes hero-fall {
  0% {
    transform: translateY(0) rotate(0deg);
    opacity: 0;
  }
  5% {
    opacity: 0.3;
  }
  85% {
    opacity: 0.25;
  }
  100% {
    transform: translateY(calc(100vh - 2rem)) rotate(45deg);
    opacity: 0;
  }
}

/* Constellation Network (Effect B) */
.hero-definitive__constellation {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 5;
  opacity: 0;
  transition: opacity 2s ease-out;
  transition-delay: 0.5s;
}

.hero-definitive__constellation.is-visible {
  opacity: 1;
}

.hero-definitive__constellation-svg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

/* Connection lines */
.hero-definitive__cline {
  stroke: rgba(255,255,255,0.15);
  stroke-width: 1;
  stroke-dasharray: 200;
  stroke-dashoffset: 200;
  animation: hero-line-draw 2s ease-out forwards;
}

@keyframes hero-line-draw {
  to {
    stroke-dashoffset: 0;
  }
}

/* Icon Nodes */
.hero-definitive__cnode-icon {
  position: absolute;
  font-size: 1.2rem;
  opacity: 0.3;
  animation: hero-icon-float 8s ease-in-out infinite;
}

.hero-definitive__cnode-icon:nth-child(odd) {
  animation-name: hero-icon-float-alt;
}

@keyframes hero-icon-float {
  0%, 100% {
    transform: translate(-50%, -50%) translateY(0) rotate(0deg);
    opacity: 0.2;
  }
  25% {
    transform: translate(-50%, -50%) translateY(-12px) translateX(6px) rotate(5deg);
    opacity: 0.35;
  }
  50% {
    transform: translate(-50%, -50%) translateY(-4px) translateX(10px) rotate(0deg);
    opacity: 0.25;
  }
  75% {
    transform: translate(-50%, -50%) translateY(-14px) translateX(3px) rotate(-3deg);
    opacity: 0.35;
  }
}

@keyframes hero-icon-float-alt {
  0%, 100% {
    transform: translate(-50%, -50%) translateY(0) rotate(0deg);
    opacity: 0.2;
  }
  25% {
    transform: translate(-50%, -50%) translateY(-8px) translateX(-8px) rotate(-5deg);
    opacity: 0.3;
  }
  50% {
    transform: translate(-50%, -50%) translateY(-16px) translateX(-4px) rotate(0deg);
    opacity: 0.25;
  }
  75% {
    transform: translate(-50%, -50%) translateY(-6px) translateX(-10px) rotate(4deg);
    opacity: 0.35;
  }
}
</style>

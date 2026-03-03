// preflight/sections.ts
import type { Preflight } from 'unocss'

/**
 * Cielos Sections Preflight
 * FoundationPressNG inspired section layout system
 */
export const preflightSections: Preflight = {
  layer: 'preflights',
  getCSS: () => `
/* ===== Section System ===== */

/* Base Section */
.section {
  position: relative;
  width: 100%;
  --section-hero-fg: #fff;
}

.dark .section {
  --section-hero-fg: #e2e8f0;
}

/* Section with container */
.section-contained {
  max-width: var(--container-w, min(1280px, 92vw));
  margin-inline: auto;
  padding-inline: 1rem;
}

@media (min-width: 768px) {
  .section-contained {
    padding-inline: 1.5rem;
  }
}

/* ===== Hero Section ===== */
.section-hero {
  position: relative;
  z-index: 1;
  min-height: 100dvh;
  display: flex;
  flex-direction: column;
  /* ヘッダーの重なりを考慮してパディングを調整 */
  padding-top: var(--header-h, 60px) !important;
  padding-bottom: 0 !important;
  background-color: var(--section-hero-bg-color, var(--c-primary));
  color: var(--section-hero-fg, #fff);
  text-align: var(--section-hero-align, left);
  overflow: hidden;
}

/* Hero background image */
.section-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image: var(--hero-bg-image);
  background-size: cover;
  background-position: center 65%;
  background-repeat: no-repeat;
  pointer-events: none;
  z-index: -1;
}

/* Hero overlay for text readability */
.section-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: var(--hero-overlay, linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.5)));
  pointer-events: none;
  z-index: 0;
}

/* アドミンバーがある場合のさらなるオフセット */
body.admin-bar .section-hero {
  padding-top: calc(var(--header-h, 60px) + 46px) !important;
}

@media (min-width: 783px) {
  body.admin-bar .section-hero {
    padding-top: calc(var(--header-h, 60px) + 32px) !important;
  }
}

/* ページ全体をヒーローのみにするための調整 */
.home #header.header-transparent,
.page-template-front #header.header-transparent {
  /* 透明ヘッダーはそのまま維持 */
}

.home footer,
.page-template-front footer {
  display: none !important; /* フロントページやFrontテンプレートではフッターを非表示 */
}

.home #cielos-back-to-top,
.page-template-front #cielos-back-to-top {
  display: none !important;
}

.section-hero .hero-showcase-mount {
  flex: 1;
  display: flex;
  flex-direction: column;
}

/* ===== Hero Definitive (Hardcoded) ===== */
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

.is-visible .hero-definitive__inner {
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

.is-visible .hero-definitive__subtitle {
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

.is-visible .hero-definitive__cards {
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

.is-visible .hero-definitive__falling-icons {
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

.is-visible .hero-definitive__constellation {
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

/* Title text - on top of icon */
.hero-title__text {
  position: relative;
  z-index: 1;
  text-shadow:
    0 2px 15px rgba(0,0,0,0.5),
    0 0 40px rgba(255, 255, 255, 0.4);
  letter-spacing: 0.05em;
  color: var(--section-hero-fg, #fff);
}

/* Sun image container - background decoration */
.hero-title__sun {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: clamp(10rem, 30vw, 25rem);
  height: clamp(10rem, 30vw, 25rem);
  z-index: 0;
  pointer-events: none;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-title__sun img {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: contain;
  transition: opacity 0.5s ease;
}

/* Light mode specific behavior */
.hero-sun-dark {
  opacity: 0;
}

.hero-sun-light {
  opacity: 1;
  filter: drop-shadow(0 0 20px rgba(255, 200, 50, 0.4));
}

/* Dark mode sun icon - golden glow */
.dark .hero-sun-light {
  opacity: 0;
}

.dark .hero-sun-dark {
  opacity: 1;
  filter: drop-shadow(0 0 30px rgba(255, 100, 0, 0.5));
}


/* ===== Intro Section ===== */
.section-intro {
  padding-block: var(--section-intro-py-sm, 3rem);
  background: var(--section-intro-bg, var(--c-bg));
}

@media (min-width: 768px) {
  .section-intro {
    padding-block: var(--section-intro-py, 4rem);
  }
}

.section-intro .fp-intro {
  max-width: var(--container-w, min(1280px, 92vw));
  margin-inline: auto;
  padding-inline: 1rem;
}

@media (min-width: 768px) {
  .section-intro .fp-intro {
    padding-inline: 1.5rem;
    max-width: 80%;
  }
}

.section-intro h2 {
  font-weight: 300;
  margin-bottom: 1.5rem;
}

.section-intro h4 {
  color: var(--c-muted, #777);
  font-size: 1.125rem;
  line-height: 1.6;
  margin-bottom: 2rem;
}

/* ===== Benefits Section ===== */
.section-benefits {
  padding-block: var(--section-benefits-py-sm, 3rem);
  background: var(--section-benefits-bg, var(--c-bg));
  text-align: center;
}

@media (min-width: 768px) {
  .section-benefits {
    padding-block: var(--section-benefits-py, 4rem);
  }
}

.section-benefits > header {
  max-width: var(--container-w, min(1280px, 92vw));
  margin-inline: auto;
  padding-inline: 1rem;
  margin-bottom: 3rem;
}

@media (min-width: 768px) {
  .section-benefits > header {
    padding-inline: 1.5rem;
  }
}

.section-benefits > header h2 {
  font-weight: 300;
  margin-bottom: 1rem;
}

.section-benefits > header h4 {
  color: var(--c-muted, #777);
  font-size: 1.125rem;
  line-height: 1.6;
}

/* ===== Section Divider ===== */
.section-divider {
  max-width: var(--container-w, min(1280px, 92vw));
  margin-inline: auto;
  padding-inline: 1rem;
  padding-block: 1rem;
}

@media (min-width: 768px) {
  .section-divider {
    padding-inline: 1.5rem;
  }
}

.section-divider hr {
  border: none;
  border-top: 1px dashed var(--c-border, #e2e8f0);
  margin: 0;
}

/* Solid variant */
.section-divider--solid hr {
  border-top-style: solid;
}

/* ===== Generic Page Section ===== */
.section-page {
  padding-block: var(--section-page-py-sm, 3rem);
  background: var(--section-page-bg, var(--c-bg));
}

@media (min-width: 768px) {
  .section-page {
    padding-block: var(--section-page-py, 4rem);
  }
}

.section-page + .section-page {
  border-top: 1px solid var(--c-border, #e2e8f0);
}

/* ===== Alternate Background ===== */
.section--alt {
  background: var(--section-alt-bg, var(--c-panel));
}

.dark .section--alt {
  background: var(--section-alt-bg-dark, var(--c-panel));
}

/* ===== CTA within sections ===== */
.section-cta {
  margin-top: 2rem;
}

.section-cta a,
.section-cta button {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}
/* Feature icons */
.feature-item__icon {
  width: 4rem;
  height: 4rem;
  margin-inline: auto;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.feature-icon {
  width: 100%;
  height: 100%;
  object-fit: contain;
  transition: transform 0.3s ease, filter 0.3s ease;
  filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
}

.feature-item:hover .feature-icon {
  transform: scale(1.1) translateY(-5px);
  filter: drop-shadow(0 8px 16px rgba(0,0,0,0.2));
}

.dark .feature-icon {
  filter: drop-shadow(0 4px 12px rgba(255,255,255,0.1));
}
`,
}

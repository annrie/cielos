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
  padding-block: 1rem !important;
  background-color: var(--section-hero-bg-color, var(--c-primary));
  color: var(--section-hero-fg, #fff);
  text-align: var(--section-hero-align, left);
  overflow: hidden;
}

.section-hero .hero-definitive-mount {
  flex: 1;
  display: flex;
  flex-direction: column;
}

@media (min-width: 768px) {
  .section-hero {
    padding-block: 1.5rem !important;
  }
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
  background: var(--hero-overlay);
  pointer-events: none;
  z-index: 0;
}

/* Hero content wrapper */
.section-hero .marketing {
  position: relative;
  z-index: 10;
  max-width: var(--container-w, min(1280px, 92vw));
  margin-inline: auto;
  padding-inline: 1rem;
  min-height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

@media (min-width: 768px) {
  .section-hero .marketing {
    padding-inline: 1.5rem;
  }
}

/* Hero tagline - slightly shifted right */
.section-hero .tagline {
  padding-left: 2rem;
}

@media (min-width: 768px) {
  .section-hero .tagline {
    padding-left: 4rem;
  }
}

@media (min-width: 1024px) {
  .section-hero .tagline {
    padding-left: 8rem;
  }
}

/* Hero title with sun icon */
.hero-title {
  position: relative;
  display: inline-block;
  font-family: "Lobster", cursive;
  font-size: clamp(3rem, 8vw, 5.5rem);
  font-weight: 400;
  line-height: 1.1;
  margin-bottom: 1rem;
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

/* Title text - on top of icon */
.hero-title__text {
  position: relative;
  z-index: 1;
  text-shadow:
    0 2px 15px rgba(0,0,0,0.5),
    0 0 40px rgba(255, 255, 255, 0.4);
  letter-spacing: 0.05em;
}


/* Hero subheader */
.section-hero .tagline .subheader {
  font-size: clamp(1rem, 2vw, 1.25rem);
  font-weight: 300;
  line-height: 1.6;
  opacity: 0.95;
  margin-bottom: 1.5rem;
}

/* CTA positioned - aligned with tagline */
.section-hero .section-cta {
  position: absolute;
  top: 13rem;
  left: 3rem;
  margin-top: 0;
}

@media (min-width: 768px) {
  .section-hero .section-cta {
    left: 5.5rem;
  }
}

@media (min-width: 1024px) {
  .section-hero .section-cta {
    left: 9.5rem;
  }
}

/* Hero CTA button styling */
.section-hero .section-cta .btn {
  background: rgba(255, 255, 255, 0.95);
  color: var(--c-primary-dark, #0369a1);
  border: none;
  backdrop-filter: blur(4px);
  font-weight: 600;
}

.section-hero .section-cta .btn:hover {
  background: #fff;
  color: var(--c-primary, #0ea5e9);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Dark mode hero button */
.dark .section-hero .section-cta .btn {
  background: rgba(255, 255, 255, 0.9);
  color: var(--c-primary-dark, #0c4a6e);
}

.dark .section-hero .section-cta .btn:hover {
  background: #fff;
  color: var(--c-primary, #0284c7);
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

// preflight/feature-grid.ts
import type { Preflight } from 'unocss'

/**
 * Cielos Feature Grid Preflight
 * FoundationPressNG inspired feature/benefits grid layout
 */
export const preflightFeatureGrid: Preflight = {
  layer: 'preflights',
  getCSS: () => `
/* ===== Feature Grid ===== */

.feature-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--feature-gap, 2rem);
  max-width: var(--container-w, min(1280px, 92vw));
  margin-inline: auto;
  padding-inline: 1rem;
}

@media (min-width: 640px) {
  .feature-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 768px) {
  .feature-grid {
    padding-inline: 1.5rem;
  }
}

@media (min-width: 1024px) {
  .feature-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

/* 3-column variant */
.feature-grid--cols-3 {
  grid-template-columns: 1fr;
}

@media (min-width: 640px) {
  .feature-grid--cols-3 {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .feature-grid--cols-3 {
    grid-template-columns: repeat(3, 1fr);
  }
}

/* ===== Feature Item ===== */

.feature-item {
  text-align: center;
  padding: var(--feature-item-padding, 1rem);
}

/* Icon container */
.feature-item__icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: var(--feature-icon-size, 4rem);
  height: var(--feature-icon-size, 4rem);
  margin: 0 auto 1rem;
  padding: 1rem;
  border-radius: var(--feature-icon-radius, 0.75rem);
  background: var(--feature-icon-bg, var(--c-primary-light, #e0f2fe));
  color: var(--feature-icon-color, var(--c-primary));
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-item:hover .feature-item__icon {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Icon SVG/image */
.feature-item__icon svg,
.feature-item__icon img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

/* UnoCSS icon support */
.feature-item__icon [class^="i-"],
.feature-item__icon [class*=" i-"] {
  font-size: 2rem;
}

/* Title */
.feature-item__title {
  font-size: var(--feature-title-fs, 1.5rem);
  font-weight: var(--feature-title-weight, 300);
  color: var(--feature-title-color, var(--c-fg));
  margin-bottom: 0.75rem;
  line-height: 1.3;
}

/* Description */
.feature-item__desc {
  font-size: var(--feature-desc-fs, 0.9375rem);
  color: var(--feature-desc-color, var(--c-muted, #777));
  line-height: 1.6;
}

/* ===== Feature Grid Footer (Why Foundation link style) ===== */

.feature-grid__footer {
  grid-column: 1 / -1;
  text-align: center;
  margin-top: 2rem;
  padding-top: 1rem;
}

.feature-grid__footer a {
  color: var(--c-primary);
  font-weight: 500;
  text-decoration: none;
  transition: color 0.2s ease;
}

.feature-grid__footer a:hover {
  color: var(--c-primary-dark);
  text-decoration: underline;
}

/* ===== Dark Mode ===== */

.dark .feature-item__icon {
  background: var(--feature-icon-bg-dark, rgba(14, 165, 233, 0.15));
}

.dark .feature-item__title {
  color: var(--feature-title-color-dark, var(--c-fg));
}

.dark .feature-item__desc {
  color: var(--feature-desc-color-dark, var(--c-muted));
}

/* ===== Compact Variant ===== */

.feature-grid--compact .feature-item {
  padding: 0.5rem;
}

.feature-grid--compact .feature-item__icon {
  width: 3rem;
  height: 3rem;
  padding: 0.5rem;
}

.feature-grid--compact .feature-item__title {
  font-size: 1.125rem;
}

.feature-grid--compact .feature-item__desc {
  font-size: 0.875rem;
}

/* ===== Card Variant ===== */

.feature-item--card {
  background: var(--card-bg, var(--c-panel));
  border: 1px solid var(--card-border, var(--c-border));
  border-radius: var(--card-radius, 0.75rem);
  padding: 1.5rem;
  transition: box-shadow 0.2s ease, transform 0.2s ease;
}

.feature-item--card:hover {
  box-shadow: var(--card-shadow-hover, 0 10px 15px -3px rgba(0,0,0,0.08));
  transform: translateY(-2px);
}

.feature-item--card .feature-item__icon {
  margin-bottom: 1.25rem;
}
`,
}

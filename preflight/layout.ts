// preflight/layout.ts
import type { Preflight } from 'unocss'

/**
 * Cielos Layout Preflight
 * トップページ: 1カラム、その他: 2カラム（モバイルスタック）
 */
export const preflightLayout: Preflight = {
  layer: 'preflights',
  getCSS: () => `
/* ===== Container ===== */
.container-page {
  width: 100%;
  max-width: var(--container-w, min(1280px, 92vw));
  margin-inline: auto;
  padding-inline: 1rem;
}

@media (min-width: 768px) {
  .container-page {
    padding-inline: 1.5rem;
  }
}

/* ===== 2-Column Layout ===== */
.layout-2col {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--layout-gap, 1.5rem);
}

@media (min-width: 1024px) {
  .layout-2col {
    grid-template-columns: 1fr var(--sidebar-w, 300px);
  }

  /* Reversed: sidebar on left */
  .layout-2col-rev {
    grid-template-columns: var(--sidebar-w, 300px) 1fr;
  }
}

/* ===== Main Content Area ===== */
.main-content {
  min-width: 0; /* Prevent overflow in grid */
  max-width: var(--content-max-w, 72ch);
}

/* Full width main content (for 1-column pages) */
.main-content-full {
  min-width: 0;
  max-width: none;
}

/* ===== Sidebar ===== */
.sidebar-area {
  min-width: 0;
}

@media (max-width: 1023px) {
  .sidebar-area {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--c-border);
  }
}

/* ===== Front Page Hero ===== */
.hero-section {
  position: relative;
  overflow: hidden;
}

.hero-section::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 50%, transparent 100%);
  pointer-events: none;
}

/* ===== Featured Posts Grid ===== */
.featured-posts .card {
  display: flex;
  flex-direction: column;
}

.featured-posts .card a:first-child {
  flex-shrink: 0;
}

/* ===== Page Sections ===== */
.page-section {
  padding-block: 3rem;
}

@media (min-width: 768px) {
  .page-section {
    padding-block: 4rem;
  }
}

.page-section + .page-section {
  border-top: 1px solid var(--c-border);
}
`,
}

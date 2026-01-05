// preflight.base.ts
import type {Preflight} from 'unocss'

/**
 * Base preflight: resets, readability, minimal layout, and accessibility.
 * Keep rules modest; rely on utilities/shortcuts for most styling.
 */
export const preflightBase: Preflight = {
  layer: 'preflights',
  getCSS: () => `

/* 一部テーマ/プラグインが挿す .nojq の min-width を無効化（幅判定を歪めるため） */
:where(.nojq){ min-width: 0 !important; }

/* ---------- Base reset (additive) ---------- */
*,*::before,*::after{box-sizing:border-box}
html:focus-within{scroll-behavior:smooth}
html{height:100%}
body{margin:0;color:var(--c-fg);background:var(--c-panel);line-height:var(--lh-normal);letter-spacing:var(--track-normal);text-rendering:optimizeLegibility;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
img,svg,video,canvas{max-width:100%;height:auto}
:focus-visible{outline:2px solid var(--c-accent);outline-offset:2px}

/* ---------- Typography scale hooks (texts use utilities for clamp) ---------- */
p{margin:1em 0}

/* ---------- Accessibility ---------- */
.screen-reader-text{
  position:absolute !important; height:1px; width:1px; overflow:hidden;
  clip:rect(1px,1px,1px,1px); white-space:nowrap; border:0; padding:0; margin:-1px;
}
.screen-reader-text:focus{
  position:static !important; height:auto; width:auto; clip:auto; white-space:normal; margin:0;
}
  `,
}

/**
 * Sticky Footer Layout
 * .site wrapper (header.php ~ footer.php)
 */
export const preflightStickyFooter: Preflight = {
  layer: 'preflights',
  getCSS: () => `
  body {
    display: flex !important;
    flex-direction: column !important;
    align-items: stretch !important;
    min-height: 100vh;
  }
  .site-wrapper {
    display: block;
    flex: 1 0 auto;
    width: 100% !important;
    max-width: none !important;
  }
  body > footer {
    flex-shrink: 0;
    width: 100%;
    margin-top: auto;
  }
  `,
}



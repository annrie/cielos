import type { Preflight } from 'unocss'

export const preflight404: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== 404 layout ===== */
:where(.error-404, #error-404){
  min-height: clamp(360px, 50vh, 640px);
  display:grid; place-items:center; padding: 2rem 1rem;
}
`,
}

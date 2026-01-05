// preflight.footer-visibility-guard.ts
import type { Preflight } from 'unocss'

export const preflightFooterVisibilityGuard: Preflight = {
  layer: 'preflights',
  getCSS: () => `
/* どんな状況でもフッターは表示させる */
@media screen{
  footer, .site-footer, #site-footer{
    display:block !important;
    visibility:visible !important;
    position:relative;
    clear:both;
  }
  /* 近傍に grid があっても、フッターはフル幅を取る */
  :is(footer, .site-footer, #site-footer){
    grid-column: 1 / -1;
  }
}
`,
}

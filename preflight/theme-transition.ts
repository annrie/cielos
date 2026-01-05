import type { Preflight } from 'unocss'

export const preflightThemeTransition: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* html に .theme-anim が付いたときだけ “色系” をやわらかく遷移 */
.theme-anim, .theme-anim *{
  transition-property: background-color, color, border-color, fill, stroke, text-decoration-color;
  transition-duration: var(--theme-anim-dur);
  transition-timing-function: var(--theme-anim-ease);
}

/* 影やレイアウトは揺らさない（重いので対象外） */
.theme-anim *{
  /* 念のため無効化（別のtransition指定があっても上書き） */
  transition-delay: 0s;
}

/* 局所的に“アニメ不要”を選べる逃げ道 */
.theme-anim .no-theme-anim, 
.theme-anim .no-theme-anim *{
  transition: none !important;
}
`,
}

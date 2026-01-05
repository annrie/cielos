import type { Preflight } from 'unocss'

export const preflightA11y: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== Focus visible: 主要インタラクティブ要素を可視化 ===== */
:where(a, button, [role="button"], input, select, textarea, summary):focus{
  outline: none;
}
:where(a, button, [role="button"], input, select, textarea, summary):focus-visible{
  box-shadow:
    0 0 0 var(--a11y-ring-offset) #0000,
    0 0 0 calc(var(--a11y-ring-offset) + 2px) var(--a11y-ring);
  border-color: transparent;
}

/* キーボード操作で見出し内アンカーが分かるよう補助 */
:where(h1,h2,h3,h4,h5,h6) a:focus-visible{
  text-decoration: underline;
  text-decoration-thickness: .12em;
  text-underline-offset: .18em;
}

/* :target（目次クリック後）をうっすら強調・印刷では無効 */
:target{
  background: var(--a11y-ring-weak);
}
@media print{
  :target{ background: transparent !important; }
}

/* 選択色（ブラウザ既定より読みやすく） */
::selection{
  background: var(--selection-bg);
  color: var(--selection-fg);
}

/* スキップリンク（キーボードで最初にフォーカス可能） */
.skip-link{
  position: fixed; left: 12px; top: 12px; z-index: 9999;
  transform: translateY(-150%);
  transition: transform .15s ease;
  padding: .5rem .75rem; border-radius: .5rem;
  background: var(--skip-bg); color: var(--skip-fg); text-decoration: none;
}
.skip-link:focus{ transform: translateY(0); }

/* 低モーション環境の配慮：大きなアニメーションを抑制 */
@media (prefers-reduced-motion: reduce){
  *, *::before, *::after{
    animation-duration: .001ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: .001ms !important;
    scroll-behavior: auto !important;
  }
}

/* SR-only（WPの .screen-reader-text 互換も一緒に） */
.sr-only, .screen-reader-text{
  position:absolute !important; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;
}
.sr-only-focusable:focus, .screen-reader-text:focus{
  position: static !important; width:auto; height:auto; margin:0; overflow:visible; clip:auto; white-space:normal;
}

/* <kbd> 表示の統一 */
kbd{
  background: var(--kbd-bg);
  color: var(--kbd-fg);
  border: 1px solid var(--kbd-bc);
  border-radius: .25rem;
  padding: .1em .35em;
  font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
  font-size: .875em;
  box-shadow: inset 0 -1px 0 rgba(0,0,0,.08);
}
`,
}

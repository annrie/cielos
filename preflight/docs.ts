// preflight.docs.ts の末尾へ（例）
import type { Preflight } from 'unocss'

const cssDocs = String.raw`
/* ===== Docs: layout ===== */
:where(.docs, #docs, body.docs) .docs-layout{
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}
@media (min-width: 1024px){
  :where(.docs, #docs, body.docs) .docs-layout{
    grid-template-columns: 260px 1fr 260px; /* sidenav | content | toc */
  }
}

/* Sticky columns */
:where(.docs, #docs, body.docs) .docs-sidenav,
:where(.docs, #docs, body.docs) .docs-toc{
  position: sticky;
  top: var(--docs-sticky-top);
  align-self: start;
}

/* Main content region spacing */
:where(.docs, #docs, body.docs) .docs-content{
  min-width: 0; /* 画像/表のあふれ対策 */
}
:where(.docs, #docs, body.docs) .docs-prose{
  line-height: var(--lh-relaxed);
}
:where(.docs, #docs, body.docs) .docs-prose > * + *{ margin-top: 1rem; }

/* Headings in content */
:where(.docs, #docs, body.docs) .docs-prose
  :where(h1,h2,h3,h4,h5,h6)
  :not([class*="heading"])
  :not(.latest-columns-title-style)
  :not(.machaki-group-title-style) {
  line-height: var(--lh-tight);
  letter-spacing: var(--track-tight);
  margin-top: 1.5rem;
  margin-bottom: .5rem;
}

/* Blockquote / Code / Pre / Table */
:where(.docs, #docs, body.docs) .docs-prose blockquote,
:where(.docs, #docs, body.docs) .docs-prose .wp-block-quote{
  position: relative;
  margin: 1rem 0;
  padding: 1.5rem 2.5rem .75rem 2.5rem;
  border-left: 3px solid var(--docs-border);
  background: var(--docs-quote-bg);
  border-radius: var(--radius-md);
  quotes: none !important;
}
/* 引用符リセット（WordPress/Gutenberg 対策） */
:where(.docs, #docs, body.docs) .docs-prose blockquote p::before,
:where(.docs, #docs, body.docs) .docs-prose blockquote p::after,
:where(.docs, #docs, body.docs) .docs-prose .wp-block-quote p::before,
:where(.docs, #docs, body.docs) .docs-prose .wp-block-quote p::after{
  content: none !important;
  display: none !important;
}
:where(.docs, #docs, body.docs) .docs-prose blockquote::before{
  content: '\f10d'; /* fa-quote-left */
  font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free', FontAwesome;
  font-weight: 900;
  position: absolute;
  top: .5rem;
  left: .75rem;
  font-size: 1.25rem;
  color: var(--c-accent, #3b82f6);
  opacity: 0.6;
}
:where(.docs, #docs, body.docs) .docs-prose blockquote::after{
  content: '\f10e'; /* fa-quote-right */
  font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free', FontAwesome;
  font-weight: 900;
  position: absolute;
  bottom: .5rem;
  right: .75rem;
  font-size: 1.25rem;
  color: var(--c-accent, #3b82f6);
  opacity: 0.6;
}
:where(.docs, #docs, body.docs) .docs-prose blockquote cite,
:where(.docs, #docs, body.docs) .docs-prose .wp-block-quote cite{
  display: block;
  margin-top: .75rem;
  padding-right: 1.5rem;
  font-size: .875rem;
  font-style: normal;
  color: var(--c-muted, #6b7280);
  text-align: right;
}
:where(.docs, #docs, body.docs) .docs-prose blockquote cite::before,
:where(.docs, #docs, body.docs) .docs-prose .wp-block-quote cite::before{
  content: '— ';
}

/* インライン引用 <q> */
:where(.docs, #docs, body.docs) .docs-prose q{
  quotes: '「' '」' '『' '』';
  font-style: normal;
  color: var(--c-fg);
}
:where(.docs, #docs, body.docs) .docs-prose q::before{
  content: open-quote;
  color: var(--c-accent, #3b82f6);
}
:where(.docs, #docs, body.docs) .docs-prose q::after{
  content: close-quote;
  color: var(--c-accent, #3b82f6);
}

:where(.docs, #docs, body.docs) .docs-prose code{
  background: color-mix(in srgb, var(--docs-code-bg) 92%, transparent);
  border: 1px solid var(--docs-border);
  padding: .1em .35em;
  border-radius: var(--radius-sm);
}
:where(.docs, #docs, body.docs) .docs-prose pre{
  background: var(--docs-code-bg);
  border: 1px solid var(--docs-border);
  border-radius: var(--radius-md);
  padding: .75rem 1rem;
  overflow: auto;
  box-shadow: var(--shadow-1);
}
:where(.docs, #docs, body.docs) .docs-prose pre code{
  background: transparent; border:0; padding:0;
}
:where(.docs, #docs, body.docs) .docs-prose hr{
  border:0; height:1px; background:var(--docs-border); margin:1.25rem 0;
}
:where(.docs, #docs, body.docs) .docs-prose table{
  width:100%; border-collapse: collapse; border:1px solid var(--docs-border);
  border-radius: var(--radius-md); overflow:hidden;
}
:where(.docs, #docs, body.docs) .docs-prose th,
:where(.docs, #docs, body.docs) .docs-prose td{
  border-bottom:1px solid var(--docs-border); padding:.5rem .75rem;
}
:where(.docs, #docs, body.docs) .docs-prose thead th{
  background: color-mix(in srgb, var(--docs-code-bg) 96%, transparent);
}

/* Sidebar/Toc base (構造のみ。見た目はショートカットで) */
:where(.docs, #docs, body.docs) .docs-sidenav .nav,
:where(.docs, #docs, body.docs) .docs-toc .toc{
  margin:0; padding:0; list-style:none;
}

/* Heading anchors: アンカーリンクを hover 時のみ可視化 */
:where(.docs, #docs, body.docs) .docs-prose :where(h2, h3, h4) .anchor{
  text-decoration: none;
  color: var(--docs-accent);
  opacity: 0;
  transition: opacity .15s ease;
}
:where(.docs, #docs, body.docs) .docs-prose :where(h2, h3, h4):hover .anchor{
  opacity: 1;
}

/* ===== Docs layout ===== */
:where(.docs, #docs, body.docs) .docs-container{
  display:grid; gap: var(--docs-gap);
  grid-template-columns: var(--docs-side-w) 1fr;
}
@media (min-width: 1280px){
  :where(.docs, #docs, body.docs) .docs-container.has-toc{
    grid-template-columns: var(--docs-side-w) 1fr var(--docs-toc-w);
  }
}
@media (max-width: 1023px){
  :where(.docs, #docs, body.docs) .docs-container{
    grid-template-columns: 1fr;
  }
}

/* 本文幅の上限を中央寄せで */
:where(.docs, #docs, body.docs) .docs-prose{
  max-width: var(--docs-max-w);
}

/* サイドナビ/TOC をスクロール時に追従 */
:where(.docs, #docs, body.docs) .docs-sidenav,
:where(.docs, #docs, body.docs) .docs-toc{
  position: sticky; top: calc(var(--header-h, 0px) + 12px);
  align-self: start;
}
`

export const preflightDocs: Preflight = {
  getCSS: () => cssDocs,
}

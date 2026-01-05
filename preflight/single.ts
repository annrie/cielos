// preflight.single.ts
import type { Preflight } from 'unocss';

const cssSingle = String.raw`
/* ===== Single: structure & base spacing ===== */

/* Hide hero-page-title on single pages */
:where(body.single, .single, #single) .hero-page-title {
  display: none;
}

/* Force entry-title to wrap */
body.single .entry-title,
.single .entry-title,
#single .entry-title {
  white-space: normal;
  word-break: break-word;
  overflow-wrap: break-word;
  display: block;
  height: auto;
  min-height: 0;
	max-height: none;
	padding: 2rem 1rem;
	text-indent: 1rem;
  box-sizing: border-box;
  line-height: 1.25;
}

/* Footer background */
body.single article footer,
.single article footer,
#single article footer {
  background-color: #f8f9fa !important;
}

html.dark body.single article footer,
html.dark .single article footer,
html.dark #single article footer {
  background-color: #1a1d22 !important;
}

:where(body.single, .single, #single) .post-header {
  margin-block: 1.25rem 1.5rem;
}

:where(body.single, .single, #single) .post-title {
  margin: 0;
}

:where(body.single, .single, #single) .post-meta {
  margin-top: .5rem;
}

:where(body.single, .single, #single) .post-hero {
  margin-block: 1rem 1.25rem;
}

:where(body.single, .single, #single) .post-hero .featured-image,
:where(body.single, .single, #single) .post-hero img {
  display: block;
  inline-size: 100%;
  block-size: auto;
  border-radius: var(--radius-lg);
  background: var(--c-panel);
  border: 1px solid var(--c-border);
  box-shadow: var(--shadow-1);
}

:where(body.single, .single, #single) .post-content {
  /* “prose” 的な余白だけ preflight で固定 */
  line-height: var(--lh-relaxed);
}

:where(body.single, .single, #single) .post-content > * + * {
  margin-top: 1rem;
}

/* headings spacing */
:where(body.single, .single, #single) .post-content
  :where(h1,h2,h3,h4,h5,h6)
  :not([class*="heading"])
  :not(.latest-columns-title-style)
  :not(.machaki-group-title-style) {
  line-height: var(--lh-tight);
  letter-spacing: var(--track-tight);
  margin-top: 1.5rem;
  margin-bottom: .5rem;
}

/* paragraphs / lists */
:where(body.single, .single, #single) .post-content p { margin: .75rem 0; }
:where(body.single, .single, #single) .post-content ul { padding-left: 1.25rem; margin: .75rem 0; }
:where(body.single, .single, #single) .post-content ol { padding-left: 1.25rem; margin: .75rem 0; }
:where(body.single, .single, #single) .post-content li + li { margin-top: .25rem; }

/* blockquote */
:where(body.single, .single, #single) .post-content blockquote,
:where(body.single, .single, #single) .post-content .wp-block-quote{
  position: relative;
  margin: 1rem 0;
  padding: 1.5rem 2.5rem .75rem 2.5rem;
  border-left: 3px solid var(--c-border);
  background: color-mix(in srgb, var(--c-panel) 90%, transparent);
  border-radius: var(--radius-md);
  quotes: none !important;
}
/* 引用符リセット（WordPress/Gutenberg 対策） */
:where(body.single, .single, #single) .post-content blockquote p::before,
:where(body.single, .single, #single) .post-content blockquote p::after,
:where(body.single, .single, #single) .post-content .wp-block-quote p::before,
:where(body.single, .single, #single) .post-content .wp-block-quote p::after{
  content: none !important;
  display: none !important;
}
:where(body.single, .single, #single) .post-content blockquote::before{
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
:where(body.single, .single, #single) .post-content blockquote::after{
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
:where(body.single, .single, #single) .post-content blockquote p{ margin: 0; }
:where(body.single, .single, #single) .post-content blockquote cite,
:where(body.single, .single, #single) .post-content .wp-block-quote cite{
  display: block;
  margin-top: .75rem;
  padding-right: 1.5rem;
  font-size: .875rem;
  font-style: normal;
  color: var(--c-muted, #6b7280);
  text-align: right;
}
:where(body.single, .single, #single) .post-content blockquote cite::before,
:where(body.single, .single, #single) .post-content .wp-block-quote cite::before{
  content: '— ';
}

/* インライン引用 <q> */
:where(body.single, .single, #single) .post-content q{
  quotes: '「' '」' '『' '』';
  font-style: normal;
  color: var(--c-fg);
}
:where(body.single, .single, #single) .post-content q::before{
  content: open-quote;
  color: var(--c-accent, #3b82f6);
}
:where(body.single, .single, #single) .post-content q::after{
  content: close-quote;
  color: var(--c-accent, #3b82f6);
}

/* code / pre */
:where(body.single, .single, #single) .post-content code{
  background: color-mix(in srgb, var(--c-panel) 92%, transparent);
  border: 1px solid var(--c-border);
  padding: .1em .35em;
  border-radius: var(--radius-sm);
}
:where(body.single, .single, #single) .post-content pre{
  background: var(--c-panel);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  padding: .75rem 1rem;
  overflow: auto;
  box-shadow: var(--shadow-1);
}
:where(body.single, .single, #single) .post-content pre code{
  background: transparent;
  border: 0;
  padding: 0;
}

/* hr / table */
:where(body.single, .single, #single) .post-content hr{
  border: 0;
  height: 1px;
  background: var(--c-border);
  margin: 1.25rem 0;
}
:where(body.single, .single, #single) .post-content table{
  width: 100%;
  border-collapse: collapse;
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  overflow: hidden;
}
:where(body.single, .single, #single) .post-content th,
:where(body.single, .single, #single) .post-content td{
  border-bottom: 1px solid var(--c-border);
  padding: .5rem .75rem;
}
:where(body.single, .single, #single) .post-content thead th{
  background: color-mix(in srgb, var(--c-panel) 96%, transparent);
}

/* figure / figcaption */
:where(body.single, .single, #single) .post-content figure{ margin: 1rem 0; }
:where(body.single, .single, #single) .post-content figcaption{
  margin-top: .5rem;
  font-size: var(--fs-sm);
  color: var(--c-muted);
  text-align: center;
}

/* links */
:where(body.single, .single, #single) .post-content a{
  color: var(--c-accent);
  text-decoration: underline;
  text-underline-offset: 2px;
}
:where(body.single, .single, #single) .post-content a:focus{
  outline: none;
  box-shadow: 0 0 0 var(--ring-width) var(--ring-color);
}
/* ===== single: structure ===== */
:where(body.single, .single, #single) .post-header{ margin: 0 0 1rem; }
:where(body.single, .single, #single) .post-title{ margin: 0; }
:where(body.single, .single, #single) .post-meta{
  display:flex; gap:.5rem .75rem; flex-wrap:wrap;
  font-size: var(--fs-sm); color: var(--single-meta-fg);
}
:where(body.single, .single, #single) .post-share{
  display:flex; gap:.5rem; flex-wrap:wrap; align-items:center;
}
:where(body.single, .single, #single) .post-hero{
  margin: 0 0 1rem; border-radius: var(--radius-lg); overflow:hidden;
}
:where(body.single, .single, #single) .post-content{ min-width:0; }

/* Post Navigation (the_post_navigation) */
:where(body.single, .single, #single) .post-navigation {
  margin: 2rem 0;
}
:where(body.single, .single, #single) .post-navigation .nav-links {
  display: grid;
  gap: 1rem;
  grid-template-columns: 1fr;
}
@media (min-width:768px){
  :where(body.single, .single, #single) .post-navigation .nav-links {
    grid-template-columns: 1fr 1fr;
  }
}
:where(body.single, .single, #single) .post-navigation .nav-previous,
:where(body.single, .single, #single) .post-navigation .nav-next {
  padding: 1rem;
  border-radius: var(--radius-md);
  background: var(--c-panel);
  border: 1px solid var(--c-border);
  transition: box-shadow 0.2s;
  position: relative;
  display: flex;
  align-items: center;
}
:where(body.single, .single, #single) .post-navigation .nav-previous:hover,
:where(body.single, .single, #single) .post-navigation .nav-next:hover {
  box-shadow: var(--shadow-2);
  background: color-mix(in srgb, var(--c-panel) 96%, transparent);
  border-color: var(--c-border);
}
:where(body.single, .single, #single) .post-navigation .nav-previous {
  text-align: left;
  justify-content: flex-start;
}
:where(body.single, .single, #single) .post-navigation .nav-previous::before {
  content: "";
  display: inline-block;
  width: 0;
  height: 0;
  border-top: 6px solid transparent;
  border-bottom: 6px solid transparent;
  border-right: 8px solid var(--c-accent);
  margin-right: 0.75rem;
  flex-shrink: 0;
}
:where(body.single, .single, #single) .post-navigation .nav-next {
  text-align: right;
  justify-content: flex-end;
}
:where(body.single, .single, #single) .post-navigation .nav-next::after {
  content: "";
  display: inline-block;
  width: 0;
  height: 0;
  border-top: 6px solid transparent;
  border-bottom: 6px solid transparent;
  border-left: 8px solid var(--c-accent);
  margin-left: 0.75rem;
  flex-shrink: 0;
}
:where(body.single, .single, #single) .post-navigation a {
  text-decoration: none;
  color: var(--c-fg);
  display: block;
}
/* ボタン全体をクリック可能に（stretched-link） */
:where(body.single, .single, #single) .post-navigation .nav-previous,
:where(body.single, .single, #single) .post-navigation .nav-next{ position: relative; }
:where(body.single, .single, #single) .post-navigation a::after{
  content: '';
  position: absolute;
  inset: 0;
  /* 透明な当たり判定。テキストは anchor 自体に表示される */
}
/* hover 時に文字が消えないよう、明示的に色を固定 */
:where(body.single, .single, #single) .post-navigation a:hover{
  color: var(--c-fg);
}

/* ダークモード時の hover 効果（背景をわずかに明るく、縁にアクセントをブレンド） */
.dark :where(body.single, .single, #single) .post-navigation .nav-previous:hover,
.dark :where(body.single, .single, #single) .post-navigation .nav-next:hover{
  background: color-mix(in srgb, var(--c-panel) 88%, transparent);
  border-color: color-mix(in srgb, var(--c-accent) 35%, transparent);
}
.dark :where(body.single, .single, #single) .post-navigation a:hover{
  color: var(--c-fg);
}
:where(body.single, .single, #single) .post-navigation .post-title {
  font-weight: bold;
  margin-top: 0.5rem;
  color: var(--c-accent);
}

/* Legacy .post-nav support */
:where(body.single, .single, #single) .post-nav{
  display:grid; gap:.75rem; grid-template-columns:1fr;
}
@media (min-width:768px){
  :where(body.single, .single, #single) .post-nav{
    grid-template-columns:1fr 1fr;
  }
}
`;

export const preflightSingle: Preflight = {
  getCSS: () => cssSingle,
};

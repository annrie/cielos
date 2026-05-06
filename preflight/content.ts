// preflight.content.ts
import type { Preflight } from 'unocss'

const css = String.raw`
/* ===== Content: structure & base spacing (page-agnostic) ===== */

/* Container classes for stable mobile display */
.machaki,
.panel {
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
  overflow-x: hidden;
}

:where(.entry-content, .page-content, .main-content) {
  line-height: var(--lh-relaxed);
}
:where(.entry-content, .page-content, .main-content) > * + * {
  margin-top: 1rem;
}

/* Headings */
:where(.entry-content, .page-content, .main-content)
  :where(h1,h2,h3,h4,h5,h6)
  :not([class*="heading"])
  :not(.latest-columns-title-style)
  :not(.machaki-group-title-style) {
  line-height: var(--lh-tight);
  letter-spacing: var(--track-tight);
  margin-top: 1.5rem;
  margin-bottom: .5rem;
}

/* Lists */
:where(.entry-content, .page-content, .main-content) ul,
:where(.entry-content, .page-content, .main-content) ol{
  padding-left: 1.25rem;
  margin: .75rem 0;
}
:where(.entry-content, .page-content, .main-content) li + li{
  margin-top: .25rem;
}

/* Blockquote */
:where(.entry-content, .page-content, .main-content) blockquote,
:where(.entry-content, .page-content, .main-content) .wp-block-quote{
  position: relative;
  margin: 1rem 0;
  padding: 1.5rem 2.5rem .75rem 2.5rem;
  border-left: 3px solid var(--c-border);
  background: var(--content-quote-bg);
  border-radius: var(--radius-md);
  quotes: none !important;
}
/* 引用符リセット（WordPress/Gutenberg 対策） */
:where(.entry-content, .page-content, .main-content) blockquote p::before,
:where(.entry-content, .page-content, .main-content) blockquote p::after,
:where(.entry-content, .page-content, .main-content) .wp-block-quote p::before,
:where(.entry-content, .page-content, .main-content) .wp-block-quote p::after{
  content: none !important;
  display: none !important;
}
:where(.entry-content, .page-content, .main-content) blockquote::before{
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
:where(.entry-content, .page-content, .main-content) blockquote::after{
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
:where(.entry-content, .page-content, .main-content) blockquote p{ margin: 0; }
:where(.entry-content, .page-content, .main-content) blockquote cite,
:where(.entry-content, .page-content, .main-content) .wp-block-quote cite{
  display: block;
  margin-top: .75rem;
  padding-right: 1.5rem;
  font-size: .875rem;
  font-style: normal;
  color: var(--c-muted, #6b7280);
  text-align: right;
}
:where(.entry-content, .page-content, .main-content) blockquote cite::before,
:where(.entry-content, .page-content, .main-content) .wp-block-quote cite::before{
  content: '— ';
}

/* インライン引用 <q> */
:where(.entry-content, .page-content, .main-content) q{
  quotes: '「' '」' '『' '』';
  font-style: normal;
  color: var(--c-fg);
}
:where(.entry-content, .page-content, .main-content) q::before{
  content: open-quote;
  color: var(--c-accent, #3b82f6);
}
:where(.entry-content, .page-content, .main-content) q::after{
  content: close-quote;
  color: var(--c-accent, #3b82f6);
}

/* Code / Pre */
:where(.entry-content, .page-content, .main-content) code{
  background: color-mix(in srgb, var(--content-code-bg) 92%, transparent);
  border: 1px solid var(--c-border);
  padding: .1em .35em;
  border-radius: var(--radius-sm);
}
:where(.entry-content, .page-content, .main-content) pre{
  background: var(--content-code-bg);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  padding: .75rem 1rem;
  overflow: auto;
  box-shadow: var(--shadow-1);
}
:where(.entry-content, .page-content, .main-content) pre code{
  background: transparent; border:0; padding:0;
}

/* HR / Table */
:where(.entry-content, .page-content, .main-content) hr{
  border:0; height:1px; background:var(--c-border); margin:1.25rem 0;
}
:where(.entry-content, .page-content, .main-content) table{
  width:100%; border-collapse: collapse; border:1px solid var(--c-border);
  border-radius: var(--radius-md); overflow:hidden;
}
:where(.entry-content, .page-content, .main-content) th,
:where(.entry-content, .page-content, .main-content) td{
  border-bottom:1px solid var(--c-border); padding:.5rem .75rem;
}
:where(.entry-content, .page-content, .main-content) thead th{
  background: color-mix(in srgb, var(--c-panel) 96%, transparent);
}

/* 外部リンクアイコン（文章中の https:// で始まるリンクに付与） */
:where(.entry-content, .page-content, .main-content) a[href^="https://"]::after{
  content: '';
  display: inline-block;
  width: .9em; height: .9em;
  margin-left: .3em;
  vertical-align: text-bottom;
  background: currentColor;
  -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='currentColor' d='M14 3h7v7h-2V6.41l-9.29 9.3-1.42-1.42 9.3-9.29H14V3z'/%3E%3Cpath fill='currentColor' d='M5 5h6v2H7v10h10v-4h2v6H5z'/%3E%3C/svg%3E") no-repeat center / contain;
  mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='currentColor' d='M14 3h7v7h-2V6.41l-9.29 9.3-1.42-1.42 9.3-9.29H14V3z'/%3E%3Cpath fill='currentColor' d='M5 5h6v2H7v10h10v-4h2v6H5z'/%3E%3C/svg%3E") no-repeat center / contain;
  opacity: .85;
}

/* Figure / Img */
:where(.entry-content, .page-content, .main-content) figure{ margin: 1rem 0; }
:where(.entry-content, .page-content, .main-content) img{
  max-width: 100%; height: auto; display: block;
  border-radius: var(--radius-md);
}

/* Footnotes (一般的なクラス名に対応) */
.footnotes{ font-size: var(--fs-sm); color: var(--c-muted); }
.footnotes hr{ display:none; }

/* ===== prose baseline ===== */
:where(.entry-content, .page-content, .main-content){
  color: var(--prose-fg);
  line-height: var(--prose-lh);
}

/* 段落とベース要素の間隔 */
:where(.entry-content, .page-content, .main-content)
  :where(p, ul, ol, pre, blockquote, table, figure){
  margin: 0 0 var(--prose-gap);
}

/* 見出し指定は "別パッチ"に任せる：ここでは触らない */
:where(.entry-content, .page-content, .main-content)
  :where(h1,h2,h3,h4,h5,h6)
  :not([class*="heading"])
  :not(.latest-columns-title-style)
  :not(.machaki-group-title-style){
  /* 余白だけ（色やサイズは触らない） */
  margin: 1.25rem 0 .5rem;
}

/* page.php の h2 に heading04-3 スタイル（僭越図書館ページと同じ） */
.page-template-default :where(.entry-content) h2:not([class*="heading"]) {
  position: relative;
  padding-top: 1.25rem;
  padding-right: 0.313rem;
  padding-bottom: 1.25rem;
  padding-left: 0.625rem;
  margin-top: 1.875rem;
  margin-right: -0.625rem;
  margin-left: -0.625rem;
  margin-bottom: 0.625rem;
  font-size: var(--latest-title-fs);
  line-height: 1.2;
  color: var(--latest-fg);
  background-image: var(--latest-bg-stack);
  border: 2px solid var(--latest-border);
  border-radius: 3px;
  box-shadow: var(--latest-inset), var(--shadow-1);
  word-break: break-word;
}

/* h2 内側の擬似要素（heading04-3 のスタイル） */
.page-template-default :where(.entry-content) h2:not([class*="heading"])::before {
  position: absolute;
  top: 100%;
  left: 1.875rem;
  width: 0;
  height: 0;
  content: '';
  border: 14px solid transparent;
  border-top: 14px solid var(--h043-bdr, var(--latest-border));
}

.page-template-default :where(.entry-content) h2:not([class*="heading"])::after {
  position: absolute;
  top: 100%;
  left: 2.063rem;
  width: 0;
  height: 0;
  content: '';
  border: 11px solid transparent;
  border-top: 11px solid var(--h043-bg, var(--latest-bg-color, #fff));
}

/* page.php の h3 に heading10 スタイル */
.page-template-default :where(.entry-content) h3:not([class*="heading"]) {
  position: relative;
  display: block;
  padding: 14px 5px 10px 50px;
  margin: 30px 20px 10px -10px;
  font-weight: 700;
  font-size: var(--hd10-fs, 1.125rem);
  line-height: 1;
  color: var(--hd10-fg);
  background: var(--hd10-bg);
  border: none;
  border-radius: 22px 0 0 22px;
}
.page-template-default :where(.entry-content) h3:not([class*="heading"])::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 14px;
  width: 20px;
  height: 20px;
  margin-top: -10px;
  background: var(--hd10-before-bg);
  border-radius: 50%;
  box-shadow: inset 1px 1px 1px #777;
}

/* Bibliography dt styling for parent page 2410 */
.parent-pageid-2410 article .entry-content dl dt {
  margin-bottom: -1px;
  padding: 0.5rem;
  background-color: #1e90ff;
  color: #fff;
  font-size: 0.875rem;
  text-shadow: 1px 1px rgba(0, 0, 0, 0.4);
}

/* Bibliography censor-button container - flex layout (限定: machaki_shorts_lists のみ) */
.parent-pageid-2410 article .entry-content :where(ul.machaki_shorts_lists, ol.machaki_shorts_lists, dl.machaki_shorts_lists dd > ul) {
  display: flex;
  flex-wrap: wrap;
  gap: 0.333rem 0.5rem; /* row-gap column-gap */
  padding-left: 0;
  margin-left: 0;
  margin-right: 0;
}

.parent-pageid-2410 article .entry-content :where(ul.machaki_shorts_lists, ol.machaki_shorts_lists, dl.machaki_shorts_lists dd > ul) > li {
  list-style-type: none;
  flex-shrink: 0;
}

/* Bibliography li > a.censor-button styling */
.parent-pageid-2410 article .entry-content li > a.censor-button {
  display: inline-block;
  padding: 0.5rem 1rem;
  background-color: #2199e8;
  color: #fff;
  font-size: 0.875rem;
  font-weight: bold;
  text-decoration: none;
  border-radius: 0.25rem;
  transition: background-color 0.2s ease, transform 0.1s ease;
}

.parent-pageid-2410 article .entry-content li > a.censor-button:hover {
  background-color: #1a7ab8;
  transform: translateY(-1px);
}

/* Genre-specific colors for censor-button (Light mode) */
/* SF - post-2412 */
article#post-2412 .entry-content li > a.censor-button {
  background-color: #4d1cff;
}
article#post-2412 .entry-content li > a.censor-button:hover {
  background-color: #3d0fcc;
}

/* 冒険小説 - post-2414 */
article#post-2414 .entry-content li > a.censor-button {
  background-color: #969;
}
article#post-2414 .entry-content li > a.censor-button:hover {
  background-color: #757;
}

/* ミステリー - post-2416 */
article#post-2416 .entry-content li > a.censor-button {
  background-color: #ed181e;
}
article#post-2416 .entry-content li > a.censor-button:hover {
  background-color: #c01318;
}

/* 時代・伝奇 - post-2418 */
article#post-2418 .entry-content li > a.censor-button {
  background-color: #2f8b20;
}
article#post-2418 .entry-content li > a.censor-button:hover {
  background-color: #256f19;
}

/* ホラー - post-2544 */
article#post-2544 .entry-content li > a.censor-button {
  background-color: #000;
}
article#post-2544 .entry-content li > a.censor-button:hover {
  background-color: #333;
}

/* 短編集 - post-2805 */
article#post-2805 .entry-content li > a.censor-button {
  background-color: #2199e8;
}
article#post-2805 .entry-content li > a.censor-button:hover {
  background-color: #1a7ab8;
}

/* Dark mode colors for censor-button */
/* SF - post-2412 */
.dark article#post-2412 .entry-content li > a.censor-button {
  background-color: #8c6aff;
}
.dark article#post-2412 .entry-content li > a.censor-button:hover {
  background-color: #a085ff;
}

/* 冒険小説 - post-2414 */
.dark article#post-2414 .entry-content li > a.censor-button {
  background-color: #9b6ba9;
}
.dark article#post-2414 .entry-content li > a.censor-button:hover {
  background-color: #ab7bb9;
}

/* ミステリー - post-2416 */
.dark article#post-2416 .entry-content li > a.censor-button {
  background-color: #d91f28;
}
.dark article#post-2416 .entry-content li > a.censor-button:hover {
  background-color: #e93f48;
}

/* 時代・伝奇 - post-2418 */
.dark article#post-2418 .entry-content li > a.censor-button {
  background-color: #2f8b20;
}
.dark article#post-2418 .entry-content li > a.censor-button:hover {
  background-color: #3fa830;
}

/* ホラー - post-2544 */
.dark article#post-2544 .entry-content li > a.censor-button {
  background-color: #666;
}
.dark article#post-2544 .entry-content li > a.censor-button:hover {
  background-color: #888;
}

/* 短編集 - post-2805 */
.dark article#post-2805 .entry-content li > a.censor-button {
  background-color: #2199e8;
}
.dark article#post-2805 .entry-content li > a.censor-button:hover {
  background-color: #3bb0ff;
}

/* リンク */
:where(.entry-content, .page-content, .main-content) a{
  color: var(--prose-link);
  text-decoration: underline;
  text-underline-offset: .15em;
}
:where(.entry-content, .page-content, .main-content) a:hover{
  color: var(--prose-link-hover);
}

/* リスト */
:where(.entry-content, .page-content, .main-content) ul,
:where(.entry-content, .page-content, .main-content) ol{
  padding-left: 1.25em;
}
:where(.entry-content, .page-content, .main-content) li{
  margin: 0 0 var(--prose-list-gap);
}

/* 引用 */
:where(.entry-content, .page-content, .main-content) blockquote{
  position: relative;
  border-left: 3px solid var(--prose-quote-bc);
  background: var(--prose-quote-bg);
  padding: 1.5rem 2.5rem .75rem 2.5rem;
  margin-left: 0; margin-right: 0;
  quotes: none !important;
}
:where(.entry-content, .page-content, .main-content) blockquote::before{
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
:where(.entry-content, .page-content, .main-content) blockquote::after{
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

/* インラインコード */
:where(.entry-content, .page-content, .main-content) :where(code):not(pre code){
  color: var(--prose-code-fg);
  background: var(--prose-code-bg);
  border: 1px solid var(--prose-code-bc);
  border-radius: .25rem;
  padding: var(--prose-code-py) var(--prose-code-px);
  font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
  font-size: .95em;
}

/* コードブロック */
:where(.entry-content, .page-content, .main-content) pre{
  background: var(--prose-code-bg);
  border: 1px solid var(--prose-code-bc);
  border-radius: .5rem;
  padding: .75rem 1rem;
  overflow: auto;
  box-shadow: var(--prose-pre-shadow);
}
:where(.entry-content, .page-content, .main-content) pre code{
  background: transparent; border: 0; padding: 0; font-size: .95em;
}

/* 区切り線 */
:where(.entry-content, .page-content, .main-content) hr{
  border: 0; border-top: 1px solid var(--prose-hr);
  margin: var(--prose-gap) 0;
}

/* テーブル（ベース） */
:where(.entry-content, .page-content, .main-content) table{
  width: 100%;
  border-collapse: collapse;
  overflow: hidden;
  border: 1px solid var(--table-bc);
  border-radius: .5rem;
  background: var(--table-bg);
}
:where(.entry-content, .page-content, .main-content) thead th{
  background: var(--table-th-bg);
}
:where(.entry-content, .page-content, .main-content) th,
:where(.entry-content, .page-content, .main-content) td{
  padding: var(--table-cell-py) var(--table-cell-px);
  border-bottom: 1px solid var(--table-bc);
}
:where(.entry-content, .page-content, .main-content) tbody tr:nth-child(odd){
  background: var(--table-stripe-bg);
}
:where(.entry-content, .page-content, .main-content) caption{
  caption-side: bottom; padding-top: .5rem;
  color: var(--table-caption-fg); font-size: .875em;
}

/* レスポンシブテーブル用のラッパ */
:where(.entry-content, .page-content, .main-content) .table-responsive{
  overflow: auto; -webkit-overflow-scrolling: touch;
}
:where(.entry-content, .page-content, .main-content) .table-responsive > table{
  min-width: 720px; /* 内容に合わせて調整可 */
}

/* 画像・figure */
:where(.entry-content, .page-content, .main-content) img{
  max-width: 100%; height: auto; display: block;
}
:where(.entry-content, .page-content, .main-content) figure{
  margin: 0 0 var(--figure-gap);
}
:where(.entry-content, .page-content, .main-content) figcaption{
  color: var(--caption-fg);
  font-size: .875em; margin-top: .35rem;
}

/* WP 互換：画像アライン */
:where(.entry-content, .page-content, .main-content) .alignleft{ float:left;  margin: .25rem 1rem .5rem 0; }
:where(.entry-content, .page-content, .main-content) .alignright{float:right; margin: .25rem 0 .5rem 1rem; }
@media (max-width: 640px){
  :where(.entry-content, .page-content, .main-content) .alignleft,
  :where(.entry-content, .page-content, .main-content) .alignright{ float:none; margin: 0 0 var(--figure-gap); }
}
`

export const preflightContent: Preflight = { getCSS: () => css }

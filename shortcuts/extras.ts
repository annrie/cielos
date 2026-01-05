import type { UserShortcuts } from 'unocss';

export const extrasShortcuts: UserShortcuts = [
['latest-columns-title-style', `
  w-full rounded-[var(--latest-radius)]
  px-[var(--latest-title-px)] py-[var(--latest-title-py)]
  text-[var(--latest-title-fs)] font-extrabold
  leading-[var(--title-lh)] tracking-[var(--title-trk)]
  [color:var(--latest-fg,#222)]
  [background-image:var(--latest-bg-stack)]
  border border-solid [border-color:var(--latest-border)]
  [box-shadow:var(--latest-inset),var(--shadow-1)]
  [&>a]:inline-flex [&>a]:items-center [&>a]:[color:inherit] [&>a>i]:mr-3
  whitespace-nowrap overflow-hidden [text-overflow:ellipsis]
  [&>a]:flex [&>a]:items-center [&>a]:no-underline [&>a]:[color:inherit]
  [&>a]:whitespace-nowrap [&>a]:overflow-hidden [&>a]:[text-overflow:ellipsis]
`],
['machaki-group-title-style', `
  relative w-full rounded-[var(--machaki-radius)]
  px-[var(--machaki-title-px)] py-[var(--machaki-title-py)]
  [background-image:var(--machaki-bg-stack)]
  border border-solid [border-color:var(--machaki-border)]
  [box-shadow:var(--machaki-inset)]
  [color:var(--machaki-fg,#2a2a2a)] text-[var(--machaki-title-fs)] font-extrabold
  leading-[var(--title-lh)] tracking-[var(--title-trk)]
  [&>a]:inline-flex [&>a]:items-center [&>a]:no-underline [&>a]:[color:inherit] [&>a>i]:mr-3
  after:absolute after:inset-0 after:rounded-[inherit]
  after:translate-y-[var(--machaki-outline-offset-y)]
  after:content-empty after:border after:border-solid
  after:[border-color:var(--machaki-outline)]
  [text-wrap:balance]
  hover:[background-image:var(--machaki-bg-stack-hover)]
  dark:hover:[background-image:var(--machaki-bg-stack-hover)]
    whitespace-nowrap overflow-hidden [text-overflow:ellipsis]
  [&>a]:flex [&>a]:items-center [&>a]:no-underline [&>a]:[color:inherit]
  [&>a]:whitespace-nowrap [&>a]:overflow-hidden [&>a]:[text-overflow:ellipsis]
`],
[
  'archive-link-button-style',
  `inline-flex items-center gap-2 no-underline
   px-[var(--archbtn-px)] py-[var(--archbtn-py)]
   rounded-[var(--archbtn-radius)]
   text-[var(--archbtn-fg)] font-semibold
   border border-solid [border-color:var(--archbtn-border)]
   [background-image:linear-gradient(to_bottom,var(--archbtn-bg-from),var(--archbtn-bg-to))]
   shadow-[var(--archbtn-shadow)]
   relative transition-all duration-200 ease-out
   before:absolute before:inset-x-0 before:top-0 before:h-[38%]
   before:rounded-t-[inherit] before:content-empty
   before:[background:linear-gradient(to_bottom,var(--archbtn-gloss),transparent)]
   [&>i]:opacity-80 [&>i]:text-[0.95em]
   hover:[background-image:linear-gradient(to_bottom,var(--archbtn-hover-from),var(--archbtn-hover-to))]
   hover:translate-y-[-0.5px]
   active:[background-image:linear-gradient(to_bottom,var(--archbtn-active-from),var(--archbtn-active-to))]
   active:translate-y-[0.5px]`
],

  ['metal-plate',   'bg-[var(--metal-grad-y)] shadow-[var(--metal-outer)]'],
  ['metal-plate-x', 'bg-[var(--metal-grad-x)] shadow-[var(--metal-outer)]'],
  ['metal-inset',   'shadow-[var(--metal-inset)]'],

  ['card-frame',    'bg-[var(--c-panel)] border border-[var(--c-border)] rounded-[var(--radius-lg)] shadow-[var(--shadow-1)] p-4'],
  ['callout-accent','relative border-l-4 pl-4 py-3 rounded-[var(--radius-md)] bg-[color-mix(in_srgb,var(--c-accent)8%,var(--c-panel))] dark:bg-[color-mix(in_srgb,var(--c-accent)10%,var(--surface-800))]'],

  ['focus-ring',    'outline-none focus-visible:outline-[var(--ring-width)] focus-visible:outline-[var(--ring-color)] focus-visible:outline-offset-[var(--ring-offset)]'],

  ['title-gradient','bg-gradient-to-r from-[var(--title-grad-from)] to-[var(--title-grad-to)] dark:from-[var(--title-grad-from)] dark:to-[var(--title-grad-to)]'],
// 追記例
['top-hero', `
  rounded-[var(--radius-lg)]
  px-5 py-4
  [background-image:var(--latest-bg-stack)]
  border border-solid [border-color:var(--archbtn-border)]
  [box-shadow:var(--latest-inset),var(--shadow-1)]
`],
['top-hero-title', `
  font-extrabold leading-[var(--lh-tight)] tracking-[var(--track-tight)]
  [color:var(--latest-fg)]
  text-[clamp(1.5rem,2.2vw+1rem,2.25rem)]
`],
['top-card', `
  rounded-[var(--radius-md)]
  bg-[var(--c-panel)] [color:var(--c-fg)]
  border border-solid [border-color:var(--c-border)]
  [box-shadow:var(--shadow-1)]
  p-3 md:p-4
  hover:[box-shadow:var(--shadow-2)]
`],
['top-meta', `[color:var(--c-muted)] text-[var(--fs-sm)] leading-[var(--lh-normal)]`],
['top-grid', `grid [grid-template-columns:repeat(auto-fill,minmax(14rem,1fr))] gap-4`],
// 既存の “machaki”/“latest” タイトルスタイルはそのまま尊重でOK

// ── Archive: カード（一覧の1件） ─────────────────────
['archive-card', `
  rounded-[var(--radius-md)]
  bg-[var(--c-panel)] [color:var(--c-fg)]
  border border-solid [border-color:var(--c-border)]
  [box-shadow:var(--shadow-1)]
  p-3 md:p-4
  hover:[box-shadow:var(--shadow-2)]
`],
['archive-card-title', `
  font-bold leading-[var(--lh-tight)]
`],
['archive-card-meta', `
  [color:var(--c-muted)] text-[var(--fs-sm)] leading-[var(--lh-normal)]
`],

// ── Archive: タイトル帯（ページ上部） ──────────────────
['archive-header', `
  rounded-[var(--radius-lg)] px-4 py-3
  [background-image:var(--latest-bg-stack)]
  border border-solid [border-color:var(--archbtn-border)]
  [box-shadow:var(--latest-inset),var(--shadow-1)]
`],
['archive-title', `
  font-extrabold leading-[var(--lh-tight)] tracking-[var(--track-tight)]
`],

// ── Archive: ページャ ────────────────────────────────
['archive-pager', `
  flex flex-wrap items-center gap-2
`],
['archive-page-link', `
  inline-flex items-center justify-center
  min-w-[2.25rem] h-[2.25rem]
  rounded-[var(--archbtn-radius)]
  [color:var(--archbtn-fg)]
  border border-solid [border-color:var(--archbtn-border)]
  [box-shadow:var(--archbtn-shadow)]
  [background-image:linear-gradient(to_bottom,var(--archbtn-gloss),transparent),linear-gradient(to_bottom,var(--archbtn-bg-from),var(--archbtn-bg-to))]
  hover:[background-image:linear-gradient(to_bottom,var(--archbtn-gloss),transparent),linear-gradient(to_bottom,var(--archbtn-hover-from),var(--archbtn-hover-to))]
  active:[background-image:linear-gradient(to_bottom,var(--archbtn-gloss),transparent),linear-gradient(to_bottom,var(--archbtn-active-from),var(--archbtn-active-to))]
`],
['archive-page-current', `
  inline-flex items-center justify-center
  min-w-[2.25rem] h-[2.25rem]
  rounded-[var(--archbtn-radius)]
  font-bold
  [color:var(--archbtn-fg)]
  border border-solid [border-color:var(--archbtn-border)]
  [box-shadow:var(--archbtn-shadow)]
  [background-image:linear-gradient(to_bottom,var(--archbtn-gloss),transparent),linear-gradient(to_bottom,var(--archbtn-hover-from),var(--archbtn-hover-to))]
`],

// ── Single: header/title/meta ─────────────────────────
['single-header', `
  mb-5
`],
['single-title', `
  font-extrabold leading-[var(--lh-tight)] tracking-[var(--track-tight)]
  text-[clamp(1.75rem,2.4vw+1rem,2.5rem)]
`],
['single-meta', `
  [color:var(--c-muted)] text-[var(--fs-sm)] leading-[var(--lh-normal)]
`],

// ── Single: hero（画像ラッパに class を付ける場合） ────
['single-hero', `
  my-4
`],

// ── Single: content helpers ───────────────────────────
['single-prose', `
  leading-[var(--lh-relaxed)]
`],
['single-hr', `
  h-px my-5 bg-[var(--c-border)]
`],

// ── Single: CTA / pager / tags（必要なら使ってください） ─
['single-cta', `
  inline-flex items-center gap-2
  px-[var(--archbtn-px)] py-[var(--archbtn-py)]
  rounded-[var(--archbtn-radius)]
  [color:var(--archbtn-fg)]
  border border-solid [border-color:var(--archbtn-border)]
  [box-shadow:var(--archbtn-shadow)]
  [background-image:linear-gradient(to_bottom,var(--archbtn-gloss),transparent),linear-gradient(to_bottom,var(--archbtn-bg-from),var(--archbtn-bg-to))]
  hover:[background-image:linear-gradient(to_bottom,var(--archbtn-gloss),transparent),linear-gradient(to_bottom,var(--archbtn-hover-from),var(--archbtn-hover-to))]
  active:[background-image:linear-gradient(to_bottom,var(--archbtn-gloss),transparent),linear-gradient(to_bottom,var(--archbtn-active-from),var(--archbtn-active-to))]
`],
['single-tags', `
  flex flex-wrap gap-2
`],
['single-tag', `
  inline-flex items-center px-2 py-1 rounded-[var(--radius-md)]
  border border-solid [border-color:var(--c-border)]
  bg-[var(--single-tag-bg)]
  text-[var(--fs-sm)] [color:var(--c-fg)]
`],
// ヒーロー枠
['single-hero', `
  rounded-[var(--radius-lg)]
  bg-[var(--single-hero-bg)]
  border border-solid [border-color:var(--single-border)]
  [box-shadow:var(--shadow-1)]
  p-3 md:p-4
`],

// タイトル直下のメタ行
['single-meta', `
  [color:var(--single-meta-fg)]
  text-[var(--fs-sm)] leading-[var(--lh-normal)]
`],

// タグ（前に修正した single-tag を使用）
['single-tags', `flex flex-wrap gap-2`],

// シェア行
['single-share', `
  flex items-center gap-2
  [color:var(--single-share-fg)]
`],

// 前後ナビ
['single-pn', `
  rounded-[var(--radius-md)]
  bg-[var(--single-pn-bg)]
  border border-solid [border-color:var(--single-border)]
  p-3 hover:[box-shadow:var(--shadow-2)]
`],
['single-pn-prev', `single-pn text-left`],
['single-pn-next', `single-pn text-right`],

// ── Biblio: card（1エントリ） ─────────────────────────
['biblio-card', `
  rounded-[var(--radius-md)]
  bg-[var(--c-panel)] [color:var(--c-fg)]
  border border-solid [border-color:var(--c-border)]
  [box-shadow:var(--shadow-1)]
  p-3 md:p-4
  hover:[box-shadow:var(--shadow-2)]
`],

['biblio-title-ui', `
  font-bold leading-[var(--lh-tight)]
`],

['biblio-meta-ui', `
  [color:var(--c-muted)] text-[var(--fs-sm)] leading-[var(--lh-normal)]
`],

['biblio-abstract-ui', `
  leading-[var(--lh-relaxed)]
`],

// ── Biblio: タグ ──────────────────────────────────────
['biblio-tags-ui', `
  flex flex-wrap gap-2
`],
['biblio-tag', `
  inline-flex items-center gap-1
  px-2 py-1 rounded-[var(--radius-md)]
  border border-solid [border-color:var(--c-border)]
  bg-[var(--biblio-tag-bg)] [color:var(--biblio-tag-fg)]
  text-[var(--fs-sm)]
`],

// ── Biblio: ヘッダー帯（任意） ────────────────────────
['biblio-header-ui', `
  rounded-[var(--radius-lg)] px-4 py-3
  [background-image:var(--latest-bg-stack)]
  border border-solid [border-color:var(--archbtn-border)]
  [box-shadow:var(--latest-inset),var(--shadow-1)]
`],

['biblio-list', 'grid gap-[var(--biblio-gap)]'],

['biblio-item', `
  rounded-[var(--radius-lg)]
  bg-[var(--biblio-item-bg)]
  border border-solid [border-color:var(--biblio-item-bc)]
  [box-shadow:var(--biblio-item-shadow)]
  hover:bg-[var(--biblio-item-bg-hover)]
  hover:[box-shadow:var(--biblio-item-shadow-hover)]
  p-3 md:p-4
`],

['biblio-key', `
  pr-3 md:pr-4 font-mono text-[var(--fs-sm)]
  [color:var(--biblio-key-fg)]
`],

['biblio-body', `min-w-0`],

['biblio-title', `
  mb-1 font-extrabold leading-[var(--lh-tight)]
  [color:var(--biblio-title-fg)]
  [&>a]:[color:inherit] [&>a]:no-underline
`],

['biblio-meta', `
  text-[var(--fs-sm)] leading-[var(--lh-normal)]
  [color:var(--biblio-meta-fg)]
`],

['biblio-badges', 'mt-2 flex flex-wrap gap-2'],
['biblio-badge', `
  inline-flex items-center gap-1 px-2 py-[2px]
  rounded-[var(--radius-sm)]
  bg-[var(--biblio-badge-bg)] [color:var(--biblio-badge-fg)]
  text-[var(--fs-xs)] font-bold
`],

/* ── Docs: パネル ─────────────────────────────────── */
['docs-panel', `
  rounded-[var(--radius-md)]
  bg-[var(--docs-surface)]
  border border-solid [border-color:var(--docs-border)]
  [box-shadow:var(--shadow-1)]
`],

/* ── Docs: Side Navigation ─────────────────────────── */
['docs-sidenav', `
  docs-panel p-3 md:p-4
  [background:var(--docs-sidenav-bg)]
`],
['docs-sidenav-item', `
  block px-2 py-1 rounded-[var(--radius-sm)]
  [color:var(--docs-sidenav-link-fg)]
  hover:bg-[var(--docs-sidenav-item-bg-hover)]
`],
['docs-sidenav-item-current', `
  block px-2 py-1 rounded-[var(--radius-sm)]
  font-bold
  [color:var(--docs-sidenav-link-fg)]
  bg-[var(--docs-sidenav-item-bg)]
`],

/* ── Docs: TOC ─────────────────────────────────────── */
['docs-toc', `
  docs-panel p-3 md:p-4
  [background:var(--docs-toc-bg)]
`],
['docs-toc-title', `
  font-bold mb-2
  [color:var(--docs-toc-title-fg)]
`],
['docs-toc-link', `
  block py-1 pl-2 rounded-[var(--radius-sm)]
  [color:var(--docs-toc-link-fg)]
  hover:bg-[var(--docs-toc-link-bg-hover)]
`],
['docs-toc-muted', `
  [color:var(--docs-toc-muted)]
`],

/* ── Docs: Content helpers ─────────────────────────── */
['docs-content', `
  max-w-[72ch] mx-auto
`],
['docs-title', `
  font-extrabold leading-[var(--lh-tight)] tracking-[var(--track-tight)]
  text-[clamp(1.75rem,2.4vw+1rem,2.5rem)]
`],
['docs-meta', `
  [color:var(--c-muted)] text-[var(--fs-sm)] leading-[var(--lh-normal)]
`],

// ── Content: prose helpers ───────────────────────────
['content-prose', `leading-[var(--lh-relaxed)]`],
['content-hr',    `h-px my-5 bg-[var(--c-border)]`],

// ── Content: コールアウト（汎用 + バリエーション） ───
['content-callout', `
  rounded-[var(--radius-md)]
  border border-solid [border-color:var(--content-callout-border)]
  [color:var(--content-callout-fg)]
  p-3 md:p-4
`],
['content-callout-note', `content-callout bg-[var(--content-note-bg)]`],
['content-callout-tip',  `content-callout bg-[var(--content-tip-bg)]`],
['content-callout-warn', `content-callout bg-[var(--content-warn-bg)]`],

// ── Content: table wrapper（はみ出し対策） ────────────
['content-table-wrap', `overflow-auto [-webkit-overflow-scrolling:touch]`],

// ── Content: figure/caption ──────────────────────────
['content-figure',     `my-4`],
['content-figcaption', `[color:var(--c-muted)] text-[var(--fs-sm)] text-center mt-2`],

// ── Content: kbd / code-inline 補助（任意） ────────────
['content-kbd', `
  inline-flex items-center gap-1
  px-2 py-[2px] rounded-[var(--radius-sm)]
  border border-solid [border-color:var(--c-border)]
  bg-[var(--content-note-bg)]
  text-[var(--fs-sm)]
`],
/* ===== Archive: cards ===== */
['archive-card', `
  rounded-[var(--radius-lg)]
  bg-[var(--archive-card-bg)]
  border border-solid [border-color:var(--archive-border)]
  [box-shadow:var(--archive-card-shadow)]
  overflow-hidden
  transition duration-200 ease-in-out
  hover:bg-[var(--archive-card-bg-hover)]
  hover:[box-shadow:var(--archive-card-shadow-hover)]
`],
['archive-card-body', `p-3 md:p-4`],
['archive-card-title', `
  mb-1 font-extrabold
  [color:var(--archive-title-fg)]
  leading-[var(--lh-tight)]
`],
['archive-card-meta', `
  [color:var(--archive-meta-fg)]
  text-[var(--fs-sm)] leading-[var(--lh-normal)]
`],
['archive-tag', `
  inline-flex items-center gap-1
  px-2 py-[2px] rounded-[var(--radius-sm)]
  bg-[var(--archive-tag-bg)] [color:var(--archive-tag-fg)]
  text-[var(--fs-sm)]
`],
['archive-badge', `
  absolute left-2 top-2 z-10
  px-2 py-[2px] rounded-[999px]
  bg-[var(--archive-badge-bg)] [color:var(--archive-badge-fg)]
  text-[var(--fs-xs)] font-bold
`],

/* ===== Archive: list rows ===== */
['archive-item', `
  rounded-[var(--radius-lg)]
  bg-[var(--archive-card-bg)]
  border border-solid [border-color:var(--archive-border)]
  [box-shadow:var(--archive-card-shadow)]
  overflow-hidden
  transition duration-200 ease-in-out
  hover:bg-[var(--archive-card-bg-hover)]
  hover:[box-shadow:var(--archive-card-shadow-hover)]
`],
['archive-item-media', `overflow-hidden rounded-l-[var(--radius-lg)]`],
['archive-item-body',  `p-3 md:p-4`],

/* ===== Archive: pagination ===== */
['pager', `flex justify-center items-center gap-2 mt-6`],
['pager-link', `
  inline-flex items-center justify-center
  min-w-9 h-9 px-3 rounded-[var(--radius-sm)]
  bg-[var(--archive-pager-bg)] [color:var(--archive-pager-fg)]
  border border-solid [border-color:var(--archive-pager-bc)]
  hover:bg-[var(--archive-card-bg-hover)]
`],
['pager-link-current', `
  inline-flex items-center justify-center
  min-w-9 h-9 px-3 rounded-[var(--radius-sm)]
  bg-[var(--archive-pager-bg-current)] [color:var(--archive-pager-fg-current)]
  border border-solid border-transparent
  font-bold
`],
['pager-gap', `opacity-60 select-none`],

/* 本文補助 */
['prose-muted',    `[color:var(--prose-muted)]`],
['prose-hr',       `my-[var(--prose-gap)] border-t border-t-[var(--prose-hr)]`],
['prose-quote',    `border-l-3 [border-left-color:var(--prose-quote-bc)] bg-[var(--prose-quote-bg)] p-3 md:p-4 rounded`],
['prose-code',     `[color:var(--prose-code-fg)] bg-[var(--prose-code-bg)] border border-solid [border-color:var(--prose-code-bc)] rounded px-[var(--prose-code-px)] py-[var(--prose-code-py)] font-mono text-[.95em]`],
['prose-pre',      `bg-[var(--prose-code-bg)] border border-solid [border-color:var(--prose-code-bc)] rounded p-4 overflow-auto shadow-[var(--prose-pre-shadow)]`],

/* テーブル */
['table-basic',    `w-full border border-solid [border-color:var(--table-bc)] rounded overflow-hidden`],
['table-striped',  `table-basic [&>tbody>tr:nth-child(odd)]:bg-[var(--table-stripe-bg)]`],
['table-responsive',`overflow-auto [&>table]:min-w-[720px] -mx-2 px-2`],

/* 画像 */
['img-fluid',      `max-w-full h-auto block`],
['img-frame',      `rounded border border-solid [border-color:var(--img-border)] shadow-[var(--img-shadow)]`],
['figure',         `my-[var(--figure-gap)]`],
['figcaption',     `[color:var(--caption-fg)] text-[.875em] mt-[.35rem]`],

/* ===== Docs: sidenav ===== */
['docs-sidenav', `
  rounded-[var(--radius-lg)]
  bg-[var(--docs-sidenav-bg)]
  border border-solid [border-color:var(--docs-sidenav-bc)]
  p-3 md:p-4
`],
['docs-sidenav-title', `mb-2 font-extrabold [color:var(--docs-sidenav-fg)]`],
['docs-sidenav-list', `m-0 p-0 list-none flex flex-col gap-1`],
['docs-sidenav-item', `
  block rounded px-3 py-2
  [color:var(--docs-sidenav-fg)]
  hover:bg-[var(--docs-sidenav-bg-hover)]
`],
['docs-sidenav-item-muted', `[color:var(--docs-sidenav-muted)]`],
['docs-sidenav-item-current', `
  block rounded px-3 py-2
  bg-[var(--docs-sidenav-bg-current)]
  [color:var(--docs-sidenav-fg-current)]
`],

/* ===== Docs: TOC ===== */
['docs-toc', `
  rounded-[var(--radius-lg)]
  bg-[var(--docs-toc-bg)]
  border border-solid [border-color:var(--docs-toc-bc)]
  p-3 md:p-4
`],
['docs-toc-title', `mb-2 font-extrabold [color:var(--docs-toc-fg)]`],
['docs-toc-list', `m-0 p-0 list-none flex flex-col gap-1`],
['docs-toc-link', `
  block rounded px-3 py-2
  [color:var(--docs-toc-fg)]
  hover:bg-[var(--docs-toc-bg-hover)]
`],
['docs-toc-link-current', `
  block rounded px-3 py-2
  [color:var(--docs-toc-accent)]
`],

/* プローズの横センター用ラッパ（必要なら） */
['docs-prose-wrap', `w-full flex justify-center`],

/* ===== Header look ===== */
['site-header', `
  bg-[var(--header-bg)] [color:var(--header-fg)]
  border-b border-b-[var(--header-bc)]
  shadow-[var(--header-shadow)]
`],
['site-header-inner', `
  w-[var(--container-w)] mx-auto min-h-[var(--header-h)]
  flex items-center justify-between gap-x-[var(--header-gap-x)] gap-y-[var(--header-gap-y)]
  px-4 py-2
`],
['site-brand', 'flex items-center gap-2 min-w-0'],
['site-brand-title', 'font-extrabold text-[1.125rem] leading-none truncate'],
['site-brand-sub',   'text-[var(--c-muted)] text-[.875rem] leading-none truncate'],

['site-nav', 'flex items-center flex-wrap gap-1'],
['site-nav-link', `
  inline-flex items-center px-3 h-9 rounded-[999px]
  [color:var(--nav-link-fg)] no-underline whitespace-nowrap
  hover:bg-[var(--nav-link-hover-bg)]
`],
['site-nav-link-current', `
  inline-flex items-center px-3 h-9 rounded-[999px]
  bg-[var(--nav-link-current-bg)] [color:var(--nav-link-current-fg)]
  font-bold no-underline
`],
['site-cta', `
  inline-flex items-center h-9 px-4 rounded-[999px]
  bg-[var(--c-accent)] [color:var(--c-fg-inv,#fff)]
  hover:brightness-110
`],

/* ===== Footer look ===== */
['site-footer', 'bg-[var(--footer-bg)] [color:var(--footer-fg)] border-t border-t-[var(--footer-bc)]'],
['site-footer-inner', 'w-[var(--container-w)] mx-auto p-4 md:p-6 grid gap-4'],
['footer-meta', 'text-[var(--fs-sm)] opacity-90'],
['footer-nav', 'flex flex-wrap gap-x-3 gap-y-2'],
['footer-nav-link', 'no-underline [color:inherit] opacity-90 hover:opacity-100'],

/* inputs */
['form-input', `
  w-full h-[var(--form-h)]
  bg-[var(--form-bg)] [color:var(--form-fg)]
  border border-solid [border-color:var(--form-bc)]
  rounded-[var(--form-radius)]
  px-[var(--form-px)] py-[var(--form-py)]
  shadow-[var(--form-shadow)]
  focus:shadow-[var(--form-shadow-focus)] focus:border-transparent
`],
['form-textarea', `
  w-full min-h-[160px] resize-y
  bg-[var(--form-bg)] [color:var(--form-fg)]
  border border-solid [border-color:var(--form-bc)]
  rounded-[var(--form-radius)]
  px-[var(--form-px)] py-[var(--form-py)]
  shadow-[var(--form-shadow)]
  focus:shadow-[var(--form-shadow-focus)] focus:border-transparent
`],
['form-select', `
  w-full h-[var(--form-h)]
  bg-[var(--form-bg)] [color:var(--form-fg)]
  border border-solid [border-color:var(--form-bc)]
  rounded-[var(--form-radius)]
  px-[var(--form-px)] py-[var(--form-py)]
  shadow-[var(--form-shadow)]
  focus:shadow-[var(--form-shadow-focus)] focus:border-transparent
`],

/* labels & help */
['form-label', 'block mb-1 font-bold'],
['form-help',  'block mt-1 text-[var(--fs-sm)] [color:var(--c-muted)]'],

/* search bar */
['search-bar', 'flex items-center gap-2'],
['search-input', 'form-input flex-1'],
['search-button', 'site-cta h-[var(--form-h)] px-4'],

/* comment form layout */
['comment-form', 'grid gap-[var(--form-gap)]'],
['form-row', 'grid gap-2 md:grid-cols-2'],

/* ===== Search: header ===== */
['search-header', 'flex flex-wrap items-baseline gap-x-3 gap-y-2'],
['search-title',  'm-0 text-[var(--search-title-fs)] leading-[var(--lh-tight)] [color:var(--search-title-fg)] font-extrabold'],
['search-meta',   '[color:var(--search-meta-fg)] text-[var(--fs-sm)]'],

/* 検索語バッジ（任意表示） */
['search-badge', `
  inline-flex items-center gap-2
  px-2 py-[2px] rounded-[999px]
  bg-[var(--search-badge-bg)] [color:var(--search-badge-fg)]
  text-[var(--fs-sm)] font-bold
`],

/* 結果リスト（行レイアウト＝archive 再利用） */
['search-list', 'grid gap-4'],
['search-item', 'archive-item'],
['search-item-media', 'archive-item-media'],
['search-item-body', 'archive-item-body'],
['search-item-title', 'archive-card-title'],
['search-item-meta', 'archive-card-meta'],

/* 0件パネル */
['search-empty', 'rounded-[var(--radius-lg)] bg-[var(--search-empty-bg)] border border-solid [border-color:var(--search-empty-bc)] p-4'],

  /* ===== Comments: reusable parts ===== */
  ['comments', ''], // ラッパの別名（必要なら）
  ['comment-list', 'grid gap-[var(--comment-gap)]'],
  ['comment', ''], // li に付ける用の空別名（保険）

  ['comment-body', `
    rounded-[var(--radius-lg)]
    bg-[var(--comment-bg)]
    border border-solid [border-color:var(--comment-bc)]
    p-3 md:p-4
    shadow-[var(--comment-shadow)]
  `],
  ['comment-meta',  `flex flex-wrap items-center gap-x-3 gap-y-2 [color:var(--comment-meta-fg)] text-[var(--fs-sm)] mb-2`],
  ['comment-author',`flex items-center gap-2 min-w-0 [color:var(--comment-author-fg)]`],
  ['comment-avatar',`rounded-full object-cover w-[var(--comment-avatar)] h-[var(--comment-avatar)] md:w-[var(--comment-avatar-md)] md:h-[var(--comment-avatar-md)]`],
  ['comment-content',``],

  /* 返信ボタン（site-cta を踏襲） */
  ['comment-reply', `
    inline-flex items-center h-8 px-3 rounded-[999px]
    bg-[var(--comment-reply-bg)] [color:var(--comment-reply-fg)]
    text-[var(--fs-sm)] no-underline hover:brightness-110
  `],

  /* ===== Breadcrumbs look ===== */
  ['breadcrumbs', `
    rounded-[var(--radius-md)]
    bg-[var(--crumb-bg)]
    border border-solid [border-color:var(--crumb-bc)]
    p-2 md:p-3
  `],
  ['crumbs', 'flex flex-wrap items-center gap-x-2 gap-y-1 m-0 p-0 list-none'],
  ['crumb',  'flex items-center gap-2'],
  ['crumb-link', `
    inline-flex items-center px-2 py-1 rounded
    no-underline [color:var(--crumb-fg)]
    hover:bg-[var(--crumb-hover-bg)] hover:[color:var(--crumb-fg-active)]
  `],
  ['crumb-current', `
    inline-flex items-center px-2 py-1 rounded font-bold
    [color:var(--crumb-fg-active)]
  `],
  ['crumb-sep', 'inline-block w-[1px] h-[1em] bg-[var(--crumb-sep)] opacity-60'],

  /* ===== 404 look ===== */
  ['error-404', 'grid place-items-center p-6'],
  ['error-panel', `
    rounded-[var(--radius-lg)]
    bg-[var(--err-panel-bg)]
    border border-solid [border-color:var(--err-panel-bc)]
    p-6 md:p-10 text-center max-w-[720px] mx-auto
  `],
  ['error-title', 'm-0 mb-2 text-[var(--err-title-fs)] font-extrabold [color:var(--err-title-fg)] leading-[var(--lh-tight)]'],
  ['error-msg',   'text-[var(--fs-md)] [color:var(--err-msg-fg)]'],
  ['error-actions','mt-4 flex flex-wrap justify-center gap-2'],

  /* ===== Sidebar & Widget look ===== */
  ['sidebar', 'grid gap-[var(--sidebar-gap)]'],
  ['sidebar-sticky', 'sticky top-[var(--sidebar-sticky-top)]'],

  ['widget', `
    rounded-[var(--radius-lg)]
    bg-[var(--sidebar-bg)]
    border border-solid [border-color:var(--sidebar-bc)]
    shadow-[var(--sidebar-shadow)]
    overflow-hidden
  `],
  ['widget-title', `
    m-0 px-3 py-2 text-[var(--widget-title-fs)] font-extrabold
    [color:var(--widget-title-fg)]
    bg-[var(--widget-title-bg)]
    border-b border-b-[var(--widget-title-bc)]
  `],
  ['widget-body', 'p-3 grid gap-[var(--widget-body-gap)]'],

  /* リスト型（カテゴリー、最近の投稿など） */
  ['widget-list', 'm-0 p-0 list-disc pl-5'],
  ['widget-link', `
    inline-flex items-center px-2 py-1 rounded
    [color:var(--widget-link-fg)] no-underline
    hover:bg-[var(--widget-link-hover-bg)]
  `],
  ['widget-meta', '[color:var(--widget-meta-fg)] text-[var(--fs-sm)]'],

  /* タグクラウド */
  ['tag-cloud', 'flex flex-wrap gap-2'],
  ['tag-chip', `
    inline-flex items-center px-2 py-[2px] rounded-[999px]
    bg-[var(--tag-bg)] [color:var(--tag-fg)]
    text-[var(--fs-sm)]
    hover:bg-[var(--tag-bg-hover)]
  `],

  /* 検索ウィジェット（フォーム基盤を流用） */
  ['widget-search', 'flex items-center gap-2 w-full'],
  ['widget-search-input', `
    flex-1 h-[var(--form-h)]
    bg-[var(--form-bg)] [color:var(--form-fg)]
    border border-solid [border-color:var(--form-bc)]
    rounded-[var(--form-radius)]
    px-[var(--form-px)] py-[var(--form-py)]
    shadow-[var(--form-shadow)]
    focus:shadow-[var(--form-shadow-focus)] focus:border-transparent
  `],
  ['widget-search-button', 'search-button flex-shrink-0'],

  ['print-hidden', '', { selector: '@media print { .print-hidden { display: none !important } }' }],
  ['print-only',  '', { selector: '@media screen { .print-only { display: none !important } }' }],
  ['print-break-before', '', { selector: '@media print { .print-break-before { page-break-before: always !important } }' }],
  ['print-break-after',  '', { selector: '@media print { .print-break-after  { page-break-after:  always !important } }' }],
  ['print-keep',         '', { selector: '@media print { .print-keep        { page-break-inside: avoid !important } }' }],
  ['print-color',        '', { selector: '@media print { .print-color      { -webkit-print-color-adjust: exact; print-color-adjust: exact } }' }],
  ['print-no-url',       '', { selector: '@media print { .print-no-url a[href]::after { content: none !important } }' }],
  ['no-link-url', ''], // a 要素自身に付けて URL 併記を抑止

  /* A11y helpers */
  ['skip-link', 'fixed left-3 top-3 z-9999 -translate-y-150% transition-transform duration-150 ease-in-out px-3 py-2 rounded bg-[var(--skip-bg)] [color:var(--skip-fg)] no-underline focus:translate-y-0'],
  ['focus-ring', 'focus-visible:shadow-[0_0_0_calc(var(--a11y-ring-offset)+2px)_var(--a11y-ring)] focus-visible:border-transparent outline-none'],

  /* コードブロックのヘッダUI（任意） */
  ['code-block', `
   relative overflow-hidden
   bg-[var(--code-bg)] border border-solid [border-color:var(--code-bc)]
   rounded-[var(--code-rd)] shadow-[var(--code-shadow)]
 `],
 ['code-header', `
   flex items-center justify-between gap-2
   px-[.6rem] py-[.4rem]
   border-b border-b-[var(--code-bc)]
   bg-[var(--code-copy-bg)] [color:var(--code-copy-fg)]
 `],
 ['code-lang', 'text-[.75rem] opacity-80'],
 ['code-copy-btn', `
   inline-flex items-center gap-[.35rem] text-[.75rem]
   border border-solid [border-color:var(--code-copy-bc)]
   rounded-[.375rem] px-2 py-1
   bg-[var(--code-copy-bg)] [color:var(--code-copy-fg)]
   hover:brightness-105
 `],
 ['code-body', 'px-[var(--code-px)] py-[var(--code-py)] overflow-auto'],

  /* ===== Related ===== */
  ['related', 'grid gap-[var(--related-gap)]'],
  ['related-title', 'm-0 text-[var(--related-title-fs)] font-extrabold [color:var(--related-title-fg)]'],
  ['related-grid', 'grid gap-[var(--related-gap)]'],
  // 中身は既存の archive-* を再利用（カード表示）
  ['related-card', 'archive-card'],
   /* archive-card-media を使わず素で記述 */
  ['related-card-media', 'block overflow-hidden'],
  ['related-card-body', 'archive-card-body'],
  ['related-card-title', 'archive-card-title'],
  ['related-card-meta', 'archive-card-meta [color:var(--related-meta-fg)]'],

  /* ===== Author box ===== */
   ['author-box', `
     grid gap-[var(--author-gap)] items-start p-4
     rounded-[var(--radius-lg)]
     bg-[var(--author-bg)] border border-solid [border-color:var(--author-bc)]
     shadow-[var(--author-shadow)]
     grid-cols-1 md:grid-cols-[auto_1fr]
  `],
  ['author-avatar', `
     rounded-full object-cover
     w-[var(--author-av-size)] h-[var(--author-av-size)]
     md:w-[var(--author-av-size-md)] md:h-[var(--author-av-size-md)]
  `],
  ['author-head', 'flex items-baseline gap-2'],
  ['author-name', 'm-0 text-[1.25rem] font-extrabold [color:var(--author-fg)] leading-[var(--lh-tight)]'],
  ['author-role', '[color:var(--author-meta)] text-[var(--fs-sm)]'],
  ['author-bio', '[color:var(--author-fg)]'],
  ['author-social', 'flex flex-wrap gap-[var(--author-social-gap)]'],
  ['author-social-link', 'inline-flex items-center gap-1 no-underline [color:var(--author-fg)] opacity-90 hover:opacity-100'],

];

import type { Preflight } from 'unocss'

export const preflightSidebar: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== Sidebar layout ===== */
:where(.sidebar, #sidebar, aside.sidebar){
  display: grid; gap: var(--sidebar-gap);
}
:where(.sidebar, #sidebar, aside.sidebar) > * {
  min-width: 0; /* grid 子要素の拡張を防止 */
}
:where(.sidebar-sticky, aside.sidebar){
  align-self: start;
}
/* sticky はデスクトップのみ */
@media (min-width: 1024px) {
  :where(.sidebar-sticky, aside.sidebar){
    position: sticky;
    top: var(--sidebar-sticky-top, calc(var(--header-h, 64px) + 32px));
  }
}

/* WP出力ベースのリセット */
:where(.widget) ul{ margin:0; padding:0 0 0 1.1em; }
:where(.widget) li{ margin: .25rem 0; }

/* 長いURL/テキストの折り返し */
:where(.sidebar, #sidebar, aside.sidebar, .widget){
  overflow-wrap: break-word;
  word-break: break-word;
}
:where(.sidebar, #sidebar, aside.sidebar, .widget) a{
  overflow-wrap: break-word;
  word-break: break-all;
}

/* 現在のページ/カテゴリをハイライト */
:where(.widget) .current_page_item > a,
:where(.widget) .current-cat > a{
  background: var(--c-accent-subtle, color-mix(in srgb, var(--c-accent) 15%, transparent));
  border-radius: .25rem;
  padding: .125rem .375rem;
  margin-left: -.375rem;
}

/* カレンダー（WP標準 .widget_calendar） */
:where(.widget_calendar) table{
  width:100%; border-collapse: collapse; border:1px solid var(--cal-bc); border-radius:.5rem; overflow:hidden;
}
:where(.widget_calendar) th, :where(.widget_calendar) td{
  padding:.4rem .5rem; text-align:center; border-bottom:1px solid var(--cal-bc);
}
:where(.widget_calendar) thead th{ background: var(--cal-th-bg); }
:where(.widget_calendar) tbody td:hover{ background: var(--cal-td-bg-hover); }

/* ===== Custom Entry Widgets (Popular/New Entries) ===== */
/* Reset default widget list styles for custom entry widgets */
:where(.cielos-entry-list){
  list-style: none !important;
  margin: 0 !important;
  padding: 0 !important;
}
:where(.cielos-entry-list) li{
  margin: 0 !important;
  padding: 0 !important;
}

/* Entry item layout */
:where(.cielos-entry-item){
  display: flex;
  gap: .75rem;
  margin-bottom: 1rem;
}
:where(.cielos-entry-item:last-child){
  margin-bottom: 0;
}

/* Thumbnail wrapper - relative positioning for rank badge */
:where(.cielos-entry-thumb-wrap){
  position: relative;
  flex-shrink: 0;
  width: 5rem;
  height: 5rem;
}

/* Rank badge positioning */
:where(.cielos-rank){
  position: absolute;
  top: 0;
  left: 0;
  width: 1.5rem;
  height: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .75rem;
  font-weight: 700;
  border-radius: .125rem;
  z-index: 10;
  box-shadow: 0 1px 2px rgba(0,0,0,.1);
}

/* Thumbnail link and image */
:where(.cielos-entry-thumb){
  display: block;
  width: 100%;
  height: 100%;
}
:where(.cielos-entry-thumb img){
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: .25rem;
}

/* Content area */
:where(.cielos-entry-content){
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
:where(.cielos-entry-title){
  font-size: var(--fs-sm, .875rem);
  font-weight: 500;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
:where(.cielos-entry-meta){
  font-size: var(--fs-xs, .75rem);
  color: var(--c-fg-muted, #666);
  margin-top: .25rem;
}
`,
}

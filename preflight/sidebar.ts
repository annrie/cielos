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
`,
}

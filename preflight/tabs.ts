import type { Preflight } from 'unocss'

/**
 * 言語別タブ切り替え UI のスタイル
 * 使用法:
 * <div class="lang-tabs">
 *   <div class="tab-item" data-tab="perl"><h3>perl</h3>...コンテンツ...</div>
 *   <div class="tab-item" data-tab="python"><h3>python</h3>...コンテンツ...</div>
 * </div>
 */
export const tabsPreflight: Preflight = {
  layer: 'components',
  getCSS: () => `
/* ===== Language Tabs Component ===== */
.lang-tabs {
  --tab-bg: var(--c-panel, #f5f5f5);
  --tab-bg-active: var(--c-bg, #fff);
  --tab-border: var(--c-border, #ddd);
  --tab-fg: var(--c-fg-muted, #666);
  --tab-fg-active: var(--c-fg, #111);
}
.dark .lang-tabs {
  --tab-bg: color-mix(in srgb, var(--c-panel) 80%, transparent);
  --tab-bg-active: var(--c-bg, #1a1a1a);
  --tab-border: var(--c-border, #444);
  --tab-fg: var(--c-fg-muted, #999);
  --tab-fg-active: var(--c-fg, #eee);
}

/* タブヘッダー（JS で生成） */
.lang-tabs-nav {
  display: flex;
  gap: 0;
  border-bottom: 1px solid var(--tab-border);
  margin-bottom: 0;
  padding: 0;
  list-style: none;
}
.lang-tabs-nav button {
  padding: 0.5rem 1.25rem;
  background: var(--tab-bg);
  border: 1px solid var(--tab-border);
  border-bottom: none;
  border-radius: 0.25rem 0.25rem 0 0;
  color: var(--tab-fg);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.15s, color 0.15s;
  margin-bottom: -1px;
}
.lang-tabs-nav button:hover {
  background: color-mix(in srgb, var(--tab-bg-active) 70%, var(--tab-bg) 30%);
}
.lang-tabs-nav button[aria-selected="true"] {
  background: var(--tab-bg-active);
  color: var(--tab-fg-active);
  border-bottom-color: var(--tab-bg-active);
}

/* タブパネル */
.lang-tabs .tab-item {
  display: none;
  padding: 1rem 0;
}
.lang-tabs .tab-item.is-active {
  display: block;
}

/* タブラベル要素は非表示（タブヘッダーとして使用済み） */
/* Gutenberg のラッパー内にあっても非表示にする */
.lang-tabs .tab-item .tab-label {
  display: none !important;
}

/* タブ内コンテンツのスタイル調整 */
.lang-tabs .tab-item > *:not(.tab-label):first-child,
.lang-tabs .tab-item > .tab-label + * {
  margin-top: 0;
}
.lang-tabs .tab-item > *:last-child {
  margin-bottom: 0;
}
`,
}

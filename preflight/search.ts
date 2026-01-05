import type { Preflight } from 'unocss'

export const preflightSearch: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== Search: layout ===== */
:where(.search, #search, body.search) .search-container{
  width: var(--container-w);
  margin-inline: auto;
  padding: 1rem;
  display: grid;
  gap: 1rem;
}

/* タイトル行 */
:where(.search, #search, body.search) .search-header{
  display: flex; flex-wrap: wrap; gap: .5rem .75rem; align-items: baseline;
}

/* 見出しサイズ（直接適用） */
:where(.search, #search, body.search) .search-title{
  font-size: var(--search-title-fs); line-height: var(--lh-tight);
  color: var(--search-title-fg); margin: 0;
}

/* 結果メタ（件数など） */
:where(.search, #search, body.search) .search-meta{
  color: var(--search-meta-fg); font-size: var(--fs-sm);
}

/* mark の見え方統一 */
:where(.search, #search, body.search) mark{
  background: var(--search-mark-bg); color: var(--search-mark-fg);
  border-radius: .25rem; padding: 0 .15em;
}

/* 0件用のパネル */
:where(.search, #search, body.search) .search-empty{
  background: var(--search-empty-bg);
  border: 1px solid var(--search-empty-bc);
  border-radius: var(--radius-lg);
  padding: 1rem;
}
`,
}

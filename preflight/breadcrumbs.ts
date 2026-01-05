import type { Preflight } from 'unocss'

export const preflightBreadcrumbs: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ========== Breadcrumb Navigation Styles ========== */

/* Breadcrumb NavXT スタイル */
.breadcrumb-navxt {
  display: inline-flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.25rem;
  font-size: 0.875rem;
  line-height: 1.5;
}

/* Breadcrumb NavXT が生成する slash を非表示 */
.breadcrumb-navxt .slash {
  display: none;
}

/* カスタムセパレーター（›）を追加 */
.breadcrumb-navxt span[property="itemListElement"]:not(:first-child)::before {
  content: '›';
  color: #9ca3af;
  margin: 0 0.375rem;
  font-weight: normal;
}

.dark .breadcrumb-navxt span[property="itemListElement"]:not(:first-child)::before {
  color: #6b7280;
}

/* パンくずリンク */
.breadcrumb-navxt a {
  color: #3b82f6;
  text-decoration: none;
  transition: color 0.2s ease;
  display: inline-flex;
  align-items: center;
  line-height: 1;
}

.breadcrumb-navxt a:hover {
  color: #2563eb;
  text-decoration: underline;
}

/* ダークモードでのリンク色 */
.dark .breadcrumb-navxt a {
  color: #60a5fa;
}

.dark .breadcrumb-navxt a:hover {
  color: #93c5fd;
}

/* ホームリンクのアイコン */
.breadcrumb-navxt a.home::before {
  content: '';
  display: inline-block;
  width: 1.125em;
  height: 1.125em;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233b82f6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'/%3E%3Cpolyline points='9 22 9 12 15 12 15 22'/%3E%3C/svg%3E");
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
  margin-right: 0.25rem;
  flex-shrink: 0;
  transform: translateY(0.15em);
}

/* ダークモードでのホームアイコン */
.dark .breadcrumb-navxt a.home::before {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2360a5fa' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'/%3E%3Cpolyline points='9 22 9 12 15 12 15 22'/%3E%3C/svg%3E");
}

/* ホームリンクのテキストを非表示（アイコンのみ表示） */
.breadcrumb-navxt a.home span[property="name"] {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}

/* 現在のページ（最後の要素） */
.breadcrumb-navxt span[property="itemListElement"]:last-child span[property="name"] {
  color: #111827;
  font-weight: 500;
}

.dark .breadcrumb-navxt span[property="itemListElement"]:last-child span[property="name"] {
  color: #e5e7eb;
}

/* レスポンシブ：モバイルではさらにコンパクトに */
@media (max-width: 640px) {
  .breadcrumb-navxt {
    font-size: 0.8125rem;
    gap: 0.25rem;
  }

  .breadcrumb-navxt span[property="itemListElement"]:not(:first-child)::before {
    margin: 0 0.25rem;
  }
}

/* レガシー breadcrumbs 構造サポート */
:where(nav.breadcrumbs, .breadcrumbs, #breadcrumbs) {
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem 0.5rem;
  align-items: center;
}

:where(nav.breadcrumbs, .breadcrumbs, #breadcrumbs) ol {
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem 0.5rem;
  margin: 0;
  padding: 0;
  list-style: none;
}

:where(nav.breadcrumbs, .breadcrumbs, #breadcrumbs) li {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

:where(nav.breadcrumbs, .breadcrumbs, #breadcrumbs) .sep {
  width: 1px;
  height: 1em;
  background: var(--crumb-sep, #9ca3af);
  opacity: 0.6;
}
`,
}

// shortcuts.compat.ts
// 互換ブリッジ：旧クラスや既存DOMセレクタ → 新ショートカットへ
// ※ "selector" 付きショートカットをサポートしている現在の設定前提（既にお使いの形式）

const compatShortcuts = [

  // ========== TOP: タイトル行 ==========
  // 旧・曖昧なクラス名 → 新スタイルに別名付与
  ['latest-title', 'latest-columns-title-style'],
  ['machaki-title', 'machaki-group-title-style'],

  // セレクタブリッジ（テンプレの DOM そのままでも当たる）
  [
    'bridge-latest-title',
    'latest-columns-title-style',
    { selector: '#latest-columns > .flex, #latest-columns .section-title, .latest .section-title' },
  ],
  [
    'bridge-machaki-title',
    'machaki-group-title-style',
    { selector: '#machaki-pickup > .flex, #machaki-pickup .section-title, .machaki .section-title' },
  ],

  // ========== ARCHIVE: カード / グリッド / ページネーション ==========
  // preflight.archive.ts と同等の挙動をユーティリティで直書き
  ['archive-grid-compat', 'grid gap-4 sm:grid-cols-2 lg:grid-cols-3'],
  ['post-list', 'grid gap-4 sm:grid-cols-2 lg:grid-cols-3'],
  ['cards', 'grid gap-4 sm:grid-cols-2 lg:grid-cols-3'],
  [
    'bridge-archive-grid',
    'archive-grid',
    { selector: '.post-list, .cards, .archive-grid--compat' },
  ],

  // カード名の揺れ
  [
    'bridge-archive-card',
    'archive-card',
    { selector: '.post-card, .card' },
  ],
  [
    'bridge-archive-card-body',
    'archive-card-body',
    { selector: '.post-card .card-body, .card__body' },
  ],
  [
    'bridge-archive-card-title',
    'archive-card-title',
    { selector: '.post-card .card-title, .card__title' },
  ],
  [
    'bridge-archive-card-meta',
    'archive-card-meta',
    { selector: '.post-card .card-meta, .card__meta' },
  ],

  // WP 標準のページネーションをブリッジ
  [
    'bridge-pager',
    'pager',
    { selector: '.pagination, .nav-links' },
  ],
  [
    'bridge-pager-link',
    'pager-link',
    { selector: '.page-numbers' },
  ],
  [
    'bridge-pager-link-current',
    'pager-link-current',
    { selector: '.page-numbers.current, .nav-links .current' },
  ],
  [
    'bridge-pager-gap',
    'pager-gap',
    { selector: '.page-numbers.dots' },
  ],

  // ========== DOCS: サイドナビ / TOC ==========
  [
    'bridge-docs-sidenav-item',
    'docs-sidenav-item',
    { selector: '.docs-sidenav a, .menu-docs a' },
  ],
  [
    'bridge-docs-sidenav-item-current',
    'docs-sidenav-item-current',
    { selector: '.docs-sidenav .is-active > a, .menu-docs .current > a' },
  ],
  [
    'bridge-docs-toc-link',
    'docs-toc-link',
    { selector: '.toc a' },
  ],
  [
    'bridge-docs-toc-link-current',
    'docs-toc-link-current',
    { selector: '.toc .is-active > a' },
  ],

  // ========== CONTENT: 汎用 ==========
  // 旧コンテンツラッパ → 新プローズ
  [
    'bridge-prose',
    'docs-prose',
    { selector: '.entry-content, .post-content, .the-content' },
  ],

  // 旧見出しクラス "headingNN-style" → 新 "headingNN"
  [/^heading(\d+)-style$/, ([, n]) => `heading${n}`],

  // 旧タグの別名
  ['tag', 'single-tag'],

  // 旧クラス → 新ショートカット
  ['header', 'site-header'],
  ['header-inner', 'site-header-inner'],
  ['gnav', 'site-nav'],
  ['gnav-link', 'site-nav-link'],
  ['gnav-link-current', 'site-nav-link-current'],

  ['footer', 'site-footer'],
  ['footer-inner', 'site-footer-inner'],
  ['footer-links', 'footer-nav'],
  ['footer-link', 'footer-nav-link'],

  ['search-field', 'search-input'],
  ['search-submit', 'search-button'],
  ['comment-form-compat', 'comment-form'], // 旧 .comment-form-wrap 等に合わせても可

  // WP の page-title / search-result / no-results → 新クラスに合流
  ['page-title', 'search-title'],
  ['search-results', 'search-list'],
  ['search-result', 'search-item'],
  ['no-results', 'search-empty'],

  // 旧テンプレの .results / .results-list なども拾っておく（任意）
  ['results', 'search-list'],
  ['results-list', 'search-list'],

  // WP 既定のマークアップをそのまま新スタイルへ
  [
    'bridge-comment-body',
    'comment-body',
    { selector: '.comment-list .comment-body' },
  ],
  [
    'bridge-comment-meta',
    'comment-meta',
    { selector: '.comment-list .comment-body .comment-meta' },
  ],
  [
    'bridge-comment-author',
    'comment-author',
    { selector: '.comment-list .comment-body .comment-author' },
  ],
  [
    'bridge-comment-avatar',
    'comment-avatar',
    { selector: '.comment-list .comment-body .comment-author .avatar' },
  ],
  [
    'bridge-comment-content',
    'comment-content',
    { selector: '.comment-list .comment-body .comment-content' },
  ],
  [
    'bridge-comment-reply',
    'comment-reply',
    { selector: '.comment-list .reply > a' },
  ],

  // よくある旧クラス名 → 新
  ['breadcrumb', 'breadcrumbs'],
  ['breadcrumb-list', 'crumbs'],
  ['breadcrumb-item', 'crumb'],
  ['breadcrumb-link', 'crumb-link'],

  // 代表的なWPウィジェットを見た目へブリッジ
  [
    'bridge-widget',
    'widget',
    { selector: '.widget' },
  ],
  [
    'bridge-widget-title',
    'widget-title',
    { selector: '.widget .widget-title, .widget .widgettitle' },
  ],
  [
    'bridge-widget-body',
    'widget-body',
    { selector: '.widget .menu, .widget ul:not(.children), .widget .textwidget, .widget .tagcloud' },
  ],
  [
    'bridge-widget-list',
    'widget-list',
    { selector: '.widget ul' },
  ],
  [
    'bridge-widget-link',
    'widget-link',
    { selector: '.widget ul a' },
  ],
  [
    'bridge-tag-cloud',
    'tag-cloud',
    { selector: '.widget .tagcloud' },
  ],
  [
    'bridge-tag-chip',
    'tag-chip',
    { selector: '.widget .tag-cloud-link' },
  ],
  [
    'bridge-widget-calendar',
    'widget', // 外枠の見た目も与える
    { selector: '.widget_calendar' },
  ],

  // WPのブロック: .wp-block-code / .wp-block-preformatted を新規ルックに
  [
    'bridge-wp-block-code',
    'code-block',
    { selector: '.wp-block-code, .wp-block-preformatted' },
  ],
  [
    'bridge-wp-block-code-body',
    'code-body',
    { selector: '.wp-block-code > pre, .wp-block-preformatted > pre' },
  ],

  // 旧クラス吸収
  ['related-posts', 'related'],
  ['related-list', 'related-grid'],
  ['related-item', 'related-card'],

  ['author', 'author-box'],
  ['author-info', 'author-bio'],
  ['author-links', 'author-social'],

]

export default compatShortcuts

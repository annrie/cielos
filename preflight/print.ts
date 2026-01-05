import type { Preflight } from 'unocss'

export const preflightPrint: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ページ余白 */
@page{ margin: var(--print-page-margin); }

/* ===== 全体の既定 ===== */
@media print{
  html, body{
    background: var(--print-bg) !important;
    color: var(--print-fg) !important;
  }

  /* 余計な装飾は排除 */
  *{
    box-shadow: none !important;
    text-shadow: none !important;
    transition: none !important;
    animation: none !important;
  }

  /* リンクはURLを併記（見出しなどは除外したい場合は .no-link-url で回避） */
  a[href]:not(.no-link-url)::after{
    content: " (" attr(href) ")";
    font-weight: normal;
  }

  /* UI系は非表示（ヘッダー/フッター/サイド/ナビ/パンくず/ページネーション等） */
  header, .site-header, #site-header,
  footer, .site-footer, #site-footer,
  nav, .breadcrumbs, #breadcrumbs,
  aside, .sidebar, #sidebar,
  .docs-sidenav, .docs-toc,
  .pager, .site-cta,
  .no-print{
    display: none !important;
  }

  /* 本文は横幅制限を解除して紙面に合わせる */
  .docs-prose-wrap, .docs-prose, .post-content, .entry, .content, #content{
    max-width: none !important;
    color: var(--print-fg) !important;
    line-height: var(--print-lh);
  }

  /* 背景は基本 off。必要箇所は .print-color を付けて許可 */
  .print-color{
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
  /* 逆に “背景消したい” 指定 */
  .print-no-bg{
    background: transparent !important;
  }

  /* 段落・基本ブロックの余白 */
  p, ul, ol, pre, blockquote, table, figure{
    margin: 0 0 var(--print-gap) 0;
    color: var(--print-fg);
  }
  small, .prose-muted{ color: var(--print-muted) !important; }

  /* 見出し（サイズはそのまま、色だけ黒へ） */
  h1,h2,h3,h4,h5,h6{
    color: var(--print-fg) !important;
    page-break-after: avoid;
  }

  /* 引用・コード */
  blockquote{
    border-left: 3px solid var(--print-border);
    background: #fff;
    padding: .75rem 1rem;
  }
  code, kbd{
    background: var(--print-code-bg);
    border: 1px solid var(--print-code-bc);
    border-radius: .25rem;
    padding: .1em .25em;
  }
  pre{
    background: var(--print-code-bg);
    border: 1px solid var(--print-code-bc);
    border-radius: .5rem;
    padding: .75rem 1rem;
    white-space: pre-wrap; /* 折り返して読めるように */
  }

  /* 画像/図版 */
  img, svg, video, canvas{
    max-width: 100% !important;
    height: auto !important;
    page-break-inside: avoid;
  }
  figure{ page-break-inside: avoid; }
  figcaption{ color: var(--print-muted) !important; }

  /* テーブル（見出しを各ページに再掲） */
  table{
    width: 100%;
    border-collapse: collapse;
    border: 1px solid var(--print-border);
  }
  thead{ display: table-header-group; }
  tfoot{ display: table-footer-group; }
  th, td{
    border-bottom: 1px solid var(--print-border);
    padding: .5rem .75rem;
  }
  thead th{
    background: var(--print-table-th);
  }

  /* ページ分割の制御 */
  .print-break-before{ page-break-before: always !important; }
  .print-break-after{  page-break-after:  always !important; }
  .print-keep{ page-break-inside: avoid !important; }

  /* WP互換：アライン解除（紙面で崩れないように） */
  .alignleft, .alignright{
    float: none !important;
    margin: 0 0 var(--print-gap) 0 !important;
  }
}
`,
}

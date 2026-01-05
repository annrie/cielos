// preflight.mobile-menu.ts
import type { Preflight } from 'unocss'

export const preflightMobileMenu: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ========== モバイル (<1024px) 専用 ========== */
@media (max-width:1023.98px){

  /* ========== 基本構造 ========== */
  /* PCナビは必ず退場（重複防止） */
  header nav#menu{ display:none !important; }
  #header-desktop{ display:none !important; }

  /* モバイルヘッダ／メニューは必ず表示 */
  #header-mobile{
    display:flex !important;
    align-items:center !important;
    justify-content:space-between !important;
  }

  /* モバイルメニュー：初期状態は非表示 */
  #mobile-menu{
    display:none !important;
    width:100% !important;
    overflow:visible !important;
    max-height:none !important;
    height:auto !important;
  }

  /* data-open属性がついた時のみ表示 */
  #mobile-menu[data-open]{
    display:block !important;
  }

  /* ========== 重複メニュー徹底除去 ========== */
  /* WPが nav 外に素の縦ULを出す場合は消す */
  header ul.vertical.menu:not(#mobile-menu ul),
  header ul.vertical.menu:not(#mobile-menu *),
  header > ul.vertical.menu,
  nav > ul.vertical.menu:not(#mobile-menu ul),
  body > ul.vertical.menu,
  main > ul.vertical.menu,
  .site-header > ul.vertical.menu,
  header .top-bar ul:not(#mobile-menu ul),
  header .menu:not(#mobile-menu .menu),
  header nav ul:not(#mobile-menu ul),
  header ul:not(#mobile-menu ul):not(#mobile-menu > ul):not(#mobile-menu *){
    display:none !important;
    visibility:hidden !important;
    opacity:0 !important;
  }

  /* ========== ハンバーガーボタン ========== */
  [data-toggle="mobile-menu"]{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    width:2.25rem !important;
    height:2.25rem !important;
    background-color:rgba(255,255,255,0.1) !important;
    border-radius:0.375rem !important;
    color:white !important;
  }
  [data-toggle="mobile-menu"]:hover{
    background-color:rgba(255,255,255,0.15) !important;
  }
  [data-toggle="mobile-menu"] svg{ color:currentColor !important; }

  /* ========== トップUL：data-open制御 ========== */
  #mobile-menu > ul,
  #mobile-menu > div > ul{
    display:none !important;
  }

  #mobile-menu[data-open] > ul,
  #mobile-menu[data-open] > div > ul{
    display:block !important;
    text-align:left !important;
    justify-content:flex-start !important;
    align-items:flex-start !important;
  }

  /* すべてのUL・LI要素を左揃え強制 */
  #mobile-menu ul,
  #mobile-menu ul ul{
    text-align:left !important;
    display:block !important;
  }

  /* ========== メニューアイテム基本スタイル ========== */
  #mobile-menu li{
    display:block !important;
    text-align:left !important;
    overflow:visible !important;
    max-height:none !important;
    height:auto !important;
    position:relative !important;
    min-height:48px !important;
    background:transparent !important;
    background-color:transparent !important;
    border:none !important;
    box-shadow:none !important;
    border-radius:0 !important;
  }

  #mobile-menu a{
    text-align:left !important;
    justify-content:flex-start !important;
    align-items:flex-start !important;
    background:transparent !important;
    background-color:transparent !important;
    border:none !important;
    box-shadow:none !important;
    border-radius:0 !important;
    text-align:left !important;
    display:flex !important;
    width:100% !important;
  }

  /* ========== Walker 構造対応 ========== */
  /* コンテナ（div）：すべてのパターン */
  #mobile-menu li > div,
  #mobile-menu li[aria-expanded] > div,
  #mobile-menu li.has-submenu > div,
  #mobile-menu li.menu-item-has-children > div{
    display:flex !important;
    flex-direction:row !important;
    align-items:center !important;
    justify-content:space-between !important;
    width:100% !important;
    min-height:3rem !important;
    padding:0 0.5rem !important;
    margin:0 !important;
    box-sizing:border-box !important;
    flex-wrap:nowrap !important;
  }

  /* ラベル（リンク）：flex成長 */
  #mobile-menu li > div > a,
  #mobile-menu li > div > a.submenu-label,
  #mobile-menu a.submenu-label{
    flex:1 1 auto !important;
    display:block !important;
    text-align:left !important;
    padding:0.75rem 0.5rem !important;
    margin:0 !important;
    color:inherit !important;
    text-decoration:none !important;
    min-width:0 !important;
    overflow:hidden !important;
    text-overflow:ellipsis !important;
    white-space:nowrap !important;
    order:1 !important;
  }

  /* トグルボタン：flex固定 */
  #mobile-menu button,
  #mobile-menu .submenu-toggle,
  #mobile-menu .submenu-toggle-icon,
  #mobile-menu button[aria-controls],
  #mobile-menu li > div > button,
  #mobile-menu li > button,
  #mobile-menu li[aria-expanded] > div > button{
    flex:0 0 auto !important;
    flex-shrink:0 !important;
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    width:2.5rem !important;
    height:2.5rem !important;
    background:rgba(255,255,255,0.1) !important;
    border:1px solid rgba(255,255,255,0.2) !important;
    border-radius:0.375rem !important;
    padding:0 !important;
    margin:0 !important;
    color:white !important;
    cursor:pointer !important;
    transition:background-color 0.2s ease !important;
    z-index:10 !important;
    align-self:center !important;
    order:2 !important;
    float:none !important;
    position:static !important;
    transform:none !important;
    vertical-align:middle !important;
  }

  #mobile-menu li > div{
    display:flex !important;
  }

  #mobile-menu li > div > *{
    display:block !important;
  }

  #mobile-menu li > div > button,
  #mobile-menu li > div > .submenu-toggle-icon{
    display:inline-flex !important;
  }

  #mobile-menu .submenu-toggle:hover,
  #mobile-menu .submenu-toggle-icon:hover{
    background:rgba(255,255,255,0.15) !important;
  }

  /* Chevron回転 */
  #mobile-menu .submenu-toggle-icon .chev,
  #mobile-menu .submenu-toggle .chev{
    transition:transform 0.2s ease !important;
  }

  #mobile-menu li[aria-expanded="true"] > div > .submenu-toggle-icon .chev,
  #mobile-menu li[aria-expanded="true"] > div > .submenu-toggle .chev{
    transform:rotate(180deg) !important;
  }

  /* ========== サブメニュー：完全にクリーンなスタイル ========== */
  #mobile-menu ul ul,
  #mobile-menu .menu .menu,
  #mobile-menu .vertical .vertical{
    display:none !important;
    visibility:hidden !important;
    opacity:0 !important;
    height:0 !important;
    max-height:0 !important;
    min-height:0 !important;
    overflow:hidden !important;
    flex-direction:column !important;
    padding:0 !important;
    padding-left:0 !important;
    margin:0 !important;
    background:transparent !important;
    background-color:transparent !important;
    box-shadow:none !important;
    border:none !important;
    border-radius:0 !important;
    width:0 !important;
    list-style:none !important;
    position:absolute !important;
    top:0 !important;
    left:-9999px !important;
    transform:none !important;
    float:none !important;
    pointer-events:none !important;
  }

  /* サブメニューが表示される時は確実にblock表示 */
  #mobile-menu ul ul[style*="display: block"],
  #mobile-menu ul ul[style*="display: flex"]{
    display:block !important;
  }

  /* サブメニューリストアイテム（縦間隔を適正に縮小） */
  #mobile-menu ul ul li,
  #mobile-menu .menu .menu li,
  #mobile-menu .vertical .vertical li{
    background:transparent !important;
    background-color:transparent !important;
    border:none !important;
    box-shadow:none !important;
    border-radius:0 !important;
    margin:0 !important;
    padding:0.125rem 0 !important; /* 以前: 0.25rem 0 */
    min-height:auto !important;    /* 親の min-height:48px を打ち消す */
    list-style:none !important;
    position:relative !important;
    text-align:left !important;
    display:block !important;
  }

  /* サブメニュー行の器(div)も背高を抑える */
  #mobile-menu ul ul li > div{
    min-height:2rem !important;    /* 以前: 3rem */
    padding-left:0.25rem !important;
    padding-right:0.25rem !important;
  }

  /* サブメニューリンク（上下の余白をやや詰める） */
  #mobile-menu ul ul a,
  #mobile-menu .menu .menu a,
  #mobile-menu .vertical .vertical a{
    background:transparent !important;
    background-color:transparent !important;
    color:inherit !important;
    padding:0.375rem 0.5rem !important;  /* 以前: 0.5rem 1rem */
    line-height:1.2 !important;
    border:none !important;
    box-shadow:none !important;
    border-radius:0 !important;
    text-decoration:none !important;
    display:block !important;
    width:100% !important;
    text-align:left !important;
  }

  /* メインメニューリンクも統一 */
  #mobile-menu > ul > li > a,
  #mobile-menu > div > ul > li > a{
    background:transparent !important;
    background-color:transparent !important;
    border:none !important;
    box-shadow:none !important;
    border-radius:0 !important;
    text-align:left !important;
    justify-content:flex-start !important;
    align-items:center !important;
    display:flex !important;
    width:100% !important;
    padding:0.75rem 1rem !important;
    position:relative !important;
    z-index:1 !important;
  }

  /* 現在地（current）をデスクトップ同様に強調 */
  #mobile-menu li.current-menu-item > a,
  #mobile-menu li.current_page_item > a,
  #mobile-menu li.current-menu-item > div > a,
  #mobile-menu li.current_page_item > div > a{
    background-color: var(--header-active-bg) !important;
    color: var(--header-active-fg) !important;
    border-radius: .375rem !important;
  }

  /* サブメニューを持つLI要素 */
  #mobile-menu li[aria-expanded]{
    position:relative !important;
    display:block !important;
    text-align:left !important;
    overflow:visible !important;
    padding:0 !important;
    margin:0 !important;
    width:100% !important;
  }

  /* サブメニューを持つLI内のdiv - 幅固定 */
  #mobile-menu li[aria-expanded] > div{
    width:100% !important;
    max-width:100% !important;
  }

  /* aria-expanded時に表示（強化版、サブULの内側余白を控えめに） */
  #mobile-menu li[aria-expanded="true"] > ul,
  #mobile-menu li[aria-expanded="true"] > .menu,
  #mobile-menu li[aria-expanded="true"] > .vertical{
    display:block !important;
    visibility:visible !important;
    opacity:1 !important;
    height:auto !important;
    max-height:none !important;
    min-height:auto !important;
    overflow:visible !important;
    width:100% !important;
    padding-left:1.25rem !important;   /* 以前: 1.5rem */
    padding-top:0.25rem !important;    /* 以前: 0.5rem */
    padding-bottom:0.25rem !important; /* 以前: 0.5rem */
    margin:0 !important;
    position:relative !important;
    top:0 !important;
    left:0 !important;
    right:auto !important;
    bottom:auto !important;
    transform:none !important;
    pointer-events:auto !important;
    text-align:left !important;
    align-items:flex-start !important;
    justify-content:flex-start !important;
    box-sizing:border-box !important;
  }

  /* 確実な初期非表示 */
  #mobile-menu li[aria-expanded="false"] > ul,
  #mobile-menu li[aria-expanded="false"] > .menu,
  #mobile-menu li[aria-expanded="false"] > .vertical,
  #mobile-menu li:not([aria-expanded="true"]) > ul,
  #mobile-menu li:not([aria-expanded="true"]) > .menu,
  #mobile-menu li:not([aria-expanded="true"]) > .vertical{
    display:none !important;
    visibility:hidden !important;
    opacity:0 !important;
    height:0 !important;
    max-height:0 !important;
    min-height:0 !important;
    overflow:hidden !important;
    width:0 !important;
    padding:0 !important;
    margin:0 !important;
    position:absolute !important;
    left:-9999px !important;
    pointer-events:none !important;
  }
}

/* ========== PC (>=1024px) ではモバイル要素を確実に隠す ========== */
@media (min-width:1024px){
  #header-mobile, #mobile-menu{ display:none !important; }
}
`,
}

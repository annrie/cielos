import type { Preflight } from 'unocss'

export const preflightHeader: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ベース色（ライト/ダーク共通で固定） */
#header{ background-color:var(--header-bg) !important; color:var(--header-fg) !important; }
#header a{ color:inherit; }

/* メニューリンク */
nav#menu a{
  color: var(--header-fg) !important;
  padding: .375rem .5rem;           /* ←背景が見える最小限の余白 */
  border-radius: .375rem;           /* ←見やすく */
  text-decoration: none;
  transition: background-color .2s ease, color .2s ease;
}

/* hover / focus-visible */
nav#menu a:hover,
nav#menu a:focus-visible{
  background-color: var(--header-hover-bg) !important;
  color: var(--header-hover-fg) !important;
  outline: none;
}

/* 現在メニュー */
nav#menu .current-menu-item > a,
nav#menu .current_page_item > a{
  background-color: var(--header-active-bg) !important;
  color: var(--header-active-fg) !important;
}

/* サブメニューにも同じルールを適用（必要なら） */
nav#menu .sub-menu a:hover,
nav#menu .sub-menu a:focus-visible{
  background-color: var(--header-hover-bg) !important;
  color: var(--header-hover-fg) !important;
}

#header{ background-color: var(--header-bg) !important; color: var(--header-fg) !important; }
#header a{ color: inherit; }

#header img.logo-img{
  height: var(--logo-h) !important;
  width: auto !important;
  max-height: none !important;
}

@media (min-width:1024px){
  #theme-toggle-desktop{
    display: inline-flex !important;
    align-items: center; justify-content: center;
    color: var(--header-fg, #fff);
    background-color: rgba(255,255,255,.10);       /* ←ベースで見えるように */
    border-radius: .375rem;
    box-shadow: inset 0 0 0 1px rgba(255,255,255,.18); /* 薄い枠 */
  }
  #theme-toggle-desktop:hover{
    background-color: var(--header-hover-bg, rgba(255,255,255,.14)) !important;
    color: var(--header-hover-fg, #fff) !important;
  }
}

/* モバイル：閉じる（data-openで開く） */
@media (max-width:1023.98px){
  nav#menu :is(>ul, >div>ul){ display:none; }
  nav#menu[data-open] :is(>ul, >div>ul){ display:flex; }
}
/* デスクトップ：常時表示（勝ち優先度を上げる） */
@media (min-width:1024px){
  nav#menu :is(>ul, >div>ul){ display:flex !important; }
}

/* 旧: .main-navigation / .menu を UnoCSS ナビにブリッジ */
:where(.main-navigation, nav.main-navigation, .global-nav, #gnav){
  display:flex; align-items:center; gap:.25rem; flex-wrap:wrap;
}
:where(.main-navigation) ul{
  display:flex; flex-wrap:wrap; gap:.25rem;
  margin:0; padding:0; list-style:none;
}
/* 旧CSSが display:none にしていることが多いので “上書き表示” */
:where(.main-navigation) > ul{ display:flex !important; }

:where(.main-navigation) li{ margin:0; padding:0; }
:where(.main-navigation) a{
  display:inline-flex; align-items:center; height:2.25rem;
  padding:0 .75rem; border-radius:999px; text-decoration:none;
  color: var(--nav-link-fg);
}
:where(.main-navigation) a:hover{
  background: var(--nav-link-hover-bg);
}
:where(.main-navigation) a[aria-current="page"],
:where(.main-navigation) .current-menu-item > a{
  background: var(--nav-link-current-bg);
  color: var(--nav-link-current-fg);
  font-weight: 700;
}

/* ヘッダ内のセンター化（.inner が無いヘッダでも破綻しないよう保険） */
:where(header.site-header, .site-header, #site-header){
  background: var(--header-bg);
  border-bottom: 1px solid var(--header-bc);
  color: var(--header-fg);
  box-shadow: var(--header-shadow);
}
:where(header.site-header, .site-header, #site-header) > :where(.inner, .wrap, .container){
  display:flex; align-items:center; justify-content:space-between;
  gap: var(--header-gap-x) var(--header-gap-y);
  width: var(--container-w); margin-inline:auto; min-height: var(--header-h);
  padding: .5rem 1rem;
}
/* 直下に .inner 等が無い場合でも最低限のパディングを付与 */
:where(header.site-header, .site-header, #site-header){
  padding: .5rem 0;
}

/* ===== Header structure ===== */
:where(header.site-header, .site-header, #site-header){
  position: sticky; top: 0; z-index: 1000;
  background: var(--header-bg);
  border-bottom: 1px solid var(--header-bc);
  color: var(--header-fg);
  box-shadow: var(--header-shadow);
}
:where(header.site-header, .site-header, #site-header) .inner{
  display:flex; align-items:center; justify-content:space-between;
  gap: var(--header-gap-x) var(--header-gap-y);
  width: var(--container-w); margin-inline:auto; min-height: var(--header-h);
  padding: .5rem 1rem;
}

/* brand と nav の並び */
.site-brand{ display:flex; align-items:center; gap:.5rem; min-width:0; }
.site-nav   { display:flex; align-items:center; gap:.25rem; flex-wrap:wrap; }

/* ナビリスト（ul/li）のリセット */
.site-nav ul{ display:flex; gap:.25rem; margin:0; padding:0; list-style:none; }
.site-nav li{ margin:0; padding:0; }

/* モバイルで縦積みにしたい場合の土台（必要なら後でONに） */
@media (max-width: 768px){
  .site-nav[data-stack="true"] ul{ flex-direction:column; align-items:stretch; }
}
/* 代表的なナビ容器を flex で表示（display:none を打ち消す） */
:where(#site-navigation, .site-navigation, .main-navigation, nav[role="navigation"], nav[aria-label*="primary" i]){
  display:flex !important; align-items:center; flex-wrap:wrap; gap:.25rem .5rem;
}

/* 上位 ul / .menu / .nav-menu を全部 flex で表示 */
:where(#site-navigation, .site-navigation, .main-navigation) > ul,
:where(#site-navigation, .site-navigation, .main-navigation) > div > ul,
:where(#site-navigation, .site-navigation, .main-navigation) .menu,
:where(#site-navigation, .site-navigation, .main-navigation) .nav-menu{
  display:flex !important; flex-wrap:wrap; gap:.25rem .5rem; margin:0; padding:0; list-style:none;
}

/* トグル前提テーマの“非表示”を無効化 */
:where(#site-navigation .menu-toggle, .main-navigation .menu-toggle){ display:none !important; }

/* 最低限のリンク見た目（色は tokens 依存） */
:where(#site-navigation a, .site-navigation a, .main-navigation a){
  display:inline-flex; align-items:center; height:2.25rem;
  padding:0 .75rem; border-radius:999px; text-decoration:none;
  color: var(--nav-link-fg, var(--c-fg));
}
:where(#site-navigation a:hover, .site-navigation a:hover, .main-navigation a:hover){
  background: var(--nav-link-hover-bg, color-mix(in srgb, var(--c-panel) 92%, transparent));
}
:where(#site-navigation .current-menu-item>a, .site-navigation .current-menu-item>a, .main-navigation .current-menu-item>a){
  font-weight:700;
  background: var(--nav-link-current-bg, color-mix(in srgb, var(--c-accent) 20%, transparent));
  color: var(--nav-link-current-fg, var(--c-fg));
}
@media (max-width:1023.98px){
  #header-desktop{ display:none !important; }
}
@media (min-width:1024px){
  #header-mobile{ display:none !important; margin:0 !important; padding:0 !important; }
  #header-desktop{display:flex;align-items:center;justify-content:flex-start}
  #header-desktop > a{flex:0 0 auto;margin-right:auto} /* ロゴで押し出す */
  #header-desktop > nav#menu{flex:1 1 auto}
  nav#menu :is(>ul, >div>ul){ display:flex !important; } /* UL を必ず表示 */
}
@media (min-width:1024px){
  :root{ --title-lh:1.20; --latest-title-fs:2.25rem; --machaki-title-fs:2.25rem; }
}

/* デフォルトは sun を表示、moon を隠す */
#theme-toggle-desktop svg[data-icon="sun"] { display:block; }
#theme-toggle-desktop svg[data-icon="moon"] { display:none; }

/* ダーク時は逆転（Uno の dark: ユーティリティに依存しない） */
html.dark #theme-toggle-desktop svg[data-icon="sun"] { display:none !important; }
html.dark #theme-toggle-desktop svg[data-icon="moon"] { display:block !important; }

/* クリック領域を確実に 36px 四方に（ユーティリティ未生成対策） */
@media (min-width:1024px){
  #theme-toggle-desktop{
    width: 36px; height: 36px;           /* ← w-9 h-9 相当を直書き */
    display: inline-flex !important;
    align-items:center; justify-content:center;
  }
}

/* Site Branding Icon styles are in header.php inline <style> */

/* 祖先の overflow で sticky を殺さない */
:where(#page, .page-container, .wrap, .container){ overflow: visible !important; }

/* 常時 sticky + 最前面（既存クラスに依存しない） */
#header{
  position: sticky !important;
  top: 0;
  z-index: 50; /* メニュー/ヒーローより上 */
  background-color: var(--header-bg, #1f2937);
  color: var(--header-fg, #fff);
  backdrop-filter: saturate(180%) blur(8px);
}

/* 子要素のヘッダー行は sticky/fixed にしない（重なり防止） */
#header-desktop,
#header-mobile{
  position: relative !important;
  top: auto !important;
}

/* ==== A) モバイルは nav#menu を確実に隠す（二重表示停止） ==== */
@media (max-width:1023.98px){
  /* header 直下の nav に強く効かせる（既存の“全部 nav を flex”を無効化） */
  header nav#menu,
  nav#menu{ display: none !important; }

  /* モバイル側は出す */
  #mobile-menu,
  #header-mobile{ display: block !important; }

  /* #mobile-menu 外に“迷子”で出てくる縦ULは全部消す */
  ul.vertical.menu{ display: none !important; }
  #mobile-menu ul.vertical.menu{ display: block !important; }

  /* モバイルヘッダーが縦積みになるのを抑止 */
  #header-mobile{
    display:flex !important;
    align-items:center !important;
    justify-content:space-between !important;
    gap:.5rem;
  }
}

/* ==== B) デスクトップは右寄せを保険で固定 ==== */
@media (min-width:1024px){
  /* nav#menu を右端へ */
  nav#menu{ margin-left:auto !important; display:flex !important; align-items:center !important; }

  /* UL は右寄せで横並び */
  nav#menu > ul,
  nav#menu > div > ul{
    display:flex !important;
    justify-content:flex-end !important;
    margin-left:auto !important;
    gap:.75rem !important;
  }

  /* モバイル用は消す（保険） */
  #mobile-menu,
  #header-mobile{ display:none !important; }
}

/* ==== D) Desktop: ロゴとメニューの重なり防止（2カラム固定） ==== */
@media (min-width:1024px){
  #header-desktop{
    display:grid !important;
    grid-template-columns:max-content minmax(0,1fr) !important;
    align-items:center !important;
    column-gap:1rem !important;
  }

  #header-desktop > a{
    grid-column:1;
    margin-right:0 !important;
    z-index:2;
  }

  #header-desktop > nav#menu{
    grid-column:2;
    min-width:0;
    width:100%;
    justify-content:flex-end !important;
  }

  #header-desktop > nav#menu > ul,
  #header-desktop > nav#menu > div > ul{
    max-width:100%;
    flex-wrap:nowrap;
  }
}

/* ==== C) モバイルのサブメニュー表示制御（孫まで閉じる土台） ==== */
@media (max-width:1023.98px){
  /* 既定は全閉（子孫の ul も閉じ） */
  #mobile-menu li.menu-item-has-children ul,
  #mobile-menu li.page_item_has_children ul,
  #mobile-menu li.has-submenu ul{
    display:none !important;
  }
  /* 開いた枝だけ展開（子孫も一括で開く） */
  #mobile-menu li[aria-expanded="true"] > ul,
  #mobile-menu li[aria-expanded="true"] ul{
    display:block !important;
  }
}

/* 例: 無条件 → PC限定に */
@media (min-width:1024px){
  :where(.main-navigation) ul,
  :where(header) :where(nav) :where(>ul, >div>ul, .menu, .nav-menu){
    display:flex;
  }
}

`
}

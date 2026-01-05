// preflight.nav.solid.ts
import type { Preflight } from 'unocss'

export const preflightNavSolid: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`

  :root{
    --nav-link-fg:        var(--c-fg);
    --nav-link-hover-bg:  color-mix(in srgb, var(--c-panel) 96%, transparent);
    --nav-link-current-bg:color-mix(in srgb, var(--c-accent) 20%, transparent);
    --nav-link-current-fg:var(--c-fg);
  }
  /* 1) あらゆるナビ容器を“表示状態”へ & 横並び */
  :where(header) :where(nav,[role="navigation"],.main-navigation,#site-navigation) :not(#menu):not(#mobile-menu){
    display:flex !important; align-items:center; flex-wrap:wrap; gap:.25rem .5rem;
  }

  /* 保険：モバイル幅では nav#menu を必ず消す */
  @media (max-width:1023.98px){
    header nav#menu{ display:none !important; }
  }

  /* 2) 直下の UL 群をフレックス化（旧 .menu/.nav-menu 対応） */
  :where(header) :where(nav,[role="navigation"],.main-navigation,#site-navigation)
    :where(> ul, > div > ul, .menu, .nav-menu){
    display:flex !important; flex-wrap:wrap; gap:.25rem .5rem; margin:0; padding:0; list-style:none;
  }
  :where(header) :where(nav) li{ margin:0; padding:0; position:relative; }

  /* 3) リンクの見た目（ピル型） */
  :where(header) :where(nav) a{
    display:inline-flex; align-items:center; height:2.25rem;
    padding:0 .75rem; border-radius:999px; text-decoration:none;
    color: var(--nav-link-fg);
  }
  :where(header) :where(nav) a:hover{
    background: var(--nav-link-hover-bg);
  }
  :where(header) :where(nav) .current-menu-item > a,
  :where(header) :where(nav) a[aria-current="page"]{
    background: var(--nav-link-current-bg);
    color: var(--nav-link-current-fg);
    font-weight:700;
  }

  /* 4) 旧モバイル開閉ロジックの“非表示”を無効化（メニュー項目は常に見える） */
  :where(.menu-toggle){ display:none !important; }
  :where(.main-navigation.toggled ul){ display:flex !important; }

  /* #menu 直下 or ラッパ直下の UL を flex で“必ず表示” */
  :where(nav#menu) :where(> ul, > div > ul){
    display:flex !important;
    flex-wrap:wrap; gap:.25rem .5rem;
    margin:0; padding:0; list-style:none;
  }
  /* LI と A の最低限の見た目（色はトークン依存） */
  :where(nav#menu) li{ margin:0; padding:0; }
  :where(nav#menu) a{
    display:inline-flex; align-items:center; height:2.25rem;
    padding:0 .75rem; border-radius:999px; text-decoration:none;
    color: var(--nav-link-fg, var(--c-fg));
  }
  :where(nav#menu) a:hover{
    background: var(--nav-link-hover-bg, color-mix(in srgb, var(--c-panel) 96%, transparent));
  }
  :where(nav#menu) .current-menu-item > a,
  :where(nav#menu) a[aria-current="page"]{
    background: var(--nav-link-current-bg, color-mix(in srgb, var(--c-accent) 20%, transparent));
    color: var(--nav-link-current-fg, var(--c-fg));
    font-weight:700;
  }
  /* nav#menu は lg 未満で閉じる → data-open が付いたら開く */
  @media (max-width: 1023.98px){
    nav#menu :is(> ul, > div > ul){ display: none; }
    nav#menu[data-open] :is(> ul, > div > ul){ display: flex; }
  }

  /* 例: 無条件 → PC限定に */
  @media (min-width:1024px){
    :where(.main-navigation) ul,
    :where(header) :where(nav) :where(>ul, >div>ul, .menu, .nav-menu){
      display:flex;
    }
  }

  @media (min-width:1024px){
  /* 直下 UL だけ横並び（孫UL＝サブは巻き込まない） */
  #header-desktop nav#menu > ul,
  #header-desktop nav#menu > div > ul{
    display:flex; justify-content:flex-end; gap:1.5rem;
    list-style:none; margin:0; padding:0;
  }

  /* サブメニューは初期閉。hover/focus-within時だけ開く */
  #header-desktop nav#menu li{ position:relative }
  #header-desktop nav#menu ul ul{
    display:none; position:absolute; top:100%; left:0;
  }
  #header-desktop nav#menu li:hover>ul,
  #header-desktop nav#menu li:focus-within>ul{ display:block }
}
`,
}

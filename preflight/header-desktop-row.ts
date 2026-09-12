// preflight.header-desktop-row.ts
import type { Preflight } from 'unocss'

export const preflightHeaderDesktopRow: Preflight = {
  layer: 'preflights',
  getCSS: () => `
@media (min-width:1024px){
  /* ========== デスクトップヘッダー基本構造 ========== */
  #header-mobile, #mobile-menu{ display:none !important; }

  #header-desktop{
    display:flex !important;
    align-items:center !important;
    justify-content:flex-start !important;
  }

  /* ロゴ：左固定 */
  #header-desktop > a{
    flex:0 0 auto !important;
  }

  /* ========== ナビゲーション右寄せ（確実化） ========== */
  nav#menu{
    flex:1 1 auto !important;
    display:flex !important;
    align-items:center !important;
    justify-content:flex-end !important;
    margin-left:auto !important;
  }

  /* トップUL：横並び（サブメニューを巻き込まない） */
  nav#menu > ul,
  nav#menu > div > ul{
    display:flex !important;
    gap:1.5rem !important;
    align-items:center !important;
    list-style:none !important;
    margin:0 !important;
    padding:0 !important;
  }

  /* ========== サブメニュー：超強制非表示 ========== */
  /* すべてのパターンに対応 */
  nav#menu ul ul,
  nav#menu li ul,
  nav#menu > ul ul,
  nav#menu > div > ul ul,
  nav#menu .menu ul,
  nav#menu .vertical ul,
  nav#menu .has-children > ul,
  nav#menu .menu-item-has-children > ul{
    display:none !important;
    visibility:hidden !important;
    opacity:0 !important;
    position:absolute !important;
    top:100% !important;
    left:0 !important;
    background:var(--header-bg,#1f2937) !important;
    /* 記事タイトルが並ぶと 200px では全項目が2行に折り返して窮屈になる。
       日本語20〜25文字が1行に収まる幅にし、画面幅も超えないようにする */
    min-width:min(22rem, 90vw) !important;
    max-width:min(28rem, 92vw) !important;
    width:max-content !important;
    box-shadow:0 8px 20px rgba(0,0,0,0.14) !important;
    border-radius:8px !important;
    padding:0.5rem !important;
    z-index:50 !important;
    transform:translateY(-10px) !important;
    transition:none !important;
    flex-direction:column !important;
    flex-wrap:nowrap !important;
  }

  /* サブメニュー内のLI要素 */
  nav#menu ul ul li,
  nav#menu li ul li{
    display:block !important;
    width:100% !important;
    float:none !important;
    flex:none !important;
  }

  /* サブメニューの項目：記事タイトルが入るので行間と余白をとる。
     トップレベル（17px）から一段落として階層を伝える */
  nav#menu ul ul li > a,
  nav#menu li ul li > a{
    display:block !important;
    padding:0.5rem 0.75rem !important;
    font-size:0.9375rem !important;   /* 15px */
    line-height:1.7 !important;
    border-radius:6px !important;
    white-space:normal !important;
    word-break:normal !important;
    overflow-wrap:anywhere !important;
  }

  /* 項目どうしを離す。1行に収まる前提だが、折り返しても潰れないように */
  nav#menu ul ul li + li{
    margin-top:0.125rem !important;
  }

  /* 親LI：relative */
  nav#menu li,
  nav#menu > ul > li,
  nav#menu > div > ul > li{
    position:relative !important;
  }

  /* ========== hover時のみ表示（複数パターン対応） ========== */
  nav#menu li:hover > ul,
  nav#menu li:hover > .menu,
  nav#menu li:hover > .vertical,
  nav#menu > ul > li:hover > ul,
  nav#menu > div > ul > li:hover > ul{
    display:block !important;
    visibility:visible !important;
    opacity:1 !important;
    transform:translateY(0) !important;
  }

  /* クラス付き親要素のhover制御 */
  nav#menu .has-children > ul,
  nav#menu .menu-item-has-children > ul{
    display:none !important;
    visibility:hidden !important;
  }

  nav#menu .has-children:hover > ul,
  nav#menu .menu-item-has-children:hover > ul{
    display:block !important;
    visibility:visible !important;
  }

  /* ========== 孫メニュー：右側に表示 ========== */
  nav#menu ul ul ul,
  nav#menu li ul ul,
  nav#menu .menu-item-has-children ul ul{
    top:0 !important;
    left:100% !important;
    margin-left:4px !important;
  }

  /* 右端で画面外に出る場合は左側に表示 */
  nav#menu ul ul ul.sub-menu-left,
  nav#menu li ul ul.sub-menu-left{
    left:auto !important;
    right:100% !important;
    margin-left:0 !important;
    margin-right:4px !important;
  }
}
`,
}

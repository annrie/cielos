import type { Preflight } from 'unocss'

export const preflightWpAdmin: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== WordPress Admin Bar ===== */
/* 管理バー高をCSS変数化して、固定ヘッダーの競合を抑える */
:root{ --wp-admin-bar-h: 0px; }
body.admin-bar{ --wp-admin-bar-h: 46px; }
@media (min-width: 783px){
  body.admin-bar{ --wp-admin-bar-h: 32px; }
}

/* 管理バーは固定表示 */
#wpadminbar{ position: fixed !important; }

/* ヘッダーが管理バーに被らないように常時オフセット */
#header,
body.admin-bar #header,
body.admin-bar #header.header-transparent,
body.admin-bar #header.header-transparent.is-scrolled{
  top: var(--wp-admin-bar-h) !important;
}

/* 固定要素の補助クラス */
body.admin-bar .fixed-top{
  top: var(--wp-admin-bar-h) !important;
}

/* 管理バー表示時は top をアニメーションさせない（潜り込み防止） */
body.admin-bar #header{
  transition-property: background-color, color, box-shadow, backdrop-filter, opacity, transform !important;
}

/* アンカー位置補正（任意だが実害を減らす） */
html{
  scroll-padding-top: calc(var(--header-h, 64px) + var(--wp-admin-bar-h));
}
`,
}

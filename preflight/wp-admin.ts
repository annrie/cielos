import type { Preflight } from 'unocss'

export const preflightWpAdmin: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== WordPress Admin Bar ===== */
/* WordPress管理バーがコンテンツに被らないようにする */

/* 管理バーを固定位置に */
#wpadminbar {
  position: fixed !important;
}

/* body.admin-bar の時の調整 */
/* デスクトップ: 32px、モバイル(783px未満): 46px */

/* 固定ヘッダーのtop位置制御 */
/* 通常時（管理バーなし） */
header#header.sticky {
  top: 0;
}

/* 管理バー表示時 */
body.admin-bar header#header.sticky {
  top: 46px;
}

@media (min-width: 783px) {
  body.admin-bar header#header.sticky {
    top: 32px;
  }
}

/* その他の固定位置要素（必要に応じて追加） */
body.admin-bar .fixed-top {
  top: 46px;
}

@media (min-width: 783px) {
  body.admin-bar .fixed-top {
    top: 32px;
  }
}
`,
}

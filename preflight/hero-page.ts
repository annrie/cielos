import type { Preflight } from 'unocss'

export const preflightHeroPage: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ========== Hero Page Title Styles ========== */

/* ヒーロー画像上のページタイトル - 縦横中央配置 */
/* hero-page-{ID} クラスがある場合のみ適用（フロントページを除外） */
.hero-feature[class*="hero-page-"] .hero-inner {
  position: absolute !important;
  top: 50% !important;
  left: 0 !important;
  right: 0 !important;
  bottom: auto !important;
  transform: translateY(-50%) !important;
  z-index: 10 !important;
  display: flex !important;
  flex-direction: column !important;
  justify-content: center !important;
  align-items: center !important;
  padding: 0 !important;
  text-align: center !important;
  height: auto !important;
}

.hero-page-title {
  margin: 0 !important;
  padding: 0 !important;
  text-align: center;
  line-height: 1;
}

/* モバイルファースト: 基本スタイル（モバイル） */
.hero-page-title-inner {
  display: inline-block;
  padding: 1rem 3rem;
  background: rgba(0, 0, 0, 0.85);
  color: #ffffff !important;
  border-radius: 9999px;
  font-size: 1.5rem;
  font-weight: 700;
  text-decoration: none;
  white-space: nowrap;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
  font-style: normal !important;
}

/* ジャンル別背景色 - SF (2412) */
.hero-page-2412 .hero-page-title-inner {
  background: rgba(77, 28, 255, 0.85);
}

/* ジャンル別背景色 - 冒険・サスペンス (2414) */
.hero-page-2414 .hero-page-title-inner {
  background: rgba(153, 102, 153, 0.85);
}

/* ジャンル別背景色 - ミステリー (2416) */
.hero-page-2416 .hero-page-title-inner {
  background: rgba(237, 24, 30, 0.85);
}

/* ジャンル別背景色 - 時代・伝奇 (2418) */
.hero-page-2418 .hero-page-title-inner {
  background: rgba(47, 139, 32, 0.85);
}

/* ジャンル別背景色 - ホラー・奇妙な味 (2544) */
.hero-page-2544 .hero-page-title-inner {
  background: rgba(0, 0, 0, 0.85);
}

/* ジャンル別背景色 - 短編・連作集 (2805) */
.hero-page-2805 .hero-page-title-inner {
  background: rgba(14, 165, 233, 0.85); /* sky-500 */
}

/* ジャンル別背景色 - Bibliography (3136, 4279, 3395, 3467) */
.hero-page-3136 .hero-page-title-inner,
.hero-page-4279 .hero-page-title-inner,
.hero-page-3395 .hero-page-title-inner,
.hero-page-3467 .hero-page-title-inner {
  background: rgba(100, 116, 139, 0.85); /* slate-500 */
}

/* ========== Genre Taxonomy Hero Styles ========== */
/* taxonomy-genre.php 用: hero-genre-* クラスで色を適用 */

/* ジャンル taxonomy ヒーロー共通スタイル */
.hero-feature[class*="hero-genre-"] .hero-inner {
  position: absolute !important;
  top: 50% !important;
  left: 0 !important;
  right: 0 !important;
  bottom: auto !important;
  transform: translateY(-50%) !important;
  z-index: 10 !important;
  display: flex !important;
  flex-direction: column !important;
  justify-content: center !important;
  align-items: center !important;
  padding: 0 !important;
  text-align: center !important;
  height: auto !important;
}

/* SF ジャンル */
.hero-genre-sf .hero-page-title-inner {
  background: rgba(77, 28, 255, 0.85);
}

/* 冒険・サスペンス ジャンル */
.hero-genre-adventure .hero-page-title-inner {
  background: rgba(153, 102, 153, 0.85);
}

/* ミステリー ジャンル */
.hero-genre-mystery .hero-page-title-inner {
  background: rgba(237, 24, 30, 0.85);
}

/* 時代・伝奇 ジャンル */
.hero-genre-jidai .hero-page-title-inner {
  background: rgba(47, 139, 32, 0.85);
}

/* ホラー・奇妙な味 ジャンル */
.hero-genre-horror .hero-page-title-inner {
  background: rgba(0, 0, 0, 0.85);
}

/* 短編・連作集 ジャンル */
.hero-genre-tanpen .hero-page-title-inner {
  background: rgba(14, 165, 233, 0.85); /* sky-500 */
}

/* デフォルト（マッピングにないジャンル） */
.hero-genre-default .hero-page-title-inner {
  background: rgba(100, 116, 139, 0.85); /* slate-500 */
}

/* タブレット以上: 641px以上 */
@media (min-width: 641px) {
  .hero-page-title-inner {
    font-size: 2rem;
    padding: 1.5rem 4rem;
  }
}

/* デスクトップ: 1025px以上 */
@media (min-width: 1025px) {
  .hero-page-title-inner {
    font-size: 3.5rem;
    padding: 2rem 5rem;
  }
}
`
}

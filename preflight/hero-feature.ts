// preflight.hero-feature.ts
import type { Preflight } from 'unocss'

export const preflightHeroFeature: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
.hero-feature{
  height: var(--hero-h) !important;
  background-size: cover;
  background-position: center;
  position: relative;
}
.hero-feature .hero-overlay{
  position:absolute; inset:0;
  background: var(--hero-overlay);
  pointer-events:none;
}
.hero-feature .hero-inner{
  position: relative; z-index: 1;
  height: 100%;
  display: flex; flex-direction: column;
  align-items: flex-end;           /* 右寄せ */
  justify-content: flex-end;       /* 下寄せ */
  padding: var(--hero-pad-y) var(--hero-pad-x);
  text-align: var(--hero-text-align);
  gap: .25rem;
}
.hero-feature .hero-title{
  color: var(--hero-title-fg);
  font-size: var(--hero-title-fs);
  line-height: var(--hero-title-lh);
  text-shadow: var(--hero-title-shadow);
  letter-spacing: .02em;
  font-style: italic;              /* 画像の雰囲気に合わせて斜体 */
}
.hero-feature .hero-subtitle{
  color: var(--hero-subtitle-fg);
  font-size: var(--hero-subtitle-fs);
  line-height: 1.5;
}

/* 横並び・右下寄せ（常時） */
.hero-feature .hero-inner{
  position: relative; z-index: 1;
  height: 100%;
  display: flex;
  flex-direction: row;        /* ← 横並び */
  flex-wrap: wrap;
  align-items: flex-end;      /* ベースラインを下で揃える */
  justify-content: flex-end;  /* 右寄せ */
  padding: var(--hero-pad-y) var(--hero-pad-x);
  text-align: right;
  gap: .25rem .75rem;         /* タイトルとタグラインの間隔 */
}

/* タイトル */
.hero-feature .hero-title{
  color: var(--hero-title-fg);
  font-size: var(--hero-title-fs);
  line-height: var(--hero-title-lh);
  text-shadow: var(--hero-title-shadow);
  letter-spacing: .02em;
  font-style: italic;
  margin: 0;
}

/* タグライン（クラスが無くても効くように h2 も拾う） */
.hero-feature .hero-subtitle,
.hero-feature h2{
  color: var(--hero-subtitle-fg, rgba(255,255,255,.85));
  font-size: var(--hero-subtitle-fs, 0.9rem);
  line-height: 1.4;
  margin: 0 !important;       /* md:text-lg mt-2 を打ち消し */
  padding: 0;
}

`,
}

// preflight.post-cover.ts
import type { Preflight } from 'unocss'

/**
 * 記事のアイキャッチ代わりの見出し領域（.post-cover）。
 *
 * 画像を用意せずに上部の空白を埋めるためのもの。
 * サイト名と同じ Lobster を使い、ロゴとの統一感を出す。
 *
 * 空（cielos）から取った淡い青のグラデーションを敷くが、
 * 主役はあくまで文字。面で押さないよう彩度は抑える。
 */
export const preflightPostCover: Preflight = {
  layer: 'preflights',
  getCSS: () => `

.post-cover{
  position: relative;
  overflow: hidden;
  margin: 0 0 2rem;
  padding: 2.5rem 2rem 2.25rem;
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md, 0.5rem);
  background:
    linear-gradient(
      160deg,
      color-mix(in srgb, var(--c-primary) 10%, var(--c-panel)) 0%,
      var(--c-panel) 62%
    );
}

/* 右上に薄い円を2つ。空に浮かぶものの見立て。装飾なので読み上げない */
.post-cover::before,
.post-cover::after{
  content: '';
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}
.post-cover::before{
  width: 220px; height: 220px;
  top: -90px; right: -60px;
  background: color-mix(in srgb, var(--c-primary) 12%, transparent);
}
.post-cover::after{
  width: 120px; height: 120px;
  top: 40px; right: 120px;
  background: color-mix(in srgb, var(--c-accent) 8%, transparent);
}

.post-cover__inner{ position: relative; z-index: 1; }

/* 技術名。ロゴと同じ Lobster を使う数少ない出番 */
.post-cover__eyebrow{
  display: block;
  margin: 0 0 0.375rem;
  font-family: var(--font-lobster, cursive);
  font-size: clamp(1.75rem, 5vw, 2.5rem);
  line-height: 1.1;
  color: var(--c-primary);
  letter-spacing: 0.01em;
}

.post-cover__title{
  margin: 0;
  font-size: clamp(1.25rem, 3.2vw, 1.75rem);
  font-weight: 700;
  line-height: 1.45;
  color: var(--c-fg);
  letter-spacing: var(--track-tight, 0);
}

.post-cover__meta{
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.5rem 0.875rem;
  margin-top: 1rem;
  color: var(--c-muted);
  font-size: 0.8125rem;
}
.post-cover__meta time{ font-variant-numeric: tabular-nums; }

/* カテゴリは差し色ではなく主色の淡い面で。琥珀は使わない */
.post-cover__cat{
  padding: 0.125rem 0.625rem;
  border-radius: 999px;
  background: color-mix(in srgb, var(--c-primary) 12%, transparent);
  color: var(--c-primary-dark, var(--c-primary));
  font-weight: 700;
  font-size: 0.75rem;
}

@media (max-width: 639.98px){
  .post-cover{ padding: 1.75rem 1.25rem 1.5rem; }
  .post-cover::before{ width: 160px; height: 160px; top: -70px; right: -50px; }
  .post-cover::after{ width: 80px; height: 80px; top: 24px; right: 70px; }
}

/* 一覧でも同じ見立てを小さく使えるようにしておく */
.post-cover--sm{ padding: 1.25rem 1.25rem 1.125rem; margin-bottom: 0; }
.post-cover--sm .post-cover__eyebrow{ font-size: 1.5rem; }
.post-cover--sm .post-cover__title{ font-size: 1rem; }
`,
}

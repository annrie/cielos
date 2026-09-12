// preflight.callout.ts
import type { Preflight } from 'unocss'

/**
 * 本文中の補足ブロックと、サイドバーのウィジェット表示。
 *
 * 装飾の方針は3つ。
 *  1. 面で塗らない。線と余白で区切る（背景は 5〜6% までに留める）
 *  2. 差し色（--c-accent）は1箇所だけ
 *  3. 角は丸めすぎない
 *
 * 本文で使うクラスは投稿本文（DB内）に書かれるため UnoCSS のスキャン対象外。
 * ここに直接定義しておかないと生成されない。
 */
export const preflightCallout: Preflight = {
  layer: 'preflights',
  getCSS: () => `

/* ========================================================================
   補足ブロック（.callout）
   ヒント・注意・落とし穴を本文から視覚的に分ける。
   ======================================================================== */
.callout{
  position: relative;
  margin: 1.75rem 0;
  padding: 1rem 1.25rem;
  border-left: 3px solid var(--c-primary);
  border-radius: 0 var(--radius-md, 0.375rem) var(--radius-md, 0.375rem) 0;
  background: color-mix(in srgb, var(--c-primary) 5%, transparent);
  line-height: var(--lh-relaxed, 1.8);
}
.callout > :first-child{ margin-top: 0; }
.callout > :last-child{ margin-bottom: 0; }

/* 見出し行。アイコンは擬似要素で置き、画像もフォントも増やさない */
.callout__title{
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin: 0 0 0.5rem;
  font-weight: 700;
  font-size: 0.9375rem;
  letter-spacing: var(--track-tight, 0);
  color: var(--c-primary-dark, var(--c-primary));
}
.callout__title::before{
  content: 'i';
  display: inline-grid;
  place-items: center;
  width: 1.25rem;
  height: 1.25rem;
  border-radius: 50%;
  background: var(--c-primary);
  color: #fff;
  font-size: 0.75rem;
  font-weight: 700;
  font-style: italic;
  flex: none;
}

/* 注意：差し色（琥珀）を使うのはここだけ */
.callout--warn{
  border-left-color: var(--c-accent);
  background: color-mix(in srgb, var(--c-accent) 6%, transparent);
}
.callout--warn .callout__title{ color: var(--c-accent-dark, var(--c-accent)); }
.callout--warn .callout__title::before{
  content: '!';
  background: var(--c-accent);
  font-style: normal;
}

/* 落とし穴：線を破線にして「引っかかる」感じを出す。色は増やさない */
.callout--trap{
  border-left-style: dashed;
  border-left-color: var(--c-muted);
  background: color-mix(in srgb, var(--c-muted) 5%, transparent);
}
.callout--trap .callout__title{ color: var(--c-fg); }
.callout--trap .callout__title::before{
  content: '?';
  background: var(--c-muted);
  font-style: normal;
}

@media (max-width: 639.98px){
  .callout{ padding: 0.875rem 1rem; margin: 1.25rem 0; }
}


/* ========================================================================
   記事本文の見出し
   heading-styles.css の既定色（グレー）を cielos の空色に寄せる。
   面で塗らず、線だけで見せる方針。
   ======================================================================== */
.entry-content h2.heading11{
  --hd11-blc: var(--c-primary);                 /* 左のボーダー */
  --hd11-bc: var(--c-border);                   /* 下の破線 */
  /* heading-styles.css の margin: 30px -30px 10px を打ち消す。
     ショートハンドで上書きしないと -30px が残る */
  margin: 2.5rem 0 1rem;
  font-size: clamp(1.25rem, 2.6vw, 1.5rem);
  line-height: 1.5;
}
.entry-content h3.heading13-9{
  --hd139-bc: color-mix(in srgb, var(--c-primary) 45%, transparent);
  font-size: clamp(1.0625rem, 2vw, 1.1875rem);
}

/* ========================================================================
   サイドバーのウィジェット
   ======================================================================== */
.sidebar .widget{
  padding: 1rem 1.125rem;
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md, 0.375rem);
  background: var(--c-panel);
}

.sidebar .widget-title{
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin: 0 0 0.75rem;
  padding-bottom: 0.5rem;
  font-size: var(--widget-title-fs, 1rem);
  font-weight: 700;
  color: var(--widget-title-fg, var(--c-fg));
  border-bottom: 1px solid var(--c-border);
}
.sidebar .widget-title > i{ color: var(--c-primary); flex: none; }

.sidebar .widget ul{ margin: 0; padding: 0; list-style: none; }
.sidebar .widget li + li{ margin-top: 0.125rem; }

.sidebar .widget li > a{
  display: block;
  padding: 0.375rem 0.5rem;
  border-radius: 0.25rem;
  font-size: 0.875rem;
  line-height: 1.5;
  color: var(--c-fg);
  text-decoration: none;
  transition: background-color 0.15s ease, color 0.15s ease;
}
.sidebar .widget li > a:hover{
  background: color-mix(in srgb, var(--c-primary) 8%, transparent);
  color: var(--c-primary-dark, var(--c-primary));
}

/* 現在のカテゴリだけ左に線を出す */
.sidebar .cat-item.current-cat > a{
  border-left: 2px solid var(--c-primary);
  padding-left: calc(0.5rem - 2px);
  font-weight: 700;
}

/* カテゴリの件数 */
.sidebar .cat-count{
  float: right;
  min-width: 1.5rem;
  padding: 0 0.375rem;
  border-radius: 999px;
  background: color-mix(in srgb, var(--c-fg) 8%, transparent);
  color: var(--c-muted);
  font-size: 0.75rem;
  line-height: 1.5rem;
  text-align: center;
}

/* タグは横並びのピル */
.sidebar .tag-list{ display: flex; flex-wrap: wrap; gap: 0.375rem; }
.sidebar .tag-list li + li{ margin-top: 0; }
.sidebar .tag-list li > a{
  padding: 0.25rem 0.625rem;
  border: 1px solid var(--c-border);
  border-radius: 999px;
  font-size: 0.8125rem;
}
.sidebar .tag-list li > a::before{ content: '#'; color: var(--c-muted); margin-right: 0.125rem; }
.sidebar .tag-list li > a:hover{ border-color: var(--c-primary); }

/* 他の記事：日付を小さく添える */
.sidebar .widget_recent_entries li > a{ padding-bottom: 0.125rem; }
.sidebar .recent-date{
  display: block;
  padding: 0 0.5rem 0.375rem;
  color: var(--c-muted);
  font-size: 0.75rem;
  font-variant-numeric: tabular-nums;
}
`,
}

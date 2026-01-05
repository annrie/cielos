// preflight.top.ts
import type { Preflight } from 'unocss';

const css = String.raw`

.hero-feature{ height: var(--hero-h) !important; }

/* タイトル直下の間隔をやや詰める（必要な場合だけ） */
:where(#latest-columns, #machaki-pickup) :where(h1,h2,h3){
  margin-bottom: .5rem;
}

/* -------- Featured hero -------- */
.featured-hero{ margin-top:-5px; margin-bottom:0; }

/* -------- Top header contents -------- */
#top-hero{ position:relative; height:auto; }

/* -------- Latest columns -------- */
#latest-columns{ margin-top: 0; }
#latest-columns article{ margin-bottom:5px; border-radius:4px; }
#latest-columns article p{ margin-left:0; }

/* ボタンを右上に配置（既存レイアウト踏襲） */
#latest-columns .archive-link{
  position:relative;
  top:-3.4rem;
  right:20px;
  z-index:1;
  float:right;
}

/* タイトルは既存ショートカット/トークンを優先利用（class化推奨） */
#latest-columns #latest-columns-title{}

/* -------- Machaki pickup -------- */
#machaki-pickup #machaki-group-title{
  width:100%;
  margin-top:20px;
  margin-bottom:0;
  line-height:4.3125rem;
  text-align:left;
}

#machaki-pickup article{ margin-bottom:0; }

/* -------- Continue button -------- */
.continue-button{ padding:0 0 3px 3px; margin-top:-15px; margin-bottom:15px; }
.continue-button a{
  color:var(--archbtn-fg);
  border:1px solid var(--archbtn-border);
  border-radius:var(--archbtn-radius);
  padding:7px 10px 5px;
  box-shadow:var(--archbtn-shadow);
  background-image:
    linear-gradient(to bottom, var(--archbtn-gloss), transparent),
    linear-gradient(to bottom, var(--archbtn-bg-from), var(--archbtn-bg-to));
}
.continue-button a:hover{
  background-image:
    linear-gradient(to bottom, var(--archbtn-gloss), transparent),
    linear-gradient(to bottom, var(--archbtn-hover-from), var(--archbtn-hover-to));
}
.continue-button a:active{
  background-image:
    linear-gradient(to bottom, var(--archbtn-gloss), transparent),
    linear-gradient(to bottom, var(--archbtn-active-from), var(--archbtn-active-to));
}

:where(#latest-columns) :is(h1,h2,h3){ color: var(--latest-title-fg); }
:where(#machaki-pickup) :is(h1,h2,h3){ color: var(--machaki-title-fg); }

/* latest の見出しサイズを強制（2remトークンを使用） */
:where(#latest-columns) :is(h1,h2,h3){
  font-size: var(--latest-title-fs) !important;
  line-height: var(--title-lh);
  letter-spacing: var(--title-trk);
  /* 見出し内リンクも同じ色/サイズに揃える */
  & > a{ color: inherit; font: inherit; }
}

/* machaki の見出しサイズを強制（2remトークンを使用） */
:where(#machaki-pickup) :is(h1,h2,h3){
  font-size: var(--machaki-title-fs) !important;
  line-height: var(--title-lh);
  letter-spacing: var(--title-trk);
  & > a{ color: inherit; font: inherit; }
}
/* latest: 見出し本人の余白＆字詰め */
:where(#latest-columns) :is(h1,h2,h3){
  margin-bottom: var(--latest-title-mb);
  letter-spacing: var(--title-trk);
  & > a{ color: inherit; font: inherit; } /* リンク継承 */
}
/* 見出し直下のメタ行の上マージン */
:where(#latest-columns) .top-meta{ margin-top: var(--latest-meta-mt); }

/* machaki: 同様に */
:where(#machaki-pickup) :is(h1,h2,h3){
  margin-bottom: var(--machaki-title-mb);
  letter-spacing: var(--title-trk);
  & > a{ color: inherit; font: inherit; }
}
:where(#machaki-pickup) .top-meta{ margin-top: var(--machaki-meta-mt); }
`;

export const preflightTop: Preflight = {
  getCSS: () => css,
};

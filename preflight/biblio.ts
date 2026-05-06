// preflight.biblio.ts
import type { Preflight } from 'unocss'

const css = String.raw`
/* ===== Biblio: structure & spacing ===== */
:where(.biblio, #biblio, body.biblio) .biblio-list{
  list-style:none; margin:0; padding:0;
}
:where(.biblio, #biblio, body.biblio) .biblio-list > li{
  margin:0 0 .75rem 0;
}
:where(.biblio, #biblio, body.biblio) .biblio-header{
  display:flex; gap:.75rem; flex-wrap:wrap; align-items:flex-end;
  margin: 0 0 .75rem;
}
:where(.biblio, #biblio, body.biblio) .biblio-title{
  margin:0;
}
:where(.biblio, #biblio, body.biblio) .biblio-meta{
  margin:.25rem 0 0; font-size: var(--fs-sm); line-height: var(--lh-normal);
}
:where(.biblio, #biblio, body.biblio) .biblio-abstract{
  margin:.5rem 0 0; line-height: var(--lh-relaxed);
}

/* Figures / thumbs */
:where(.biblio, #biblio, body.biblio) .biblio-thumb{
  display:block; inline-size:100%; block-size:auto;
  border-radius: var(--radius-md); overflow:hidden;
}

/* Tag row */
:where(.biblio, #biblio, body.biblio) .biblio-tags{
  display:flex; flex-wrap:wrap; gap:.5rem;
  margin:.5rem 0 0;
}

/* ===== Machaki content compatibility ===== */
:where(.entry-content) h2{
  border-left-color: var(--biblio-entry-border);
}
:where(.page-parent) .entry-content h2{
  border-left-color: var(--c-primary);
}
:where(.page-parent) .censor-button{
  font-weight: 700;
}
:where(.page-child) .entry-content{
  padding-top: 0;
}

:where(.censor-button){
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  padding: .5rem 1rem;
  border-radius: .5rem;
  color: var(--machaki-censor-fg);
  background: var(--c-accent);
  font-weight: 700;
  text-decoration: none;
  box-shadow: var(--machaki-censor-shadow);
}

:where(#post-2412, .term-sf) .entry-content h2{
  border-style: solid;
  border-color: var(--machaki-label-sf-bg);
  border-width: 0 0 1px 5px;
}
:where(#post-2412, .term-sf) .entry-content h3{
  border-left: 4px solid var(--machaki-label-sf-bg);
  border-bottom: 1px solid var(--machaki-label-sf-bg);
}
:where(#post-2412, .term-sf) .censor-button{
  background: var(--machaki-label-sf-bg);
}

:where(#post-2414, .term-adv) .entry-content h2{
  border-style: solid;
  border-color: var(--machaki-label-adv-bg);
  border-width: 0 0 1px 5px;
}
:where(#post-2414, .term-adv) .entry-content h3{
  border-left: 4px solid var(--machaki-label-adv-bg);
  border-bottom: 1px solid var(--machaki-label-adv-bg);
}
:where(#post-2414, .term-adv) .censor-button{
  background: var(--machaki-label-adv-bg);
}
:where(#post-2414) dt{
  margin-bottom: 1rem;
}

:where(#post-2416, .term-mys) .entry-content h2{
  border-style: solid;
  border-color: var(--machaki-label-mys-bg);
  border-width: 0 0 1px 5px;
}
:where(#post-2416, .term-mys) .entry-content h3{
  border-left: 4px solid var(--machaki-label-mys-bg);
  border-bottom: 1px solid var(--machaki-label-mys-bg);
}
:where(#post-2416, .term-mys) .censor-button{
  background: var(--machaki-label-mys-bg);
}

:where(#post-2418, .term-jedi, .tem-jedi) .entry-content h2{
  border-style: solid;
  border-color: var(--machaki-label-denki-bg);
  border-width: 0 0 1px 5px;
}
:where(#post-2418, .term-jedi, .tem-jedi) .entry-content h3{
  border-left: 4px solid var(--machaki-label-denki-bg);
  border-bottom: 1px solid var(--machaki-label-denki-bg);
}
:where(#post-2418, .term-jedi, .tem-jedi) .censor-button{
  background: var(--machaki-label-denki-bg);
}

:where(#post-2544, .term-horror) .entry-content h2{
  border-style: solid;
  border-color: var(--machaki-label-kimyo-bg);
  border-width: 0 0 1px 5px;
}
:where(#post-2544, .term-horror) .entry-content h3{
  border-left: 4px solid var(--machaki-label-kimyo-bg);
  border-bottom: 1px solid var(--machaki-label-kimyo-bg);
}
:where(#post-2544, .term-horror) .censor-button{
  background: var(--machaki-label-kimyo-bg);
}

:where(#post-2805, #post-2410, .term-short) .entry-content h2{
  border-style: solid;
  border-color: var(--c-primary);
  border-width: 0 0 1px 5px;
}
:where(#post-2805, #post-2410, .term-short) .entry-content h3{
  border-left: 4px solid var(--c-primary);
  border-bottom: 1px solid var(--c-primary);
}
:where(#post-2805, #post-2410, .term-short) .censor-button{
  background: var(--c-primary);
}

#post-2412 h1.entry-title{
  padding: .3125rem 1.25rem;
  text-shadow: var(--machaki-title-shadow);
}
.page-id-2410 .featured-hero{
  margin-top: -2rem;
}

/* ===== Taxonomy genre tables ===== */
:where(.tax-genre) h2{
  margin-bottom: -1.5rem;
}
:where(.tax-genre) .entry-content{
  margin-top: -1.5rem;
}
:where(.tax-genre) h3{
  font-size: 110%;
}
:where(.tax-genre) table{
  border-spacing: 0 .3125rem;
  border-collapse: separate;
  border: none;
}
:where(.tax-genre) table caption{
  margin-top: 1rem;
  margin-bottom: -1rem;
}
:where(.tax-genre) table thead td,
:where(.tax-genre) table thead th{
  padding: .625rem;
  font-size: .875rem;
}
:where(.tax-genre) table thead th{
  padding: .3125rem 0;
  border-bottom: 3px solid var(--machaki-table-divider);
  background: var(--c-panel);
  color: var(--machaki-table-caption-fg);
  font-size: .9rem;
  font-weight: 700;
  text-align: center;
}
:where(.tax-genre) table thead th::after{
  display: none;
}
:where(.tax-genre) table thead th:first-of-type{
  width: 37%;
}
:where(.tax-genre) table tbody th{
  position: relative;
  overflow: visible;
  background: color-mix(in srgb, var(--machaki-dl-bg) 75%, transparent);
  color: var(--machaki-dl-fg);
  font-size: .875rem;
  font-weight: 400;
  text-align: left;
  vertical-align: middle;
}
:where(.tax-genre) table tbody th::after{
  content: '';
  position: absolute;
  top: 50%;
  left: 100%;
  margin-top: -10px;
  border: solid transparent;
  border-width: 10px;
  border-left-color: color-mix(in srgb, var(--machaki-dl-bg) 75%, transparent);
  pointer-events: none;
}
:where(.tax-genre) table tbody td{
  padding-left: 1rem !important;
  background: var(--machaki-table-td-bg);
  color: var(--machaki-table-td-fg);
  font-size: .875rem;
  font-weight: 700;
  text-shadow: var(--machaki-title-shadow);
}
:where(.tax-genre) .cell{
  padding-bottom: 15px;
}
:where(.tax-genre) th{
  white-space: nowrap;
}
:where(.tax-genre) td{
  hyphens: auto;
}

:where(.tax-genre) .side-nav{
  margin-bottom: 30px;
}
:where(.tax-genre) .side-nav h2{
  margin-top: 0;
  padding: .9375rem .625rem .625rem;
  background: var(--biblio-side-nav-bg);
  color: var(--biblio-side-nav-fg);
  font-size: .875rem;
  font-weight: 700;
}
:where(.tax-genre) .side-nav h2 a{
  color: var(--biblio-side-nav-link);
  text-decoration: none;
}
:where(.tax-genre) .side-nav ul{
  margin-top: 30px;
  padding: 0;
  list-style: none;
}
:where(.tax-genre) .side-nav ul li > a{
  display: block;
  padding: .8125rem .625rem .625rem 1.5625rem;
  border-bottom: 1px dotted var(--biblio-side-nav-border);
  background-image: var(--machaki-short-arrow);
  background-repeat: no-repeat;
  background-position: .625rem 1.1875rem;
  color: var(--c-fg);
  font-size: .8125rem;
  text-decoration: none;
}
:where(.tax-genre) .side-nav ul li > a:hover{
  color: var(--c-accent);
}

/* ===== Biblio labels ===== */
:where(.biblio, #biblio, body.biblio) .Label{
  display: inline-flex;
  align-items: center;
  gap: .25rem;
  margin-bottom: .3125rem;
  padding: .333rem .5rem;
  font-size: var(--machaki-label-font-size);
  line-height: 1;
  color: var(--machaki-label-base-fg);
  background: var(--machaki-label-sf-bg);
  border-radius: .25rem;
  text-shadow: var(--machaki-label-shadow-strong);
  cursor: default;
  white-space: nowrap;
}
:where(.biblio, #biblio, body.biblio) .Label.sfsub{
  margin-left: .3125rem;
  background: var(--machaki-label-sf-bg);
  text-shadow: var(--machaki-label-shadow-soft);
}
:where(.biblio, #biblio, body.biblio) .Label.advsub{
  margin-left: .625rem;
  background: var(--machaki-label-adv-bg);
}
:where(.biblio, #biblio, body.biblio) .Label.myssub{
  margin-left: .625rem;
  background: var(--machaki-label-mys-bg);
  text-shadow: var(--machaki-label-shadow-soft);
}
:where(.biblio, #biblio, body.biblio) .Label.kimyosub,
:where(.biblio, #biblio, body.biblio) .Label.horrorsub{
  margin-left: .625rem;
  background: var(--machaki-label-kimyo-bg);
  text-shadow: var(--machaki-label-shadow-strong);
}
:where(.biblio, #biblio, body.biblio) .Label.denkisub,
:where(.biblio, #biblio, body.biblio) .Label.jedisub{
  margin-left: .625rem;
  background: var(--machaki-label-denki-bg);
}
:where(.biblio, #biblio, body.biblio) .Label.sussub{
  margin-left: .625rem;
  background: var(--machaki-label-sus-bg);
}
:where(.biblio, #biblio, body.biblio) .Label.normal,
:where(.biblio, #biblio, body.biblio) .Label.normalsub,
:where(.biblio, #biblio, body.biblio) .Label.taidansub{
  margin-left: .625rem;
  background: var(--machaki-label-normal-bg);
  color: var(--machaki-label-normal-fg);
  font-weight: 400;
  text-shadow: var(--machaki-label-normal-shadow);
}
:where(.biblio, #biblio, body.biblio) .Label.non{
  font-size: 1.3rem;
}

@media (max-width: 639px){
  :where(.biblio, #biblio, body.biblio) .Label.sfsub,
  :where(.biblio, #biblio, body.biblio) .Label.advsub,
  :where(.biblio, #biblio, body.biblio) .Label.denkisub,
  :where(.biblio, #biblio, body.biblio) .Label.horrorsub,
  :where(.biblio, #biblio, body.biblio) .Label.jedisub,
  :where(.biblio, #biblio, body.biblio) .Label.kimyosub,
  :where(.biblio, #biblio, body.biblio) .Label.myssub,
  :where(.biblio, #biblio, body.biblio) .Label.normal,
  :where(.biblio, #biblio, body.biblio) .Label.normalsub,
  :where(.biblio, #biblio, body.biblio) .Label.sussub,
  :where(.biblio, #biblio, body.biblio) .Label.taidansub{
    font-size: .7rem;
    text-shadow: none;
  }
}

:where(.kaisf, .kaiadv, .kaimys){
  color: var(--machaki-kai-small-fg);
  font-weight: 700;
  text-shadow: var(--machaki-kai-shadow);
}
:where(.kaisf, .kaiadv, .kaimys) small{
  color: var(--machaki-kai-small-fg) !important;
  font-size: .9em;
  text-shadow: none;
}

:where(.adv, .denki, .horror, .jedi, .kimyo, .mys, .sf, .sus, .short){
  font-size: 1.5rem;
}

:where(h3.sf a){ color: var(--machaki-label-sf-bg); }
:where(h3.adv a){ color: var(--machaki-label-adv-bg); }
:where(h3.mys a){ color: var(--machaki-label-mys-bg); }
:where(h3.kimyo a),
:where(h3.horror a),
:where(h3.other a){ color: var(--machaki-label-kimyo-bg); }
:where(h3.denki a),
:where(h3.jedi a){ color: var(--machaki-label-denki-bg); }
:where(h3.sus a){ color: var(--machaki-label-sus-bg); }
:where(h3.other a){ color: var(--c-fg); }

/* ===== Single machaki: hero overlap + fade-in ===== */
@media (min-width: 768px){
  body.single-machaki .primary-book .md\\:col-span-1{ margin-top: -5rem; position: relative; z-index: 2; }
}
@media (max-width: 767.98px){
  body.single-machaki .primary-book .md\\:col-span-1{ margin-top: -2.5rem; position: relative; z-index: 2; }
}
body.single-machaki .primary-book img{
  animation: machaki-fade-up 1.2s cubic-bezier(.22,.61,.36,1) both;
  filter: drop-shadow(0 8px 16px rgba(0,0,0,.25));
}
@keyframes machaki-fade-up{
  0%   { opacity: 0; transform: translateY(16px) scale(.88); }
  60%  { opacity: .75; transform: translateY(6px)  scale(.97); }
  100% { opacity: 1; transform: translateY(0)    scale(1); }
}

/* 見出し（本文中 h2/h3 の最小スタイル） */
body.single-machaki .entry-content h2{
  margin: 2rem 0 .75rem;
  padding: .25rem .5rem;
  border-left: 4px solid var(--c-accent);
  background: color-mix(in srgb, var(--c-panel) 96%, transparent);
}
/* h3 は heading10（shortcuts.headings.ts 相当）を適用 */
body.single-machaki .entry-content h3{
  position: relative;
  display: block;
  padding: 14px 5px 10px 50px;        /* pt-14 pr-5 pb-10 pl-50 */
  margin: 30px 20px 10px -10px;      /* mt-30 mr-20 mb-10 ml--10 */
  font-weight: 700;
  font-size: 1.125rem;               /* 18px - ワンポイント大きく */
  line-height: 1;                    /* leading-none */
  color: var(--hd10-fg);
  background: var(--hd10-bg);
  border: none;
  border-radius: 22px 0 0 22px;      /* rounded-l-[22px] */
}
body.single-machaki .entry-content h3::before{
  content: '';
  position: absolute;
  top: 50%;
  left: 14px;
  width: 20px; height: 20px;
  margin-top: -10px;
  background: var(--hd10-before-bg);
  border-radius: 9999px;
  box-shadow: inset 1px 1px 1px #777;
}

/* bibliography ページは heading10 スタイルをリセット（!important で強制） */
#post-3136 .entry-content h3,
#post-4279 .entry-content h3,
#post-3395 .entry-content h3,
#post-3467 .entry-content h3{
  position: static !important;
  display: block !important;
  padding: 0 !important;
  margin: 0 !important;
  font-size: 1.5rem !important;
  font-weight: 700 !important;
  line-height: 1.2 !important;
  min-height: 2.2em !important;
  color: inherit !important;
  background: transparent !important;
  border: none !important;
  border-radius: 0 !important;
}
#post-3136 .entry-content h3::before,
#post-4279 .entry-content h3::before,
#post-3395 .entry-content h3::before,
#post-3467 .entry-content h3::before{
  content: none !important;
  display: none !important;
}

/* h4 は下線グラデのみの見出し */
body.single-machaki .entry-content h4{
  display: block;
  position: relative;
  color: var(--hd12-fg);
  font-size: var(--hd12-fs);
  padding-bottom: .5rem;
  margin: 1.25rem 0 .5rem;
  clear: both;
}
body.single-machaki .entry-content h4::after{
  content: '';
  position: absolute;
  left: 0; bottom: 0;
  width: 100%; height: 2px;
  background: linear-gradient(90deg, var(--hd12-b1), var(--hd12-b2));
}

/* h5 は heading12（左上に2つの菱形装飾）を適用 */
body.single-machaki .entry-content h5{
  display: block;
  position: relative;
  padding: 14px 5px 10px 10px;
  margin: 30px 0 .5rem;
  font-size: var(--hd12-fs, 1.25rem);
  line-height: 1;
  color: var(--hd12-fg, #111);
  clear: both;
}
body.single-machaki .entry-content h5::before{
  content: '';
  position: absolute;
  top: 0;
  left: -5px;
  width: 12px;
  height: 12px;
  background: var(--hd12-b1, #999);
  transform: rotate(45deg);
}
body.single-machaki .entry-content h5::after{
  content: '';
  position: absolute;
  top: 15px;
  left: -10px;
  width: 8px;
  height: 8px;
  background: var(--hd12-b2, #777);
  transform: rotate(12deg);
}

.dark body.single-machaki .entry-content h4{
  color: var(--c-fg);
}
.dark body.single-machaki .entry-content h5{
  color: var(--c-fg);
}
.dark body.single-machaki .entry-content h5::before,
.dark body.single-machaki .entry-content h5::after{
  filter: brightness(1.2) saturate(1.1);
}

/* ===== Machaki panel chips (horizontal, no list marker) ===== */
section.machaki > div.panel > ul{
  display: flex;
  flex-wrap: wrap;
  gap: 0.333rem 0.5rem; /* row-gap column-gap */
  margin: 0;
  padding: 0;
  list-style: none;
}
section.machaki > div.panel > ul > li{
  list-style: none;
  flex: 0 0 auto;       /* モバイルでの横ぐらつきを抑止 */
}
section.machaki > div.panel > ul > li > a{
  display: inline-block;
  text-decoration: none;
}

/* ===== Single machaki: primary-book レイアウト調整（中央寄せ + テーブルを半幅） ===== */
@media (min-width: 768px){
  body.single-machaki .primary-book .grid{
    display: grid !important;
    grid-template-columns: max-content 1fr !important;  /* 左: 画像(内容幅) / 右: 残り幅(テーブル) */
    gap: 1.5rem 2rem !important;
    margin-inline: auto !important;                      /* 中央寄せ */
    width: min(var(--container-w), 100%) !important;     /* コンテナ幅に収める */
    align-items: start !important;
  }
  /* 画像はコンテンツ幅に基づくサイズで固定（w-full を打ち消し） */
  body.single-machaki .primary-book img{
    width: auto !important;
    max-width: clamp(280px, 28vw, 420px) !important;
    height: auto !important;
  }
  body.single-machaki .primary-book .md\\:col-span-2{
    grid-column: auto / auto !important;                /* 2列に合わせて span を解除 */
  }
  body.single-machaki .primary-book table{
    width: 100% !important;                              /* 右カラムの残り幅を占有 */
    margin: 0 !important;
  }
}
@media (max-width: 767.98px){
  body.single-machaki .primary-book table{ width: 100% !important; }
}

/* ===== Single machaki: primary-book のテーブルを biblio と同様に ===== */
body.single-machaki .primary-book table,
body.single-machaki .reprint-details table{
  width: 100%;
  margin-bottom: 2rem;
  border-spacing: 0;
  border-collapse: separate;
  table-layout: fixed;
  border-radius: 0.375rem;
  overflow: hidden;
}
.dark body.single-machaki .primary-book table,
.dark body.single-machaki .reprint-details table{
  border: 1px solid color-mix(in srgb, var(--c-accent-lightcyan) 40%, transparent) !important;
}
body.single-machaki .primary-book table thead th,
body.single-machaki .reprint-details table thead th{
  padding: .5rem;
  border-bottom: 1px solid var(--c-border);
  background: color-mix(in srgb, var(--hd-accent) 10%, transparent);
  color: var(--c-fg);
  font-size: .875rem;
  font-weight: 700;
  text-align: center;
}
.dark body.single-machaki .primary-book table thead th,
.dark body.single-machaki .reprint-details table thead th{
  border-bottom: 1px solid color-mix(in srgb, var(--c-accent-lightcyan) 40%, transparent) !important;
}
/* 1列目の見出し（th）を太く背景色、右側 td は通常背景 */
body.single-machaki .primary-book table tbody th,
body.single-machaki .reprint-details table tbody th{
  position: relative;
  padding: 10px;
  background: color-mix(in srgb, var(--machaki-dl-bg) 75%, transparent);
  color: var(--machaki-dl-fg);
  font-weight: 700;
  text-align: left;
  vertical-align: middle;
  white-space: normal;
  width: 40%;
}
body.single-machaki .primary-book table tbody th > a,
body.single-machaki .reprint-details table tbody th > a{
  color: var(--c-panel);
  text-decoration: underline;
}
body.single-machaki .primary-book table tbody th::after,
body.single-machaki .reprint-details table tbody th::after{
  content: '';
  position: absolute;
  top: 50%;
  left: 100%;
  margin-top: -8px;
  border: solid transparent;
  border-width: 8px;
  border-left-color: color-mix(in srgb, var(--machaki-dl-bg) 75%, transparent);
  pointer-events: none;
}
body.single-machaki .primary-book table tbody td,
body.single-machaki .reprint-details table tbody td{
  padding: 0 0 0 15px;
  background: #f0f0f0;
  color: var(--c-fg);
  border-bottom: 1px solid var(--c-border);
  font-size: .875rem;
  vertical-align: middle;
}
.dark body.single-machaki .primary-book table tbody td,
.dark body.single-machaki .reprint-details table tbody td{
  background: #2a2a2a;
  border-bottom: 1px solid color-mix(in srgb, var(--c-accent-lightcyan) 40%, transparent) !important;
}
.dark body.single-machaki .primary-book table thead th,
.dark body.single-machaki .reprint-details table thead th{
  border-bottom: 2px solid #ddd;
}
body.single-machaki .primary-book table tbody tr:last-child td,
body.single-machaki .reprint-details table tbody tr:last-child td{
  border-bottom: none;
}

/* ===== Single machaki: section.prose 直下の h2 に heading13 を適用 ===== */
body.single-machaki section.prose > h2{
  display: inline-block;
  border-width: var(--hd13-bw);
  border-style: var(--hd13-bs);
  border-color: var(--hd13-bc);
  color: var(--hd13-fg);
  padding: .25rem .75rem; /* py-1 px-3 相当 */
  border-radius: .25rem;  /* rounded */
  margin: 0 0 .75rem 0;  /* 少しだけ下に余白 */
  margin-left: 0;        /* この見出しは左寄せ（他h2は別指定で+1rem） */
}
.dark body.single-machaki section.prose > h2{
  /* 深めの面に薄いハイライトとアクセント縁で質感を出す */
  background:
    linear-gradient(to bottom,
      color-mix(in srgb, var(--c-panel) 18%, #000) 0%,
      color-mix(in srgb, var(--c-panel) 10%, #000) 100%
    ),
    radial-gradient(120% 60% at 50% -20%, rgba(255,255,255,.08), transparent 60%);
  border-color: color-mix(in srgb, var(--c-accent-lightcyan) 55%, transparent);
  box-shadow:
    inset 0 1px 0 rgba(255,255,255,.06),        /* 上端の薄いハイライト */
    inset 0 0 0 1px rgba(255,255,255,.04),      /* 細い内枠 */
    0 2px 10px rgba(0,0,0,.35);                 /* 外側の落ち影 */
  color: var(--c-fg);
}

/* その他の h2 は左パディングを 1rem に */
body.single-machaki .entry-content h2{ padding-left: 1rem; }

/* その他の h2（ダーク時）は、落ち着いたグラデ＋アクセントの縁で質感を付与 */
/* section.prose > h2 は別スタイルのため除外し、その他の h2 のダーク背景に色味を付加 */
.dark body.single-machaki .entry-content :not(section.prose) > h2{
  background:
    linear-gradient(to right,
      color-mix(in srgb, var(--c-accent) 24%, var(--c-panel) 76%) 0%,
      color-mix(in srgb, var(--c-accent) 10%, var(--c-panel) 90%) 100%
    ),
    radial-gradient(160% 80% at 0% -30%, rgba(255,255,255,.07), transparent 60%);
  border-left: 3px solid color-mix(in srgb, var(--c-accent) 65%, transparent);
  border-radius: 0 .35rem .35rem 0;
  box-shadow:
    inset 0 1px 0 rgba(255,255,255,.06),
    inset 0 0 0 1px rgba(255,255,255,.03),
    0 2px 10px rgba(0,0,0,.35);
  color: var(--c-fg);
}
/* ===== Single machaki: hero overlap + fade-in (clone) ===== */
.hero-feature{ position: relative; }
.hero-feature .machaki-hero-book{
  position: absolute;
  left: 50%;
  top: 42%;               /* 初期待機位置（JSでtop(px)を再配置） */
  transform: translateX(-50%);
  z-index: 3;
  opacity: 0;             /* 画像ロード前は非表示 */
  pointer-events: none;
  will-change: transform, opacity;
}
.hero-feature .machaki-hero-book.is-ready{
  opacity: 1;
  animation: machaki-fade-up-center 1.6s cubic-bezier(.22,.61,.36,1) both;
}
.hero-feature .machaki-hero-book img{
  width: min(42vw, 240px);
  height: auto;
  border-radius: .375rem;
  filter: drop-shadow(0 8px 16px rgba(0,0,0,.28));
}
@keyframes machaki-fade-up-center{
  0%   { opacity: 0; transform: translateX(-50%) translateY(20px) scale(.92); }
  100% { opacity: 1; transform: translateX(-50%) translateY(0)    scale(1); }
}
@media (min-width: 1024px){
  .hero-feature .machaki-hero-book{
    left: 50%;
    top: 36%;            /* 初期待機位置（JSで上書き） */
    transform: translateX(-50%);
  }
  .hero-feature .machaki-hero-book img{ width: min(26vw, 280px); }
}

:where(#post-3136, #post-4279, #post-3395, #post-3467, #post-2412, #post-2416, #post-2414, #post-2418, #post-2544, #post-2805) ul.machaki_shorts_lists{
  margin-bottom: 1rem;
  list-style: none;
  padding-left: 0;
}
.parent-pageid-2410 article#post-3136 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-4279 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-3395 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-3467 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-2412 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-2416 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-2414 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-2418 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-2544 ul.machaki_shorts_lists > li,
.parent-pageid-2410 article#post-2805 ul.machaki_shorts_lists > li{
  display: inline-block;
  margin-right: 0.5rem;
  margin-bottom: 0.25rem;
  margin-top: 0;
  padding-left: .5rem;
  background: var(--machaki-short-arrow) no-repeat left center;
  background-size: .5rem;
  vertical-align: top;
  max-width: 100%;
}

.parent-pageid-2410 article#post-3136 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-4279 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-3395 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-3467 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-2412 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-2416 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-2414 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-2418 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-2544 ul.machaki_shorts_lists > li > a,
.parent-pageid-2410 article#post-2805 ul.machaki_shorts_lists > li > a{
  word-break: break-word;
  overflow-wrap: break-word;
  white-space: normal;
  display: inline;
}

.parent-pageid-2410 article#post-3136 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-4279 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-3395 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-3467 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-2412 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-2416 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-2414 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-2418 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-2544 dl.machaki_shorts_lists dd li,
.parent-pageid-2410 article#post-2805 dl.machaki_shorts_lists dd li{
  display: inline-block;
  margin-right: 0.5rem;
  margin-bottom: 0.25rem;
  margin-top: 0;
  padding-left: .5rem;
  background: var(--machaki-short-arrow) no-repeat left center;
  background-size: .5rem;
  vertical-align: top;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467, #post-2412, #post-2416, #post-2414, #post-2418, #post-2544, #post-2805) dl.machaki_shorts_lists dt{
  margin: 1rem 0 0 1rem;
  padding: .1875rem .3125rem;
  background: var(--machaki-dl-bg);
  color: var(--machaki-dl-fg);
}

:where(#post-3136, #post-4279, #post-3395, #post-3467, #post-2412, #post-2416, #post-2414, #post-2418, #post-2544, #post-2805) dl.machaki_shorts_lists dt a{
  color: #fff;
  text-decoration: underline;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467, #post-2412, #post-2416, #post-2414, #post-2418, #post-2544, #post-2805) dl.machaki_shorts_lists dd{
  margin-top: 0;
  margin-left: 0;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467, #post-2412, #post-2416, #post-2414, #post-2418, #post-2544, #post-2805) dl.machaki_shorts_lists dd ul{
  margin: 0;
  padding: 0;
  list-style: none;
}

/* ===== Bibliography page (#post-3136) grid list reset ===== */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content ol,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content ul{
  margin: 0;
  padding: 0 0 0 1.5rem;
  list-style: none;
  counter-reset: item;
}

#post-3136 .entry-content ol > li:not([value]),
#post-4279 .entry-content ol > li:not([value]),
#post-3395 .entry-content ol > li:not([value]),
#post-3467 .entry-content ol > li:not([value]),
#post-3136 .entry-content ul > li:not([value]),
#post-4279 .entry-content ul > li:not([value]),
#post-3395 .entry-content ul > li:not([value]),
#post-3467 .entry-content ul > li:not([value]){
  margin: 0 0 2rem 0;
  counter-increment: item;
  align-self: start;
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 0.5rem;
}

/* li counter styling using ::before */
#post-3136 .entry-content ol > li:not([value])::before,
#post-4279 .entry-content ol > li:not([value])::before,
#post-3395 .entry-content ol > li:not([value])::before,
#post-3467 .entry-content ol > li:not([value])::before{
  content: counter(item) '. ';
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--c-fg);
  grid-column: 1;
}

#post-3136 .entry-content ol > li:not([value]) > *,
#post-4279 .entry-content ol > li:not([value]) > *,
#post-3395 .entry-content ol > li:not([value]) > *,
#post-3467 .entry-content ol > li:not([value]) > *{
  grid-column: 2;
}

/* h3 title styling in bibliography grid */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content ol h3{
  margin: 0;
  font-size: 1.5rem;
  font-weight: 700;
  line-height: 1.2;
  min-height: 2.2em;
  display: block;
}

/* h3 small element styling */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content ol h3 small{
  margin-left: 10px;
  color: #777;
  font-size: 0.9rem;
  font-weight: 700;
  text-shadow: none;
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content ol h3 small{
  color: #999;
}

/* Special styling for li[value] items */
#post-3136 .entry-content ol > li[value],
#post-4279 .entry-content ol > li[value],
#post-3395 .entry-content ol > li[value],
#post-3467 .entry-content ol > li[value]{
  list-style-type: none !important;
  font-style: italic;
}

#post-3136 .entry-content ol > li[value] h3,
#post-4279 .entry-content ol > li[value] h3,
#post-3395 .entry-content ol > li[value] h3,
#post-3467 .entry-content ol > li[value] h3{
  font-size: 1.125rem !important;
}

/* Label badges in bibliography grid */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label{
  display: inline-flex;
  align-items: center;
  gap: .25rem;
  margin-left: .5rem;
  padding: .333rem .5rem;
  font-size: var(--machaki-label-font-size);
  line-height: 1;
  color: var(--machaki-label-base-fg);
  background: var(--machaki-label-sf-bg);
  border-radius: .25rem;
  text-shadow: var(--machaki-label-shadow-strong);
  white-space: nowrap;
  vertical-align: middle;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.sfsub{
  background: var(--machaki-label-sf-bg);
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.advsub{
  background: var(--machaki-label-adv-bg);
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.myssub{
  background: var(--machaki-label-mys-bg);
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.horrorsub,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.kimyosub{
  background: var(--machaki-label-kimyo-bg);
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.denkisub,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.jedisub{
  background: var(--machaki-label-denki-bg);
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.sussub{
  background: var(--machaki-label-sus-bg);
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.normal,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content .Label.normalsub{
  background: var(--machaki-label-normal-bg);
  color: var(--machaki-label-normal-fg);
  text-shadow: var(--machaki-label-normal-shadow);
}

/* Genre-specific h3 link colors */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.sf a{
  color: var(--machaki-label-sf-bg);
  text-decoration: none;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.sf a:hover{
  text-decoration: underline;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.adv a{
  color: var(--machaki-label-adv-bg);
  text-decoration: none;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.adv a:hover{
  text-decoration: underline;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.mys a{
  color: var(--machaki-label-mys-bg);
  text-decoration: none;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.mys a:hover{
  text-decoration: underline;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.other a,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.kimyo a,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.horror a{
  color: var(--machaki-label-kimyo-bg);
  text-decoration: none;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.kimyo a:hover,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.horror a:hover{
  text-decoration: underline;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.denki a,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.jedi a{
  color: var(--machaki-label-denki-bg);
  text-decoration: none;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.denki a:hover,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.jedi a:hover{
  text-decoration: underline;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.sus a{
  color: var(--machaki-label-sus-bg);
  text-decoration: none;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.sus a:hover{
  text-decoration: underline;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.short a{
  color: var(--machaki-label-sus-bg);
  text-decoration: none;
}
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content h3.short a:hover{
  text-decoration: underline;
}

/* Dark mode: brighter colors for WCAG 2.2 (AA) compliance */
.dark #post-3136 .entry-content h3.sf a,
.dark #post-4279 .entry-content h3.sf a,
.dark #post-3395 .entry-content h3.sf a,
.dark #post-3467 .entry-content h3.sf a{
  color: #a385ff !important;
}

.dark #post-3136 .entry-content h3.adv a,
.dark #post-4279 .entry-content h3.adv a,
.dark #post-3395 .entry-content h3.adv a,
.dark #post-3467 .entry-content h3.adv a{
  color: #d98fd9 !important;
}

.dark #post-3136 .entry-content h3.mys a,
.dark #post-4279 .entry-content h3.mys a,
.dark #post-3395 .entry-content h3.mys a,
.dark #post-3467 .entry-content h3.mys a{
  color: #ff6b6b !important;
}

.dark #post-3136 .entry-content h3.kimyo a,
.dark #post-4279 .entry-content h3.kimyo a,
.dark #post-3395 .entry-content h3.kimyo a,
.dark #post-3467 .entry-content h3.kimyo a,
.dark #post-3136 .entry-content h3.horror a,
.dark #post-4279 .entry-content h3.horror a,
.dark #post-3395 .entry-content h3.horror a,
.dark #post-3467 .entry-content h3.horror a,
.dark #post-3136 .entry-content h3.short a,
.dark #post-4279 .entry-content h3.short a,
.dark #post-3395 .entry-content h3.short a,
.dark #post-3467 .entry-content h3.short a{
  color: #aaa !important;
}

.dark #post-3136 .entry-content h3.denki a,
.dark #post-4279 .entry-content h3.denki a,
.dark #post-3395 .entry-content h3.denki a,
.dark #post-3467 .entry-content h3.denki a,
.dark #post-3136 .entry-content h3.jedi a,
.dark #post-4279 .entry-content h3.jedi a,
.dark #post-3395 .entry-content h3.jedi a,
.dark #post-3467 .entry-content h3.jedi a{
  color: #6fc96f !important;
}

.dark #post-3136 .entry-content h3.sus a,
.dark #post-4279 .entry-content h3.sus a,
.dark #post-3395 .entry-content h3.sus a,
.dark #post-3467 .entry-content h3.sus a{
  color: #5bc0ff !important;
}

/* ===== Bibliography page (#post-3136) table styles ===== */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table{
  width: 100%;
  margin-bottom: 2rem;
  border-spacing: 0;
  border-collapse: separate;
  table-layout: fixed;
  border-radius: 0.375rem;
  overflow: hidden;
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table{
  border: 1px solid color-mix(in srgb, var(--c-accent-lightcyan) 40%, transparent) !important;
}

/* Ruby tag spacing fix */
.parent-pageid-2410 article#post-3136 .entry-content ruby,
.parent-pageid-2410 article#post-4279 .entry-content ruby,
.parent-pageid-2410 article#post-3395 .entry-content ruby,
.parent-pageid-2410 article#post-3467 .entry-content ruby{
  display: ruby;
  ruby-position: over;
}

.parent-pageid-2410 article#post-3136 .entry-content rt,
.parent-pageid-2410 article#post-4279 .entry-content rt,
.parent-pageid-2410 article#post-3395 .entry-content rt,
.parent-pageid-2410 article#post-3467 .entry-content rt{
  display: ruby-text;
  font-size: 0.5em;
  line-height: 0.8;
  margin: 0;
  padding: 0;
  vertical-align: top;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table thead th{
  padding: .5rem;
  border-bottom: 1px solid var(--c-border);
  background: color-mix(in srgb, var(--hd-accent) 10%, transparent);
  color: var(--c-fg);
  font-size: .875rem;
  font-weight: 700;
  text-align: center;
}
.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table thead th{
  border-bottom: 1px solid color-mix(in srgb, var(--c-accent-lightcyan) 40%, transparent) !important;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table thead th:nth-child(1),
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody th{
  width: 40%;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table thead th:nth-child(2),
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody td:nth-child(1){
  width: 30%;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table thead th:nth-child(3),
:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody td:nth-child(2){
  width: 30%;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody th{
  position: relative;
  padding: 10px;
  background: color-mix(in srgb, var(--machaki-dl-bg) 75%, transparent);
  color: var(--machaki-dl-fg);
  font-weight: 700;
  text-align: left;
  vertical-align: middle;
  white-space: normal;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody th > a{
  color: var(--c-panel);
  text-decoration: underline;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody th::after{
  content: '';
  position: absolute;
  top: 50%;
  left: 100%;
  margin-top: -8px;
  border: solid transparent;
  border-width: 8px;
  border-left-color: color-mix(in srgb, var(--machaki-dl-bg) 75%, transparent);
  pointer-events: none;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody td{
  padding: 0 0 0 15px;
  background: #f0f0f0;
  color: var(--c-fg);
  border-bottom: 1px solid var(--c-border);
  font-size: .875rem;
  vertical-align: middle;
  white-space: normal;
  word-break: break-word;
  overflow-wrap: break-word;
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody td{
  background: #2a2a2a;
  border-bottom: 1px solid color-mix(in srgb, var(--c-accent-lightcyan) 40%, transparent) !important;
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table thead th{
  border-bottom: 2px solid #ddd;
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody th > a{
  color: #fff !important;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .entry-content table tbody tr:last-child td{
  border-bottom: none;
}

/* ===== Machaki archive table (taxonomy-genre listing) ===== */
.machaki-archive-table table{
  width: 100%;
  margin-bottom: 0;
  border-spacing: 0;
  border-collapse: separate;
  table-layout: fixed;
  border-radius: 0.375rem;
  overflow: hidden;
}
.dark .machaki-archive-table table{
  border: 1px solid color-mix(in srgb, var(--c-accent-lightcyan) 40%, transparent);
}
.machaki-archive-table table tbody th{
  position: relative;
  padding: 10px;
  background: color-mix(in srgb, var(--machaki-dl-bg) 75%, transparent);
  color: var(--machaki-dl-fg);
  font-weight: 700;
  font-size: .875rem;
  text-align: left;
  vertical-align: middle;
  white-space: nowrap;
  width: 30%;
}
.machaki-archive-table table tbody th::after{
  content: '';
  position: absolute;
  top: 50%;
  left: 100%;
  margin-top: -8px;
  border: solid transparent;
  border-width: 8px;
  border-left-color: color-mix(in srgb, var(--machaki-dl-bg) 75%, transparent);
  pointer-events: none;
}
.machaki-archive-table table tbody td{
  padding: 8px 10px 8px 18px;
  background: #f0f0f0;
  color: var(--c-fg);
  border-bottom: 1px solid var(--c-border);
  font-size: .875rem;
  vertical-align: middle;
}
.dark .machaki-archive-table table tbody td{
  background: #2a2a2a;
  border-bottom: 1px solid color-mix(in srgb, var(--c-accent-lightcyan) 40%, transparent);
  font-weight: 600;
  text-shadow: none;
}
.machaki-archive-table table tbody tr:last-child td{
  border-bottom: none;
}

/* Machaki archive section headings (h3/h4) - matches single-machaki h2 style */
.machaki-archive-section h3,
.machaki-archive-section h4{
  margin: 0 0 .75rem;
  padding: .25rem .5rem;
  border-left: 4px solid var(--c-accent);
  background: color-mix(in srgb, var(--c-panel) 96%, transparent);
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--c-fg);
}
.dark .machaki-archive-section h3,
.dark .machaki-archive-section h4{
  background: color-mix(in srgb, var(--c-accent) 15%, var(--c-panel) 85%);
  border-left-color: var(--c-accent);
}
.machaki-archive-section h4{
  font-size: 1rem;
}
/* Larger text for content in archive sections */
.machaki-archive-section .prose{
  font-size: 1rem;
  line-height: 1.75;
}
.machaki-archive-section .prose p,
.machaki-archive-section .prose li{
  font-size: 1rem;
}

/* Machaki archive article footer - remove background, right-align */
.tax-genre article footer,
body.tax-genre article footer{
  display: flex !important;
  justify-content: flex-end !important;
  background: transparent !important;
  background-color: transparent !important;
  border: none !important;
}
.dark .tax-genre article footer,
html.dark .tax-genre article footer,
html.dark body.tax-genre article footer{
  display: flex !important;
  justify-content: flex-end !important;
  background: transparent !important;
  background-color: transparent !important;
}

/* Machaki pagination (WordPress the_posts_pagination) */
.machaki-pagination{
  margin-top: 2rem;
}
.machaki-pagination .nav-links{
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}
.machaki-pagination .page-numbers{
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 2.5rem;
  height: 2.5rem;
  padding: 0.5rem 0.75rem;
  border-radius: 0.375rem;
  border: 1px solid var(--c-border);
  background: var(--c-panel);
  color: var(--c-fg);
  text-decoration: none;
  transition: all 0.2s ease;
}
.machaki-pagination .page-numbers:hover:not(.current):not(.dots){
  background: var(--c-accent);
  color: #fff;
  border-color: var(--c-accent);
}
.machaki-pagination .page-numbers.current{
  background: var(--c-accent);
  color: #fff;
  border-color: var(--c-accent);
  font-weight: 700;
}
.machaki-pagination .page-numbers.dots{
  border: none;
  background: transparent;
}

/* ===== biblio: structure ===== */
:where(.biblio, #biblio, body.biblio) .biblio-list{
  display: grid; gap: var(--biblio-gap);
}
:where(.biblio, #biblio, body.biblio) .biblio-item{
  display: grid;
  grid-template-columns: var(--biblio-key-w) 1fr;
  align-items: start;
}
@media (max-width: 640px){
  :where(.biblio, #biblio, body.biblio) .biblio-item{
    grid-template-columns: 1fr;
  }
}

/* ===== Bibliography pagination ===== */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination{
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
  margin-top: 3rem;
  padding: 1.5rem 0;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li{
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 2.5rem;
  height: 2.5rem;
  padding: 0;
  border-radius: 0.375rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s ease;
  cursor: pointer;
  background: color-mix(in srgb, var(--c-panel) 90%, transparent);
  color: var(--c-fg);
  border: 1px solid var(--c-border);
  line-height: 1;
  vertical-align: middle;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li > a{
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  padding: 0.5rem 0.75rem;
  color: inherit;
  text-decoration: none;
  line-height: 1;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.pagination-previous > a::before{
  content: '‹ ';
  margin-right: 0.25rem;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.pagination-next > a::after{
  content: ' ›';
  margin-left: 0.25rem;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li:not(.current):not(.disabled):not(.dots):hover{
  background: var(--c-accent);
  color: #fff;
  border-color: var(--c-accent);
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.current{
  background: #2199e8;
  color: #fff;
  border: 1px solid #2199e8;
  font-weight: 700;
  cursor: default;
  padding: 0.5rem 0.75rem;
  text-align: center;
}

/* Screen reader only text for "このページにいます" */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination .screen-reader-text,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination .show-for-sr,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination .current > span{
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.dots{
  color: var(--c-muted);
  border: none;
  background: transparent;
  cursor: default;
}

/* Disabled state for pagination */
:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.pagination-previous.disabled,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.pagination-next.disabled{
  background: #e0e0e0 !important;
  color: #999 !important;
  border: 1px solid #d0d0d0 !important;
  cursor: not-allowed !important;
  opacity: 0.5;
}

:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.pagination-previous.disabled:hover,
:where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.pagination-next.disabled:hover{
  background: #e0e0e0 !important;
  color: #999 !important;
  cursor: not-allowed !important;
  transform: none !important;
  box-shadow: none !important;
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.pagination-previous.disabled,
.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.pagination-next.disabled{
  background: #3a3a3a !important;
  color: #666 !important;
  border: 1px solid #4a4a4a !important;
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li:not(.current):not(.disabled):not(.dots){
  background: color-mix(in srgb, var(--c-panel) 80%, transparent);
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li:not(.current):not(.disabled):not(.dots):hover{
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.dark :where(#post-3136, #post-4279, #post-3395, #post-3467) .pagination li.current{
  background: #2199e8;
  border-color: #2199e8;
}
`
export const preflightBiblio: Preflight = { getCSS: () => css }

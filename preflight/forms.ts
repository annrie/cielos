import type { Preflight } from 'unocss'

export const preflightForms: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== Forms: base reset ===== */
:where(input,select,textarea,button){ font: inherit; color: inherit; }
:where(input,select,textarea){ background: var(--form-bg); color: var(--form-fg); border:1px solid var(--form-bc); border-radius: var(--form-radius); }
:where(input,select){ height: var(--form-h); }
:where(input,select,textarea){ padding: var(--form-py) var(--form-px); box-shadow: var(--form-shadow); outline: none; box-sizing: border-box; }
:where(input::placeholder, textarea::placeholder){ color: var(--form-ph); }

/* テキスト入力系フィールドを親要素の幅いっぱいに */
input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]):not([type="reset"]),
select,
textarea{ width: 100%; }

/* MW/Uno WP Form の電話番号・郵便番号フィールド（複数入力フィールド）はデフォルト幅 */
input[name^="お電話番号"],
input[name^="郵便番号"],
.mwform-tel-field input,
.mwform-zip-field input,
.unoform-tel-field input,
.unoform-zip-field input{ width: auto !important; }

/* focus */
:where(input,select,textarea):focus{ box-shadow: var(--form-shadow-focus); border-color: transparent; }

/* group spacing */
:where(form, .search-form, .comment-form) :where(.form-row, .form-group){ margin-bottom: var(--form-gap); }

/* label 内のバッジ（必須など）とラベル文字の間隔 */
label > .Label{ margin-left: 5px; }

/* ===== MW/Uno WP Form: 行間をトークンで統一 ===== */
/* フォーム全体のギャップを 10px に固定（必要に応じて tokens.css 側へ昇格可） */
:is(.mw_wp_form,.uno_wp_form){ --form-gap: 10px; }

/* ===== MW/Uno WP Form: 12カラムグリッドレイアウト ===== */
/* WP 管理画面本文内のクラスは UnoCSS スキャン対象外になりやすいので直接定義 */
:is(.mw_wp_form,.uno_wp_form) .grid{
  display: grid;
  row-gap: var(--form-gap);
}
:is(.mw_wp_form,.uno_wp_form) .grid-cols-12{
  grid-template-columns: repeat(12, minmax(0, 1fr));
}
:is(.mw_wp_form,.uno_wp_form) .gap-x-2{ column-gap: 0.5rem; }
:is(.mw_wp_form,.uno_wp_form) .items-center{ align-items: center; }

/* カラムスパン */
:is(.mw_wp_form,.uno_wp_form) .col-span-12{ grid-column: span 12 / span 12; }

/* デスクトップ: ラベル(4) + 入力(8) の横並び */
@media (min-width: 1024px){
  :is(.mw_wp_form,.uno_wp_form) .lg\:col-span-4{ grid-column: span 4 / span 4; }
  :is(.mw_wp_form,.uno_wp_form) .lg\:col-span-8{ grid-column: span 8 / span 8; }
  :is(.mw_wp_form,.uno_wp_form) .text-right{ text-align: right; }
}

/* タブレット: ラベル(6) + 入力(6) */
@media (min-width: 768px) and (max-width: 1023.98px){
  :is(.mw_wp_form,.uno_wp_form) .md\:col-span-6{ grid-column: span 6 / span 6; }
}

/* モバイル時はラベルを左寄せ・縦並び */
@media (max-width: 767.98px){
  :is(.mw_wp_form,.uno_wp_form) .text-right{ text-align: left !important; }
  :is(.mw_wp_form,.uno_wp_form) label{ text-align: left !important; display: block; }
}

/* ===== 必須バッジ（Label）を目立たせる ===== */
:is(.mw_wp_form,.uno_wp_form) label > .Label{
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 0 .375rem;
  min-height: 1.25rem;
  line-height: 1.2;
  font-size: .75rem;          /* 12px 相当 */
  font-weight: 700;
  color: var(--badge-required-fg, #fff);
  background: var(--badge-required-bg, var(--c-accent, #b92a2c));
  border: 1px solid var(--badge-required-bc, color-mix(in srgb, var(--badge-required-bg, var(--c-accent, #b92a2c)) 60%, black));
  border-radius: 999px;
  box-shadow: 0 1px 2px rgba(0,0,0,.12);
}
:is(.mw_wp_form,.uno_wp_form) label > .Label::before{
  content: "!";
  display: inline-block;
  font-weight: 900;
}

/* ===== Uno WP Form: submit buttons ===== */
:is(.mw_wp_form,.uno_wp_form) :where(input[type="submit"], button[type="submit"]){
  appearance: none;
  display: inline-block;
  min-height: calc(var(--form-h, 40px) + 4px);
  width: auto;
  min-width: min(100%, 11rem);
  padding: .65rem 1.35rem;
  border: 1px solid color-mix(in srgb, var(--c-accent, #2563eb) 72%, black);
  border-radius: calc(var(--form-radius, 6px) + 2px);
  background:
    linear-gradient(180deg,
      color-mix(in srgb, var(--c-accent, #2563eb) 92%, white) 0%,
      var(--c-accent, #2563eb) 100%);
  color: var(--c-fg-inv, #fff);
  box-shadow:
    0 10px 18px rgba(0,0,0,.18),
    inset 0 1px 0 rgba(255,255,255,.24);
  font-weight: 700;
  line-height: 1.2;
  letter-spacing: 0;
  text-align: center;
  cursor: pointer;
  transform: translateY(0);
  transition: transform .12s ease, box-shadow .12s ease, filter .12s ease, background-color .12s ease;
  vertical-align: middle;
}
:is(.mw_wp_form,.uno_wp_form) :where(input[type="submit"], button[type="submit"]):hover:not(:disabled){
  filter: brightness(1.06);
  box-shadow:
    0 13px 24px rgba(0,0,0,.22),
    inset 0 1px 0 rgba(255,255,255,.28);
}
:is(.mw_wp_form,.uno_wp_form) :where(input[type="submit"], button[type="submit"]):active:not(:disabled){
  transform: translateY(2px);
  box-shadow:
    0 4px 9px rgba(0,0,0,.18),
    inset 0 2px 4px rgba(0,0,0,.18);
}
:is(.mw_wp_form,.uno_wp_form) :where(input[type="submit"], button[type="submit"]):focus-visible{
  outline: 2px solid color-mix(in srgb, var(--c-accent, #2563eb) 55%, white);
  outline-offset: 3px;
}
:is(.mw_wp_form,.uno_wp_form) :where(input[type="submit"], button[type="submit"]):disabled{
  cursor: not-allowed;
  opacity: .72;
  filter: saturate(.72) grayscale(.1);
  transform: none;
  box-shadow:
    0 6px 12px rgba(0,0,0,.12),
    inset 0 1px 0 rgba(255,255,255,.18);
}
:is(.mw_wp_form,.uno_wp_form) input[name="submitBack"]{
  border-color: var(--form-bc, color-mix(in srgb, currentColor 24%, transparent));
  background: var(--form-bg, transparent);
  color: var(--form-fg, currentColor);
  box-shadow: var(--form-shadow, none);
}
:is(.mw_wp_form,.uno_wp_form) input[name="submitBack"]:hover:not(:disabled){
  background: color-mix(in srgb, var(--c-accent, #2563eb) 8%, var(--form-bg, #fff));
  filter: none;
}
:is(.mw_wp_form,.uno_wp_form) input[name="submitBack"]:active:not(:disabled){
  box-shadow: inset 0 2px 4px rgba(0,0,0,.12);
}
:is(.mw_wp_form,.uno_wp_form) :where(div,p):has(> input[name="submitBack"]){
  display: flex;
  justify-content: center;
  align-items: center;
  gap: .75rem;
  flex-wrap: wrap;
  width: 100%;
  text-align: center;
}
:is(.mw_wp_form,.uno_wp_form) :where(div,p):has(> input[name="submitBack"]) > :where(input[type="submit"], button[type="submit"]){
  margin: 0;
  flex: 0 1 11rem;
}
@media (max-width: 480px){
  :is(.mw_wp_form,.uno_wp_form) :where(div,p):has(> input[name="submitBack"]) > :where(input[type="submit"], button[type="submit"]){
    flex-basis: 100%;
  }
}

/* ===== このページに限り: エントリーメタ（日付など）を非表示 ===== */
.has-mwform .entry-meta,
.has-unoform .entry-meta{ display: none !important; }

/* ===== WordPress 互換ブリッジ ===== */
.search-form .search-submit{ height: var(--form-h); }
.comment-form textarea{ min-height: 160px; resize: vertical; }
`,
}

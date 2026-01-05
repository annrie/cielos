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

/* MWFormの電話番号・郵便番号フィールド（複数入力フィールド）はデフォルト幅 */
input[name^="お電話番号"],
input[name^="郵便番号"],
.mwform-tel-field input,
.mwform-zip-field input{ width: auto !important; }

/* focus */
:where(input,select,textarea):focus{ box-shadow: var(--form-shadow-focus); border-color: transparent; }

/* group spacing */
:where(form, .search-form, .comment-form) :where(.form-row, .form-group){ margin-bottom: var(--form-gap); }

/* label 内のバッジ（必須など）とラベル文字の間隔 */
label > .Label{ margin-left: 5px; }

/* ===== MW WP Form: 行間をトークンで統一 ===== */
/* フォーム全体のギャップを 10px に固定（必要に応じて tokens.css 側へ昇格可） */
.mw_wp_form{ --form-gap: 10px; }

/* ===== MW WP Form: 12カラムグリッドレイアウト ===== */
/* MW WP Form が生成するクラスは UnoCSS スキャン対象外なので直接定義 */
.mw_wp_form .grid{
  display: grid;
  row-gap: var(--form-gap);
}
.mw_wp_form .grid-cols-12{
  grid-template-columns: repeat(12, minmax(0, 1fr));
}
.mw_wp_form .gap-x-2{ column-gap: 0.5rem; }
.mw_wp_form .items-center{ align-items: center; }

/* カラムスパン */
.mw_wp_form .col-span-12{ grid-column: span 12 / span 12; }

/* デスクトップ: ラベル(4) + 入力(8) の横並び */
@media (min-width: 1024px){
  .mw_wp_form .lg\:col-span-4{ grid-column: span 4 / span 4; }
  .mw_wp_form .lg\:col-span-8{ grid-column: span 8 / span 8; }
  .mw_wp_form .text-right{ text-align: right; }
}

/* タブレット: ラベル(6) + 入力(6) */
@media (min-width: 768px) and (max-width: 1023.98px){
  .mw_wp_form .md\:col-span-6{ grid-column: span 6 / span 6; }
}

/* モバイル時はラベルを左寄せ・縦並び */
@media (max-width: 767.98px){
  .mw_wp_form .text-right{ text-align: left !important; }
  .mw_wp_form label{ text-align: left !important; display: block; }
}

/* ===== 必須バッジ（Label）を目立たせる ===== */
.mw_wp_form label > .Label{
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
.mw_wp_form label > .Label::before{
  content: "!";
  display: inline-block;
  font-weight: 900;
}

/* ===== このページに限り: エントリーメタ（日付など）を非表示 ===== */
.has-mwform .entry-meta{ display: none !important; }

/* ===== WordPress 互換ブリッジ ===== */
.search-form .search-submit{ height: var(--form-h); }
.comment-form textarea{ min-height: 160px; resize: vertical; }
`,
}

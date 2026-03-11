# LiftKit-Vue マップ変換対象実績一覧（cielos）

UnoCSS + presetLiftKit 導入に伴い、標準ユーティリティクラスが CSS 変数に間接参照される問題への対応記録。

## 問題の概要

presetLiftKit は UnoCSS の標準ユーティリティを CSS 変数経由の値にリマップする。
変数が未定義の場合は `inherit` にフォールバックし、意図しないスタイル継承が発生する。
また `bg-[]` / `text-[]` で CSS 変数を渡すと UnoCSS が自動的に `color-mix(in oklab, ...)` でラップし、
グラデーション値や特定のカラー形式が壊れる。

**対策**: arbitrary property 記法 `[property:value]` を使い、変数間接参照と color-mix ラッピングをバイパスする。

---

## 導入構成

### 追加パッケージ
- `@liftkit-vue/preset-unocss`: ^0.1.0
- `@liftkit-vue/theme-css`: ^0.1.0

### uno.config.ts の変更点
1. `presetLiftKit({ injectVars: false })` をプリセットに追加
2. `liftkit-core.css` をプリフライトとして注入（CSS Level 4 の `pow()`/`round()` は事前計算で置換）
3. リセットスタイル（html, body, *, a）は除外し、button スタイルのみ追加

---

## 1. タイポグラフィスケール変換（font-size）

LiftKit が `text-{size}` を `font-size: var(--text-{size}-fontSize)` にリマップ。
cielos では独自の `TEXT_SCALE` + `clamp()` で流体タイポグラフィを定義済み。

| 元クラス | LiftKit変換後 | 未定義変数 | 備考 |
|----------|--------------|-----------|------|
| `text-xs` | `font-size: var(--text-xs-fontSize)` | `--text-xs-fontSize` ❌ | cielos独自clamp値あり |
| `text-sm` | `font-size: var(--text-sm-fontSize)` | `--text-sm-fontSize` ❌ | 同上 |
| `text-base` | `font-size: var(--text-base-fontSize)` | `--text-base-fontSize` ✅ | LiftKit定義済 |
| `text-lg` | `font-size: var(--text-lg-fontSize)` | `--text-lg-fontSize` ❌ | cielos独自clamp値あり |

**注意**: cielos の `TEXT_SCALE` が `buildTextTheme()` 経由で UnoCSS テーマに登録されるため、
presetLiftKit のリマップと競合する可能性がある。問題が発生した場合は `[font-size:...]` 記法で回避。

---

## 2. フォントウェイト変換（font-weight）

LiftKit が `font-bold` を `font-weight: var(--fontWeight-bold)` にリマップ。

| 元クラス | 変換後 | 未定義変数 |
|----------|--------|-----------|
| `font-bold` | `[font-weight:bold]` or `[font-weight:700]` | `--fontWeight-bold` ❌ |

### 適用ファイル
- 現時点で変換実績なし（問題発生時に対応）

---

## 3. カラー color-mix() ラッピング回避

UnoCSS の `text-[var(...)]` / `bg-[var(...)]` は値を `color-mix(in oklab, ...)` でラップする。
CSS 変数がグラデーションや複合値を持つ場合に壊れる。

| 元記法 | 変換先 | 理由 |
|--------|--------|------|
| `bg-[var(--xxx)]` | `[background:var(--xxx)]` | color-mix がグラデーション対応不可 |
| `text-[var(--xxx)]` | `[color:var(--xxx)]` | color-mix がカラー値を変質させる |
| `border-[var(--xxx)]` | `[border-color:var(--xxx)]` | 同上 |

### 適用ファイル
- 現時点で変換実績なし（問題発生時に対応）

---

## 4. ボーダー複合値

`border-[var(...)]` も color-mix ラッピングの影響を受ける。

| 元記法 | 変換後 | 理由 |
|--------|--------|------|
| `border-[1px] border-solid border-[var(--xxx)]` | `[border:1px_solid_var(--xxx)]` | 一括指定で回避 |

---

## 5. line-height / --un-leading 変数

LiftKit が `leading-*` を内部変数 `--un-leading` にマップし、意図しない値になる場合がある。

| 元クラス | 変換後 | 理由 |
|----------|--------|------|
| `leading-[1.5]` | `[--un-leading:1.5] [line-height:1.5]` | --un-leading が上書きされるため両方指定 |

---

## 6. 潜在的な影響箇所（要確認）

以下のファイル・クラスも同様の問題を持つ可能性がある:

- `text-sm`, `text-xs`, `text-lg`, `text-xl`, `text-2xl` を使用する Vue コンポーネント
- `font-bold`, `font-semibold` 等のフォントウェイトクラス
- `bg-[var(...)]` でグラデーション値を渡している shortcut（headings.ts 等）
- cielos 独自の `btn-*` ショートカット（`btn-outline` の unmatched utility 警告あり）

### 確認コマンド例

```bash
# text-* クラスの使用箇所を検索
grep -rn 'text-\(xs\|sm\|lg\|xl\|2xl\|3xl\)' src/components/

# font-weight クラスの使用箇所を検索
grep -rn 'font-\(bold\|semibold\|medium\|light\)' src/components/

# bg-[var(...)] パターンの検索（グラデーション候補）
grep -rn 'bg-\[var(' shortcuts/
```

---

## 更新履歴

- 2026-03-11: 初版作成（LiftKit-Vue 導入、変換パターンの記録）

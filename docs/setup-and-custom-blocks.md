# Cielos テーマ完全ガイド — セットアップからカスタムブロックスタイルの作成まで

Vite + UnoCSS + Vue 3 + TypeScript で構築されたモダン WordPress テーマ「Cielos」の導入・カスタマイズ・カスタムブロック開発を、テーマ開発経験者向けに解説します。

---

## 目次

1. [はじめに](#はじめに)
2. [セットアップ](#セットアップ)
3. [テーマのカスタマイズ](#テーマのカスタマイズ)
4. [既存ブロックへのスタイル追加](#既存ブロックへのスタイル追加)
5. [カスタムブロックの新規作成](#カスタムブロックの新規作成)
6. [まとめ](#まとめ)

---

## はじめに

### Cielos とは

Cielos は、従来の WordPress テーマ開発のワークフローを一新するモダンテーマです。

| 技術 | 役割 |
|------|------|
| **Vite** | ビルドツール・HMR 開発サーバー |
| **UnoCSS** (Wind4) | ユーティリティファースト CSS エンジン |
| **Vue 3** (Composition API) | インタラクティブ UI コンポーネント |
| **TypeScript** | 型安全な開発 |
| **theme.json v3** | WordPress フルサイトエディタ対応 |

### 前提条件

| ツール | バージョン |
|--------|-----------|
| WordPress | 6.0 以上 |
| PHP | 8.0 以上 |
| Node.js | 18 以上 |
| pnpm | 8 以上 |

WordPress のテーマ開発経験があることを前提に進めます。

---

## セットアップ

### 1. テーマのインストール

```bash
cd wp-content/themes/
git clone https://github.com/annrie/cielos.git
cd cielos
pnpm install
```

### 2. 開発環境の起動

```bash
pnpm dev
```

これにより Vite 開発サーバーがポート `5173` で起動します。WordPress 側で `WP_ENVIRONMENT_TYPE` を `development` に設定しておく必要があります。

```php
// wp-config.php
define('WP_ENVIRONMENT_TYPE', 'development');
```

### 3. Vite と WordPress の連携の仕組み

Cielos の最大の特徴は、Vite を WordPress と直接統合している点です。`functions.php` 内で以下のように切り替えています。

```
開発時: 127.0.0.1:5173 への接続を検知 → HMR モード
本番時: dist/.vite/manifest.json からビルド済みアセットを読み込み
```

具体的には `cielos_is_vite_dev()` 関数が開発サーバーの起動状態を検出します。

```php
// functions.php:56-62
function cielos_is_vite_dev(): bool {
    if (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'development') {
        $fp = @fsockopen('127.0.0.1', 5173, $errno, $errstr, 0.05);
        if ($fp) { fclose($fp); return true; }
    }
    return false;
}
```

開発モードでは `@vite/client` と `src/main.ts` が直接読み込まれ、CSS や Vue コンポーネントの変更が即座にブラウザに反映されます。

### 4. エントリーポイント構成

Cielos には 2 つのエントリーポイントがあります。

| エントリー | 用途 | 読み込みタイミング |
|-----------|------|-----------------|
| `src/main.ts` | フロントエンド全体 | すべてのページ |
| `src/blocks/my-block-editor.ts` | カスタムブロック | ブロックエディタのみ |

`main.ts` は Vue アプリの初期化、各種コンポーネントのマウント、UnoCSS や Animate.css の読み込みを担当します。`my-block-editor.ts` はブロックエディタ内でのみ読み込まれ、カスタムブロックの登録を行います。

### 5. 本番ビルドとデプロイ

```bash
pnpm build
```

ビルド成果物は `dist/` ディレクトリに出力されます。Vite のマニフェスト (`dist/.vite/manifest.json`) をもとに、`functions.php` 側が適切な JS/CSS ファイルを `wp_enqueue_script` / `wp_enqueue_style` で読み込みます。

テーマを配布する場合：

```bash
pnpm archive    # ビルド後に zip アーカイブを作成
```

---

## テーマのカスタマイズ

### theme.json によるグローバル設定

Cielos は `theme.json` v3 を使用し、WordPress のフルサイトエディタと連携しています。

#### カラーパレット

```jsonc
// theme.json (抜粋)
{
  "settings": {
    "color": {
      "palette": [
        { "color": "#0ea5e9", "name": "Primary",       "slug": "primary" },
        { "color": "#38bdf8", "name": "Primary Light",  "slug": "primary-light" },
        { "color": "#0284c7", "name": "Primary Dark",   "slug": "primary-dark" },
        { "color": "#f59e0b", "name": "Accent",         "slug": "accent" },
        { "color": "#22c55e", "name": "Success",        "slug": "success" },
        { "color": "#ef4444", "name": "Danger",         "slug": "danger" }
      ]
    }
  }
}
```

ここに追加したカラーはブロックエディタのカラーピッカーに自動的に反映されます。

#### タイポグラフィ

日本語に最適化されたフォントスタックを使用しています。

```jsonc
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "fontFamily": "\"Noto Sans JP\", \"Hiragino Sans\", \"Yu Gothic\", sans-serif",
          "name": "Sans Serif",
          "slug": "sans"
        },
        {
          "fontFamily": "\"JetBrains Mono\", \"Fira Code\", monospace",
          "name": "Monospace",
          "slug": "mono"
        }
      ]
    }
  }
}
```

#### レイアウト

```jsonc
{
  "settings": {
    "layout": {
      "contentSize": "840px",
      "wideSize": "1280px"
    }
  }
}
```

### デザイントークン（CSS カスタムプロパティ）

テーマ全体の色やスペーシングは CSS カスタムプロパティで管理しています。ハードコードされた値ではなく、必ずトークンを参照します。

```css
/* src/assets/css/tokens.css */
:root {
  --c-fg: #334155;           /* テキスト色 */
  --c-muted: #64748b;        /* セカンダリテキスト */
  --c-primary: #0ea5e9;      /* プライマリカラー */
  --c-accent: #f59e0b;       /* アクセントカラー */
  --c-bg: #ffffff;           /* 背景色 */
  --c-panel: #f8fafc;        /* パネル背景 */
  --c-border: #e2e8f0;       /* ボーダー色 */
  --c-success: #22c55e;
  --c-danger: #ef4444;
  --c-warning: #f59e0b;
}

.dark {
  --c-fg: #e2e8f0;
  --c-bg: #0f172a;
  --c-panel: #1e293b;
  --c-border: #334155;
}
```

テンプレート内での使用例：

```php
<!-- 推奨: デザイントークンを使用 -->
<div class="bg-[var(--c-panel)] text-[var(--c-fg)] rounded-lg shadow-md">

<!-- 非推奨: ハードコード -->
<div class="bg-gray-100 text-gray-900 rounded-lg shadow-md">
```

### UnoCSS 設定

`uno.config.ts` で UnoCSS の設定を管理しています。Cielos では以下のプリセットとプラグインを統合しています。

| プリセット | 用途 |
|-----------|------|
| `presetWind4` | Tailwind CSS 互換のユーティリティクラス |
| `presetAttributify` | HTML 属性ベースのクラス指定 (`bg="blue-500"`) |
| `presetIcons` | Iconify アイコン (`class="i-mdi-home"`) |
| `presetTypography` | prose クラスによる本文スタイル |
| `presetWebFonts` | Web フォントの自動読み込み |
| `presetTagify` | `<un-button>` 等のタグベース記法 |
| `presetHeroPatterns` | Hero Patterns の SVG 背景パターン |
| `animatedUno` | Animate.css のアニメーションクラス統合 |

レスポンシブデザインはモバイルファーストで記述します。

```html
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
```

### ダークモード対応

`<html>` 要素の `.dark` クラスで切り替えるクラスベース方式を採用しています。CSS カスタムプロパティがライト/ダークで自動的に切り替わるため、テンプレートでは特別な対応は不要です。

```php
<!-- header.php 内の初期化スクリプト -->
<script>
(() => {
  const theme = localStorage.getItem('cielos:theme') || 'system';
  const isDark = theme === 'system'
    ? window.matchMedia('(prefers-color-scheme: dark)').matches
    : theme === 'dark';
  document.documentElement.classList.toggle('dark', isDark);
})();
</script>
```

---

## 既存ブロックへのスタイル追加

Cielos では 27 種類の見出しスタイルバリエーションが用意されています。独自のスタイルを追加する手順を解説します。

### アーキテクチャ

見出しブロックのスタイルシステムは以下の 3 ファイルで構成されています。

```
src/blocks/heading-styles.css       ← CSS スタイル定義
src/blocks/my-block-editor.ts       ← STYLE_OPTIONS 配列（エディタ選択肢）
src/blocks/HeadingStyleSelector.vue ← Vue セレクターコンポーネント
```

### ステップ 1: CSS クラスの定義

`src/blocks/heading-styles.css` に新しいスタイルを追加します。既存スタイルの命名規則 (`heading01` ~ `heading13-9`) に従います。

```css
/* heading14 - 星マーク + 下線スタイル */
h1.heading14, h2.heading14, h3.heading14,
h4.heading14, h5.heading14, h6.heading14 {
  position: relative;
  padding-left: 1.5em;
  padding-bottom: 0.5em;
  border-bottom: 2px solid var(--c-primary);
}

h1.heading14::before, h2.heading14::before, h3.heading14::before,
h4.heading14::before, h5.heading14::before, h6.heading14::before {
  content: "\2605"; /* ★ */
  position: absolute;
  left: 0;
  color: var(--c-accent);
}
```

ポイント:
- 必ず `h1` から `h6` まで全レベルに対応するセレクターを書く
- 色はデザイントークン (`var(--c-primary)` 等) を参照する
- ダークモードは CSS カスタムプロパティの切り替えで自動対応

### ステップ 2: エディタの選択肢に登録

`src/blocks/my-block-editor.ts` の `STYLE_OPTIONS` 配列に追加します。

```ts
// src/blocks/my-block-editor.ts:20-48
const STYLE_OPTIONS = [
  { label: 'Heading 01（上下破線-切り取り線）', value: 'heading01' },
  { label: 'Heading 02（傾き-テープ）', value: 'heading02' },
  // ... 既存の 27 スタイル ...
  { label: 'Heading 14（星マーク+下線）', value: 'heading14' },  // 追加
]
```

これだけで、ブロックエディタの「見出し設定」パネルから新しいスタイルを選択できるようになります。

### ステップ 3: Vue セレクターの更新（任意）

`HeadingStyleSelector.vue` を使用している場合は、こちらにも追加します。

```ts
// src/blocks/HeadingStyleSelector.vue
const styles = [
  // ... 既存のスタイル ...
  { value: 'heading14', label: 'スタイル 14' },
]
```

### ステップ 4: 確認

```bash
pnpm dev
```

ブロックエディタで「Uno テーマ見出し」ブロックを挿入し、右パネルの「スタイル」から新しいスタイルが選択できることを確認します。

---

## カスタムブロックの新規作成

Cielos では WordPress のブロックエディタ (React ベース) の中で Vue コンポーネントを動作させる独自のブリッジパターンを採用しています。ここでは「アラートブロック」を例に、新規カスタムブロックの作成手順を解説します。

### アーキテクチャ概要

```
cielos-block.php              ← PHP: アセット登録 & ブロックタイプ登録
  ↓ Vite manifest.json 参照
src/blocks/my-block-editor.ts ← TS: registerBlockType() でブロック定義
  ↓ Vue コンポーネント import
src/blocks/AlertBlock.vue     ← Vue: エディタ表示用コンポーネント
```

PHP がブロックの WordPress 側登録を担当し、TypeScript がブロックのロジックを定義し、Vue がエディタ内のリッチ UI を担当します。

### ステップ 1: Vue コンポーネントを作成する

`src/blocks/AlertBlock.vue`:

```vue
<script setup lang="ts">
defineProps<{
  type?: 'info' | 'warning' | 'danger' | 'success'
  content?: string
}>()

defineEmits<{
  'update:content': [value: string]
}>()
</script>

<template>
  <div :class="['alert-block', `alert-${type || 'info'}`]">
    <div class="alert-icon">
      <span :class="`i-mdi-${
        type === 'danger'  ? 'alert-circle' :
        type === 'warning' ? 'alert' :
        type === 'success' ? 'check-circle' :
        'information'
      }`" />
    </div>
    <div
      class="alert-content"
      contenteditable="true"
      @input="$emit('update:content', ($event.target as HTMLElement).textContent || '')"
      data-placeholder="テキストを入力..."
    />
  </div>
</template>

<style scoped>
.alert-block {
  display: flex;
  gap: 0.75rem;
  padding: 1rem 1.25rem;
  border-radius: 0.5rem;
  border-left: 4px solid;
}
.alert-info    { background: #eff6ff; border-color: var(--c-primary); }
.alert-warning { background: #fffbeb; border-color: var(--c-warning); }
.alert-danger  { background: #fef2f2; border-color: var(--c-danger); }
.alert-success { background: #f0fdf4; border-color: var(--c-success); }

[contenteditable]:empty::before {
  content: attr(data-placeholder);
  color: var(--c-muted, #999);
  pointer-events: none;
}
</style>
```

### ステップ 2: ブロックを TypeScript で登録する

`src/blocks/my-block-editor.ts` に以下を追加します。これが Cielos の核心であるVue-React ブリッジパターンです。

```ts
import AlertBlock from './AlertBlock.vue'

registerBlockType('uno/alert', {
  title: 'アラートブロック',
  description: '情報・警告・エラー・成功のアラート表示',
  icon: 'warning',
  category: 'design',
  keywords: ['alert', 'notice', '通知'],

  attributes: {
    content:   { type: 'string', default: '' },
    alertType: { type: 'string', default: 'info' },
  },

  edit: (props: any) => {
    const { attributes, setAttributes } = props
    const containerRef = useRef<HTMLDivElement | null>(null)
    const appRef = useRef<ReturnType<typeof createApp> | null>(null)

    // Vue アプリのマウント関数
    const mountVueApp = () => {
      if (appRef.current) appRef.current.unmount()
      appRef.current = createApp({
        render() {
          return h(AlertBlock, {
            type: attributes.alertType,
            content: attributes.content,
            'onUpdate:content': (v: string) => setAttributes({ content: v }),
          })
        },
      })
      if (containerRef.current) appRef.current.mount(containerRef.current)
    }

    // 初回マウント & クリーンアップ
    useEffect(() => {
      if (containerRef.current && !appRef.current) mountVueApp()
      return () => {
        if (appRef.current) { appRef.current.unmount(); appRef.current = null }
      }
    }, [])

    // 属性変更時に再マウント
    useEffect(() => {
      if (appRef.current && containerRef.current) mountVueApp()
    }, [attributes.alertType])

    return createElement(
      'div', null,
      // InspectorControls: 右パネルの設定 UI
      createElement(InspectorControls, null,
        createElement(PanelBody, { title: 'アラート設定', initialOpen: true },
          createElement(SelectControl, {
            label: 'タイプ',
            value: attributes.alertType,
            options: [
              { label: '情報', value: 'info' },
              { label: '警告', value: 'warning' },
              { label: 'エラー', value: 'danger' },
              { label: '成功', value: 'success' },
            ],
            onChange: (v: string) => setAttributes({ alertType: v }),
          })
        )
      ),
      // Vue コンポーネントのマウントポイント
      createElement('div', { ref: containerRef })
    )
  },

  // save: フロントエンド出力は React の createElement で定義
  save: ({ attributes }: any) => {
    return createElement(
      'div',
      { className: `alert-block alert-${attributes.alertType}` },
      createElement('p', null, attributes.content)
    )
  },
})
```

**Vue-React ブリッジの仕組み:**

1. `useRef` で DOM コンテナと Vue アプリインスタンスの参照を保持
2. `useEffect` の初回実行で `createApp()` → `mount()` により Vue アプリをマウント
3. 属性変更時は `useEffect` の依存配列で検知し、Vue アプリを再マウント
4. `return` のクリーンアップ関数で `unmount()` を呼びメモリリークを防止
5. `edit` (エディタ側) は Vue で実装し、`save` (フロント出力) は WordPress 標準の `createElement` で実装

### ステップ 3: PHP でブロックタイプを登録する

`cielos-block.php` の `$blocks` 配列に新しいブロック名を追加します。

```php
// cielos-block.php:100
$blocks = ['uno/my-block', 'uno/theme-heading', 'uno/alert'];
```

これにより、Vite マニフェストから解決された JS/CSS が自動的にブロックエディタで読み込まれます。

### ステップ 4: フロントエンド用 CSS を追加する

`save` で出力される HTML に対応する CSS を追加します。`src/blocks/` ディレクトリに `alert-styles.css` を作成し、`my-block-editor.ts` で import します。

```css
/* src/blocks/alert-styles.css */
.alert-block {
  display: flex;
  gap: 0.75rem;
  padding: 1rem 1.25rem;
  border-radius: 0.5rem;
  border-left: 4px solid;
}
.alert-info    { background: #eff6ff; border-color: var(--c-primary); }
.alert-warning { background: #fffbeb; border-color: var(--c-warning); }
.alert-danger  { background: #fef2f2; border-color: var(--c-danger); }
.alert-success { background: #f0fdf4; border-color: var(--c-success); }
```

```ts
// src/blocks/my-block-editor.ts に追加
import './alert-styles.css'
```

### ステップ 5: 動作確認

```bash
pnpm dev
```

1. ブロックエディタを開く
2. 「+」ボタンから「アラートブロック」を検索して挿入
3. 右パネルの「アラート設定」からタイプを切り替え
4. テキストを入力して保存
5. フロントエンドで表示を確認

---

## まとめ

### テーマの技術構成

| レイヤー | 技術 | ファイル |
|---------|------|---------|
| ビルド | Vite | `vite.config.ts` |
| スタイル | UnoCSS + CSS カスタムプロパティ | `uno.config.ts`, `tokens.css` |
| UI | Vue 3 (Composition API) | `src/components/`, `src/blocks/` |
| 型安全 | TypeScript | `tsconfig.json` |
| WP 連携 | theme.json v3 + PHP | `theme.json`, `functions.php` |
| ブロック | React-Vue ブリッジ | `cielos-block.php`, `my-block-editor.ts` |

### 開発フロー

```
1. pnpm dev で開発サーバー起動
2. Vue/CSS/TS の変更 → HMR で即座に反映
3. PHP テンプレートの変更 → ブラウザリロード
4. pnpm build で本番ビルド
5. pnpm archive で配布用 zip 作成
```

### カスタマイズのチェックリスト

- [ ] `theme.json` でカラーパレットとフォントを設定
- [ ] `src/assets/css/tokens.css` でデザイントークンを定義
- [ ] テンプレート内ではハードコードではなく CSS カスタムプロパティを使用
- [ ] 新しい見出しスタイルは `heading-styles.css` + `STYLE_OPTIONS` の 2 箇所を更新
- [ ] 新規ブロックは Vue コンポーネント → TS 登録 → PHP 登録 → フロント CSS の 4 ステップ
- [ ] ダークモードは CSS カスタムプロパティの自動切り替えに依存（個別対応は原則不要）

Cielos テーマのモダンなアーキテクチャを活用して、効率的な WordPress テーマ開発をお楽しみください。

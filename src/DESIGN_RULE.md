# Nuxtationデザインルール

このドキュメントでは、Nuxtationプロジェクトで使用するUnoCSS設定に基づいたデザインシステムとコーディング規約を定義します。

## 目次

1. [概要](#概要)
2. [デザインシステム](#デザインシステム)
3. [レイアウト](#レイアウト)
4. [カラーパレット](#カラーパレット)
5. [タイポグラフィ](#タイポグラフィ)
6. [スペーシング](#スペーシング)
7. [ブレイクポイント](#ブレイクポイント)
8. [コンポーネント設計](#コンポーネント設計)
9. [実装ガイドライン](#実装ガイドライン)

## 概要

NuxtationプロジェクトはUnoCSS（Wind4プリセット）を基盤とした原子的CSSフレームワークを採用しています。以下の設計原則に従ってください：

- **原子的設計**: 単一責任の小さなユーティリティクラスを組み合わせる
- **レスポンシブファースト**: モバイルを基準とした段階的な画面対応
- **一貫性の維持**: 統一されたデザイントークンの使用
- **パフォーマンス重視**: オンデマンド生成による軽量なCSS

## デザインシステム

### 基本構成

- **ベースフレームワーク**: UnoCSS + Wind4プリセット
- **アイコン**: Iconify（Carbon、MDI、Prime等）
- **タイポグラフィ**: プリセット + Webフォント
- **コンポーネント**: PrimeVue + カスタムコンポーネント

## レイアウト

### コンテナ設計

```vue
<!-- メインレイアウト -->
<main class="mx-auto text-center tb:max-w-2xl lg:max-w-5xl">
  <slot />
</main>

<!-- グリッドレイアウト -->
<div class="lg:(grid grid-cols-[1.5fr_1fr])">
  <!-- コンテンツ -->
</div>
```

### フレックスボックス

```vue
<!-- 基本的なセンタリング -->
<div class="flex-center"> <!-- flex justify-center items-center -->
<div class="flex-col-center"> <!-- flex items-center -->
<div class="flex-row-center"> <!-- flex justify-center -->
```

## カラーパレット

### 主要カラー

#### PrimeVueテーマカラー
```scss
// プライマリカラー（Auraテーマ）
primary-50 to primary-950  // 段階的なプライマリカラー
surface-0 to surface-950   // サーフェスカラー
```

#### カスタムカラー
```scss
// ベーシックカラー
black: '#0a0a0a'
white: '#fefefe'

// 機能的カラー
success: '#3adb76'
warning: '#ffae00'
alert: '#cc4b37'

// JIS安全色
jis-red: '#ff4b00'
jis-orange: '#f6aa00'
jis-yellow: '#f2e700'
jis-green: '#00b06b'
jis-blue: '#1971ff'

// テーマ別カラー
sf: '#2563eb'     // SF
adv: '#690'       // Adventure
mys: '#ed181e'    // Mystery
horror: '#0a0a0a' // Horror
```

### ダークモード対応

```vue
<!-- ライト/ダークモード切り替え -->
<div class="bg-white dark:bg-gray-900">
<div class="text-gray-800 dark:text-white">
```

### 色の使用例

```vue
<!-- 背景色 -->
<div class="bg-primary-500">
<div class="bg-surface-100 dark:bg-surface-900">

<!-- テキスト色 -->
<p class="text-primary-600">
<p class="text-gray-600 dark:text-gray-300">
```

## タイポグラフィ

### フォントファミリー

```scss
// メインフォント
font-sans: "Roboto", "Noto Sans Japanese"
font-serif: "Noto Serif JP", "Hiragino Sans"
font-mono: "Fira Code", "Fira Mono"

// 特殊フォント
font-lato: "Lato"
font-lobster: "Lobster"
font-inter: "Inter"
```

### フォントサイズとラインハイト

```scss
// 基本サイズ
text-xxs: 0.5rem (8px)
text-xs: 0.75rem (12px)
text-sm: 0.875rem (14px)
text-base: 1rem (16px)
text-lg: 1.125rem (18px)

// 見出しサイズ
text-h5: 1.25rem (20px)
text-h4: 1.5rem (24px)
text-h3: 2rem (32px)
text-h2: 3rem (48px)
text-h1: 4rem (64px)
text-highlight: 5rem (80px)

// レスポンシブ対応
text-h5_sm: 1.25rem
text-h4_sm: 1.5rem
text-h3_sm: 1.75rem
text-h2_sm: 2.25rem
text-h1_sm: 3rem
text-highlight_sm: 3.5rem
```

### 文字間隔

```vue
<!-- letter-spacing -->
<p class="tracking-100"> <!-- 0.1em -->
<p class="tracking-150"> <!-- 0.15em -->
```

## スペーシング

### マージン・パディング記法

#### 標準記法
```vue
<!-- ピクセル単位 -->
<div class="m-10">     <!-- margin: 10px -->
<div class="pt-20">    <!-- padding-top: 20px -->

<!-- rem変換 (px to rem) -->
<div class="m-20ptr">  <!-- margin: 1.25rem (20px/16) -->
<div class="p-32ptr">  <!-- padding: 2rem (32px/16) -->

<!-- em単位 -->
<div class="mt-1.5em"> <!-- margin-top: 1.5em -->
<div class="mt-16/20em"> <!-- margin-top: 0.8em (16/20) -->

<!-- パーセント -->
<div class="w-50per">  <!-- width: 50% -->
<div class="h-10/100per"> <!-- height: 10% -->
```

#### ビューポート単位 (vw)
```vue
<!-- 基準別vw変換 -->
<div class="w-20ptvw">     <!-- 基準: 375px -->
<div class="w-20ptvw-sm">  <!-- 基準: 640px -->
<div class="w-20ptvw-md">  <!-- 基準: 768px -->
<div class="w-20ptvw-lg">  <!-- 基準: 1024px -->
<div class="w-20ptvw-xl">  <!-- 基準: 1440px -->
```

#### clamp()関数
```vue
<!-- レスポンシブサイズ -->
<div class="text-clamp-16-24"> <!-- clamp(1rem, calc(...), 1.5rem) -->
<div class="p-clamp-10-20">    <!-- clamp(0.625rem, calc(...), 1.25rem) -->
```

### 定義済みスペーシング

```scss
// セクションスペーシング
section_x_sm: 1.5rem (24px)
section_x: 5rem (80px)
section_y_sm: 3rem (48px)
section_y: 5rem (80px)

// ナビゲーション
nav: 120px
nav_sm: 116px
```

## ブレイクポイント

### 設定値

```scss
sm: 375px   // スマートフォン
md: 640px   // タブレット縦
tb: 768px   // タブレット横
lg: 1024px  // ラップトップ
xl: 1440px  // デスクトップ
2xl: 1600px // 大画面
```

### レスポンシブ記法

```vue
<!-- モバイルファースト -->
<div class="text-sm tb:text-base lg:text-lg">
<div class="grid-cols-1 tb:grid-cols-2 lg:grid-cols-3">

<!-- 画面別スタイル -->
<div class="sm:text-center tb:text-left lg:text-right">
```

## コンポーネント設計

### 基本カードコンポーネント

```vue
<template>
  <article class="blogCard mx-auto bg-white p-5 rounded-2xl dark:bg-gray-900">
    <!-- コンテンツ -->
  </article>
</template>
```

### イメージコンポーネント

```vue
<NuxtPicture
  provider="imgix"
  :src="item.img"
  width="1280"
  height="640"
  fit="contain"
  format="avif,webp,png"
  :modifiers="{ auto: 'format,compress', q: 60, cs: 'srgb' }"
  :img-attrs="{
    class: 'rounded w-full transition-all duration-400 hover:scale-110'
  }"
  style="aspect-ratio: 16 / 9;"
/>
```

### ボタンコンポーネント

```vue
<!-- 基本ボタン -->
<button class="btn">
<!-- 定義済みショートカット -->
</button>

<!-- カスタムボタン -->
<button class="linkButton text-white hover:(scale-110 text-pink-100 duration-400)">
  読んでみる
</button>
```

## 実装ガイドライン

### クラス命名規則

#### ショートカットの活用
```vue
<!-- 推奨: 定義済みショートカット -->
<div class="flex-center">
<div class="absolute-center">
<div class="trans-all-300-ease">

<!-- 定義済みショートカット一覧 -->
flex-center           // flex justify-center items-center
flex-col-center       // flex items-center
flex-row-center       // flex justify-center
absolute-center       // absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
absolute-x-center     // absolute left-1/2 -translate-x-1/2
absolute-y-center     // absolute top-1/2 -translate-y-1/2
hw-full              // h-full w-full
trans-300            // transition-all duration-300
border-com           // border border-gray-200 dark:border-gray-700
bg-com               // bg-white dark:bg-gray-900
```

#### バリアント記法
```vue
<!-- グループ化 -->
<div class="hover:(scale-110 text-pink-100 duration-400)">
<div class="sm:(text-center w-full) lg:text-left">
<div class="dark:(bg-gray-900 text-white)">
```

### パフォーマンス最適化

#### Safelist設定
```ts
// uno.config.ts
safelist: [
  'prose',
  'prose-sm',
  'm-auto',
  'text-left'
]
```

#### 動的クラスの回避
```vue
<!-- 避ける: 動的クラス -->
<div :class="`text-${size}`">

<!-- 推奨: 条件分岐 -->
<div :class="{
  'text-sm': size === 'small',
  'text-base': size === 'medium',
  'text-lg': size === 'large'
}">
```

### アニメーション

#### トランジション
```scss
// 定義済みイージング
ease: cubic-bezier(.16,1,.3,1)
duration: 0.8s

// カスタムアニメーション
animation: {
  'custom-anime': 'custom-anime 0.8s cubic-bezier(.16,1,.3,1)'
}
```

```vue
<!-- トランジションの使用 -->
<div class="transition-all duration-300 ease-default">
<div class="hover:scale-110 trans-300">
```

### ダークモード実装

```vue
<template>
  <div class="bg-white dark:bg-gray-900">
    <h1 class="text-gray-800 dark:text-white">
      タイトル
    </h1>
    <p class="text-gray-600 dark:text-gray-300">
      説明文
    </p>
  </div>
</template>
```

### PrimeVue統合

```vue
<!-- PrimeVueコンポーネントとUnoCSS -->
<PrimeButton
  class="mt-4 px-6 py-3"
  severity="primary"
>
  送信
</PrimeButton>

<!-- カスタムテーマとの組み合わせ -->
<PrimeDataTable class="border-com bg-com">
  <!-- テーブル内容 -->
</PrimeDataTable>
```

### 開発ツール

#### UnoCSS Inspector
開発時は `http://localhost:3200/__unocss` でインスペクターを確認

#### VSCode拡張
- UnoCSS Language Support
- UnoCSS Intellisense

### よくある実装パターン

#### レスポンシブグリッド
```vue
<div class="grid grid-cols-1 tb:grid-cols-2 lg:grid-cols-3 gap-6">
  <!-- グリッドアイテム -->
</div>
```

#### カードレイアウト
```vue
<article class="bg-com border-com rounded-lg p-6 shadow-md hover:shadow-lg trans-300">
  <!-- カード内容 -->
</article>
```

#### フレックスレイアウト
```vue
<div class="flex flex-col tb:flex-row items-center gap-4">
  <!-- フレックスアイテム -->
</div>
```

## 保守性向上のための推奨事項

1. **一貫性の維持**: 定義済みのデザイントークンを必ず使用
2. **レスポンシブ設計**: すべてのコンポーネントでブレイクポイントを考慮
3. **ダークモード対応**: 色彩に関わるすべての要素でダークモード対応
4. **パフォーマンス**: 不要なクラスの生成を避ける
5. **ドキュメント**: 新しいパターンやショートカットは文書化

このガイドラインに従うことで、保守性が高く一貫したデザインシステムを構築できます。

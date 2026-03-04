# AGENTS.md

このファイルは、このリポジトリで作業する際に Claude Code (claude.ai/code) にガイダンスを提供します。

回答は必ず日本語で行ってください。

## プロジェクト概要

**unomoon** は、従来の SCSS から最新の Vite + Vue + UnoCSS アーキテクチャへ移行中の WordPress テーマです。WordPress テンプレートの互換性を維持しながら、段階的にコンポーネントベース開発を採用しています。

**アーキテクチャ**: WordPress (PHP) + Vite + Vue 3 + UnoCSS + TypeScript

## 開発コマンド

### ビルド・開発
```bash
# HMR 対応の開発サーバー（Vite は localhost:5173 で起動）
pnpm dev

# プロダクションビルド
pnpm build

# プロダクションビルドのプレビュー
pnpm serve
```

### コード品質
```bash
# ESLint を実行
pnpm lint

# ESLint の問題を自動修正
pnpm lint:fix
```

### バージョン管理
```bash
# パッチリリース作成 (0.0.x)
pnpm release:patch

# マイナーリリース作成 (0.x.0)
pnpm release:minor

# メジャーリリース作成 (x.0.0)
pnpm release:major
```

### Git コミットツール
```bash
# AI アシストコミットメッセージ（OpenAI）
pnpm oco

# AI アシストコミットメッセージ（Ollama ローカル）
pnpm lloco
```

## アーキテクチャ概要

### デザイントークンシステム（Tokens First 哲学）

**単一の真実の源**: すべてのデザイン値（色、余白、タイポグラフィ、見出し装飾）は CSS カスタムプロパティで定義し、UnoCSS 設定ではハードコードしません。

**トークン読み込み順序**（`preflight.ts` の `tokensPreflight()`）:
1. 明示的な `tokensPath` 引数（指定された場合）
2. `<theme-root>/tokens.css`（ベーストークン）
3. `<theme-root>/tokens.compat.css`（互換レイヤー）
4. `src/assets/css/tokens.css`（ベーストークンのフォールバック）
5. `src/assets/css/tokens.compat.css`（互換フォールバック）
6. フォールバック: `:root{--c-fg:#111;--c-fg-inv:#fff}`（いずれも存在しない場合）

**トークンファイル**:
- `src/assets/css/tokens.css` - 主要デザイントークン（色、余白、タイポグラフィ、見出しスタイル）
- `src/assets/css/tokens.compat.css` - レガシー SCSS 値の互換トークン

### UnoCSS アーキテクチャ

**責務分離**:
- **Preflights**（`preflight.*.ts`）: ページレベルの構造、レイアウト基盤、レスポンシブ基本スタイル、初期化
- **Shortcuts**（`shortcuts.*.ts`）: 再利用可能な UI コンポーネントとパターン（見出し群、カード、メタ UI など）

**主要ファイル**:
- `uno.config.ts` - メイン UnoCSS 設定、preflights と shortcuts を集約
- `preflight.ts` - preflight の中央レジストリと `tokensPreflight()` 実装
- `shortcuts.headings.ts` - 見出しコンポーネント（heading01-13）
- `shortcuts.extras.ts` - UI パターン（カード、メタ、ページネーションなど）
- `shortcuts.compat.ts` - レガシー互換ブリッジ

**ドメイン別 Preflight 構成**:
- ベース: `preflight.base.ts`（コアリセット + スティッキーフッター）
- ページタイプ: `preflight.top.ts`, `preflight.archive.ts`, `preflight.single.ts`, `preflight.docs.ts`, `preflight.biblio.ts`
- コンテンツ: `preflight.content.ts`（記事本文、テーブル、画像）
- ナビゲーション: `preflight.header-desktop-row.ts`, `preflight.mobile-menu.ts`, `preflight.theme-icons.ts`
- レイアウト: `preflight.layout-2col.ts`, `preflight.layout-2col-mobile-stack.ts`
- 機能: `preflight.print.ts`, `preflight.syntax.ts`, `preflight.comments.ts`, `preflight.forms.ts`

### Vite ビルドシステム

**開発モード**（HMR 有効）:
- `WP_ENVIRONMENT_TYPE=development` + localhost:5173 の可用性を検出
- `@vite/client` と `src/main.ts` を `type="module"` で注入
- `functions.php:unomoon_is_vite_dev()` と `unomoon_enqueue_scripts()` を参照

**プロダクションモード**:
- `dist/.vite/manifest.json` を読み込み（子テーマ優先、次に親テーマ）
- ハッシュ付きアセットをエンキュー: `assets/[name]-[hash].js`, `assets/[name]-[hash].css`
- エントリーポイント: `main`, `block`, `watcher`

**ビルド設定**（`vite.config.ts`）:
- 出力先: `dist/` ディレクトリ
- エントリーポイント: `src/main.ts`, `src/blocks/my-block-editor.ts`, `src/assets/js/theme-watcher.unomoon.js`
- ベースパス: `/wp-content/themes/unomoon/dist/`（プロダクション）
- ターゲット: `es2018`（モダンブラウザ）

### WordPress 統合

**テーマ構造**:
- PHP テンプレート: ルートの `*.php` ファイル（WordPress テンプレート階層）
- カスタム Walker: `library/class-unomoon-*-walker.php`（メニューレンダリング）
- テーマ機能: `library/*.php`（モジュール化された機能）
- ブロックエディタ: `unomoon-block.php`, `src/blocks/`

**主要 WordPress ファイル**:
- `functions.php` - メインテーマセットアップ、Vite 統合、スクリプトエンキュー
- `header.php` - デスクトップ/モバイルナビゲーションの基盤（`#menu`, `#mobile-menu`）
- `footer.php` - スクリプト読み込み（`nav-control.js` を含む）
- `library/class-unomoon-mobile-walker.php` - モバイルメニュー Walker（ラベル + トグルボタン構造）
- `library/class-unomoon-primary-menu-walker.php` - デスクトップメニュー Walker

**ナビゲーションシステム**:
- デスクトップ: 右寄せナビゲーション、ホバーベースのサブメニュー（`preflight.header-desktop-row.ts` で制御）
- モバイル: アコーディオンスタイルのナビゲーション、aria-expanded 制御（`preflight.mobile-menu.ts` で制御）
- JavaScript: `nav-control.js`（テーマトグル、モバイルメニュートグル、サブメニュートグル）
- テーマアイコン: ライト/ダークテーマ切替アイコン（`preflight.theme-icons.ts` で制御）

### Vue コンポーネントシステム

**コンポーネント配置**: `src/components/`

**主要コンポーネント**:
- `PostList.vue` - 投稿リスト（フロントページで使用）
- `MachakiPickup.vue` - 注目コンテンツピッカー
- `Pagination.vue` - ページネーション UI
- `SidebarTop.vue`, `SidebarBooks.vue`, `SidebarFull.vue` - サイドバーバリエーション
- `Gallery.vue` - 画像ギャラリー
- `Balloon.vue` - 吹き出し/ツールチップコンポーネント
- `SocialShareButton.vue` - ソーシャルシェア UI

**統合**:
- `src/main.ts` - Vue アプリ初期化
- `front-page.php` - Vue コンポーネント使用（移行進行中）

## UnoCSS 使用パターン

### 厳格なユーティリティルール

UnoCSS は複雑な値に対して正確な構文を要求します。以下のパターンに従ってください：

**Color Mix**（正しい）:
```typescript
// 正確なブラケット記法と適切なエスケープを使用
bg-[color-mix(in_srgb,var(--c-accent)_70%,transparent)]
```

**Shadow**（正しい）:
```typescript
shadow-[0_1px_2px_rgba(0,0,0,0.08)]
```

**よくある間違い**:
- ❌ ブラケット不一致: `bg-[color-mix(...)]`
- ❌ カンマエスケープ誤り: `bg-[color-mix(in srgb, var(--c-accent) 70%, transparent)]`
- ✅ 正しい: `bg-[color-mix(in_srgb,var(--c-accent)_70%,transparent)]`

### Safelist 戦略

`uno.config.ts` の `safelist` は動的に追加されるクラスがビルドに含まれることを保証します：

```typescript
safelist: [
  ...namesFromShortcuts(headingShortcuts),  // heading01-heading13
  ...namesFromShortcuts(extrasShortcuts),    // UI パターン
  'no-theme-anim',                          // テーマトランジション制御
  'layout-2col', 'layout-2col-rev',         // レイアウトバリエーション
]
```

以下の場合に safelist に追加：
- JavaScript でクラスが追加される
- WordPress PHP テンプレートが動的クラスを生成する
- コンテンツスキャンで静的検出されないクラス

### ビューポートベースのレスポンシブ値

**カスタムブレークポイント**:
- `xsm`: 320px
- `sm`: 375px
- `md`: 640px
- `tb`: 768px（タブレット）
- `lg`: 1024px
- `xl`: 1440px
- `2xl`: 1600px

**流動的タイポグラフィ**（`uno.config.ts` の `TEXT_SCALE`）:
- 最小（320px ビューポート）から最大（1600px ビューポート）へのスケーリングに `clamp()` を使用
- 例: `text-base` → `clamp(0.938rem, 0.625rem + 1.094vw, 1.125rem)`（15px-18px）
- 利用可能なスケール: `xxs`, `xs`, `sm`, `base`, `lg`, `h6`, `h5`, `h4`, `h3`, `h2`, `h1`, `highlight`

### UnoCSS でのデザイントークン参照

**常に `var()` 参照を使用** - 値をハードコードしない：

```typescript
// ✅ 正しい - トークンを参照
bg-[var(--c-panel)]
text-[var(--c-fg)]
border-[var(--c-border)]

// ❌ 間違い - ハードコード値
bg-[#ffffff]
text-[#111111]
```

## よくあるビルドエラーと解決方法

### `unmatched utility "...color-mix..."`

**原因**: 複雑な CSS 値でのブラケット/カンマ/閉じ `]` の不一致

**解決方法**:
- スペースにアンダースコアを使用: `color-mix(in_srgb,...)`
- 正確なブラケットペアを確保: `[...]` であり `[..]` ではない
- 複雑な値でのカンマエスケープを検証

### `i.getCSS is not a function`

**原因**: `tokensPreflight()` または他の preflight 関数からの誤った戻り型

**解決方法**:
- 戻り型が `layer` と `getCSS()` プロパティを持つ `Preflight` であることを確認
- `preflight.ts` の実装がパターンと一致することを確認

### `Unexpected token` in preflight.*.ts

**原因**: preflight 文字列内の CSS 構文エラー、通常はブラケット不一致

**解決方法**:
- CSS 構文を検証: `:where(...) .block :where(h2,h3,h4){...}`
- すべての `{`, `(`, `[` に対応する閉じ文字があることを確認

### ESLint/TypeScript エラー

**原因**: インポート欠落、型の不一致、Vue コンポーネントの問題

**解決方法**:
```bash
# 自動修正可能な問題を修正
pnpm lint:fix

# 残りの問題を確認
pnpm lint
```

## 移行状況と既知の課題

### 完了（2025-12-14 更新）
- ✅ SCSS → UnoCSS 移行（top, archive, single, docs, biblio ページ）
- ✅ 見出しシステム（heading01-13 shortcuts）
- ✅ 互換レイヤー付きトークンシステム
- ✅ ナビゲーション（デスクトップ右寄せ、モバイルアコーディオン、テーマトグル）
- ✅ 印刷スタイルとシンタックスハイライト（Prism/hljs）
- ✅ **モバイルメニューの完全修正**（2025-12-14）
  - 初期状態での表示問題を解決
  - イベントリスナーの競合を解消（nav-control.js に一本化）
  - クリック無反応の問題を修正
- ✅ **PostList.vue のレスポンシブレイアウト**（2025-12-14）
  - デスクトップブレークポイントを lg: (1024px) に統一
  - 画像の左側配置を修正
  - リスト間スペーシングの調整
- ✅ **Pagination.vue の実装**（2025-12-14）
  - home.php にページネーション追加
  - モバイル対応の省略機能（around: 1, edges: 1）
  - 記号のみの UI（« ‹ › »）
- ✅ **サイドバーアイコン機能**（2025-12-14）
  - Carbon icons の動的追加
  - ウィジェット別アイコン（document, folder, calendar, book）

### 進行中
- ⚠️ `heading02` ダークモード色の洗練

### 既知の課題
1. **heading02 ダークモード**: `--hd02-bg`, `--hd02-fg` トークンの確定とショートカットの簡素化が必要
2. **フッター固定レイアウト**: 短ページでのフッター固定に CSS Grid リファクタが必要（別ブランチで計画中）

### 残存 SCSS 移行（将来フェーズ）
- Phase 1: `styles/` ディレクトリの残存 SCSS ファイルの棚卸し
- Phase 2: ウィジェットとサイドバースタイル
- Phase 3: フォームとコメント
- Phase 4: 管理画面とエディタスタイル（Gutenberg ブロック）
- Phase 5: アニメーションとトランジション
- Phase 6: 最終クリーンアップ（Sass 依存関係の削除）

## ナビゲーション問題のデバッグ

### デスクトップナビゲーション確認
```javascript
// ブラウザコンソールで実行
({
  topFlex: getComputedStyle(document.querySelector('nav#menu > ul, nav#menu > div > ul')).display,
  right:   getComputedStyle(document.querySelector('nav#menu')).marginLeft,
  subInit: getComputedStyle(document.querySelector('nav#menu ul ul')).display
})
// 期待値: {topFlex:"flex", right:"auto", subInit:"none"}
```

### モバイルナビゲーション確認
```javascript
// 初期状態
({
  pcNav: getComputedStyle(document.querySelector('nav#menu')).display,
  mNav:  getComputedStyle(document.querySelector('#mobile-menu')).display,
  topUl: getComputedStyle(document.querySelector('#mobile-menu > ul, #mobile-menu > div > ul')).display
})
// 期待値: {pcNav:"none", mNav:"block", topUl:"none"} → ハンバーガークリック → "block"
```

### モバイルサブメニュートグル確認
```javascript
// サブメニュー閉状態
({
  subClosed: getComputedStyle(document.querySelector('#mobile-menu li[aria-expanded="false"] > ul')).display,
  subPosition: getComputedStyle(document.querySelector('#mobile-menu li[aria-expanded="false"] > ul')).position,
  subLeft: getComputedStyle(document.querySelector('#mobile-menu li[aria-expanded="false"] > ul')).left
})
// 期待値: {subClosed:"none", subPosition:"absolute", subLeft:"-9999px"}
```

## トークンの操作

### 新しいデザイントークンの追加

1. **`src/assets/css/tokens.css` で定義**:
```css
:root {
  --my-new-color: #ff6b6b;
  --my-spacing: 1.5rem;
}

.dark {
  --my-new-color: #ff9999; /* ダークモードオーバーライド */
}
```

2. **UnoCSS で参照**（shortcuts または preflights）:
```typescript
// shortcuts 内
['my-component', 'bg-[var(--my-new-color)] p-[var(--my-spacing)]']

// preflight 内
getCSS: () => `
  .my-element {
    background: var(--my-new-color);
    padding: var(--my-spacing);
  }
`
```

3. **UnoCSS 設定で値をハードコードしない** - 常に `var()` 参照を使用

### トークンオーバーライドパターン

一時的なオーバーライドまたは互換レイヤー用：
```css
/* tokens.compat.css */
:root {
  --legacy-value: var(--new-token); /* 古いものを新しいものにマップ */
}
```

## WordPress + Vite 開発ワークフロー

### ローカル開発セットアップ

1. **Vite 開発サーバーを起動**:
```bash
pnpm dev
```

2. **WordPress 設定**:
- `wp-config.php` で `WP_ENVIRONMENT_TYPE` を `'development'` に設定
- テーマが localhost:5173 を自動検出し HMR を有効化

3. **HMR の確認**:
- ブラウザコンソールで Vite クライアント接続を確認
- Vue/TS/CSS の変更がホットリロードされる
- PHP の変更は手動リフレッシュが必要

### プロダクションデプロイ

1. **アセットをビルド**:
```bash
pnpm build
```

2. **dist/manifest.json をコミット**:
- ハッシュ付きビルドアセットは `dist/` ディレクトリへ
- `functions.php` が `dist/.vite/manifest.json` を読み込んで正しいファイルをエンキュー

3. **デプロイ**:
- テーマフォルダを WordPress の `wp-content/themes/` にアップロード
- WordPress 管理画面でテーマを有効化

## ファイル構成

```
unomoon/
├── src/
│   ├── components/        # Vue コンポーネント
│   ├── blocks/           # WordPress ブロックエディタ
│   ├── assets/
│   │   ├── css/          # デザイントークン
│   │   └── js/           # Vanilla JS ユーティリティ
│   └── main.ts           # Vue アプリエントリー
├── library/              # WordPress PHP モジュール
├── dist/                 # ビルドアセット（プロダクション）
├── preflight.*.ts        # UnoCSS ページ構造
├── shortcuts.*.ts        # UnoCSS コンポーネントパターン
├── uno.config.ts         # UnoCSS 設定
├── vite.config.ts        # Vite ビルド設定
├── functions.php         # WordPress テーマ関数
├── *.php                 # WordPress テンプレート
└── CLAUDE.md            # このファイル
```

## 重要な原則

1. **Tokens First**: デザイントークンが単一の真実の源、値をハードコードしない
2. **Preflight vs Shortcuts**: Preflights が構造を扱い、Shortcuts がパターンを扱う
3. **厳格なユーティリティ**: UnoCSS は複雑な値に正確な構文を要求（ブラケット、エスケープ）
4. **WordPress 互換性**: Vue を段階的に採用しながらテンプレート階層を維持
5. **HMR 開発**: 開発中は Vite 開発サーバーを使用して即座のフィードバックを得る
6. **段階的移行**: SCSS → UnoCSS 移行は段階的であり、一度にすべてではない

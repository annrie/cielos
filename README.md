# Cielos

モダンなフロントエンド技術を活用した WordPress テーマです。Vite、UnoCSS（liftkitでラップ）、Vue 3、TypeScript を組み合わせ、高速な開発体験と優れたパフォーマンスを実現します。

> [English](#english) is available below.

## 特徴

- **Vite** によるHMR対応の高速開発環境
- **UnoCSS** (Wind4 プリセット) を **liftkit** でラップしたスタイリング基盤
- **Vue 3** (Composition API) によるインタラクティブなUIコンポーネント
- **TypeScript** による型安全な開発
- **WordPress Block Editor** 対応のカスタムブロック
- **theme.json** (v3) によるフルサイトエディタ対応
- **Noto Sans JP** を含む日本語最適化タイポグラフィ
- **レスポンシブデザイン** & **アクセシビリティ対応**
- **Anime.js** & **Animate.css** によるアニメーション
- **Iconify** による豊富なアイコンセット

ウィジェット機能は、[cocoon](https://wp-cocoon.com)を利用しています。

## 必要環境

| ツール | バージョン |
|--------|-----------|
| WordPress | 6.0 以上 |
| PHP | 8.0 以上 |
| Node.js | 18 以上 |
| pnpm | 8 以上 |

## インストール

```bash
# テーマディレクトリに移動
cd wp-content/themes/cielos

# 依存パッケージをインストール
pnpm install
```

## 開発

```bash
# 開発サーバーを起動 (HMR有効)
pnpm dev

# 本番用にビルド
pnpm build

# ビルドをプレビュー
pnpm serve

# ESLint でコードチェック
pnpm lint

# ESLint で自動修正
pnpm lint:fix
```

## リリース

```bash
# パッチバージョンリリース
pnpm release:patch

# マイナーバージョンリリース
pnpm release:minor

# メジャーバージョンリリース
pnpm release:major

# テーマを zip にアーカイブ
pnpm archive
```

## ディレクトリ構成

```
cielos/
├── src/                    # フロントエンドソース
│   ├── assets/             # 画像・フォント等のアセット
│   ├── blocks/             # カスタムブロック
│   ├── components/         # Vue コンポーネント
│   ├── main.ts             # エントリーポイント
│   └── App.vue             # ルートコンポーネント
├── preflight/              # UnoCSS プリフライトスタイル
├── shortcuts/              # UnoCSS ショートカット定義
├── template-parts/         # テンプレートパーツ
├── page-templates/         # ページテンプレート
├── library/                # テーマライブラリ
├── languages/              # 翻訳ファイル
├── dist/                   # ビルド出力 (自動生成)
├── public/                 # 静的ファイル
├── uno.config.ts           # UnoCSS 設定
├── vite.config.ts          # Vite 設定
├── theme.json              # WordPress テーマ設定 (v3)
├── style.css               # テーマメタデータ
└── functions.php           # テーマ関数
```

## ページテンプレート

| テンプレート | 説明 |
|-------------|------|
| `front.php` | フロントページ |
| `page-full-width.php` | 全幅レイアウト |
| `page-hero-showcase.php` | ヒーローショーケース |
| `page-sidebar-left.php` | 左サイドバー |
| `page-sidebar-right.php` | 右サイドバー |
| `kitchen-sink.php` | スタイル一覧 |

## テーマカラー

| 名前 | カラーコード | 用途 |
|------|------------|------|
| Primary | `#0ea5e9` | メインカラー |
| Accent | `#f59e0b` | アクセントカラー |
| Success | `#22c55e` | 成功 |
| Danger | `#ef4444` | エラー |
| Warning | `#f59e0b` | 警告 |

## ライセンス

[GNU General Public License v2.0](LICENSE)

## 作者

[annrie](https://github.com/annrie)

---

<a id="english"></a>

# Cielos (English)

A modern WordPress theme powered by Vite, UnoCSS wrapped by liftkit, Vue 3, and TypeScript. Combines cutting-edge frontend tooling with WordPress for fast development and excellent performance.

## Features

- **Vite** - Lightning-fast HMR development server
- **UnoCSS** (Wind4 preset) wrapped by **liftkit** - Utility-first styling foundation
- **Vue 3** (Composition API) - Interactive UI components
- **TypeScript** - Type-safe development
- **WordPress Block Editor** - Custom block support
- **theme.json** (v3) - Full Site Editing compatible
- **Japanese-optimized typography** with Noto Sans JP
- **Responsive design** & **accessibility-ready**
- **Anime.js** & **Animate.css** animations
- **Iconify** icon sets

## Requirements

| Tool | Version |
|------|---------|
| WordPress | 6.0+ |
| PHP | 8.0+ |
| Node.js | 18+ |
| pnpm | 8+ |

## Getting Started

```bash
cd wp-content/themes/cielos
pnpm install
```

## Development

```bash
# Start dev server with HMR
pnpm dev

# Production build
pnpm build

# Preview build
pnpm serve

# Lint
pnpm lint

# Lint with auto-fix
pnpm lint:fix
```

## Directory Structure

```
cielos/
├── src/                    # Frontend source
│   ├── assets/             # Images, fonts, etc.
│   ├── blocks/             # Custom blocks
│   ├── components/         # Vue components
│   ├── main.ts             # Entry point
│   └── App.vue             # Root component
├── preflight/              # UnoCSS preflight styles
├── shortcuts/              # UnoCSS shortcut definitions
├── template-parts/         # Template parts
├── page-templates/         # Page templates
├── dist/                   # Build output (auto-generated)
├── uno.config.ts           # UnoCSS config
├── vite.config.ts          # Vite config
├── theme.json              # WordPress theme config (v3)
└── functions.php           # Theme functions
```

## License

[GNU General Public License v2.0](LICENSE)

## Author

[annrie](https://github.com/annrie)

# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

## v1.0.8

[compare changes](https://github.com/annrie/cielos/compare/v1.0.7...v1.0.8)

### 🐛 バグ修正

- **forms:** 🐛 uno-wp-form にスタイルが当たらない問題を修正 ([c8681d3](https://github.com/annrie/cielos/commit/c8681d3))
- **forms:** 🐛 cielos のフォームで md の 4:8 レイアウトが効かない問題を修正 ([c7d0875](https://github.com/annrie/cielos/commit/c7d0875))
- **layout:** 🐛 Full Width テンプレートの本文が左に寄る問題を修正 ([0799ed9](https://github.com/annrie/cielos/commit/0799ed9))

### 📖 ドキュメント

- 📛 READMEにステータスバッジを追加 ([bc4984a](https://github.com/annrie/cielos/commit/bc4984a))
- 📛 READMEにステータスバッジを追加 ([7a173d1](https://github.com/annrie/cielos/commit/7a173d1))

### 📦 ビルド

- **deps:** ⬆️ Snyk指摘のform-data 4.0.6ほかminor/patch一括更新 ([1e2e9aa](https://github.com/annrie/cielos/commit/1e2e9aa))

### 🧹 ビルドプロセスまたは補助ツールの変更

- 🔖 style.cssのテーマバージョンを1.0.7に同期 ([f4e2d60](https://github.com/annrie/cielos/commit/f4e2d60))
- **config:** 🔧 .entire/ を削除 ([a9c4294](https://github.com/annrie/cielos/commit/a9c4294))

### ❤️ Contributors

- Annrie ([@annrie](https://github.com/annrie))

## v1.0.7

[compare changes](https://github.com/annrie/cielos/compare/v1.0.1...v1.0.7)

### 🚀 新機能

- Refine hero showcase ([34b1a23](https://github.com/annrie/cielos/commit/34b1a23))
- Add ASCII permalink handling ([22f7f3d](https://github.com/annrie/cielos/commit/22f7f3d))

### 🐛 バグ修正

- **archive:** Src/ディレクトリをアーカイブに含めるように修正 ([06f4ef7](https://github.com/annrie/cielos/commit/06f4ef7))
- Resolve dependency alerts and lint block editor ([58d386e](https://github.com/annrie/cielos/commit/58d386e))
- Allow tag_id archive permalinks ([740a5ca](https://github.com/annrie/cielos/commit/740a5ca))
- Simplify permalink fallback and restore post links ([1415a64](https://github.com/annrie/cielos/commit/1415a64))
- Restore pnpm 11 build ([3a7a658](https://github.com/annrie/cielos/commit/3a7a658))

### 📖 ドキュメント

- Update readme intro ([8474963](https://github.com/annrie/cielos/commit/8474963))

### 📦 ビルド

- **deps:** ⬆️ vue 3.5.40・unocss 66.7.5・vite 8.1.5ほかminor/patch一括更新 ([e0cbbd5](https://github.com/annrie/cielos/commit/e0cbbd5))

### 🧹 ビルドプロセスまたは補助ツールの変更

- Switch license to mit ([b899548](https://github.com/annrie/cielos/commit/b899548))
- Bump version to 1.0.3 ([f7bb4c2](https://github.com/annrie/cielos/commit/f7bb4c2))
- Remove liftkit-vue and bump version to 1.0.5 ([f3c2c6e](https://github.com/annrie/cielos/commit/f3c2c6e))
- Remove lk compat layer and bump version to 1.0.6 ([eca4b47](https://github.com/annrie/cielos/commit/eca4b47))

### 🔧 設定ファイル

- 7.7.0 → 7.7.2 - @iconify-json/material-symbols: 1.2.61 → 1.2.62 - @iconify/json: 2.2.448 → 2.2.449 - @vitejs/plugin-basic-ssl: 2.1.4 → 2.2.0 - @vitejs/plugin-legacy: 7.2.1 → 8.0.0 - @vitejs/plugin-vue: 6.0.4 → 6.0.5 - vite: 7.3.1 → 8.0.0 - vite-plugin-vue-devtools: 8.0.7 → 8.1.0 ([2af6866](https://github.com/annrie/cielos/commit/2af6866))

### ❤️ Contributors

- Annrie ([@annrie](https://github.com/annrie))

### 1.0.1 (2026-03-03)


### Features

* Cielos カラーパレットを適用（sky/amber テーマ） ad2f96f, closes #b92a2
* Cocoon スタイルのウィジェットシステムを実装 eaf73a8
* implement hero-only landing page and enhanced dark mode support 90624cb
* Initial Cielos theme d8a6804
* theme.json を tokens.css と同期して拡張 ab45746
* セマンティックカラートークンを追加（ライト/ダーク両対応） 25fcaa5
* タイポグラフィ・コンポーネント・レイアウトシステムを追加 78f792c


### Bug Fixes

* PostList タグ・ボタンの視認性を改善 9fc2055
* ウィジェットエリアIDの不整合を修正 3c370fe
* カスタマイザーのフッターテキスト設定を反映 4b07510
* ダークモードに --c-fg-inv トークンを追加 db28901, closes #0f172
* フッターの3カラムグリッドが機能するようsafelistに追加 fb17cf3

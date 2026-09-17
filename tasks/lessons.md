# Lessons

ユーザーから修正・指摘を受けたパターンと、次回それを避けるためのルール。

## 2026-09-17: プラグイン改名でテーマの CSS が黙って外れた

- 何が起きたか: uno-wp-form → unomoon-form の改名(09-15)で、フォームのラッパークラスが
  `.uno_wp_form` → `.unomoon_form`、フィールド接頭辞が `.unoform-*` → `.unomoonform-*` に変わったが、
  `preflight/forms.ts` は旧クラスしか見ていなかった。フォーム本文は DB にあって UnoCSS のスキャン対象外
  なので、ここで再定義している grid / col-span が全部外れ、本番のお問い合わせフォームが 2 日間縦積みだった。
  ユーザーの指摘:「検証が足りませんでしたね」。v1.0.21 で修正。
- ルール:
  1. プラグインの識別子(クラス / ショートコード / フック)を変えたら、本番反映の前に
     `grep -rnE "uno_wp_form|unoform|unomoon_form|unomoonform" preflight functions.php` を両テーマで実行する
  2. フォームの検証は「送れる」だけで終わらせず、フォームページで `.unomoon_form .grid` の
     computed style が `display: grid` / 12 カラムになっているかを見る
  3. 本番の CSS 検証は Autoptimize 集約後のファイル(`<link id='vite-import-css-…'>`)を curl して
     新クラスのルール数を数える。HTML の class 属性だけでは CSS が当たっているか分からない

## 2026-09-17: transparent ヘッダーの文字色を text-white 直書きにしていた

- 何が起きたか: `header-transparent.php` が `text-white` を直書きしていたため、ヒーロー画像のない
  ページではライトモードで文字が消えていた。ユーザーの指摘:「初期状態時のヘッダーの配色を見直してください」。
- ルール: ヘッダーの色は要素に直書きせず、`--header-fg` 系の変数を状態(ヒーロー有無 / スクロール前後)ごとに
  差し替える。header.ts のリンク・hover・現在項目・トグルはすべてこの変数を !important で参照しているので、
  要素の `color` を変えても効かない。

## 2026-09-17: 固定ページのスタイルが投稿に追いついていなかった

- 何が起きたか: 投稿には `.post-cover` の見出し・`heading11` / `heading13-9` の h2/h3・カード型の前後ナビが
  入っていたが、固定ページは h1 が余白なしの帯、h2 は素のまま、前後ナビは body.single スコープの外だった。
- ルール: 投稿向けに preflight を足すときは、同じ部品を固定ページ(`body.page` / `content-page.php`)でも
  使うか確認し、スコープを `:where(body.single, …, body.page)` の形で揃える。

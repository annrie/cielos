import type { Preflight } from 'unocss'

export const preflightChildPages: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ========== Child Pages Shortcode Styles ========== */

/* 2カラムグリッドレイアウト */
.child_pages {
  display: grid !important;
  grid-template-columns: repeat(2, 1fr) !important;
  gap: 2rem !important;
  margin-bottom: 2rem;
  max-width: none !important;
  width: 100% !important;
}

/* prose クラスの影響を無効化 */
.prose .child_pages,
:is(.prose) .child_pages {
  max-width: none !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
}

/* タブレット以下では1カラム */
@media (max-width: 1024px) {
  .child_pages {
    grid-template-columns: 1fr !important;
    gap: 1.5rem !important;
  }
}

/* モバイル（スマートフォン）ではさらにコンパクトに + タイトルを画像に重ねる */
@media (max-width: 640px) {
  .child_pages {
    grid-template-columns: 1fr !important;
    gap: 1rem !important;
  }

  .child_page-container {
    border-radius: 0.5rem;
    position: relative;
  }

  /* 画像コンテナを相対配置に */
  .child_pages .post_thumb {
    position: relative;
  }

  /* コンテンツエリアは通常のフロー */
  .child_pages .post_content {
    padding: 1rem;
  }

  /* タイトルだけを画像の上に絶対配置 */
  .child_pages .post_content h4 {
    position: absolute;
    top: 28.125%; /* aspect-ratio 16:9 の中央 (56.25% / 2) */
    left: 0;
    right: 0;
    transform: translateY(-50%);
    z-index: 10;
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
    border-bottom: none !important;
    text-align: center;
  }

  .child_pages .post_content h4 a {
    display: inline-block;
    padding: 0.75rem 3rem !important;
    background: rgba(0, 0, 0, 0.85);
    color: #ffffff !important;
    border-radius: 9999px;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
  }

  /* 抜粋は画像の下に通常表示 */
  .child_pages .post_content .post_excerpt {
    margin-top: 0;
    font-size: 0.875rem;
    line-height: 1.6;
  }

  /* ジャンル別背景色 - SF */
  #child_page-2412 .post_content h4 a {
    background: rgba(77, 28, 255, 0.85);
  }

  /* ジャンル別背景色 - 冒険・サスペンス */
  #child_page-2414 .post_content h4 a {
    background: rgba(153, 102, 153, 0.85);
  }

  /* ジャンル別背景色 - ミステリー */
  #child_page-2416 .post_content h4 a {
    background: rgba(237, 24, 30, 0.85);
  }

  /* ジャンル別背景色 - 時代・伝奇 */
  #child_page-2418 .post_content h4 a {
    background: rgba(47, 139, 32, 0.85);
  }

  /* ジャンル別背景色 - ホラー・奇妙な味 */
  #child_page-2544 .post_content h4 a {
    background: rgba(0, 0, 0, 0.85);
  }

  /* ジャンル別背景色 - 短編・連作集 */
  #child_page-2805 .post_content h4 a {
    background: rgba(14, 165, 233, 0.85); /* sky-500 */
  }

  /* Bibliography ページ（後で調整） */
  #child_page-3136 .post_content h4 a,
  #child_page-4279 .post_content h4 a,
  #child_page-3395 .post_content h4 a,
  #child_page-3467 .post_content h4 a {
    background: rgba(100, 116, 139, 0.85); /* slate-500 仮の色 */
  }
}

/* 各子ページカード - プラグインのスタイルを完全に上書き */
.child_pages .child_page,
.child_pages-thumbnail .child_page,
div.child_pages .child_page,
.child_page.cell,
.child_pages .cell {
  display: block !important;
  overflow: hidden;
  width: auto !important;
  max-width: none !important;
  min-width: 0 !important;
  float: none !important;
  box-sizing: border-box !important;
  margin: 0 !important;
  flex: none !important;
}

.child_page-container {
  background-color: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 0.75rem;
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  height: 100%;
  width: 100% !important;
  max-width: none !important;
  min-width: 0 !important;
  display: flex !important;
  flex-direction: column !important;
  flex: 1 1 auto !important;
  padding: 0 !important;
  margin: 0 !important;
  gap: 0 !important;
}

/* 最初の子要素（画像コンテナ）の上部マージンを強制的にゼロに */
.child_page-container > *:first-child,
.child_page-container > .post_thumb {
  margin-top: 0 !important;
  padding-top: 0 !important;
}

.child_page-container:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
}

/* ダークモード */
.dark .child_page-container {
  background-color: #1f2937;
  border-color: #374151;
}

/* ヒーロー画像（アイキャッチ） */
.child_pages .post_thumb {
  width: 100%;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  background-color: #f3f4f6;
  position: relative;
  margin: 0 !important;
  padding: 0 !important;
  flex-shrink: 0;
  display: block;
}

.dark .child_pages .post_thumb {
  background-color: #374151;
}

/* prose クラスの figure 要素の影響を完全に無効化 */
.prose .child_pages .post_thumb figure,
.prose .child_pages .post_thumb figure.wp-caption,
.child_pages .post_thumb figure,
.child_pages .post_thumb figure.wp-caption,
:is(.prose) .child_pages .post_thumb figure {
  width: 100% !important;
  height: 100% !important;
  max-width: none !important;
  margin: 0 !important;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  padding: 0 !important;
  display: block !important;
  aspect-ratio: inherit;
}

.child_pages .post_thumb img.wp-post-image {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover;
  object-position: center;
  transition: transform 0.3s ease;
  display: block !important;
  margin: 0 !important;
  padding: 0 !important;
  vertical-align: top;
  border: none;
}

.child_page-container:hover .post_thumb img.wp-post-image {
  transform: scale(1.05);
}

/* アイキャッチがない場合のプレースホルダー */
.child_pages .post_thumb:not(:has(img))::before {
  content: '📄';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 3rem;
  opacity: 0.3;
}

/* コンテンツエリア */
.child_pages .post_content {
  padding: 1.5rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}

/* タイトル */
.child_pages .post_content h4,
.child_pages .post_content h4 a {
  margin: 0 0 0.75rem 0;
  padding: 0 0 0.75rem 0;
  font-size: 1.25rem;
  font-weight: 700;
  line-height: 1.4;
  color: #111827;
  border-bottom: 2px solid #e5e7eb;
  text-decoration: none;
  transition: color 0.2s ease;
}

.dark .child_pages .post_content h4,
.dark .child_pages .post_content h4 a {
  color: #f9fafb;
  border-bottom-color: #374151;
}

.child_pages .post_content h4 a:hover {
  color: #3b82f6;
}

.dark .child_pages .post_content h4 a:hover {
  color: #60a5fa;
}

/* 抜粋 */
.child_pages .post_content .post_excerpt {
  margin: 0;
  font-size: 0.9375rem;
  line-height: 1.6;
  color: #6b7280;
  flex: 1;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.dark .child_pages .post_content .post_excerpt {
  color: #9ca3af;
}

/* 「続きを読む」リンク（もしあれば） */
.child_pages .post_content .read-more {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  font-weight: 600;
  color: #3b82f6;
  text-decoration: none;
  border-radius: 0.375rem;
  transition: background-color 0.2s ease, color 0.2s ease;
}

.child_pages .post_content .read-more:hover {
  background-color: #eff6ff;
  color: #2563eb;
}

.dark .child_pages .post_content .read-more {
  color: #60a5fa;
}

.dark .child_pages .post_content .read-more:hover {
  background-color: #1e3a8a;
  color: #93c5fd;
}
`
}

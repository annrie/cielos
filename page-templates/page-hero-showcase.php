<?php
/**
 * Template Name: Hero Showcase
 *
 * Displays 10 different hero section designs as Vue components
 * for inspiration and reference.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

// 調整中に古いアセット参照を掴まないよう、このページはキャッシュさせない
if (!defined('DONOTCACHEPAGE')) {
  define('DONOTCACHEPAGE', true);
}
nocache_headers();

get_header();

$theme_uri = get_template_directory_uri();
$site_name = get_bloginfo('name');
$tagline = get_bloginfo('description');
?>

<style>
/* Hero Showcase では transparent header の absolute を無効化して重なりを防ぐ */
body[class*="page-template-page-hero-showcase"] #header.header-transparent {
  position: sticky !important;
  top: 0 !important;
  background: var(--header-bg) !important;
  background-color: var(--header-bg) !important;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
  backdrop-filter: blur(12px) !important;
}

/* Utility 生成状況に依存せず、ショーケースナビを確実に sticky にする */
body[class*="page-template-page-hero-showcase"] nav.hero-showcase-nav {
  position: -webkit-sticky;
  position: sticky !important;
  top: var(--hero-showcase-nav-top, calc(var(--header-h, 64px) + var(--wp-admin-bar-h, 0px)));
  z-index: 40;
  width: 100%;
}

/* sticky が効かない環境向けフォールバック（JSで付与） */
body[class*="page-template-page-hero-showcase"] nav.hero-showcase-nav.is-fixed {
  position: fixed !important;
  top: var(--hero-showcase-nav-top, calc(var(--header-h, 64px) + var(--wp-admin-bar-h, 0px)));
  left: 0;
  right: 0;
  z-index: 45;
}

/* sticky を殺す overflow をテンプレート内で回避 */
body[class*="page-template-page-hero-showcase"] .site-wrapper,
body[class*="page-template-page-hero-showcase"] .site-wrapper > * {
  overflow: visible !important;
}

/* セクション内アンカーの被り防止 */
body[class*="page-template-page-hero-showcase"] .hero-showcase-anchor {
  scroll-margin-top: calc(var(--hero-showcase-nav-top, 64px) + 80px);
}

/* Showcase nav: 1行の横スクロール + タップしやすいサイズ */
body[class*="page-template-page-hero-showcase"] .hero-showcase-nav .hero-showcase-nav-inner {
  overflow-x: auto;
  overflow-y: hidden;
  -webkit-overflow-scrolling: touch;
}

body[class*="page-template-page-hero-showcase"] .hero-showcase-nav .hero-showcase-nav-list {
  display: flex;
  flex-wrap: nowrap;
  gap: 0.5rem;
  min-width: max-content;
}

body[class*="page-template-page-hero-showcase"] .hero-showcase-nav .hero-showcase-nav-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 42px;
  padding: 0.5rem 0.8rem;
  line-height: 1.2;
  white-space: nowrap;
}

@media (max-width: 639.98px) {
  body[class*="page-template-page-hero-showcase"] .hero-showcase-nav .hero-showcase-nav-inner {
    padding-top: 0.65rem;
    padding-bottom: 0.65rem;
  }

  body[class*="page-template-page-hero-showcase"] .hero-showcase-nav .hero-showcase-nav-link {
    min-height: 44px;
    padding: 0.58rem 0.85rem;
    font-size: 0.9rem;
  }
}
</style>

<!-- Showcase Navigation -->
<nav class="hero-showcase-nav sticky top-[var(--header-h)] z-40 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
  <div class="hero-showcase-nav-inner max-w-7xl mx-auto px-4 py-3">
    <div class="hero-showcase-nav-list">
      <?php
      $heroes = [
        ['id' => 'gradient-mesh',     'label' => '01 グラデーション'],
        ['id' => 'split-diagonal',    'label' => '02 スプリット'],
        ['id' => 'glassmorphism',     'label' => '03 グラスモーフィズム'],
        ['id' => 'typography',        'label' => '04 タイポグラフィ'],
        ['id' => 'parallax-layers',   'label' => '05 パララックス'],
        ['id' => 'minimal-zen',       'label' => '06 ミニマル禅'],
        ['id' => 'interactive-cards', 'label' => '07 カード'],
        ['id' => 'cinematic',         'label' => '08 シネマティック'],
        ['id' => 'geometric',         'label' => '09 ジオメトリック'],
        ['id' => 'aurora-wave',       'label' => '10 オーロラ'],
        ['id' => 'scroll-reveal',     'label' => '11 スクロールリビール'],
      ];
      foreach ($heroes as $hero) : ?>
        <a
          href="#hero-<?php echo esc_attr($hero['id']); ?>"
          class="hero-showcase-nav-link inline-flex items-center px-3 py-1.5 rounded-full text-sm font-500 text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors whitespace-nowrap"
        >
          <?php echo esc_html($hero['label']); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</nav>

<!-- Hero Section Showcase -->
<?php
$hero_components = [
  'gradient-mesh',
  'split-diagonal',
  'glassmorphism',
  'typography',
  'parallax-layers',
  'minimal-zen',
  'interactive-cards',
  'cinematic',
  'geometric',
  'aurora-wave',
  'scroll-reveal',
];

$hero_labels = [
  'gradient-mesh'     => 'グラデーションメッシュ — アニメーション背景 + フローティングオーブ',
  'split-diagonal'    => 'スプリットダイアゴナル — 斜めクリップパスで画像とテキストを分割',
  'glassmorphism'     => 'グラスモーフィズム — すりガラス効果のカード + 背景画像',
  'typography'        => 'タイポグラフィ — 大胆な文字デザイン + 動的ワード切替',
  'parallax-layers'   => 'パララックスレイヤー — 多層スクロール視差 + SVG地形',
  'minimal-zen'       => 'ミニマル禅 — 和風の余白を活かした静かなデザイン',
  'interactive-cards' => 'インタラクティブカード — ホバーで反応するフィーチャーカード',
  'cinematic'         => 'シネマティック — レターボックス映画風の没入デザイン',
  'geometric'         => 'ジオメトリック — 幾何学図形 + グラデーションアクセント',
  'aurora-wave'       => 'オーロラウェーブ — CSS光波アニメーション + グロウ効果',
  'scroll-reveal'     => 'スクロールリビール — スクロール連動で要素が順に現れる演出',
];

foreach ($hero_components as $component) :
  $component_id = 'hero-' . $component;
?>

<!-- Section Label -->
<div id="<?php echo esc_attr($component_id); ?>" class="hero-showcase-anchor scroll-mt-16">
  <div class="bg-gray-100 dark:bg-gray-800 py-3 px-6 text-center">
    <span class="text-sm font-600 text-gray-600 dark:text-gray-400">
      <?php echo esc_html($hero_labels[$component] ?? $component); ?>
    </span>
  </div>

  <!-- Vue Mount Point -->
  <div
    class="hero-showcase-mount"
    data-hero-type="<?php echo esc_attr($component); ?>"
    data-site-name="<?php echo esc_attr($site_name); ?>"
    data-tagline="<?php echo esc_attr($tagline); ?>"
    data-theme-uri="<?php echo esc_attr($theme_uri); ?>"
  ></div>
</div>

<?php endforeach; ?>

<script>
(() => {
  const root = document.documentElement;
  const header = document.getElementById('header');
  const admin = document.getElementById('wpadminbar');
  const nav = document.querySelector('nav.hero-showcase-nav');
  if (!nav) return;

  const navSpacer = document.createElement('div');
  navSpacer.setAttribute('aria-hidden', 'true');
  navSpacer.style.display = 'none';
  nav.parentNode?.insertBefore(navSpacer, nav.nextSibling);

  let navDocumentTop = 0;

  const syncHeaderOffsets = () => {
    const adminH = admin ? admin.offsetHeight : 0;
    const headerH = header ? header.offsetHeight : 64;
    // ヘッダー高さに管理バー分を足して、showcase nav の top を確定
    root.style.setProperty('--hero-showcase-nav-top', `${headerH + adminH}px`);
  };

  const updateNavMetrics = () => {
    const navRect = nav.getBoundingClientRect();
    navDocumentTop = navRect.top + window.scrollY;
    navSpacer.style.height = `${nav.offsetHeight}px`;
  };

  const updateStickyFallback = () => {
    const stickyTop = parseFloat(getComputedStyle(root).getPropertyValue('--hero-showcase-nav-top')) || 0;
    const shouldFix = window.scrollY > navDocumentTop - stickyTop;
    nav.classList.toggle('is-fixed', shouldFix);
    navSpacer.style.display = shouldFix ? 'block' : 'none';
  };

  const syncAll = () => {
    syncHeaderOffsets();
    // fixed 状態だと位置取得がずれるので一旦解除して測定
    const wasFixed = nav.classList.contains('is-fixed');
    if (wasFixed) {
      nav.classList.remove('is-fixed');
      navSpacer.style.display = 'none';
    }
    updateNavMetrics();
    updateStickyFallback();
  };

  syncAll();
  window.addEventListener('load', syncAll, { once: true });
  window.addEventListener('resize', syncAll, { passive: true });
  window.addEventListener('scroll', updateStickyFallback, { passive: true });
})();
</script>

<?php get_footer(); ?>

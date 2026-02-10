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

get_header();

$theme_uri = get_template_directory_uri();
$site_name = get_bloginfo('name');
$tagline = get_bloginfo('description');
?>

<!-- Showcase Navigation -->
<nav class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
  <div class="max-w-7xl mx-auto px-4 py-3 overflow-x-auto">
    <div class="flex gap-2 min-w-max">
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
      ];
      foreach ($heroes as $hero) : ?>
        <a
          href="#hero-<?php echo esc_attr($hero['id']); ?>"
          class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-500 text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors whitespace-nowrap"
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
];

foreach ($hero_components as $component) :
  $component_id = 'hero-' . $component;
?>

<!-- Section Label -->
<div id="<?php echo esc_attr($component_id); ?>" class="scroll-mt-16">
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

<?php get_footer(); ?>

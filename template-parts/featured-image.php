<?php
$image_url = get_the_post_thumbnail_url(null, 'full');
$page_id = get_the_ID();
// 通常の single では非表示だが、machaki の single は表示する
if ($image_url && (!is_single() || is_singular('machaki'))):
?>
<div class="relative hero-feature bg-cover bg-center w-full <?php echo is_front_page() ? '' : 'hero-page-' . $page_id; ?>" style="background-image:url('<?php echo esc_url($image_url); ?>')">
  <div class="absolute inset-0 hero-overlay"></div>
  <div class="hero-inner">
    <?php if (is_front_page()): ?>
      <!-- フロントページ: サイト名とデスクリプション -->
      <h1 class="hero-title"><?php bloginfo('name'); ?></h1>
      <div class="hero-subtitle"><?php bloginfo('description'); ?></div>
    <?php elseif (is_home()): ?>
      <!-- home.php: 記事一覧タイトル -->
      <h1 class="hero-page-title">
        <span class="hero-page-title-inner" style="background: rgba(0, 0, 0, 0.65);">
          <i class="fas fa-newspaper fa-lg mr-9 ml-3" aria-hidden="true" style="vertical-align: middle;"></i><?php single_post_title(); ?>一覧
        </span>
      </h1>
    <?php else: ?>
      <!-- その他のページ: ページタイトル -->
      <h1 class="hero-page-title">
        <span class="hero-page-title-inner"><?php echo esc_html(get_the_title()); ?></span>
      </h1>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>
<?php
// Hero が出ているページでは、パンくずをヒーロー直下に出す
if ($image_url && (!is_single() || is_singular('machaki')) && !is_front_page() && !is_page() && !is_home()) : ?>
  <nav aria-label="breadcrumb" class="breadcrumb-nav container mx-auto px-4 pt-4 pb-3">
    <?php if (function_exists('bcn_display')) : ?>
      <div class="breadcrumb-navxt text-sm bg-[var(--c-bg)] px-3 py-1.5 rounded inline-flex">
        <?php bcn_display(); ?>
      </div>
    <?php endif; ?>
  </nav>
<?php endif; ?>

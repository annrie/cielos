<?php
/**
 * The template for displaying genre taxonomy archive pages
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

get_header();

// ジャンル term 情報を取得
$term = get_queried_object();
$term_slug = $term ? $term->slug : '';

// ジャンルスラッグから色クラスへのマッピング（親ページ ID ベース）
$genre_class_map = array(
    'sf'          => 'hero-genre-sf',       // SF (2412)
    'adventure'   => 'hero-genre-adventure', // 冒険・サスペンス (2414)
    'bouken'      => 'hero-genre-adventure',
    'mystery'     => 'hero-genre-mystery',   // ミステリー (2416)
    'jidai'       => 'hero-genre-jidai',     // 時代・伝奇 (2418)
    'denki'       => 'hero-genre-jidai',
    'horror'      => 'hero-genre-horror',    // ホラー・奇妙な味 (2544)
    'tanpen'      => 'hero-genre-tanpen',    // 短編・連作集 (2805)
    'rensaku'     => 'hero-genre-tanpen',
);

$genre_class = isset($genre_class_map[$term_slug]) ? $genre_class_map[$term_slug] : 'hero-genre-default';
$image_url = function_exists('z_taxonomy_image_url') ? z_taxonomy_image_url() : '';
?>

<?php if ($image_url) : ?>
<!-- ヒーローセクション with ジャンル固有色 -->
<div class="relative hero-feature bg-cover bg-center w-full <?php echo esc_attr($genre_class); ?>" style="background-image:url('<?php echo esc_url($image_url); ?>')">
  <div class="absolute inset-0 hero-overlay"></div>
  <div class="hero-inner">
    <h1 class="hero-page-title">
      <span class="hero-page-title-inner"><?php single_cat_title(); ?>作品一覧</span>
    </h1>
  </div>
</div>
<!-- パンくず -->
<nav aria-label="breadcrumb" class="breadcrumb-nav container mx-auto px-4 pt-4 pb-3">
  <?php if (function_exists('bcn_display')) : ?>
    <div class="breadcrumb-navxt text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded inline-flex">
      <?php bcn_display(); ?>
    </div>
  <?php endif; ?>
</nav>
<?php endif; ?>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <?php if ($image_url) : ?>
      <!-- ヒーロー画像がある場合のメタ情報 -->
      <div class="entry-meta text-gray-500 dark:text-gray-400 mb-6">
          <?php cielos_entry_meta(); ?>
      </div>
      <?php else : ?>
      <!-- ヒーロー画像がない場合のフォールバック -->
      <header class="page-header mt-[-1rem] mb-40 border-b border-gray-200 dark:border-gray-700 pb-4">
        <h1 class="page-title text-4xl font-bold text-gray-900 dark:text-white">
          <?php single_cat_title(); ?>作品一覧
        </h1>
        <div class="entry-meta text-gray-500 dark:text-gray-400 mt-2">
            <?php cielos_entry_meta(); ?>
        </div>
      </header>
      <?php endif; ?>

      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('template-parts/content-archive-machaki', get_post_format()); ?>
        <?php endwhile; ?>
      <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
      <?php endif; ?>

      <?php
      // Pagination - WordPress標準関数を使用
      the_posts_pagination(array(
        'mid_size'  => 2,
        'prev_text' => __('‹', 'cielos'),
        'next_text' => __('›', 'cielos'),
        'class'     => 'machaki-pagination',
      ));
      ?>
    </main>

      <?php get_sidebar('books'); ?>
  </div>
</div>

<?php
get_footer();

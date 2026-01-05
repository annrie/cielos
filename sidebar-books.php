<?php
/**
 * The sidebar containing the book-specific widget area
 *
 * @package    WordPress
 * @subpackage unomoon
 * @since      unomoon 1.0.0
 */

?>
<aside class="sidebar lg:col-span-1" id="side-nav">
  <div id="header-widget-area" class="space-y-6">
    <div class="widget-search">
      <?php get_template_part('searchform'); ?>
    </div>
  </div>

  <?php
  // 僭越図書館ジャンル別一覧ページウィジェット
  ob_start();
  wp_list_categories(
      array(
          'taxonomy'         => 'genre',
          'title_li'         => '',
          'hide_empty'       => true,
          'current_category' => get_queried_object_id(),
          'show_option_none' => '',
          'depth'            => 1,
      )
  );
  $genre_list = ob_get_clean();
  $genre_list_with_suffix = preg_replace('/<\/a>/', '作品一覧</a>', $genre_list);
  ?>

  <!-- 僭越図書館ジャンル別一覧ページ -->
  <div class="widget widget_pages mt-6">
    <h3 class="widget-title">
      <i class="i-carbon-folder" aria-hidden="true"></i>
      僭越図書館ジャンル別一覧ページ
    </h3>
    <ul><?php echo $genre_list_with_suffix; ?></ul>
  </div>

  <!-- 僭越図書館 -->
  <div class="widget widget_pages mt-6">
    <h3 class="widget-title">
      <i class="i-carbon-book" aria-hidden="true"></i>
      僭越図書館
    </h3>
    <ul>
      <?php wp_list_pages(array('child_of' => '2410', 'title_li' => '', 'depth' => 1)); ?>
    </ul>
  </div>

  <div id="sidebar-books-vue-app"></div>

  <?php if (is_active_sidebar('sidebar-1')) : ?>
    <div class="space-y-6">
      <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
  <?php endif; ?>

  <?php if (is_active_sidebar('sidebar-2')) : ?>
    <div class="space-y-6">
      <?php dynamic_sidebar('sidebar-2'); ?>
    </div>
  <?php endif; ?>
</aside>
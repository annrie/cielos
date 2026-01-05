<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Cielos
 * @since unomoon 1.0.0
 */
?>

<aside class="sidebar lg:col-span-1" id="side-nav">
  <div id="header-widget-area" class="space-y-6">
    <div class="widget-search">
      <?php get_template_part('searchform'); ?>
    </div><!-- .widget-search end -->
    <?php if (is_category() ) : ?>
    <div class="rss-link bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
      <a href="<?php echo get_category_feed_link($cat); ?>" class="flex items-center gap-2 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:underline transition-colors duration-200">
        <i class="i-carbon-rss text-orange-500"></i>
        <span>RSS フィード</span>
      </a>
    </div>
    <?php endif; ?>
  </div><!-- #header-widget-area end -->

  <?php if (is_tag()) : ?>
    <div class="widget widget_categories mt-6">
      <h3 class="widget-title">
        <i class="i-carbon-folder" aria-hidden="true"></i>
        カテゴリー
      </h3>
      <ul>
        <?php
        $categories = get_categories(array(
          'orderby' => 'name',
          'order'   => 'ASC',
          'hide_empty' => true,
        ));
        foreach ($categories as $category) :
        ?>
          <li class="cat-item">
            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
              <?php echo esc_html($category->name); ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php
  // 僭越図書館の子ページの場合、僭越図書館ウィジェットを表示
  $is_biblio_child = is_page() && (get_the_ID() == 2410 || wp_get_post_parent_id(get_the_ID()) == 2410);
  if ($is_biblio_child) :
    // ジャンル別一覧リスト
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

    <!-- 僭越図書館ジャンル別一覧ページ -->
    <div class="widget widget_pages mt-6">
      <h3 class="widget-title">
        <i class="i-carbon-folder" aria-hidden="true"></i>
        僭越図書館ジャンル別一覧ページ
      </h3>
      <ul><?php echo $genre_list_with_suffix; ?></ul>
    </div>
  <?php endif; ?>

  <?php if (is_active_sidebar('sidebar-1')) : ?>
    <div class="space-y-6">
      <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
  <?php endif; ?>
</aside>

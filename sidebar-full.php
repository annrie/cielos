<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Cielos
 * @since unomoon 1.0.0
 */

?>
<aside class="sidebar space-y-6 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700" id="side-nav">
  <div id="header-widget-area">
    <?php if (is_category()) : ?>
      <aside class="rss_link mb-4">
        <a href="<?php echo get_category_feed_link($cat); ?>" class="flex items-center gap-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
          <i class="i-carbon-rss text-orange-500 text-xl"></i>
          <span>RSS</span>
        </a>
      </aside>
    <?php endif; ?>
  </div><!-- #header-widget-area end -->
  
  <div id="sidebar-full-vue-app"></div>

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
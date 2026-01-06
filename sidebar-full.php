<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Cielos
 * @since unomoon 1.0.0
 */

?>
<aside class="sidebar space-y-6 p-6 bg-[var(--c-panel)] rounded-lg shadow-sm border border-[var(--c-border)]" id="side-nav">
  <div id="header-widget-area">
    <?php if (is_category()) : ?>
      <aside class="rss_link mb-4">
        <a href="<?php echo get_category_feed_link($cat); ?>" class="flex items-center gap-2 text-[var(--c-muted)] hover:text-[var(--c-primary)] transition-colors duration-200">
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
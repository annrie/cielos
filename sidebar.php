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
    <div class="rss-link bg-[var(--c-panel)] border border-[var(--c-border)] rounded-lg p-4 shadow-sm">
      <a href="<?php echo get_category_feed_link($cat); ?>" class="flex items-center gap-2 text-sm font-semibold text-[var(--c-primary)] hover:text-[var(--c-primary-dark)] hover:underline transition-colors duration-200">
        <i class="i-carbon-rss text-orange-500"></i>
        <span>RSS フィード</span>
      </a>
    </div>
    <?php endif; ?>
  </div><!-- #header-widget-area end -->

  <?php
  // カテゴリー：記事の文脈（単記事・一覧・カテゴリ・タグ）で出す。
  // 以前は is_tag() のときだけ出していたので、記事ページでは検索フォームしか
  // 表示されていなかった。
  $show_taxonomy = is_singular('post') || is_home() || is_archive();
  if ($show_taxonomy) :
    $categories = get_categories(array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => true));
    if ($categories) :
  ?>
    <div class="widget widget_categories mt-6">
      <h3 class="widget-title">
        <i class="i-carbon-folder" aria-hidden="true"></i>
        カテゴリー
      </h3>
      <ul>
        <?php foreach ($categories as $category) : ?>
          <li class="cat-item<?php echo in_category($category->term_id) ? ' current-cat' : ''; ?>">
            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
              <?php echo esc_html($category->name); ?>
              <span class="cat-count"><?php echo (int) $category->count; ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php
    endif;

    // タグ：記事が増えるまでは数が少ないので、まとめて一覧にする
    $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 20));
    if ($tags) :
  ?>
    <div class="widget widget_tag_cloud mt-6">
      <h3 class="widget-title">
        <i class="i-carbon-tag" aria-hidden="true"></i>
        タグ
      </h3>
      <ul class="tag-list">
        <?php foreach ($tags as $tag) : ?>
          <li><a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"><?php echo esc_html($tag->name); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php
    endif;

    // 最近の記事：単記事では自分を除いて回遊先を出す
    $recent = get_posts(array(
      'numberposts' => 5,
      'post_status' => 'publish',
      'exclude'     => is_singular('post') ? array(get_the_ID()) : array(),
    ));
    if ($recent) :
  ?>
    <div class="widget widget_recent_entries mt-6">
      <h3 class="widget-title">
        <i class="i-carbon-document" aria-hidden="true"></i>
        <?php echo is_singular('post') ? '他の記事' : '最近の記事'; ?>
      </h3>
      <ul>
        <?php foreach ($recent as $r) : ?>
          <li>
            <a href="<?php echo esc_url(get_permalink($r->ID)); ?>"><?php echo esc_html(get_the_title($r->ID)); ?></a>
            <time class="recent-date" datetime="<?php echo esc_attr(get_the_date('c', $r->ID)); ?>"><?php echo esc_html(get_the_date('Y.m.d', $r->ID)); ?></time>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php
    endif;
  endif;
  ?>

  <?php if (is_active_sidebar('sidebar')) : ?>
    <div class="space-y-6">
      <?php dynamic_sidebar('sidebar'); ?>
    </div>
  <?php endif; ?>

  <?php if (is_active_sidebar('sidebar-scroll')) : ?>
    <div class="sidebar-scroll-area space-y-6 sticky top-4">
      <?php dynamic_sidebar('sidebar-scroll'); ?>
    </div>
  <?php endif; ?>
</aside>

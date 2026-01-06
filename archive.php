<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

get_header(); ?>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-5">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <?php if (have_posts()) : ?>
      <header class="page-header mb-8 pb-6">
        <?php
        if (is_category() && function_exists('z_taxonomy_image_url')) {
            $category = get_queried_object();
            $image_url = z_taxonomy_image_url($category->term_id);
            if ($image_url) {
                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '" class="w-full h-auto object-cover rounded-lg mb-6 shadow-md" loading="lazy" decoding="async">';
            }
        }
        ?>

        <div class="space-y-3">
          <div class="flex items-center gap-2 text-sm text-[var(--c-muted)]">
            <i class="i-carbon-folder text-[var(--c-primary)]"></i>
            <span class="font-medium">
              <?php
              if (is_category()) {
                echo 'カテゴリー';
              } elseif (is_tag()) {
                echo 'タグ';
              } elseif (is_day()) {
                echo '日別アーカイブ';
              } elseif (is_month()) {
                echo '月別アーカイブ';
              } elseif (is_year()) {
                echo '年別アーカイブ';
              } elseif (is_tax()) {
                echo 'カスタム分類';
              } elseif (is_search()) {
                echo '検索結果';
              } elseif (is_author()) {
                echo '著者アーカイブ';
              } else {
                echo 'ブログアーカイブ';
              }
              ?>
            </span>
          </div>

          <h1 class="page-title heading04-3 leading-[1.2] break-words" style="font-size: var(--latest-title-fs); color: var(--latest-fg); background-image: var(--latest-bg-stack); border-color: var(--latest-border); box-shadow: var(--latest-inset), var(--shadow-1); padding-top: 1.25rem; padding-bottom: 1.25rem;">
            <i class="i-carbon-folder text-lg mr-3 ml-3" aria-hidden="true" style="vertical-align: middle;"></i><?php
            if (is_category()) {
              single_cat_title();
            } elseif (is_tag()) {
              single_tag_title();
            } elseif (is_day()) {
              echo get_the_date('Y年n月j日');
            } elseif (is_month()) {
              echo get_the_date('Y年n月');
            } elseif (is_year()) {
              echo get_the_date('Y年');
            } elseif (is_tax()) {
              single_term_title();
            } elseif (is_search()) {
              echo '「' . get_search_query() . '」';
            } elseif (is_author()) {
              echo esc_html(get_the_author_meta('display_name', get_query_var('author')));
            } else {
              echo 'ブログ';
            }
            ?></h1>

          <?php if (is_category() || is_tag() || is_tax()) : ?>
            <?php $description = term_description(); ?>
            <?php if (!empty($description)) : ?>
              <div class="text-[var(--c-muted)] text-sm sm:text-base leading-relaxed mt-4">
                <?php echo $description; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </header>

      <?php
      // 現在のカテゴリ/タグ/タームのIDを取得
      $term_id = '';
      $term_type = '';
      if (is_category()) {
          $term_id = get_queried_object_id();
          $term_type = 'category';
      } elseif (is_tag()) {
          $term_id = get_queried_object_id();
          $term_type = 'tag';
      } elseif (is_tax()) {
          $term_id = get_queried_object_id();
          $term_type = get_queried_object()->taxonomy;
      }
      ?>
      <div id="post-list-app" data-show-title="false" data-layout="list" data-term-id="<?php echo esc_attr($term_id); ?>" data-term-type="<?php echo esc_attr($term_type); ?>"></div>

      <?php
      // Pagination handled by Vue component
      global $wp_query;
      $current_page = max(1, get_query_var('paged'));
      $total_pages = $wp_query->max_num_pages;

      if ($total_pages > 1) :
        // Get base URL for pagination
        $base_url = get_pagenum_link(1);
        if (strpos($base_url, '?') !== false) {
          $base_url = preg_replace('/\?.*/', '', $base_url);
        }
        $base_url = trailingslashit($base_url) . 'page/%#%/';
        ?>
        <script>
        window.unomoonPagination = {
          currentPage: <?php echo esc_js($current_page); ?>,
          totalPages: <?php echo esc_js($total_pages); ?>,
          base: <?php echo wp_json_encode($base_url); ?>
        };
        </script>
        <div id="pagination-app"></div>
      <?php endif; ?>

      <?php else : ?>
      <?php get_template_part('template-parts/content', 'none'); ?>
      <?php endif; ?>
    </main>

      <?php get_sidebar(); ?>
  </div>
</div>

<?php
get_footer();

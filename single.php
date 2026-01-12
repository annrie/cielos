<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

get_header(); ?>

<?php
if ( ! has_block('image') ) :
?>
<?php get_template_part('template-parts/featured-image'); ?>
<?php
endif;
?>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <?php
      while (have_posts()) :
          the_post();
          get_template_part('template-parts/content', 'single');

          // スコアリングベースの関連記事を表示
          if (function_exists('cielos_display_related_posts')) {
              cielos_display_related_posts(get_the_ID(), 6, '関連記事');
          }

          the_post_navigation();
          comments_template();
      ?>
      <div id="cielos-comment-pagination"></div>
      <?php endwhile; ?>
    </main>
      <?php get_sidebar(); ?>
  </div>
</div>
<?php
get_footer();

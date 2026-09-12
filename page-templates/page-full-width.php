<?php
/*
Template Name: Full Width
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage unomoon
 * @since unomoon 1.0.0
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
  <?php // main-content の max-width:72ch は残したまま mx-auto で中央に置く。
        // .main-content はサイドバー付きグリッドで左右どちらにも寄せる前提のため
        // margin:auto を持たず、1カラムで使うと左に寄ってしまう。
        // 幅の制限を外す main-content-full は、フォームだと間延びして読みにくい ?>
  <main id="main" class="main-content mx-auto w-full" role="main" tabindex="-1">
    <?php
    while (have_posts()) :
        the_post();
        get_template_part('template-parts/content', 'page');
        the_post_navigation();
        comments_template();
    endwhile;
    ?>
  </main>
</div>
<?php get_footer(); ?>
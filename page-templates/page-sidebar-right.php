<?php
/*
Template Name: Right Sidebar
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage unomoon
 * @since unomoon 1.0.0
*/

get_header(); ?>

<?php get_template_part('template-parts/featured-image'); ?>
<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <main id="main" class="main-content lg:col-span-8" role="main" tabindex="-1">
      <?php
      while (have_posts()) :
          the_post();
          get_template_part('template-parts/content', 'page');
          comments_template();
      endwhile;
      ?>
    </main>
    <aside class="sidebar lg:col-span-4">
      <?php get_sidebar(); ?>
    </aside>
  </div>
</div>
<?php
get_footer();
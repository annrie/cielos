<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

get_header(); ?>

<?php get_template_part('template-parts/featured-image'); ?>

<!-- Breadcrumb Navigation -->
<nav aria-label="breadcrumb" class="breadcrumb-nav container mx-auto px-4 pt-8 pb-3">
  <?php if (function_exists('bcn_display')) : ?>
    <div class="breadcrumb-navxt text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded inline-flex">
      <?php bcn_display(); ?>
    </div>
  <?php endif; ?>
</nav>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-5">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <?php
      while (have_posts()) :
          the_post();
          get_template_part('template-parts/content', 'page');
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

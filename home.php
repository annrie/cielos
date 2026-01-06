<?php
/**
 * The home template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package Cielos
 */

get_header(); ?>

<?php get_template_part('template-parts/featured-image'); ?>

<!-- Breadcrumb Navigation -->
<nav aria-label="breadcrumb" class="breadcrumb-nav container mx-auto px-4 pt-8 pb-3">
  <?php if (function_exists('bcn_display')) : ?>
    <div class="breadcrumb-navxt text-sm bg-[var(--c-bg)] px-3 py-1.5 rounded inline-flex">
      <?php bcn_display(); ?>
    </div>
  <?php endif; ?>
</nav>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-5">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <div id="post-list-app" data-show-title="false" data-layout="list"></div>

      <?php
      // Pagination handled by Vue component
      echo '<div id="pagination-app"></div>';
      ?>
    </main>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php
get_footer();?>

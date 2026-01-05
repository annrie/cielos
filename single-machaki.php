<?php
/**
 * The template for displaying all single machaki posts
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

get_header(); ?>

<?php get_template_part('template-parts/featured-image'); ?>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('prose dark:prose-invert max-w-none'); ?>>
          <header class="entry-header my-8">
            <?php the_title('<h1 class="entry-title heading05">', '</h1>'); ?>
            <div class="entry-meta text-gray-500 dark:text-gray-400 mt-2">
              <?php cielos_entry_meta(); ?>
            </div>
          </header>

          <div class="entry-content content-wrapper">
            <?php get_template_part('template-parts/content', 'machaki'); ?>
          </div>

          <footer class="mt-8">
            <?php the_post_navigation(); ?>
          </footer>
        </article>
        <?php comments_template(); ?>
      <?php endwhile; ?>
      <div id="cielos-comment-pagination"></div>
    </main>
    <?php get_sidebar('books'); ?>
  </div>
</div>
<?php get_footer();

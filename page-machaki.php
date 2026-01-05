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

<div class="container mx-auto px-4 py-4">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-5">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <?php
      while (have_posts()) :
          the_post();
      ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('prose dark:prose-invert max-w-none'); ?>>
        <header class="entry-header mb-8">
          <h2 class="entry-title heading04-3 leading-[1.2] break-words" style="font-size: var(--latest-title-fs); color: var(--latest-fg); background-image: var(--latest-bg-stack); border-color: var(--latest-border); box-shadow: var(--latest-inset), var(--shadow-1); padding-top: 1.25rem; padding-bottom: 1.25rem;">
            <i class="i-twemoji-classical-building text-3xl mr-3 ml-3" aria-hidden="true" style="vertical-align: middle;"></i><?php the_title(); ?>
          </h2>
          <div class="entry-meta text-gray-500 dark:text-gray-400 mt-2">
            <?php cielos_entry_meta(); ?>
          </div>
        </header>
        <div class="entry-content">
          <?php the_content(); ?>
          <?php edit_post_link(__('(Edit)', 'cielos'), '<span class="edit-link mt-4 inline-block">', '</span>'); ?>
        </div>
        <footer class="mt-8">
          <?php
          wp_link_pages(
              array(
                  'before' => '<nav id="page-nav" class="mt-8"><p>' . __('Pages:', 'cielos'),
                  'after'  => '</p></nav>',
              )
          );
          ?>
          <div class="tags-container mt-4">
            <?php the_tags('<span class="tag-link inline-block bg-gray-100 dark:bg-gray-800 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-200 mr-2 mb-2">', '</span><span class="tag-link inline-block bg-gray-100 dark:bg-gray-800 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-200 mr-2 mb-2">', '</span>'); ?>
          </div>
        </footer>
        <div class="comments-container mt-8">
            <?php comments_template(); ?>
        </div>
        <!--div id="cielos-comment-pagination" class="mt-8"></div-->
      </article>
      <?php endwhile; ?>
    </main>

    <?php get_sidebar(); ?>
  </div>
</div>
<?php
get_footer();

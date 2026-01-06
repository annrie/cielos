<?php
/**
 * The template for displaying search results pages.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

get_header(); ?>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <header class="page-header mt-[-1rem] mb-40 border-b border-[var(--c-border)] pb-4">
        <h1 class="page-title text-4xl font-bold text-[var(--c-fg)]">
          <?php _e('Search Results for', 'cielos'); ?> "<span class="text-[var(--c-primary)]"><?php echo get_search_query(); ?></span>"
        </h1>
      </header>

      <div id="search-results">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/content', get_post_format()); ?>
          <?php endwhile; ?>
        <?php else : ?>
          <?php get_template_part('template-parts/content', 'none'); ?>
        <?php endif; ?>

        <?php
        // Check if cielos_pagination exists, otherwise use default WordPress navigation
        if (function_exists('cielos_pagination')) :
            cielos_pagination();
        else :
            the_posts_navigation(array(
                'prev_text' => '<span class="text-sm text-[var(--c-primary)] hover:underline">&larr; ' . __('Older posts', 'cielos') . '</span>',
                'next_text' => '<span class="text-sm text-[var(--c-primary)] hover:underline">' . __('Newer posts &rarr;', 'cielos') . '</span>',
            ));
        endif;
        ?>
      </div>
    </main>
    <?php get_sidebar(); ?>
  </div>
</div>

<?php
get_footer();
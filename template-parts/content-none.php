<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

?>

<article class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-8 text-center" aria-labelledby="page-title">
  <header class="page-header mt-[-1rem] mb-40">
    <h1 id="page-title" class="page-title text-3xl font-bold text-gray-900 dark:text-white">
      <?php _e('Nothing Found', 'cielos'); ?>
    </h1>
  </header>

  <div class="page-content text-gray-700 dark:text-gray-300">
    <?php if (is_home() && current_user_can('publish_posts')) : ?>

    <p class="mb-4">
      <?php
            printf(
            /* translators: %1$s: new post url */
                __('Ready to publish your first post? <a href="%1$s" class="text-blue-600 dark:text-blue-400 hover:underline">Get started here</a>.', 'cielos'),
    admin_url('post-new.php')
);
            ?>
    </p>

    <?php elseif (is_search()) : ?>

    <p class="mb-4"><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'cielos'); ?></p>
    <div class="max-w-md mx-auto">
        <?php get_search_form(); ?>
    </div>

    <?php else : ?>

    <p class="mb-4"><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'cielos'); ?></p>
    <div class="max-w-md mx-auto">
        <?php get_search_form(); ?>
    </div>

    <?php endif; ?>
  </div>
</article>
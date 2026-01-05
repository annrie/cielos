<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

get_header(); ?>

<div class="container mx-auto px-4 py-16">
  <div class="grid grid-cols-1">
    <main id="main" class="main-content text-center" tabindex="-1">
      <article class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <header class="mb-8">
          <div class="text-7xl text-red-500 mb-4">
            <i class="i-carbon-face-dissatisfied"></i>
          </div>
          <h1 class="entry-title text-4xl font-bold text-gray-900 dark:text-white"><?php _e('File Not Found', 'cielos'); ?></h1>
        </header>
        <div class="entry-content text-gray-700 dark:text-gray-300">
          <p class="text-lg mb-6"><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'cielos'); ?></p>
          <p class="mb-4"><?php _e('Please try the following:', 'cielos'); ?></p>
          <ul class="list-none p-0 m-0 space-y-2 text-left inline-block">
            <li class="flex items-center gap-2">
              <i class="i-carbon-checkmark text-green-500"></i>
              <span><?php _e('Check your spelling', 'cielos'); ?></span>
            </li>
            <li class="flex items-center gap-2">
              <i class="i-carbon-home text-blue-500"></i>
              <span>
                <?php
                printf(
                    /* translators: %s: home page url */
                    __('Return to the <a href="%s" class="text-blue-600 dark:text-blue-400 hover:underline">home page</a>', 'cielos'),
                    home_url()
                );
                ?>
              </span>
            </li>
            <li class="flex items-center gap-2">
              <i class="i-carbon-arrow-left text-blue-500"></i>
              <span>
                <a href="javascript:history.back()" class="text-blue-600 dark:text-blue-400 hover:underline"><?php _e('Click the Back button', 'cielos'); ?></a>
              </span>
            </li>
          </ul>
        </div>
      </article>
    </main>
  </div>
</div>

<?php
get_footer();
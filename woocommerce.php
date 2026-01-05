<?php
/**
 * Basic WooCommerce support
 * For an alternative integration method see WC docs
 * http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

get_header(); ?>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <?php woocommerce_content(); ?>
    </main>
      <?php get_sidebar(); ?>
  </div>
</div>

<?php
get_footer();

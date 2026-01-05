<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @category WordPress
 * @package  unomoon
 * @author   annrie <info@cielos.com>
 * @license  MIT License
 * @link     https://codex.wordpress.org/Template_Hierarchy
 * @since    unomoon 1.0.0
 */

get_header(); ?>
<?php
if (get_option('page_on_front')) {
    $post = get_post(get_option('page_on_front'));
    setup_postdata($post);
}
?>
<?php get_template_part('template-parts/featured-image'); ?>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <main id="main" class="main-content lg:col-span-2 scroll-mt-[var(--header-h)]" role="main" tabindex="-1">

      <section id="latest-columns">
        <div id="post-list-app"></div>
      </section>
      <section id="machaki-pickup" class="mt-8">
        <div id="machaki-pickup-app"></div>
      </section>
    </main>
    <?php get_sidebar('top'); ?>
  </div>
</div>
<?php
get_footer();

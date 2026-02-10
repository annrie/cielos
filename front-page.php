<?php
/**
 * The front page template
 *
 * Definitive Edition: Hero section with Vue.js component.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

get_header(); ?>

<!-- ===== Hero Section (Definitive Edition) ===== -->
<section class="section-hero">
  <div
    class="hero-definitive-mount"
    data-site-name="<?php echo esc_attr(get_bloginfo('name')); ?>"
    data-tagline="<?php echo esc_attr(get_bloginfo('description')); ?>"
    data-theme-uri="<?php echo esc_attr(get_template_directory_uri()); ?>"
  ></div>
</section>

<?php do_action('cielos_after_hero'); ?>

<?php get_footer(); ?>

<?php
/**
 * Template Name: Front
 * Template Post Type: page
 *
 * Cielos theme showcase front page with Vue.js Hero.
 * This template only displays the Hero section.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

get_header(); ?>

<?php
// Get hero type from customizer
$hero_type = get_theme_mod( 'cielos_hero_type', 'definitive' );
?>

<!-- ===== Hero Section ===== -->
<section class="section-hero">
  <div
    class="hero-showcase-mount"
    data-hero-type="<?php echo esc_attr($hero_type); ?>"
    data-site-name="<?php echo esc_attr(get_bloginfo('name')); ?>"
    data-tagline="<?php echo esc_attr(get_bloginfo('description')); ?>"
    data-theme-uri="<?php echo esc_attr(get_template_directory_uri()); ?>"
  ></div>
</section>

<?php
get_footer();

<?php
/**
 * The template for displaying the footer
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<!-- Navigation Control - Clean navigation functionality -->
<script src="<?php echo get_template_directory_uri(); ?>/nav-control.js" defer></script>
<div id="top"></div>
<div id="content-top"></div>
</div>
<div id="cielos-back-to-top" class="fixed bottom-4 right-4 z-50"></div>
<?php
/**
 * Footer - load selected pattern
 */
$footer_pattern = get_theme_mod( 'cielos_footer_pattern', 'default' );
get_template_part( 'template-parts/footer', $footer_pattern );
?>
<?php if (get_theme_mod('wpt_mobile_menu_layout') === 'offcanvas' ) : ?>
<?php endif; ?>
<div id="app"></div>
<?php wp_footer(); ?>
<!-- <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
AOS.init();
</script>
-->
</body>

</html>

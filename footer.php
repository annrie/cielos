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
 * Footer
 */
?>
<footer class="bg-[var(--footer-bg)] text-[var(--footer-fg)] py-[var(--footer-py)] px-4 mt-16">
    <div class="footer-grid flex flex-col items-center">
        <div class="cell"> <?php dynamic_sidebar('footer-widgets1'); ?> </div>
        <div id="copyright"
            class="cell text-center">
            <small>Copyright &copy; <?php bloginfo('name'); ?> All rights reserved.</small>
        </div>
    </div>
</footer>
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

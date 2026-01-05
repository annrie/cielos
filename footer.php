<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

?> <?php
/**
 * Back to Top
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
<footer class="bg-gray-800 text-white py-8 px-4 mt-16 dark:bg-gray-900">
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

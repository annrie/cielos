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
<footer class="bg-[var(--footer-bg)] text-[var(--footer-fg)] py-[var(--footer-py)] px-4 <?php echo is_front_page() ? '' : 'mt-16'; ?>">
    <div class="footer-container max-w-screen-xl mx-auto">
        <?php if (is_active_sidebar('footer-left') || is_active_sidebar('footer-center') || is_active_sidebar('footer-right')) : ?>
        <div class="footer-widgets grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <?php if (is_active_sidebar('footer-left')) : ?>
            <div class="footer-widget-area footer-left">
                <?php dynamic_sidebar('footer-left'); ?>
            </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('footer-center')) : ?>
            <div class="footer-widget-area footer-center">
                <?php dynamic_sidebar('footer-center'); ?>
            </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('footer-right')) : ?>
            <div class="footer-widget-area footer-right">
                <?php dynamic_sidebar('footer-right'); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (is_active_sidebar('footer-mobile')) : ?>
        <div class="footer-widget-mobile md:hidden mb-8">
            <?php dynamic_sidebar('footer-mobile'); ?>
        </div>
        <?php endif; ?>

        <div id="copyright" class="text-center border-t border-[var(--footer-fg)]/20 pt-6">
            <?php
            $copyright_text = get_theme_mod('cielos_copyright_text', '');
            if ($copyright_text) :
            ?>
                <small><?php echo wp_kses_post($copyright_text); ?></small>
            <?php else : ?>
                <small>Copyright &copy; <?php bloginfo('name'); ?> All rights reserved.</small>
            <?php endif; ?>
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

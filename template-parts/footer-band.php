<?php
/**
 * Footer Pattern: Dark Band
 *
 * Two-tier footer: main content area + dark bottom bar.
 * Widget areas in upper section, compact info bar below.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<footer class="<?php echo is_front_page() ? '' : 'mt-16'; ?>">
    <!-- Upper band: widgets + site info -->
    <div class="bg-[var(--footer-bg)] text-[var(--footer-fg)] px-4 py-10">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Site branding column -->
                <div>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block mb-3">
                        <span class="font-lobster text-2xl"><?php bloginfo('name'); ?></span>
                    </a>
                    <p class="text-sm opacity-75 leading-relaxed">
                        <?php bloginfo('description'); ?>
                    </p>
                </div>

                <!-- Widget areas -->
                <?php if (is_active_sidebar('footer-left')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-left'); ?>
                </div>
                <?php endif; ?>
                <?php if (is_active_sidebar('footer-center')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-center'); ?>
                </div>
                <?php endif; ?>
                <?php if (is_active_sidebar('footer-right')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-right'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Lower band: dark bottom bar -->
    <div class="bg-[color-mix(in_srgb,var(--footer-bg)_85%,black)] text-[var(--footer-fg)] px-4 py-3">
        <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-xs opacity-70">
            <!-- Copyright -->
            <div>
                <?php
                $copyright_text = get_theme_mod('cielos_copyright_text', '');
                if ($copyright_text) :
                    echo '<small>' . wp_kses_post($copyright_text) . '</small>';
                else :
                ?>
                    <small>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</small>
                <?php endif; ?>
            </div>

            <!-- Social + privacy links -->
            <div class="flex items-center gap-4">
                <?php if (has_nav_menu('privacy-nav')) : ?>
                <nav aria-label="<?php esc_attr_e('Legal', 'cielos'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'privacy-nav',
                        'container'      => false,
                        'menu_class'     => 'flex gap-3 list-none',
                        'depth'          => 1,
                        'fallback_cb'    => '__return_empty_string',
                    ));
                    ?>
                </nav>
                <?php endif; ?>
                <div class="flex items-center gap-2">
                    <a href="https://github.com/annrie/cielos" target="_blank" rel="noopener"
                       class="hover:opacity-100 transition-opacity" aria-label="GitHub">
                        <span class="i-carbon-logo-github text-base" aria-hidden="true"></span>
                    </a>
                    <a href="https://twitter.com/muraie_jin" target="_blank" rel="noopener"
                       class="hover:opacity-100 transition-opacity" aria-label="Twitter">
                        <span class="i-carbon-logo-twitter text-base" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

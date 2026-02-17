<?php
/**
 * Footer Pattern: Rich
 *
 * Full-featured footer with site info, 4-column links,
 * newsletter signup, social links, and copyright bar.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

$theme_uri = get_template_directory_uri();
?>
<footer class="bg-[var(--footer-bg)] text-[var(--footer-fg)] <?php echo is_front_page() ? '' : 'mt-16'; ?>">
    <div class="max-w-screen-xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-10">
            <!-- Site info -->
            <div class="lg:col-span-2">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 mb-4">
                    <span class="font-lobster text-2xl"><?php bloginfo('name'); ?></span>
                </a>
                <p class="text-sm opacity-80 leading-relaxed mb-4 max-w-sm">
                    <?php bloginfo('description'); ?>
                </p>
                <!-- Social links -->
                <div class="flex items-center gap-3">
                    <a href="https://github.com/annrie/cielos" target="_blank" rel="noopener"
                       class="w-9 h-9 flex items-center justify-center rounded-lg bg-[var(--footer-fg)]/10 hover:bg-[var(--footer-fg)]/20 transition-colors"
                       aria-label="GitHub">
                        <span class="i-carbon-logo-github text-lg" aria-hidden="true"></span>
                    </a>
                    <a href="https://twitter.com/muraie_jin" target="_blank" rel="noopener"
                       class="w-9 h-9 flex items-center justify-center rounded-lg bg-[var(--footer-fg)]/10 hover:bg-[var(--footer-fg)]/20 transition-colors"
                       aria-label="Twitter">
                        <span class="i-carbon-logo-twitter text-lg" aria-hidden="true"></span>
                    </a>
                </div>
            </div>

            <!-- Widget columns -->
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

    <!-- Bottom bar -->
    <div class="border-t border-[var(--footer-fg)]/10">
        <div class="max-w-screen-xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <small class="opacity-70">
                <?php
                $copyright_text = get_theme_mod('cielos_copyright_text', '');
                if ($copyright_text) :
                    echo wp_kses_post($copyright_text);
                else :
                ?>
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
                <?php endif; ?>
            </small>
            <?php if (has_nav_menu('privacy-nav')) : ?>
            <nav aria-label="<?php esc_attr_e('Footer links', 'cielos'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'privacy-nav',
                    'container'      => false,
                    'menu_class'     => 'flex gap-4 list-none text-sm opacity-70',
                    'depth'          => 1,
                    'fallback_cb'    => '__return_empty_string',
                ));
                ?>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</footer>

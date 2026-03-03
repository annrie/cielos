<?php
/**
 * Footer Pattern: Centered
 *
 * Logo centered, horizontal nav links, social icons, copyright.
 * All content aligned to center for a balanced look.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<footer class="bg-[var(--footer-bg)] text-[var(--footer-fg)] text-center <?php echo is_front_page() ? '' : 'mt-16'; ?>">
    <div class="max-w-screen-xl mx-auto px-4 py-10">
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block mb-6">
            <span class="font-lobster text-3xl"><?php bloginfo('name'); ?></span>
        </a>

        <!-- Navigation -->
        <?php if (has_nav_menu('primary-menu')) : ?>
        <nav class="mb-6" aria-label="<?php esc_attr_e('Footer navigation', 'cielos'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container'      => false,
                'menu_class'     => 'flex flex-wrap items-center justify-center gap-x-6 gap-y-2 list-none text-sm',
                'depth'          => 1,
                'fallback_cb'    => '__return_empty_string',
            ));
            ?>
        </nav>
        <?php endif; ?>

        <!-- Tagline -->
        <p class="text-sm opacity-70 mb-6 max-w-md mx-auto leading-relaxed">
            <?php bloginfo('description'); ?>
        </p>

        <!-- Social links -->
        <div class="flex items-center justify-center gap-4 mb-8">
            <a href="https://github.com/annrie/cielos" target="_blank" rel="noopener"
               class="opacity-60 hover:opacity-100 transition-opacity" aria-label="GitHub">
                <span class="i-carbon-logo-github text-2xl" aria-hidden="true"></span>
            </a>
            <a href="https://twitter.com/muraie_jin" target="_blank" rel="noopener"
               class="opacity-60 hover:opacity-100 transition-opacity" aria-label="Twitter">
                <span class="i-carbon-logo-twitter text-2xl" aria-hidden="true"></span>
            </a>
        </div>

        <!-- Copyright -->
        <div class="border-t border-[var(--footer-fg)]/15 pt-6">
            <small class="opacity-60">
                <?php
                $copyright_text = get_theme_mod('cielos_copyright_text', '');
                if ($copyright_text) :
                    echo wp_kses_post($copyright_text);
                else :
                ?>
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
                <?php endif; ?>
            </small>
        </div>
    </div>
</footer>

<?php
/**
 * Footer Pattern: Minimal
 *
 * Simple single-line footer with copyright and social links.
 * Clean and unobtrusive.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<footer class="bg-[var(--footer-bg)] text-[var(--footer-fg)] px-4 <?php echo is_front_page() ? '' : 'mt-16'; ?>">
    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 py-6">
        <!-- Copyright -->
        <div class="text-sm opacity-80">
            <?php
            $copyright_text = get_theme_mod('cielos_copyright_text', '');
            if ($copyright_text) :
            ?>
                <small><?php echo wp_kses_post($copyright_text); ?></small>
            <?php else : ?>
                <small>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></small>
            <?php endif; ?>
        </div>

        <!-- Social links -->
        <div class="flex items-center gap-4">
            <a href="https://github.com/annrie/cielos" target="_blank" rel="noopener"
               class="opacity-70 hover:opacity-100 transition-opacity" aria-label="GitHub">
                <span class="i-carbon-logo-github text-xl" aria-hidden="true"></span>
            </a>
            <a href="https://twitter.com/muraie_jin" target="_blank" rel="noopener"
               class="opacity-70 hover:opacity-100 transition-opacity" aria-label="Twitter">
                <span class="i-carbon-logo-twitter text-xl" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</footer>

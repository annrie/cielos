<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="color-scheme" content="light dark">

  <script>
// FOUC (Flash of Unstyled Content) prevention: immediately apply 'dark' class to <html>
(() => {
  const KEY = 'cielos:theme';
  const theme = localStorage.getItem(KEY) || 'system';
  const isDark = theme === 'system'
    ? window.matchMedia('(prefers-color-scheme: dark)').matches
    : theme === 'dark';
  document.documentElement.classList.toggle('dark', isDark);
  document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
})();
</script>

  <style id="cielos-adminbar-critical">
/* 初期描画で admin-bar に潜り込まないよう、外部CSS前に top を確定 */
body.admin-bar #header{
  top: 46px !important;
}
@media (min-width: 783px){
  body.admin-bar #header{
    top: 32px !important;
  }
}
</style>

  <?php wp_head(); ?>
</head>

  <body <?php body_class('bg-[var(--c-bg)] text-[var(--c-fg)] transition-colors duration-500'); ?>>
    <?php wp_body_open(); ?>
    <div class="site-wrapper">
      <?php
        /**
         * Skip Links
         */
        ?>
      <nav id="skip-links" class="sr-only focus:not-sr-only" aria-label="Skip links" data-smooth-scroll>
        <a href="#main"><?php esc_html_e('Skip to content', 'cielos'); ?></a>
        <a href="#menu"><?php esc_html_e('Skip to navigation', 'cielos'); ?></a>
      </nav>
        <!-- ** Site Header ** -->
<?php
$header_pattern = get_theme_mod( 'cielos_header_pattern', 'default' );
get_template_part( 'template-parts/header', $header_pattern );
?>

        <?php
        // Breadcrumb display: show below header only when hero is not displayed
        $image_url_header = get_the_post_thumbnail_url(null, 'full');
        $show_hero_like = ($image_url_header && !is_single());
        if (!is_front_page() && !is_page() && !is_home() && !$show_hero_like) : ?>
          <nav aria-label="breadcrumb" class="breadcrumb-nav container mx-auto px-4 pt-4 pb-3">
            <?php if (function_exists('bcn_display')) : ?>
              <div class="breadcrumb-navxt text-sm bg-[var(--crumb-bg)] border border-[var(--crumb-bc)] px-3 py-1.5 rounded inline-flex">
                <?php bcn_display(); ?>
              </div>
            <?php endif; ?>
          </nav>
        <?php endif;

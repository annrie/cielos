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
<header id="header" class="min-h-[var(--header-h)] sticky z-10 bg-[var(--header-bg)] text-[var(--header-fg)] shadow-md backdrop-blur">
  <!-- Mobile ( < lg ) -->
  <div id="header-mobile" class="lg:hidden flex items-center justify-between px-4 py-2">
    <a rel="home" href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center" style="flex:1 1 auto">
      <?php if (has_custom_logo()) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <span class="text-xl font-bold"><?php bloginfo('name'); ?></span>
      <?php endif; ?>
    </a>
    <div class="flex items-center gap-x-2">
      <!-- theme -->
      <button id="theme-toggle-mobile" type="button"
        class="p-2 w-8 h-8 flex items-center justify-center rounded-md bg-[var(--header-hover-bg)] hover:bg-[var(--header-active-bg)]"
        aria-label="<?php esc_attr_e('Toggle theme', 'cielos'); ?>">
        <svg data-icon="sun" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
          <path d="M12 4V2m0 20v-2M4 12H2m20 0h-2M5.64 5.64 4.22 4.22m15.56 15.56-1.42-1.42M18.36 5.64l1.42-1.42M4.22 19.78l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <circle cx="12" cy="12" r="4" fill="currentColor"/>
        </svg>
        <svg data-icon="moon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor"/>
        </svg>
        <svg data-icon="system" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
          <rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
          <path d="M8 21h8M12 17v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>

      <!-- hamburger -->
      <button data-toggle="mobile-menu" type="button"
        class="p-2 w-9 h-9 inline-flex items-center justify-center rounded-md bg-[var(--header-hover-bg)] hover:bg-[var(--header-active-bg)]"
        aria-controls="mobile-menu" aria-expanded="false" title="<?php esc_attr_e('Menu', 'cielos'); ?>">
        <svg data-icon="menu" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
          <path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Desktop ( >= lg ) -->
  <section id="header-desktop" class="hidden lg:flex items-center justify-between px-4 py-2" aria-label="<?php esc_attr_e('Site navigation', 'cielos'); ?>">
    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="flex-shrink-0 flex items-center">
      <?php if (has_custom_logo()) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <span class="text-xl font-bold"><?php bloginfo('name'); ?></span>
      <?php endif; ?>
    </a>

    <nav id="menu" class="lg:flex items-center gap-x-4 ml-auto" aria-label="<?php esc_attr_e('Main menu', 'cielos'); ?>">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary-menu',
        'container'      => false,
        'menu_class'     => 'flex gap-6 list-none',
        'fallback_cb'    => '__return_empty_string',
        'walker'         => new Cielos_Primary_Menu_Walker(),
      ));
      ?>
      <button id="theme-toggle-desktop" class="ml-3 hidden lg:inline-flex items-center justify-center w-9 h-9 rounded-md"
        type="button" aria-label="<?php esc_attr_e('Theme toggle', 'cielos'); ?>">
        <svg data-icon="sun"  width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
          <path d="M12 4V2m0 20v-2M4 12H2m20 0h-2M5.64 5.64 4.22 4.22m15.56 15.56-1.42-1.42M18.36 5.64l1.42-1.42M4.22 19.78l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <circle cx="12" cy="12" r="4" fill="currentColor"/>
        </svg>
        <svg data-icon="moon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor"/>
        </svg>
        <svg data-icon="system" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
          <rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
          <path d="M8 21h8M12 17v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
    </nav>
  </section>

  <!-- Mobile panel -->
  <nav id="mobile-menu" class="w-full bg-[var(--header-bg)] text-[var(--header-fg)] py-4 px-2"
       aria-label="<?php esc_attr_e('Mobile menu', 'cielos'); ?>">
    <?php
    wp_nav_menu(array(
      'theme_location' => 'primary-menu',
      'container'      => false,
      'menu_id'        => 'menu-global-mobile',
      'menu_class'     => 'vertical menu',
      'fallback_cb'    => '__return_empty_string',
      'walker'         => new Cielos_Mobile_Walker(),
    ));
    ?>
  </nav>
</header>

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

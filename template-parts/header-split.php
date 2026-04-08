<?php
/**
 * Header Pattern: Split (Two-tier)
 *
 * Top bar with secondary menu + theme toggle,
 * main bar with logo left + primary navigation right.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

$theme_uri = get_template_directory_uri();
?>
<style>
.site-branding-icon{display:inline-flex;align-items:center;line-height:1}
.site-branding-icon .site-logo-light,.site-branding-icon .site-logo-dark{height:calc(var(--logo-h,40px) + 16px);width:auto;max-width:none;display:block}
.site-branding-icon .site-logo-dark{display:none}
html.dark .site-branding-icon .site-logo-light{display:none}
html.dark .site-branding-icon .site-logo-dark{display:block}
@media (max-width:1023.98px){.site-branding-icon .site-logo-light,.site-branding-icon .site-logo-dark{height:calc(var(--logo-h,48px) + 14px)}}
</style>
<header id="header" class="sticky top-0 z-10 bg-[var(--header-bg)] text-[var(--header-fg)] shadow-md backdrop-blur">
  <!-- Mobile ( < lg ) -->
  <div id="header-mobile" class="lg:hidden flex items-center justify-between px-4 py-2">
    <a rel="home" href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center" style="flex:1 1 auto">
      <span class="site-branding-icon">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/site-logo-light.png"
             alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="site-logo-light">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/site-logo-dark.png"
             alt="" class="site-logo-dark" aria-hidden="true">
      </span>
    </a>
    <div class="flex items-center gap-x-2">
      <?php get_template_part('template-parts/header', 'theme-toggle', array('id' => 'mobile', 'size' => '18')); ?>
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
  <div class="hidden lg:block">
    <!-- Top bar: secondary menu + theme toggle -->
    <div class="border-b border-[var(--header-fg)]/10 bg-[color-mix(in_srgb,var(--header-bg)_90%,black)]">
      <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between py-1 text-xs opacity-80">
        <div class="flex items-center gap-4">
          <?php if (has_nav_menu('top-bar-r')) : ?>
          <nav aria-label="<?php esc_attr_e('Secondary menu', 'cielos'); ?>">
            <?php
            wp_nav_menu(array(
              'theme_location' => 'top-bar-r',
              'container'      => false,
              'menu_class'     => 'flex gap-4 list-none',
              'depth'          => 1,
              'fallback_cb'    => '__return_empty_string',
            ));
            ?>
          </nav>
          <?php endif; ?>
        </div>
        <div class="flex items-center gap-3">
          <span class="opacity-70"><?php bloginfo('description'); ?></span>
          <?php get_template_part('template-parts/header', 'theme-toggle', array('id' => 'desktop-top', 'size' => '16')); ?>
        </div>
      </div>
    </div>

    <!-- Main bar: logo + primary nav -->
    <section id="header-desktop" class="flex items-center justify-between px-4 py-2 max-w-screen-xl mx-auto"
      aria-label="<?php esc_attr_e('Site navigation', 'cielos'); ?>">
      <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="flex-shrink-0 flex items-center">
        <span class="site-branding-icon">
          <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/site-logo-light.png"
               alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="site-logo-light">
          <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/site-logo-dark.png"
               alt="" class="site-logo-dark" aria-hidden="true">
        </span>
      </a>

      <nav id="menu" class="flex items-center gap-x-4 ml-auto" aria-label="<?php esc_attr_e('Main menu', 'cielos'); ?>">
        <?php
        wp_nav_menu(array(
          'theme_location' => 'primary-menu',
          'container'      => false,
          'menu_class'     => 'flex gap-6 list-none',
          'fallback_cb'    => '__return_empty_string',
          'walker'         => new Cielos_Primary_Menu_Walker(),
        ));
        ?>
      </nav>
    </section>
  </div>

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

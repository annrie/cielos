<?php
/**
 * Header Pattern: Transparent
 *
 * Transparent background that overlays the hero section.
 * Ideal for front pages and landing pages with hero images.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

$theme_uri = get_template_directory_uri();
?>
<style>
.header-transparent{position:absolute;top:0;left:0;right:0;background:transparent!important;box-shadow:none!important;backdrop-filter:none!important}
.header-transparent.is-scrolled{position:fixed;background:var(--header-bg)!important;box-shadow:0 1px 3px rgba(0,0,0,.1)!important;backdrop-filter:blur(12px)!important}
.site-branding-icon{position:relative;display:inline-flex;align-items:center;justify-content:center;height:2.25rem}
.site-branding-icon .site-branding-sun{position:absolute!important;top:50%!important;left:50%!important;transform:translate(-50%,-50%)!important;width:2.75rem!important;height:2.75rem!important;max-width:2.75rem!important;max-height:2.75rem!important;object-fit:contain!important;pointer-events:none;transition:opacity .5s ease;filter:none!important}
.site-branding-icon .site-branding-name{position:relative;z-index:1;font-size:1.25rem;font-weight:400;color:var(--header-fg,#fff);text-shadow:0 1px 2px rgba(0,0,0,.6),0 0 8px rgba(0,0,0,.4),0 0 20px rgba(0,0,0,.2);letter-spacing:.03em}
</style>
<header id="header" class="header-transparent min-h-[var(--header-h)] z-10 text-white transition-all duration-300">
  <!-- Mobile ( < lg ) -->
  <div id="header-mobile" class="lg:hidden flex items-center justify-between px-4 py-2">
    <a rel="home" href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center" style="flex:1 1 auto">
      <span class="site-branding-icon">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-light.png"
             alt="" class="hero-sun-light site-branding-sun" aria-hidden="true">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-dark.png"
             alt="" class="hero-sun-dark site-branding-sun" aria-hidden="true">
        <span class="site-branding-name font-lobster"><?php bloginfo('name'); ?></span>
      </span>
    </a>
    <div class="flex items-center gap-x-2">
      <?php get_template_part('template-parts/header', 'theme-toggle', array('id' => 'mobile', 'size' => '18')); ?>
      <button data-toggle="mobile-menu" type="button"
        class="p-2 w-9 h-9 inline-flex items-center justify-center rounded-md hover:bg-white/20"
        aria-controls="mobile-menu" aria-expanded="false" title="<?php esc_attr_e('Menu', 'cielos'); ?>">
        <svg data-icon="menu" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
          <path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Desktop ( >= lg ) -->
  <section id="header-desktop" class="hidden lg:flex items-center justify-between px-6 py-3" aria-label="<?php esc_attr_e('Site navigation', 'cielos'); ?>">
    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="flex-shrink-0 flex items-center">
      <span class="site-branding-icon">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-light.png"
             alt="" class="hero-sun-light site-branding-sun" aria-hidden="true">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-dark.png"
             alt="" class="hero-sun-dark site-branding-sun" aria-hidden="true">
        <span class="site-branding-name font-lobster"><?php bloginfo('name'); ?></span>
      </span>
    </a>

    <nav id="menu" class="lg:flex items-center gap-x-6 ml-auto" aria-label="<?php esc_attr_e('Main menu', 'cielos'); ?>">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary-menu',
        'container'      => false,
        'menu_class'     => 'flex gap-6 list-none',
        'fallback_cb'    => '__return_empty_string',
        'walker'         => new Cielos_Primary_Menu_Walker(),
      ));
      ?>
      <?php get_template_part('template-parts/header', 'theme-toggle', array('id' => 'desktop', 'size' => '20')); ?>
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

<script>
(function() {
  var header = document.getElementById('header');
  if (!header) return;
  var onScroll = function() {
    header.classList.toggle('is-scrolled', window.scrollY > 80);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();
</script>

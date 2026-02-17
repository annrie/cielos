<?php
/**
 * Header Pattern: Split Navigation
 *
 * Navigation split left and right of centered logo.
 * Balanced layout for sites with moderate menu items.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

$theme_uri = get_template_directory_uri();

// Split menu items for left/right display
$menu_locations = get_nav_menu_locations();
$menu_items = array();
if (isset($menu_locations['primary-menu'])) {
    $menu_items = wp_get_nav_menu_items($menu_locations['primary-menu']);
}
// Only top-level items
$top_items = array_filter($menu_items ?: array(), function($item) {
    return $item->menu_item_parent == 0;
});
$top_items = array_values($top_items);
$half = ceil(count($top_items) / 2);
$left_items = array_slice($top_items, 0, $half);
$right_items = array_slice($top_items, $half);
?>
<style>
.site-branding-icon{position:relative;display:inline-flex;align-items:center;justify-content:center;height:2.25rem}
.site-branding-icon .site-branding-sun{position:absolute!important;top:50%!important;left:50%!important;transform:translate(-50%,-50%)!important;width:2.75rem!important;height:2.75rem!important;max-width:2.75rem!important;max-height:2.75rem!important;object-fit:contain!important;pointer-events:none;transition:opacity .5s ease;filter:none!important}
.site-branding-icon .site-branding-name{position:relative;z-index:1;font-size:1.25rem;font-weight:400;color:var(--header-fg,#fff);text-shadow:0 1px 2px rgba(0,0,0,.6),0 0 8px rgba(0,0,0,.4),0 0 20px rgba(0,0,0,.2);letter-spacing:.03em}
.split-nav-link{padding:.25rem .75rem;font-size:.875rem;font-weight:500;color:var(--header-fg);text-decoration:none;border-radius:.375rem;transition:background .2s,color .2s}
.split-nav-link:hover{background:var(--header-hover-bg,rgba(255,255,255,.18));color:var(--header-hover-fg,#fff)}
</style>
<header id="header" class="min-h-[var(--header-h)] sticky top-0 z-10 bg-[var(--header-bg)] text-[var(--header-fg)] shadow-md backdrop-blur">
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
        class="p-2 w-9 h-9 inline-flex items-center justify-center rounded-md bg-[var(--header-hover-bg)] hover:bg-[var(--header-active-bg)]"
        aria-controls="mobile-menu" aria-expanded="false" title="<?php esc_attr_e('Menu', 'cielos'); ?>">
        <svg data-icon="menu" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
          <path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Desktop ( >= lg ) -->
  <section id="header-desktop" class="hidden lg:grid items-center py-2 px-4"
    style="grid-template-columns:1fr auto 1fr"
    aria-label="<?php esc_attr_e('Site navigation', 'cielos'); ?>">
    <!-- Left nav -->
    <nav class="flex items-center justify-end gap-x-4" aria-label="<?php esc_attr_e('Primary left', 'cielos'); ?>">
      <?php foreach ($left_items as $item) : ?>
        <a href="<?php echo esc_url($item->url); ?>" class="split-nav-link"><?php echo esc_html($item->title); ?></a>
      <?php endforeach; ?>
    </nav>

    <!-- Center logo -->
    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="mx-6 flex items-center">
      <span class="site-branding-icon">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-light.png"
             alt="" class="hero-sun-light site-branding-sun" aria-hidden="true">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-dark.png"
             alt="" class="hero-sun-dark site-branding-sun" aria-hidden="true">
        <span class="site-branding-name font-lobster text-xl"><?php bloginfo('name'); ?></span>
      </span>
    </a>

    <!-- Right nav -->
    <nav class="flex items-center justify-start gap-x-4" aria-label="<?php esc_attr_e('Primary right', 'cielos'); ?>">
      <?php foreach ($right_items as $item) : ?>
        <a href="<?php echo esc_url($item->url); ?>" class="split-nav-link"><?php echo esc_html($item->title); ?></a>
      <?php endforeach; ?>
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

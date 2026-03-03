<?php
/**
 * Header Pattern: Minimal
 *
 * Logo left + hamburger menu only (both mobile & desktop).
 * Opens a full-screen overlay navigation.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

$theme_uri = get_template_directory_uri();
?>
<style>
.site-branding-icon{position:relative;display:inline-flex;align-items:center;justify-content:center;height:2.25rem}
.site-branding-icon .site-branding-sun{position:absolute!important;top:50%!important;left:50%!important;transform:translate(-50%,-50%)!important;width:2.75rem!important;height:2.75rem!important;max-width:2.75rem!important;max-height:2.75rem!important;object-fit:contain!important;pointer-events:none;transition:opacity .5s ease;filter:none!important}
.site-branding-icon .site-branding-name{position:relative;z-index:1;font-size:1.25rem;font-weight:400;color:var(--header-fg,#fff);text-shadow:0 1px 2px rgba(0,0,0,.6),0 0 8px rgba(0,0,0,.4),0 0 20px rgba(0,0,0,.2);letter-spacing:.03em}
.fullscreen-nav{position:fixed;inset:0;z-index:100;display:flex;flex-direction:column;align-items:center;justify-content:center;background:var(--header-bg);opacity:0;pointer-events:none;transition:opacity .3s ease}
.fullscreen-nav.is-open{opacity:1;pointer-events:auto}
.fullscreen-nav .menu{display:flex;flex-direction:column;align-items:center;gap:1.5rem;list-style:none;padding:0}
.fullscreen-nav .menu a{font-size:1.5rem;font-weight:300;letter-spacing:.05em;color:var(--header-fg);text-decoration:none;transition:opacity .2s}
.fullscreen-nav .menu a:hover{opacity:.7}
.fullscreen-nav__close{position:absolute;top:1rem;right:1rem}
</style>
<header id="header" class="min-h-[var(--header-h)] sticky top-0 z-10 bg-[var(--header-bg)] text-[var(--header-fg)] backdrop-blur">
  <div class="flex items-center justify-between px-4 py-2">
    <a rel="home" href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
      <span class="site-branding-icon">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-light.png"
             alt="" class="hero-sun-light site-branding-sun" aria-hidden="true">
        <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-dark.png"
             alt="" class="hero-sun-dark site-branding-sun" aria-hidden="true">
        <span class="site-branding-name font-lobster"><?php bloginfo('name'); ?></span>
      </span>
    </a>
    <div class="flex items-center gap-x-2">
      <?php get_template_part('template-parts/header', 'theme-toggle', array('id' => 'minimal', 'size' => '18')); ?>
      <button id="fullscreen-nav-toggle" type="button"
        class="p-2 w-9 h-9 inline-flex items-center justify-center rounded-md bg-[var(--header-hover-bg)] hover:bg-[var(--header-active-bg)]"
        aria-label="<?php esc_attr_e('Open menu', 'cielos'); ?>">
        <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
          <path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
    </div>
  </div>
</header>

<!-- Full-screen overlay navigation -->
<div id="fullscreen-nav" class="fullscreen-nav text-[var(--header-fg)]" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Navigation', 'cielos'); ?>">
  <button id="fullscreen-nav-close" class="fullscreen-nav__close p-3 rounded-md hover:bg-[var(--header-hover-bg)]" type="button"
    aria-label="<?php esc_attr_e('Close menu', 'cielos'); ?>">
    <svg viewBox="0 0 24 24" width="28" height="28" aria-hidden="true">
      <path d="M18 6 6 18M6 6l12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
  </button>
  <nav aria-label="<?php esc_attr_e('Main menu', 'cielos'); ?>">
    <?php
    wp_nav_menu(array(
      'theme_location' => 'primary-menu',
      'container'      => false,
      'menu_class'     => 'menu',
      'fallback_cb'    => '__return_empty_string',
    ));
    ?>
  </nav>
</div>

<script>
(function() {
  var toggle = document.getElementById('fullscreen-nav-toggle');
  var nav = document.getElementById('fullscreen-nav');
  var close = document.getElementById('fullscreen-nav-close');
  if (!toggle || !nav || !close) return;
  toggle.addEventListener('click', function() { nav.classList.add('is-open'); });
  close.addEventListener('click', function() { nav.classList.remove('is-open'); });
  nav.addEventListener('click', function(e) { if (e.target === nav) nav.classList.remove('is-open'); });
  document.addEventListener('keydown', function(e) { if (e.key === 'Escape') nav.classList.remove('is-open'); });
})();
</script>

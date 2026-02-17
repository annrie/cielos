<?php
/**
 * Theme Toggle Button (shared partial)
 *
 * Usage: get_template_part('template-parts/header', 'theme-toggle', array('id' => 'mobile', 'size' => '18'));
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

$toggle_id = 'theme-toggle-' . ($args['id'] ?? 'default');
$icon_size = $args['size'] ?? '18';
$extra_class = ($args['id'] ?? '') === 'desktop'
    ? 'ml-3 hidden lg:inline-flex items-center justify-center w-9 h-9 rounded-md'
    : 'p-2 w-8 h-8 flex items-center justify-center rounded-md bg-[var(--header-hover-bg)] hover:bg-[var(--header-active-bg)]';
?>
<button id="<?php echo esc_attr($toggle_id); ?>" type="button"
  class="<?php echo esc_attr($extra_class); ?>"
  data-theme-toggle
  aria-label="<?php esc_attr_e('Toggle theme', 'cielos'); ?>">
  <svg data-icon="sun" width="<?php echo esc_attr($icon_size); ?>" height="<?php echo esc_attr($icon_size); ?>" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
    <path d="M12 4V2m0 20v-2M4 12H2m20 0h-2M5.64 5.64 4.22 4.22m15.56 15.56-1.42-1.42M18.36 5.64l1.42-1.42M4.22 19.78l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <circle cx="12" cy="12" r="4" fill="currentColor"/>
  </svg>
  <svg data-icon="moon" width="<?php echo esc_attr($icon_size); ?>" height="<?php echo esc_attr($icon_size); ?>" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor"/>
  </svg>
  <svg data-icon="system" width="<?php echo esc_attr($icon_size); ?>" height="<?php echo esc_attr($icon_size); ?>" viewBox="0 0 24 24" aria-hidden="true" style="display:none">
    <rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
    <path d="M8 21h8M12 17v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>
</button>

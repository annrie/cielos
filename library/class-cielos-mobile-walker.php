<?php
class Cielos_Mobile_Walker extends Walker_Nav_Menu {
  public function start_lvl( &$output, $depth = 0, $args = null ) {
    $output .= '<ul id="menu-global-mobile" class="sub-menu">';
  }
  public function end_lvl( &$output, $depth = 0, $args = null ) {
    $output .= '</ul>';
  }

  public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $has_children = in_array('menu-item-has-children', $classes, true)
                 || in_array('page_item_has_children', $classes, true)
                 || in_array('has-submenu', $classes, true);

    $class_names = implode(' ', array_map('esc_attr', $classes));
    $output .= '<li class="' . $class_names . '"' . ($has_children ? ' aria-expanded="false"' : '') . '>';

    // 行本体（ラベル＋トグル）
    $output .= '<div class="flex items-center justify-between w-full">';
    $url = function_exists('cielos_resolve_multibyte_internal_url')
      ? cielos_resolve_multibyte_internal_url((string) $item->url)
      : (string) $item->url;
    $output .= '<a class="submenu-label flex-1" href="' . esc_url($url) . '">' . esc_html($item->title) . '</a>';
    if ($has_children) {
      $output .= '<button type="button" class="submenu-toggle-icon" aria-label="' . esc_attr__('サブメニューを開く','cielos') . '">'
               .   '<svg class="chev" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">'
               .     '<path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />'
               .   '</svg>'
               . '</button>';
    }
    $output .= '</div>';
  }

  public function end_el( &$output, $item, $depth = 0, $args = null ) {
    $output .= "</li>\n";
  }
}

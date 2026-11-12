<?php
/**
 * ACF Option Pages
 *
 * PHP Version >=7.0
 *
 * @category unomoon
 * @package  unomoon
 * @author   annrie <blastspinner@gmail.com>
 * @license  MIT
 * @link     https://unomoon.cielos.com
 */

/**
 * メニューの場所を登録する
 *
 * ファイルを読み込んだ時点で __() を呼ぶと、WordPress 6.7 以降は
 * 「翻訳の読み込みが早すぎる」notice が出るため、after_setup_theme で登録する。
 * 翻訳を読み込む cielos_theme_support（theme-support.php）は先に同じ優先度で
 * 登録されているので、こちらより先に実行される。
 */
if ( ! function_exists('cielos_register_nav_menus') ) {
    function cielos_register_nav_menus() {
        register_nav_menus(
            array(
                'primary-menu' => __('Primary Menu', 'cielos'),
                'top-bar-r'   => esc_html__('Right Top Bar', 'cielos'),
                'mobile-nav'  => esc_html__('Mobile', 'cielos'),
                'privacy-nav' => esc_html__('Privacy', 'cielos'),
            )
        );
    }
}
add_action('after_setup_theme', 'cielos_register_nav_menus');


/**
 * Desktop navigation - right top bar
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists('cielos_top_bar_r') ) {
    function cielos_top_bar_r() {
        wp_nav_menu(
            array(
                'container'      => false,
                'menu_class'     => 'flex space-x-4 items-center',
                'items_wrap'     => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
                'theme_location' => 'top-bar-r',
                'depth'          => 3,
                'fallback_cb'    => false,
                
            )
        );
    }
}


/**
 * Mobile navigation - topbar (default) or offcanvas
 */
if ( ! function_exists('cielos_mobile_nav') ) {
    function cielos_mobile_nav() {
        wp_nav_menu(
            array(
                'container'      => false,                         // Remove nav container
                'menu'           => __('mobile-nav', 'cielos'),
                'menu_class'     => 'vertical menu',
                'theme_location' => 'mobile-nav',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'fallback_cb'    => false,
                'walker'         => new Cielos_Mobile_Walker(),
            )
        );
    }
}


/**
 * Privacy navigation
 */
if ( ! function_exists('cielos_privacy_nav') ) {
    function cielos_privacy_nav() {
        wp_nav_menu(
            array(
                'container'      => false,
                'menu_class'     => 'vertical menu accordion-menu',
                'items_wrap'     => '<ul id="%1$s" class="%2$s nested privacy-menu align-center">%3$s</ul>',
                'theme_location' => 'privacy-nav',
                'depth'          => 3,
                'fallback_cb'    => false,
            )
        );
    }
}


/**
 * Add support for buttons in the top-bar menu:
 * 1) In WordPress admin, go to Apperance -> Menus.
 * 2) Click 'Screen Options' from the top panel and enable 'CSS CLasses' and 'Link Relationship (XFN)'
 * 3) On your menu item, type 'has-form' in the CSS-classes field. Type 'button' in the XFN field
 * 4) Save Menu. Your menu item will now appear as a button in your top-menu
*/
if ( ! function_exists('cielos_add_menuclass') ) {
    function cielos_add_menuclass( $ulclass ) {
        $find    = array( '/<a rel="button"/', '/<a title=".*?" rel="button"/' );
        $replace = array( '<a rel="button" class="button"', '<a rel="button" class="button"' );

        return preg_replace($find, $replace, $ulclass, 1);
    }
    add_filter('wp_nav_menu', 'cielos_add_menuclass');
}
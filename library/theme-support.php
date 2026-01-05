<?php
/**
 * ACF Option Pages
 *
 * PHP Version >=7.0
 *
 * @category unomoon
 * @package.json  unomoon
 * @author   annrie <blastspinner @gmail.com>
 * @license  MIT
 * @link     https://unomoon.cielos.com
 */

if (! function_exists('cielos_theme_support')) :
function cielos_theme_support()
{       // Add language support
    load_theme_textdomain('cielos', get_template_directory() . '/languages');

    // Switch default core markup for search form, comment form, and comments to output valid HTML5
    add_theme_support(
        'html5',
        array(
            'style',
            'script',
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'navigation-widgets',
        )
    );

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Add post thumbnail support: http://codex.wordpress.org/Post_Thumbnails
    add_theme_support('post-thumbnails');

    // RSS thingy
    add_theme_support('automatic-feed-links');

    // Add post formats support: http://codex.wordpress.org/Post_Formats
    add_theme_support('post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ));

    $args = array(
      'flex-width'    => true,
      'width'         => 1200,
      'flex-width'    => true,
      'height'        => 200,
      'default-image' => get_template_directory_uri() . '/dist/assets/images/top/cielos_main.jpg',
    );
    add_theme_support('custom-header', $args);

    $defaults = array(
      'default-color'          => '',
      'default-image'          => '',
      'default-repeat'         => '',
      'default-position-x'     => '',
      'default-attachment'     => '',
      'wp-head-callback'       => '_custom_background_cb',
      'admin-head-callback'    => '',
      'admin-preview-callback' => ''
    );
    add_theme_support('custom-background', $defaults);

    // Additional theme support for woocommerce 3.0.+
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /* ▼ ブロックの追加スタイルを有効化 */
    // add_theme_support( 'wp-block-styles' );

    // ピクセル以外の単位を有効化
    add_theme_support('custom-units', array());

    // 埋め込みコンテンスのレスポンシブ化
    add_theme_support('responsive-embeds');

    // Add support for full and wide align images.
    add_theme_support('align-wide');

    // Add support for custom line height controls.
    add_theme_support('custom-line-height');

    // Add support for experimental link color control.
    add_theme_support('link-color');

    // Add support for experimental cover block spacing.
    add_theme_support('custom-spacing');

    // Custom background color.
add_theme_support(
'custom-background',
array(
'default-color' => '#dcedc8',
)
);

// Editor color palette.
    $primary     = '#1779ba';
    $secondary   = '#767676';
    $success     = '#3adb76';
    $warning     = '#ffae00';
    $alert       = '#cc4b37';
$black       = '#0a0a0a';
$light_gray  = '#e6e6e6';
$medium_gray = '#cacaca';
$dark_gray   = '#8a8a8a';
$gray        = '#39414D';
$green       = '#D1E4DD';
$jis_green   = '#00b06b';
$blue        = '#D1DFE4';
$jis_blue    = '#1971ff';
$purple      = '#D1D1E4';
$red         = '#E4D1D1';
$jis_red     = '#ff4b00';
$orange      = '#E4DAD1';
$jis_orange  = '#f6aa00';
$yellow      = '#EEEADD';
$jis_yellow  = '#f2e700';
    $jis_magenta = '#990';
$white       = '#fefefe';

add_theme_support(
'editor-color-palette',
array(
array(
'name'  => esc_html__( 'Primary', 'cielos' ),
'slug'  => 'primary',
'color' => $primary,
),
        array(
'name'  => esc_html__( 'Secondary', 'cielos' ),
'slug'  => 'secondary',
'color' => $secondary,
),
        array(
'name'  => esc_html__( 'Success', 'cielos' ),
'slug'  => 'success',
'color' => $success,
),
        array(
'name'  => esc_html__( 'Warning', 'cielos' ),
'slug'  => 'warning',
'color' => $warning,
),
        array(
'name'  => esc_html__( 'Alert', 'cielos' ),
'slug'  => 'alert',
'color' => $alert,
),
        array(
'name'  => esc_html__( 'Black', 'cielos' ),
'slug'  => 'black',
'color' => $black,
),
array(
'name'  => esc_html__( 'Light gray', 'cielos' ),
'slug'  => 'light-gray',
'color' => $light_gray,
),
array(
'name'  => esc_html__( 'Medium gray', 'cielos' ),
'slug'  => 'medium-gray',
'color' => $medium_gray,
),array(
'name'  => esc_html__( 'Dark gray', 'cielos' ),
'slug'  => 'dark-gray',
'color' => $dark_gray,
),
array(
'name'  => esc_html__( 'Gray', 'cielos' ),
'slug'  => 'gray',
'color' => $gray,
),
array(
'name'  => esc_html__( 'Green', 'cielos' ),
'slug'  => 'green',
'color' => $green,
),
array(
'name'  => esc_html__( 'Jis green', 'cielos' ),
'slug'  => 'jis-green',
'color' => $jis_green,
),
array(
'name'  => esc_html__( 'Blue', 'cielos' ),
'slug'  => 'blue',
'color' => $blue,
),
array(
'name'  => esc_html__( 'Jis blue', 'cielos' ),
'slug'  => 'jis-blue',
'color' => $jis_blue,
),
array(
'name'  => esc_html__( 'Purple', 'cielos' ),
'slug'  => 'purple',
'color' => $purple,
),
array(
'name'  => esc_html__( 'Red', 'cielos' ),
'slug'  => 'red',
'color' => $red,
),
array(
'name'  => esc_html__( 'Jis red', 'cielos' ),
'slug'  => 'jis-red',
'color' => $jis_red,
),
array(
'name'  => esc_html__( 'Orange', 'cielos' ),
'slug'  => 'orange',
'color' => $orange,
),
array(
'name'  => esc_html__( 'Jis orange', 'cielos' ),
'slug'  => 'jis-orange',
'color' => $jis_orange,
),
array(
'name'  => esc_html__( 'Yellow', 'cielos' ),
'slug'  => 'yellow',
'color' => $yellow,
),
array(
'name'  => esc_html__( 'Jis yellow', 'cielos' ),
'slug'  => 'jis-yellow',
'color' => $jis_yellow,
),
array(
'name'  => esc_html__( 'Jis magenta', 'cielos' ),
'slug'  => 'jis-magenta',
'color' => $jis_magenta,
),
array(
'name'  => esc_html__( 'White', 'cielos' ),
'slug'  => 'white',
'color' => $white,
),
)
);

add_theme_support(
'editor-gradient-presets',
array(
array(
'name'     => esc_html__( 'Purple to yellow', 'twentytwentyone' ),
'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $yellow . ' 100%)',
'slug'     => 'purple-to-yellow',
),
array(
'name'     => esc_html__( 'Yellow to purple', 'twentytwentyone' ),
'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $purple . ' 100%)',
'slug'     => 'yellow-to-purple',
),
array(
'name'     => esc_html__( 'Green to yellow', 'twentytwentyone' ),
'gradient' => 'linear-gradient(160deg, ' . $green . ' 0%, ' . $yellow . ' 100%)',
'slug'     => 'green-to-yellow',
),
array(
'name'     => esc_html__( 'Yellow to green', 'twentytwentyone' ),
'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $green . ' 100%)',
'slug'     => 'yellow-to-green',
),
array(
'name'     => esc_html__( 'Red to yellow', 'twentytwentyone' ),
'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $yellow . ' 100%)',
'slug'     => 'red-to-yellow',
),
array(
'name'     => esc_html__( 'Yellow to red', 'twentytwentyone' ),
'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $red . ' 100%)',
'slug'     => 'yellow-to-red',
),
array(
'name'     => esc_html__( 'Purple to red', 'twentytwentyone' ),
'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $red . ' 100%)',
'slug'     => 'purple-to-red',
),
array(
'name'     => esc_html__( 'Red to purple', 'twentytwentyone' ),
'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $purple . ' 100%)',
'slug'     => 'red-to-purple',
),
)
);

}

add_action('after_setup_theme', 'cielos_theme_support');
endif;
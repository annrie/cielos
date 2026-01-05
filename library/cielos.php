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
 * A fallback when no navigation is selected by default.
 */

if ( ! function_exists('cielos_menu_fallback') ) :
    function cielos_menu_fallback() {         echo '<div class="bg-blue-100 text-blue-800 p-4 rounded">';
        printf(
        /* translators: %1$s: link to menus, %2$s: link to customize. */
            __('Please assign a menu to the primary menu location under %1$s or %2$s the design.', 'cielos'),
            sprintf(
            /* translators: %s: menu url */
                __('<a href="%s">Menus</a>', 'cielos'),
                get_admin_url(get_current_blog_id(), 'nav-menus.php')
            ),
            sprintf(
            /* translators: %s: customize url */
                __('<a href="%s">Customize</a>', 'cielos'),
                get_admin_url(get_current_blog_id(), 'customize.php')
            )
        );
        echo '</div>';
    }
endif;

// Add unomoon 'is-active' class for the current menu item.
if ( ! function_exists('cielos_active_nav_class') ) :
    function cielos_active_nav_class( $classes, $item ) {
        if (1 === $item->current || true === $item->current_item_ancestor ) {
            $classes[] = 'is-active';
        }
        return $classes;
    }
    add_filter('nav_menu_css_class', 'cielos_active_nav_class', 10, 2);
endif;

/**
 * Use the is-active class of ZURB unomoon on wp_list_pages output.
 * From required+ unomoon http://themes.required.ch.
 */
if ( ! function_exists('cielos_active_list_pages_class') ) :
    function cielos_active_list_pages_class( $input ) {
        $pattern = '/current_page_item/';
        $replace = 'current_page_item is-active';

        $output = preg_replace($pattern, $replace, $input);

        return $output;
    }
    add_filter('wp_list_pages', 'cielos_active_list_pages_class', 10, 2);
endif;



/**
 * Get mobile menu ID
 */

if ( ! function_exists('cielos_mobile_menu_id') ) :
    function cielos_mobile_menu_id() {         if (get_theme_mod('wpt_mobile_menu_layout') === 'offcanvas' ) {
            echo 'off-canvas-menu';
        } else {
		echo 'mobile-menu';
        }
    }
endif;

/**
 * Get title bar responsive toggle attribute
 */

if ( ! function_exists('cielos_title_bar_responsive_toggle') ) :
    function cielos_title_bar_responsive_toggle() {         if ( ! get_theme_mod('wpt_mobile_menu_layout') || get_theme_mod('wpt_mobile_menu_layout') === 'topbar' ) {
            echo 'data-responsive-toggle="mobile-menu"';
        }
    }
endif;

/**
 * Custom markup for WordPress gallery
 */
if ( ! function_exists('cielos_gallery') ) :
    function cielos_gallery( $attr ) {
        $post            = get_post();
        static $instance = 0;
        $instance++;

        if ( ! empty($attr['ids']) ) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if (empty($attr['orderby']) ) {
                $attr['orderby'] = 'post__in';
            }
            $attr['include'] = $attr['ids'];
        }

        // Allow plugins/themes to override the default gallery template.
        $output = apply_filters('post_gallery', '', $attr, $instance);
        if ('' !== $output ) {
            return $output;
        }

        // Let's make sure it looks like a valid orderby statement
        if (isset($attr['orderby']) ) {
            $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
            if ( ! $attr['orderby'] ) {
                unset($attr['orderby']);
            }
        }

        $atts = shortcode_atts(
            array(
                'order'          => 'ASC',
                'orderby'        => 'menu_order ID',
                'id'             => $post ? $post->ID : 0,
                'itemtag'        => 'figure',
                'icontag'        => 'div',
                'captiontag'     => 'figcaption',
                'columns-small'  => 2, // set default columns for small screen
                'columns-medium' => 4, // set default columns for medium screen
                'columns'        => 3, // set default columns for large screen (3 = wordpress default)
                'size'           => 'thumbnail',
                'include'        => '',
                'exclude'        => '',
            ),
            $attr,
            'gallery'
        );

        $id = intval($atts['id']);

        if ( ! empty($atts['include']) ) {
            $_attachments = get_posts(
                array(
                    'include'        => $atts['include'],
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );

            $attachments = array();
            foreach ($_attachments as $key => $val ) {
                $attachments[ $val->ID ] = $_attachments[ $key ];
            }
        } elseif ( ! empty($atts['exclude']) ) {
            $attachments = get_children(
                array(
                    'post_parent'    => $id,
                    'exclude'        => $atts['exclude'],
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );
        } else {
            $attachments = get_children(
                array(
                    'post_parent'    => $id,
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );
        }

        if (empty($attachments) ) {
            return '';
        }

        if (is_feed() ) {
            $output = "\n";
            foreach ($attachments as $att_id => $attachment ) {
                $output .= wp_get_attachment_link($att_id, $atts['size'], true) . "\n";
            }
            return $output;
        }

        $item_tag    = tag_escape($atts['itemtag']);
        $caption_tag = tag_escape($atts['captiontag']);
        $icon_tag    = tag_escape($atts['icontag']);
        $valid_tags  = wp_kses_allowed_html('post');

        if ( ! isset($valid_tags[ $item_tag ]) ) {
            $item_tag = 'figure';
        }
        if ( ! isset($valid_tags[ $caption_tag ]) ) {
            $caption_tag = 'figcaption';
        }
        if ( ! isset($valid_tags[ $icon_tag ]) ) {
            $icon_tag = 'div';
        }

        $gallery_data = [];
        foreach ($attachments as $attachment_id => $attachment ) {
            $image_src = wp_get_attachment_image_src($attachment_id, $atts['size']);
            $image_full_src = wp_get_attachment_image_src($attachment_id, 'full'); // Get full size for lightbox if needed

            $orientation = '';
            if (isset($image_src[1], $image_src[2]) ) {
                $orientation = ( $image_src[2] > $image_src[1] ) ? 'portrait' : 'landscape';
            }

            $gallery_data[] = [
                'id'          => $attachment_id,
                'src'         => $image_src[0],
                'width'       => $image_src[1],
                'height'      => $image_src[2],
                'full_src'    => $image_full_src[0],
                'caption'     => wptexturize($attachment->post_excerpt),
                'alt'         => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
                'orientation' => $orientation,
                'link'        => get_attachment_link($attachment_id), // Default to attachment page
            ];
        }

        $json_gallery_data = json_encode($gallery_data);
        $unique_id = 'cielos-gallery-' . $instance;

        return '<div id="' . esc_attr($unique_id) . '" data-gallery-data=\'' . esc_attr($json_gallery_data) . '\' data-columns-small="' . esc_attr($atts['columns-small']) . '" data-columns-medium="' . esc_attr($atts['columns-medium']) . '" data-columns="' . esc_attr($atts['columns']) . '"></div>';
    }
    add_shortcode('gallery', 'cielos_gallery');
endif;

if ( ! function_exists('cielos_sidebar_widget_styler') ) {
    function cielos_sidebar_widget_styler($params) {
        $params[0]['before_widget'] = '<aside class="widget %1$s %2$s">';
        $params[0]['after_widget'] = '</aside>';
        $params[0]['before_title'] = '<h4 class="widget-title text-xl font-bold mb-4 pb-2 border-b-2 border-gray-200 dark:border-gray-700 dark:text-white">';
        $params[0]['after_title'] = '</h4>';

        return $params;
    }
    add_filter('dynamic_sidebar_params', 'cielos_sidebar_widget_styler');
}

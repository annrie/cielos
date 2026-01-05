<?php
/**
 * Uses WP image & file attachments to quickly output the correct code
 * 11/16/2018
 *
 * @category unomoon
 * @package  unomoon
 * @author   annrie <blastspinner@gmail.com>
 * @license  MIT
 * @link     https://unomoon.cielos.com
 *
 * Requires: WordPress @link https://codex.wordpress.org/
 */

/**
 * Check if a WP attachment MIME type is image/svg+xml
 *
 * @return boolean
 */

function is_svg( $attachment_id ) {
    $mime_type = get_post_mime_type($attachment_id);
    error_log( 'is_svg: Checking ID ' . $attachment_id . ', MIME type: ' . $mime_type );
    if ('image/svg+xml' === $mime_type ) {
        error_log( 'is_svg: ID ' . $attachment_id . ' is SVG (true)' );
        return true;
    } else {
        error_log( 'is_svg: ID ' . $attachment_id . ' is NOT SVG (false)' );
        return false;
    }
}
/**
 * Get the SVG as code
 *
 * @return string the raw SVG code
 */
 function get_svg( $attachment_id, $size = 'thumbnail', $icon = false ) {
     // Get the direct URL of the attachment
    $svg_url = wp_get_attachment_url( $attachment_id );

     if ( ! $svg_url ) {
         return new WP_Error( 'svg_url_not_found', 'Could not get URL for attachment
      ID: ' . $attachment_id );
     }

     // Use wp_remote_get to fetch the content from the URL
     $response = wp_remote_get( $svg_url );

     if ( is_wp_error( $response ) ) {
         return new WP_Error( 'svg_remote_get_failed', 'wp_remote_get failed for URL: ' . $svg_url . ' Error: ' . $response->get_error_message() );
     }

     $svg_content = wp_remote_retrieve_body( $response );

     if ( empty( $svg_content ) ) {
         return new WP_Error( 'empty_svg_content_from_url', 'Empty SVG content
      retrieved from URL: ' . $svg_url );
     }

     return $svg_content;
 }


/**
 * Output SVG as code
 *
 * * @return string the raw SVG code
 */
function the_svg( $attachment_id ) {
    echo get_svg($attachment_id);
}

/**
 * Get the image attachment or SVG as code
 *
 * @return string the image or raw SVG code
 */
function get_the_image( $attachment_id, $size = 'thumbnail', $icon = false, $attr = '' ) {
    if (is_svg($attachment_id) ) {
        // SVGs are now handled by the Vue component.
        // This function will return an empty string for SVGs.
        return '';
    } else {
        return wp_get_attachment_image($attachment_id, $size, $icon, $attr);
    }
}
    /**
     * Output the image attachment or SVG as code
     *
     * * @return string out image attachment or raw SVG as code
     */
function the_image( $attachment_id, $size = 'thumbnail', $icon = false, $attr = '' ) {
    echo get_the_image($attachment_id, $size, $icon, $attr);
}
    /**
     * Get the image url
     *
     * @return string the image url
     */
function get_the_image_url( $attachment_id, $size = 'thumbnail', $icon = false ) {
    return wp_get_attachment_image_url($attachment_id, $size, $icon);
}
    /**
     * Output the image url
     *
     * * @return string output the image url
     */
function the_image_url( $attachment_id ) {
    echo get_the_image_url($attachment_id);
}
    /**
     * Get the file url
     *
     * @return string the image url
     */
function get_the_file_url( $attachment_id ) {
    return wp_get_attachment_url($attachment_id);
}
    /**
     * Output the file url
     *
     * * @return string output the image url
     */
function the_file_url( $attachment_id ) {
    echo get_the_file_url($attachment_id);
}
    /**
     * Generate custom dimensions
     */
function generate_ratio( $new_size = array(), $old_size = array() ) {
    $new_width  = $new_size[0];
    $new_height = $new_size[1];
    $old_width  = $old_size[0];
    $old_height = $old_size[1];
    // Both declared
    if (isset($new_width) && ( '' !== $new_width ) && isset($new_height) && ( '' !== $new_height ) ) {
        return; // Do nothing, values already set
            // Height declared
    } elseif (isset($new_height) && ( '' !== $new_height ) && ( '' === $new_width ) || ! isset($new_width) ) {
        if ($old_height === $old_width ) {
            $new_width = $new_height;
        } elseif ($old_width > $old_height ) {
            $new_width = ( $old_width / $old_height ) * $new_height;
        } elseif ($old_height > $old_width ) {
            $new_width = ( $old_width / $old_height ) * $new_height;
        } // Width declared
    } elseif (isset($new_width) && ( '' !== $new_width ) && ( '' === $new_height ) || ! isset($new_height) ) {
        if ($old_height === $old_width ) {
            $new_height = $new_width;
        } elseif ($old_width > $old_height ) {
            $new_height = ( $old_height / $old_width ) * $new_width;
        } elseif ($old_height > $old_width ) {
            $new_height = ( $old_height / $old_width ) * $new_width;
        }
    } else {
        return; // None declared
    }
    return array( $new_width, $new_height );
}
    /**
     * Get size information for all currently-registered image sizes.
     *
     * @global $_wp_additional_image_sizes
     * @uses   get_intermediate_image_sizes()
     * @return array $sizes Data for all currently-registered image sizes.
     */
function get_the_image_sizes() {     global $_wp_additional_image_sizes;
    $sizes = array();
    foreach (get_intermediate_image_sizes() as $_size ) {
        if (in_array($_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true) ) {
            $sizes[ $_size ]['width']  = get_option("{$_size}_size_w");
            $sizes[ $_size ]['height'] = get_option("{$_size}_size_h");
            $sizes[ $_size ]['crop']   = (bool) get_option("{$_size}_crop");
        } elseif (isset($_wp_additional_image_sizes[ $_size ]) ) {
            $sizes[ $_size ] = array(
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
        }
    }
    return $sizes;
}
            /**
             * Get size information for a specific image size.
             *
             * @uses   get_the_image_sizes()
             * @param  string $size The image size for which to retrieve data.
             * @return bool|array $size Size data about an image size or false if the size doesn't exist.
             */
function get_the_image_size( $size ) {
    $sizes = get_the_image_sizes();
    if (isset($sizes[ $size ]) ) {
        return $sizes[ $size ];
    }
    return false;
}
    /**
     * Get the width of a specific image size.
     *
     * @uses   get_the_image_size()
     * @param  string $size The image size for which to retrieve data.
     * @return bool|string $size Width of an image size or false if the size doesn't exist.
     */
function get_the_image_width( $size ) {
    if ( ! get_the_image_size($size) === $size ) {
        return false;
    }
    if (isset($size['width']) ) {
        return $size['width'];
    }
    return false;
}
    /**
     * Get the height of a specific image size.
     *
     * @uses   get_the_image_size()
     * @param  string $size The image size for which to retrieve data.
     * @return bool|string $size Height of an image size or false if the size doesn't exist.
     */
function get_the_image_height( $size ) {
    if ( ! get_the_image_size($size) === $size ) {
        return false;
    }
    if (isset($size['height']) ) {
        return $size['height'];
    }
    return false;
}
    /**
     * Get the image as a background
     * This will return svgs formatted as CSS and anything else as a URL
     */
function cielos_svg_to_data_uri( $svg_raw ) {
    if ( empty( $svg_raw ) || is_wp_error( $svg_raw ) ) {
        return '';
    }
    // 余計なXML宣言などは除去・軽量化（必要に応じて）
    $svg = preg_replace( '/<\?xml[^>]*\?>/i', '', $svg_raw );
    $svg = trim( $svg );
    // 最小化（任意）
    $svg = preg_replace( '/>\s+</', '><', $svg );

    // data URI 化
    return 'data:image/svg+xml;charset=utf-8,' . rawurlencode( $svg );
}

function get_the_image_bg( $attachment_id, $size = 'thumbnail', $icon = false, $attr = '' ) {
    if ( ! $attachment_id ) {
        return '';
    }

    // SVG は data URI を返す
    if ( is_svg( $attachment_id ) ) {
        // キャッシュ（トランジェント）で高速化
        $cache_key = "cielos_svg_bg_uri_{$attachment_id}";
        $data_uri  = get_transient( $cache_key );

        if ( false === $data_uri ) {
            $svg_raw = get_svg( $attachment_id, $size, $icon ); // 既存の生SVG取得関数
            if ( empty( $svg_raw ) || is_wp_error( $svg_raw ) ) {
                error_log( 'get_the_image_bg: failed to get raw SVG for ID ' . $attachment_id );
                return '';
            }
            $data_uri = cielos_svg_to_data_uri( $svg_raw );
            // 失敗時ガード
            if ( empty( $data_uri ) ) {
                error_log( 'get_the_image_bg: failed to build data URI for ID ' . $attachment_id );
                return '';
            }
            set_transient( $cache_key, $data_uri, DAY_IN_SECONDS );
        }

        return $data_uri; // ← これを style="background-image:url(...)" で使う
    }

    // 非SVGは通常の画像URLを返す
    $url = wp_get_attachment_image_url( $attachment_id, $size, $icon );
    return $url ? $url : '';
}
function cielos_purge_svg_bg_cache( $attachment_id ) {
    $mime = get_post_mime_type( $attachment_id );
    if ( $mime === 'image/svg+xml' ) {
        delete_transient( "cielos_svg_bg_uri_{$attachment_id}" );
    }
}
add_action( 'edit_attachment',   'cielos_purge_svg_bg_cache' );
add_action( 'delete_attachment', 'cielos_purge_svg_bg_cache' );

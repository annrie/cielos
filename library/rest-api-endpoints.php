<?php
/**
 * REST API Endpoints for unomoon theme.
 *
 * @package Cielos
 */

add_action('rest_api_init', function () {
    register_rest_route('unomoon/v1', '/svg/(?P<id>\d+)', [
        'methods'  => 'GET',
        'callback' => 'cielos_get_svg_data',
        'permission_callback' => '__return_true',
        'args' => [
            'id' => [
                'type' => 'integer',
                'required' => true,
            ],
            'format' => [
                'type' => 'string',
                'required' => false,
            ],
        ],
    ]);
});

function cielos_get_svg_data( WP_REST_Request $request ) {
    $id = absint( $request['id'] );
    $format = $request->get_param('format') ?: 'inline';

    if ( ! $id ) {
        return new WP_Error( 'bad_id', 'Invalid attachment id', [ 'status' => 400 ] );
    }

    $mime = get_post_mime_type( $id );
    if ( $mime !== 'image/svg+xml' ) {
        return new WP_Error( 'not_svg', 'Attachment is not SVG', [ 'status' => 400 ] );
    }

    // できるだけファイルパスから読む（URL経由だと権限やリダイレクトで落ちやすい）
    $path = get_attached_file( $id );
    if ( ! $path || ! file_exists( $path ) ) {
        return new WP_Error( 'no_file', 'SVG file not found on disk', [ 'status' => 500 ] );
    }

    $svg_raw = @file_get_contents( $path );
    if ( $svg_raw === false ) {
        return new WP_Error( 'read_fail', 'Failed to read SVG content', [ 'status' => 500 ] );
    }

    // alt など任意
    $alt_text = get_post_meta( $id, '_wp_attachment_image_alt', true );

    // viewBox 幅高（あると便利）
    $vb_w = null; $vb_h = null;
    if ( preg_match('/viewBox\\s*=\\s*"([^"]+)"/i', $svg_raw, $m) ) {
        $p = preg_split('/\\s+/', trim($m[1]));
        if ( count($p) === 4 ) { $vb_w = (float)$p[2]; $vb_h = (float)$p[3]; }
    }

    $resp = [
        'id'             => $id,
        'alt_text'       => $alt_text ?: '',
        'viewbox_width'  => $vb_w,
        'viewbox_height' => $vb_h,
        'svg_content'    => $svg_raw,
    ];

    if ( $format === 'background' ) {
        // data URI を生成（テーマ関数があれば利用）
        if ( ! function_exists('cielos_svg_to_data_uri') ) {
            // 念のため読み込む（パスはあなたの構成に合わせて）
            @require_once get_template_directory() . '/library/attachment-functions.php';
        }
        if ( function_exists('cielos_svg_to_data_uri') ) {
            $resp['svg_data_uri'] = cielos_svg_to_data_uri( $svg_raw );
        } else {
            // フォールバック
            $resp['svg_data_uri'] = 'data:image/svg+xml;charset=utf-8,' . rawurlencode( trim($svg_raw) );
        }
    }

    return new WP_REST_Response( $resp, 200 );
}
// viewBox="minX minY width height" を抜くヘルパ
function cielos_extract_viewbox($svg) {
    if ( preg_match('/viewBox\s*=\s*"([^"]+)"/i', $svg, $m) ) {
        $parts = preg_split('/\s+/', trim($m[1]));
        if ( count($parts) === 4 ) {
            return array(
                'min_x' => (float) $parts[0],
                'min_y' => (float) $parts[1],
                'width' => (float) $parts[2],
                'height'=> (float) $parts[3],
            );
        }
    }
    return null;
}

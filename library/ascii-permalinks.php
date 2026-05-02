<?php
/**
 * Avoid public links that contain multibyte slugs.
 *
 * The production server returns 403 before WordPress handles requests whose
 * path contains percent-encoded Japanese characters. Keep generated links on
 * ASCII-only paths/query strings, and prevent canonical redirects back to the
 * blocked pretty URL.
 *
 * @package Cielos
 */

if (!defined('ABSPATH')) {
    exit;
}

function cielos_slug_has_multibyte_chars($slug): bool {
    $decoded = rawurldecode((string) $slug);

    return $decoded !== '' && preg_match('/[^\x00-\x7F]/', $decoded) === 1;
}

function cielos_url_has_multibyte_path(string $url): bool {
    $path = wp_parse_url($url, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        return false;
    }

    return cielos_slug_has_multibyte_chars($path);
}

function cielos_url_has_legacy_dot_host(string $url): bool {
    $parts = wp_parse_url(html_entity_decode(trim($url), ENT_QUOTES, get_bloginfo('charset') ?: 'UTF-8'));
    if (!is_array($parts)) {
        return false;
    }

    $host = isset($parts['host']) ? (string) $parts['host'] : '';

    return ($host === '.' || $host === '..')
        && (empty($parts['scheme']) || in_array(strtolower((string) $parts['scheme']), ['http', 'https'], true));
}

function cielos_get_current_base_url(): string {
    if (function_exists('get_the_ID')) {
        $post_id = get_the_ID();
        if ($post_id) {
            $permalink = get_permalink($post_id);
            if (is_string($permalink) && $permalink !== '') {
                return $permalink;
            }
        }
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) && is_string($_SERVER['REQUEST_URI'])
        ? wp_unslash($_SERVER['REQUEST_URI'])
        : '/';

    return home_url($request_uri);
}

function cielos_get_current_request_url(): string {
    $request_uri = isset($_SERVER['REQUEST_URI']) && is_string($_SERVER['REQUEST_URI'])
        ? wp_unslash($_SERVER['REQUEST_URI'])
        : '/';

    return home_url($request_uri);
}

function cielos_normalize_path(string $path): string {
    $has_trailing_slash = substr($path, -1) === '/';
    $segments = explode('/', $path);
    $normalized = [];

    foreach ($segments as $segment) {
        if ($segment === '' || $segment === '.') {
            continue;
        }

        if ($segment === '..') {
            array_pop($normalized);
            continue;
        }

        $normalized[] = $segment;
    }

    $path = '/' . implode('/', $normalized);

    return $has_trailing_slash && $path !== '/' ? $path . '/' : $path;
}

function cielos_make_absolute_internal_url(string $relative_url, string $base_url = ''): string {
    $base_url = $base_url !== '' ? $base_url : cielos_get_current_base_url();
    $base = wp_parse_url($base_url);
    $relative = wp_parse_url($relative_url);

    if (!is_array($relative)) {
        return $relative_url;
    }

    $relative_path = isset($relative['path']) ? (string) $relative['path'] : '';
    $query = isset($relative['query']) ? '?' . $relative['query'] : '';
    $fragment = isset($relative['fragment']) ? '#' . $relative['fragment'] : '';

    if ($relative_path === '') {
        return home_url('/') . $query . $fragment;
    }

    if (substr($relative_path, 0, 1) === '/') {
        $path = $relative_path;
    } else {
        $base_path = isset($base['path']) ? (string) $base['path'] : '/';
        $base_dir = substr($base_path, -1) === '/' ? $base_path : dirname($base_path) . '/';
        $path = $base_dir . $relative_path;
    }

    return home_url(cielos_normalize_path($path)) . $query . $fragment;
}

function cielos_resolve_legacy_dot_internal_url(string $url, string $base_url = ''): string {
    $decoded_url = html_entity_decode(trim($url), ENT_QUOTES, get_bloginfo('charset') ?: 'UTF-8');
    if (!cielos_url_has_legacy_dot_host($decoded_url)) {
        return $url;
    }

    $relative = preg_replace('#^(?:https?:)?//#i', '', $decoded_url);
    if (!is_string($relative) || $relative === '') {
        return $url;
    }

    return cielos_make_absolute_internal_url($relative, $base_url);
}

function cielos_post_type_allows_safe_fallback(string $post_type): bool {
    $object = get_post_type_object($post_type);

    return $object && !empty($object->public);
}

function cielos_post_needs_safe_permalink($post): bool {
    $post = get_post($post);
    if (!$post || !cielos_post_type_allows_safe_fallback($post->post_type)) {
        return false;
    }

    return cielos_slug_has_multibyte_chars($post->post_name);
}

function cielos_get_safe_post_permalink($post): string {
    $post = get_post($post);
    if (!$post) {
        return home_url('/');
    }

    $args = [];
    if ($post->post_type === 'page') {
        $args['page_id'] = $post->ID;
    } elseif ($post->post_type === 'attachment') {
        $args['attachment_id'] = $post->ID;
    } else {
        $args['p'] = $post->ID;
        if ($post->post_type !== 'post') {
            $args['post_type'] = $post->post_type;
        }
    }

    return add_query_arg($args, home_url('/'));
}

function cielos_filter_safe_post_permalink(string $permalink, $post): string {
    if (!cielos_post_needs_safe_permalink($post)) {
        return $permalink;
    }

    return cielos_get_safe_post_permalink($post);
}

add_filter('post_link', 'cielos_filter_safe_post_permalink', 10, 2);
add_filter('post_type_link', 'cielos_filter_safe_post_permalink', 10, 2);

add_filter('page_link', function ($link, $post_id) {
    return cielos_filter_safe_post_permalink($link, $post_id);
}, 10, 2);

add_filter('attachment_link', function ($link, $post_id) {
    return cielos_filter_safe_post_permalink($link, $post_id);
}, 10, 2);

function cielos_filter_safe_term_link(string $termlink, $term, string $taxonomy): string {
    if (!$term instanceof WP_Term || !cielos_slug_has_multibyte_chars($term->slug)) {
        return $termlink;
    }

    if ($taxonomy === 'category') {
        return add_query_arg('cat', $term->term_id, home_url('/'));
    }

    if ($taxonomy === 'post_tag') {
        return add_query_arg('tag_id', $term->term_id, home_url('/'));
    }

    return $termlink;
}
add_filter('term_link', 'cielos_filter_safe_term_link', 10, 3);

add_filter('query_vars', function (array $vars): array {
    if (!in_array('tag_id', $vars, true)) {
        $vars[] = 'tag_id';
    }

    return $vars;
});

function cielos_ascii_slug_from_title(string $title, int $post_id, string $post_type): string {
    $title = wp_strip_all_tags(html_entity_decode($title, ENT_QUOTES, get_bloginfo('charset') ?: 'UTF-8'));
    if (function_exists('mb_convert_kana')) {
        $title = mb_convert_kana($title, 'as', 'UTF-8');
    }

    $title = str_replace(['&', '+'], [' and ', ' plus '], $title);
    $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $title);
    $slug = strtolower(is_string($ascii) && $ascii !== '' ? $ascii : $title);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim((string) preg_replace('/-+/', '-', (string) $slug), '-');

    $ascii_len = strlen(preg_replace('/[^a-z0-9]/', '', $slug));
    if ($slug === '' || $slug === 'n-a' || $ascii_len < 3) {
        $slug = sanitize_key($post_type) . '-' . $post_id;
    }

    return $slug;
}

function cielos_query_absint(string $key): int {
    if (!isset($_GET[$key]) || is_array($_GET[$key])) {
        return 0;
    }

    return absint(wp_unslash($_GET[$key]));
}

function cielos_query_string(string $key): string {
    if (!isset($_GET[$key]) || is_array($_GET[$key])) {
        return '';
    }

    return (string) wp_unslash($_GET[$key]);
}

add_action('save_post', function ($post_id, $post) {
    static $updating = false;

    if ($updating || wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }

    if (!$post instanceof WP_Post || !cielos_post_needs_safe_permalink($post)) {
        return;
    }

    $slug = cielos_ascii_slug_from_title($post->post_title, (int) $post_id, $post->post_type);
    $slug = wp_unique_post_slug($slug, (int) $post_id, $post->post_status, $post->post_type, (int) $post->post_parent);

    $updating = true;
    wp_update_post([
        'ID'        => (int) $post_id,
        'post_name' => $slug,
    ]);
    $updating = false;
}, 20, 2);

add_filter('redirect_canonical', function ($redirect_url) {
    $post_id = 0;

    if (isset($_GET['p'])) {
        $post_id = cielos_query_absint('p');
    } elseif (isset($_GET['page_id'])) {
        $post_id = cielos_query_absint('page_id');
    } elseif (isset($_GET['attachment_id'])) {
        $post_id = cielos_query_absint('attachment_id');
    }

    if ($post_id && cielos_post_needs_safe_permalink($post_id)) {
        return false;
    }

    if (isset($_GET['cat'])) {
        $term = get_term(cielos_query_absint('cat'), 'category');
        if ($term instanceof WP_Term && cielos_slug_has_multibyte_chars($term->slug)) {
            return false;
        }
    }

    if (isset($_GET['tag_id'])) {
        $term = get_term(cielos_query_absint('tag_id'), 'post_tag');
        if ($term instanceof WP_Term && cielos_slug_has_multibyte_chars($term->slug)) {
            return false;
        }
    }

    if (isset($_GET['tag'])) {
        $tag = cielos_query_string('tag');
        $term = get_term_by('slug', sanitize_title($tag), 'post_tag');
        if (($term instanceof WP_Term && cielos_slug_has_multibyte_chars($term->slug))
            || cielos_slug_has_multibyte_chars($tag)
        ) {
            return false;
        }
    }

    if (function_exists('is_tag') && is_tag()) {
        $term = get_queried_object();
        if ($term instanceof WP_Term && cielos_slug_has_multibyte_chars($term->slug)) {
            return false;
        }
    }

    return $redirect_url;
}, 9);

function cielos_resolve_multibyte_internal_url(string $url, string $base_url = ''): string {
    $url = cielos_resolve_legacy_dot_internal_url($url, $base_url);

    if (!cielos_url_has_multibyte_path($url)) {
        return $url;
    }

    $home = wp_parse_url(home_url('/'));
    $parts = wp_parse_url($url);
    $home_host = isset($home['host']) ? strtolower((string) $home['host']) : '';
    $url_host = isset($parts['host']) ? strtolower((string) $parts['host']) : '';

    if ($url_host !== '' && $home_host !== '' && $url_host !== $home_host) {
        return $url;
    }

    $post_id = url_to_postid($url);
    if ($post_id) {
        return cielos_get_safe_post_permalink($post_id);
    }

    $path = isset($parts['path']) ? trim(rawurldecode((string) $parts['path']), '/') : '';
    $slug = basename($path);
    if ($slug === '' || !cielos_slug_has_multibyte_chars($slug)) {
        return $url;
    }

    $post_id = cielos_find_post_id_by_multibyte_slug($slug);
    if ($post_id) {
        return cielos_get_safe_post_permalink($post_id);
    }

    return $url;
}

function cielos_find_post_id_by_multibyte_slug(string $slug): int {
    global $wpdb;

    if (!is_object($wpdb) || empty($wpdb->posts)) {
        return 0;
    }

    $candidates = array_values(array_unique(array_filter([
        $slug,
        sanitize_title($slug),
        strtolower(rawurlencode($slug)),
    ])));

    if (empty($candidates)) {
        return 0;
    }

    $placeholders = implode(',', array_fill(0, count($candidates), '%s'));
    $query = "SELECT ID FROM {$wpdb->posts} WHERE post_name IN ({$placeholders}) AND post_status = 'publish' ORDER BY post_date DESC LIMIT 1";
    $prepared = call_user_func_array([$wpdb, 'prepare'], array_merge([$query], $candidates));

    return (int) $wpdb->get_var($prepared);
}

function cielos_rewrite_multibyte_internal_links(string $html, string $base_url = ''): string {
    if ($html === '' || (strpos($html, '%') === false && preg_match('/[^\x00-\x7F]/', $html) !== 1)) {
        if (strpos($html, '://..') === false && strpos($html, '//..') === false) {
            return $html;
        }
    }

    if (class_exists('WP_HTML_Tag_Processor')) {
        $processor = new WP_HTML_Tag_Processor($html);
        while ($processor->next_tag('A')) {
            $href = $processor->get_attribute('href');
            if (is_string($href)) {
                $processor->set_attribute('href', cielos_resolve_multibyte_internal_url($href, $base_url));
            }
        }
        return $processor->get_updated_html();
    }

    $rewritten = preg_replace_callback(
        '/\bhref=(["\'])(.*?)\1/i',
        function ($matches) use ($base_url) {
            return 'href=' . $matches[1] . esc_url(cielos_resolve_multibyte_internal_url($matches[2], $base_url)) . $matches[1];
        },
        $html
    );

    return is_string($rewritten) ? $rewritten : $html;
}

add_filter('the_content', 'cielos_rewrite_multibyte_internal_links', 20);
add_filter('widget_text', 'cielos_rewrite_multibyte_internal_links', 20);
add_filter('widget_text_content', 'cielos_rewrite_multibyte_internal_links', 20);

add_action('template_redirect', function () {
    if (is_admin()
        || (defined('REST_REQUEST') && REST_REQUEST)
        || (function_exists('wp_doing_ajax') && wp_doing_ajax())
        || (function_exists('is_feed') && is_feed())
    ) {
        return;
    }

    $base_url = cielos_get_current_request_url();
    ob_start(function ($html) use ($base_url) {
        return is_string($html) ? cielos_rewrite_multibyte_internal_links($html, $base_url) : $html;
    });
}, 0);

function cielos_filter_rest_response_links($response, $post) {
    if (!is_object($response) || !method_exists($response, 'get_data') || !$post instanceof WP_Post) {
        return $response;
    }

    $data = $response->get_data();
    $base_url = get_permalink($post);

    if (isset($data['link']) && is_string($data['link'])) {
        $data['link'] = cielos_filter_safe_post_permalink($data['link'], $post);
    }

    foreach (['content', 'excerpt'] as $field) {
        if (isset($data[$field]['rendered']) && is_string($data[$field]['rendered'])) {
            $data[$field]['rendered'] = cielos_rewrite_multibyte_internal_links($data[$field]['rendered'], $base_url);
        }
    }

    $response->set_data($data);

    return $response;
}

add_filter('rest_prepare_post', 'cielos_filter_rest_response_links', 20, 2);
add_filter('rest_prepare_page', 'cielos_filter_rest_response_links', 20, 2);

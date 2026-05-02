<?php
/**
 * Minimal permalink compatibility hooks.
 *
 * Keep `tag_id` available as a public query var so URLs like
 * `/?tag_id=26` resolve to tag archives.
 *
 * @package Cielos
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('query_vars', function (array $vars): array {
    if (!in_array('tag_id', $vars, true)) {
        $vars[] = 'tag_id';
    }

    return $vars;
});

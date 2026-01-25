<?php
/**
 * Custom block registrations and asset enqueues for Cielos theme.
 * Uses Vite manifest.json for asset loading (consistent with functions.php).
 *
 * @package Cielos
 * @since   cielos 1.0.0
 */

/**
 * Get asset paths from Vite manifest.json
 *
 * @param string $entry_key The manifest entry key (e.g., 'src/blocks/my-block-editor.ts')
 * @return array|null Array with 'js', 'css', 'base_uri' keys, or null if not found
 */
function cielos_get_block_assets($entry_key) {
    $child_path  = get_stylesheet_directory() . '/dist/.vite/manifest.json';
    $parent_path = get_template_directory() . '/dist/.vite/manifest.json';

    $manifest_path = file_exists($child_path) ? $child_path : (file_exists($parent_path) ? $parent_path : '');
    if (!$manifest_path) {
        return null;
    }

    $base_uri = file_exists($child_path)
        ? get_stylesheet_directory_uri() . '/dist/'
        : get_template_directory_uri() . '/dist/';

    $manifest = json_decode(file_get_contents($manifest_path), true);
    if (!is_array($manifest) || !isset($manifest[$entry_key])) {
        return null;
    }

    $entry = $manifest[$entry_key];
    $result = [
        'js' => isset($entry['file']) ? $base_uri . $entry['file'] : null,
        'css' => [],
        'base_uri' => $base_uri,
    ];

    // Collect CSS files
    if (isset($entry['css']) && is_array($entry['css'])) {
        foreach ($entry['css'] as $css_file) {
            $result['css'][] = $base_uri . $css_file;
        }
    }

    return $result;
}

/**
 * Add module type for ES modules
 */
function cielos_block_script_module_type($tag, $handle) {
    if ($handle === 'cielos-block-editor-script') {
        return str_replace(' src', ' type="module" src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'cielos_block_script_module_type', 10, 2);

/**
 * Enqueue block assets and register block type
 */
function cielos_theme_block_enqueue() {
    $entry_key = 'src/blocks/my-block-editor.ts';
    $assets = cielos_get_block_assets($entry_key);

    if (!$assets || !$assets['js']) {
        // Development mode or manifest not found - skip registration
        return;
    }

    // Generate version based on file hash in URL
    $version = substr(md5($assets['js']), 0, 8);

    // Register block editor script
    wp_register_script(
        'cielos-block-editor-script',
        $assets['js'],
        ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components'], // WordPress dependencies
        $version,
        true // Load in footer
    );

    // Register block editor styles
    if (!empty($assets['css'])) {
        foreach ($assets['css'] as $index => $css_url) {
            $handle = 'cielos-block-editor-style' . ($index > 0 ? "-{$index}" : '');
            wp_register_style(
                $handle,
                $css_url,
                [],
                $version
            );
        }
    }

    // Register block types
    $blocks = ['uno/my-block', 'uno/theme-heading'];
    foreach ($blocks as $block_name) {
        register_block_type(
            $block_name,
            [
                'editor_script' => 'cielos-block-editor-script',
                'editor_style'  => 'cielos-block-editor-style',
                'style'         => 'cielos-block-editor-style',
            ]
        );
    }

}
add_action('init', 'cielos_theme_block_enqueue');

/**
 * Enqueue block styles on frontend
 */
function cielos_theme_block_frontend_styles() {
    if (is_admin()) {
        return;
    }

    $entry_key = 'src/blocks/my-block-editor.ts';
    $assets = cielos_get_block_assets($entry_key);

    if (!$assets || empty($assets['css'])) {
        return;
    }

    $version = substr(md5($assets['js']), 0, 8);

    foreach ($assets['css'] as $index => $css_url) {
        $handle = 'cielos-block-frontend-style' . ($index > 0 ? "-{$index}" : '');
        wp_enqueue_style(
            $handle,
            $css_url,
            [],
            $version
        );
    }
}
add_action('wp_enqueue_scripts', 'cielos_theme_block_frontend_styles');

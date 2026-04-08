<?php
/**
 * functions.php (full, cleaned, with Dev/HMR + Prod manifest)
 * - Dev: Vite HMR (@vite/client + /src/main.ts) when localhost:5173 is available and WP_ENVIRONMENT_TYPE=development
 * - Prod: dist/.vite/manifest.json from child theme first, then parent theme
 * - Adds type="module" and defer on main bundle
 * - Localizes pagination data expected by main.ts
 * - Keeps your existing includes and useful filters
 */

/* -------------------------------------------------------------------------- */
/* Includes (元の構成を維持) */
/* -------------------------------------------------------------------------- */
require_once 'library/cleanup.php';
require_once 'library/widget-areas.php';
require_once 'library/display-widgets.php';
require_once 'library/theme-support.php';

// カスタムウィジェット
require_once 'library/widgets/new-entries.php';
require_once 'library/widgets/popular-entries.php';
require_once 'library/widgets/cta-box.php';
require_once 'library/widgets/profile.php';
require_once 'library/navigation.php';
require_once 'library/class-cielos-top-bar-walker.php';
require_once 'library/class-cielos-mobile-walker.php';
require_once 'library/class-cielos-primary-menu-walker.php';
require_once 'library/class-cielos-comments.php';
require_once 'library/entry-meta.php';
require_once 'library/sticky-posts.php';
require_once 'library/responsive-images.php';
require_once 'library/acf-options.php';
require_once 'library/attachment-functions.php';
require_once 'library/rest-api-endpoints.php';
require_once 'library/string-to-slug.php';
require_once 'library/phone-format.php';
require_once 'library/woocommerce-support.php';
require_once 'library/woocommerce-image-sizes.php';
require_once 'library/remove-type.php';
require_once 'library/customizer.php';
require_once 'library/cielos.php';
require_once 'library/class-related-posts-scoring.php';  // 関連記事（スコアリング方式）
require_once 'cielos-block.php';

/* -------------------------------------------------------------------------- */
/* Theme textdomain */
/* -------------------------------------------------------------------------- */
function cielos_setup() {
    load_theme_textdomain( 'cielos', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'cielos_setup' );

/* -------------------------------------------------------------------------- */
/* Dev server detection (localhost:5173, WP_ENVIRONMENT_TYPE=development) */
/* -------------------------------------------------------------------------- */
function cielos_is_vite_dev(): bool {
    if (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'development') {
        $fp = @fsockopen('127.0.0.1', 5173, $errno, $errstr, 0.05);
        if ($fp) { fclose($fp); return true; }
    }
    return false;
}

/* -------------------------------------------------------------------------- */
/* Script tag tweaks（mainは上でtype/defer済み） */
/* -------------------------------------------------------------------------- */
// module を付けるのは “自分のESMだけ”。jQueryなどには付けない
add_filter('script_loader_tag', function ($tag, $handle) {
  $module_handles = ['cielos-main']; // ←必要に応じて更新
  return in_array($handle, $module_handles, true)
    ? str_replace('<script ', '<script type="module" ', $tag)
    : $tag;
}, 10, 2);

/* -------------------------------------------------------------------------- */
/* Add featured image URL to page REST API responses */
/* -------------------------------------------------------------------------- */
function add_featured_image_to_pages_api($response, $post, $request) {
    if (has_post_thumbnail($post->ID)) {
        $response->data['featured_image_url'] = get_the_post_thumbnail_url($post->ID, 'full');
    }
    return $response;
}
add_filter('rest_prepare_page', 'add_featured_image_to_pages_api', 10, 3);

/* -------------------------------------------------------------------------- */
/* Register formatted_date rest field */
/* -------------------------------------------------------------------------- */
function register_formatted_date_rest_field() {
    register_rest_field(
        'post',
        'formatted_date',
        array(
            'get_callback' => function($object, $field_name, $request) {
                return get_the_date('Y.m.d (D)', $object['id']);
            },
            'update_callback' => null,
            'schema' => null,
        )
    );
}
add_action('rest_api_init', 'register_formatted_date_rest_field');

/**
 * Islands placeholder helper for SvgImage
 */
function cielos_svg_image( array $args = [] ) {
    $defaults = [
        'id'      => 0,
        'max_kb'  => 1024,
        'sanitize'=> true,
    ];
    $args = wp_parse_args($args, $defaults);

    $att_id = intval($args['id']);
    if (!$att_id) {
        return '';
    }

    $mime = get_post_mime_type($att_id);
    if ($mime !== 'image/svg+xml') {
        return '';
    }

    $path = get_attached_file($att_id);
    if (!$path || !file_exists($path) || !is_readable($path)) {
        return '';
    }

    $size_kb = ceil(filesize($path) / 1024);
    if ($size_kb > $args['max_kb']) {
        return '';
    }

    $svg = file_get_contents($path);
    if ($svg === false || $svg === '') {
        return '';
    }

    // 任意のサニタイズ
    if ($args['sanitize'] && class_exists('\\enshrined\\svgSanitize\\Sanitizer')) {
        $sanitizer = new \enshrined\svgSanitize\Sanitizer();
        $clean = $sanitizer->sanitize($svg);
        if ($clean) $svg = $clean;
    }

    return $svg;
}


/* -------------------------------------------------------------------------- */
/* Allow SVG uploads site-wide */
/* -------------------------------------------------------------------------- */
function allow_svg_uploads( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'allow_svg_uploads' );


// dist/.vite/manifest.json から "file" を拾って <link rel="preload"> を出す
add_action('wp_head', function () {
  if (!defined('WP_ENVIRONMENT_TYPE') || WP_ENVIRONMENT_TYPE !== 'production') return;

  $theme_dir = get_stylesheet_directory();
  $manifest_path = $theme_dir . '/dist/.vite/manifest.json';
  if (!file_exists($manifest_path)) return;

  $man = json_decode(file_get_contents($manifest_path), true);
  if (!is_array($man)) return;

  $want = [
    'src/main.ts',
  ];

  $base = get_stylesheet_directory_uri() . '/dist/';
  foreach ($want as $key) {
    if (!empty($man[$key]['file'])) {
      $href = $base . ltrim($man[$key]['file'], '/');
      echo '<link rel="preload" as="script" href="' . esc_url($href) . '">' . "\n";
    }
    if (!empty($man[$key]['css']) && is_array($man[$key]['css'])) {
      foreach ($man[$key]['css'] as $css) {
        echo '<link rel="preload" as="style" href="' . esc_url($base . ltrim($css, '/')) . '">' . "\n";
      }
    }
  }
}, 20);

/* -------------------------------------------------------------------------- */
/* 画像の遅延読み込みとデコード最適化（フィルタで既定付与） */
/* -------------------------------------------------------------------------- */
add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment, $size) {
  if (empty($attr['loading']))
    $attr['loading'] = 'lazy';
  if (empty($attr['decoding']))
    $attr['decoding'] = 'async';
  return $attr;
}, 10, 3);

/* -------------------------------------------------------------------------- */
/* ローカルフォントの preload（存在すれば） */
/* -------------------------------------------------------------------------- */
add_action('wp_head', function () {
  $theme_dir = get_template_directory();
  $theme_uri = get_template_directory_uri();
  $candidates = [
    [$theme_dir . '/dist/fonts', $theme_uri . '/dist/fonts'],
    [$theme_dir . '/public/fonts', $theme_uri . '/public/fonts'],
  ];
  foreach ($candidates as [$dir, $base]) {
    if (!is_dir($dir)) continue;
    $files = @scandir($dir);
    if (!$files) continue;
    foreach ($files as $f) {
      if ($f === '.' || $f === '..') continue;
      $path = "$dir/$f";
      if (!is_file($path)) continue;
      $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
      $type = '';
      if ($ext === 'woff2') $type = 'font/woff2';
      elseif ($ext === 'woff') $type = 'font/woff';
      elseif ($ext === 'ttf') $type = 'font/ttf';
      else continue;
      $href = $base . '/' . rawurlencode($f);
      echo '<link rel="preload" as="font" href="' . esc_url($href) . '" type="' . esc_attr($type) . '" crossorigin>' . "\n";
    }
    // 最初に見つかった場所のみで十分
    break;
  }
}, 9);

/* -------------------------------------------------------------------------- */
/* 外部リンクアイコンのドメインフィルタ（自サイトはアイコンを外す） */
/* -------------------------------------------------------------------------- */
add_action('wp_head', function () {
  $home = home_url('/');
  $host = parse_url($home, PHP_URL_HOST);
  if (!$host) return;
  $host_www = (stripos($host, 'www.') === 0) ? substr($host, 4) : ('www.' . $host);
  ?>
  <style>
  /* 自サイトへの絶対URL（https://example.com/... と https://www.example.com/...）には外部アイコンを付けない */
  :where(.entry-content, .page-content, .main-content)
    a[href^="https://"][href*="//<?php echo esc_js($host); ?>"]::after,
  :where(.entry-content, .page-content, .main-content)
    a[href^="https://"][href*="//<?php echo esc_js($host_www); ?>"]::after{
      content: none !important;
  }
  </style>
  <?php
}, 11);

/* -------------------------------------------------------------------------- */
/* Front Page Hero: 背景画像のCSS変数を動的に設定 */
/* -------------------------------------------------------------------------- */
add_action('wp_head', function () {
  if (!is_front_page()) return;

  $theme_uri = get_template_directory_uri();
  $light_hero = $theme_uri . '/src/assets/images/hero/light-hero4.png';
  $dark_hero = $theme_uri . '/src/assets/images/hero/dark-hero3.png';
  ?>
  <style id="cielos-hero-images">
  :root {
    --hero-bg-image: url('<?php echo esc_url($light_hero); ?>');
  }
  html.dark :root,
  html.dark {
    --hero-bg-image: url('<?php echo esc_url($dark_hero); ?>');
  }
  </style>
  <?php
}, 12);


// manifestからエントリのJS + ひも付くCSSをまとめてenqueue
// === Vite 自動ローダー（DevならHMR、無ければmanifestでJS+CSSをenqueue） ===
// === 超シンプル Vite ローダー（DevはHMR、ProdはmanifestからJS+CSS） ===
add_action('wp_enqueue_scripts', function () {
  // ← ここに必要なエントリキーを列挙（manifest のキー名）
  // Note: block editor scripts are handled by cielos-block.php (editor context only)
  $entries = ['src/main.ts'];

  // --- Dev(HMR)検出（起動してるなら CSS <link> は出ません／HMRが挿入します） ---
  $hmr = @fsockopen('127.0.0.1', 5173, $e, $s, 0.15);
  if ($hmr) {
    fclose($hmr);
    wp_enqueue_script('vite-client', 'http://127.0.0.1:5173/@vite/client', [], null, false);
    add_filter('script_loader_tag', function($tag,$h){
      return $h==='vite-client' ? str_replace('<script ', '<script type="module" ', $tag) : $tag;
    },10,2);
    foreach ($entries as $key) {
      $h = 'vite-entry-'.md5($key);
      wp_enqueue_script($h, 'http://127.0.0.1:5173/'.$key, [], null, false);
      add_filter('script_loader_tag', function($tag,$hh) use($h){
        return $hh===$h ? str_replace('<script ', '<script type="module" ', $tag) : $tag;
      },10,2);
    }
    return;
  }

  // --- Prod: manifest から解決（JS + CSS） ---
  $child_path  = get_stylesheet_directory() . '/dist/.vite/manifest.json';
  $parent_path = get_template_directory()   . '/dist/.vite/manifest.json';
  $use_child   = file_exists($child_path);
  $manifest_path = $use_child ? $child_path : (file_exists($parent_path) ? $parent_path : '');

  if (!$manifest_path) { return; }

  $man = json_decode(file_get_contents($manifest_path), true);
  if (!is_array($man)) { return; }

  // ★ base は素直に /dist/ 直下を指す（パス組み立ての迷子を防止）
  $base = ($use_child ? get_stylesheet_directory_uri() : get_template_directory_uri()) . '/dist/';

  foreach ($entries as $key) {
    if (empty($man[$key])) { continue; }
    $entry = $man[$key];

    // JS
    if (!empty($entry['file'])) {
      $js = $base . ltrim($entry['file'], '/');
      $h  = 'vite-entry-'.md5($key);
      wp_enqueue_script($h, $js, [], null, true);
      add_filter('script_loader_tag', function($tag,$hh) use($h){
        return $hh===$h ? str_replace('<script ', '<script type="module" ', $tag) : $tag;
      },10,2);
    }

    // CSS（エントリー直接）
    if (!empty($entry['css']) && is_array($entry['css'])) {
      foreach ($entry['css'] as $i => $css) {
        $href = $base . ltrim($css, '/');
        wp_enqueue_style('vite-style-'.md5($key).'-'.$i, $href, [], null);
      }
    }

    // CSS（imports 経由のチャンクから）
    if (!empty($entry['imports']) && is_array($entry['imports'])) {
      foreach ($entry['imports'] as $importKey) {
        if (!empty($man[$importKey]['css']) && is_array($man[$importKey]['css'])) {
          foreach ($man[$importKey]['css'] as $i => $css) {
            $href = $base . ltrim($css, '/');
            $handle = 'vite-import-css-'.md5($importKey).'-'.$i;
            // 重複登録を避ける
            if (!wp_style_is($handle, 'enqueued') && !wp_style_is($handle, 'registered')) {
              wp_enqueue_style($handle, $href, [], null);
              // error_log('[VITE] Import CSS '.$importKey.' => '.$href);
            }
          }
        }
      }
    }
  }
}, 20);

// 新ローダーが enqueue した後で走らせる（優先度を少し遅らせる）
add_action('wp_enqueue_scripts', function () {
  $handle = 'vite-entry-'.md5('src/main.ts');

  if (!wp_script_is($handle, 'enqueued') && !wp_script_is($handle, 'registered')) {
    // 念のため安全確認（まだ読み込まれていないなら何もしない）
    return;
  }

  global $wp_query;

  wp_localize_script($handle, 'cielosPagination', array(
    'currentPage' => max(1, get_query_var('paged')),
    'totalPages'  => max(0, intval($wp_query->max_num_pages) - 1),
    'base'        => get_permalink(get_option('page_for_posts')) . user_trailingslashit('page/%#%/', 'paged'),
  ));

  // Comment pagination data (single posts/pages only)
  if (is_singular() && (comments_open() || get_comments_number())) {
    $comment_pages = get_comment_pages_count();
    if ($comment_pages > 1) {
      wp_localize_script($handle, 'cielosCommentPagination', array(
        'currentPage' => get_query_var('cpage') ? intval(get_query_var('cpage')) : 1,
        'totalPages'  => $comment_pages,
        'links'       => paginate_comments_links(array('type' => 'array', 'echo' => false)),
      ));
    }
  }

}, 30);

add_action('wp_enqueue_scripts', function () {
  wp_dequeue_script('mountSvgImages');
  wp_deregister_script('mountSvgImages');

}, 100);

// 安全なファイル直読み（大きすぎるのも拒否）
if (!function_exists('cielos_get_raw_svg')) {
  function cielos_get_raw_svg(int $att_id, int $max_kb = 1536) {
    $file = get_attached_file($att_id);
    if (!$file || !file_exists($file)) {
      return new WP_Error('svg_file_missing', 'SVG file not found.');
    }
    if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'svg') {
      return new WP_Error('not_svg', 'Attachment is not an SVG.');
    }
    if (filesize($file) > $max_kb * 1024) {
      return new WP_Error('svg_too_large', 'SVG too large.');
    }
    $svg = file_get_contents($file);
    if ($svg === false || trim($svg) === '') {
      return new WP_Error('svg_empty', 'SVG is empty.');
    }
    // 先頭BOMなどを除去（フロントでも保険を入れているが一応）
    $svg = preg_replace('/^\xEF\xBB\xBF/u', '', $svg);
    return $svg;
  }
}

// 生SVGを返すREST
add_action('rest_api_init', function () {
  register_rest_route('cielos/v1', '/svg-raw/(?P<id>\d+)', [
    'methods'  => 'GET',
    'callback' => function($req) {
      $id  = (int) $req['id'];
      $svg = cielos_get_raw_svg($id);

      if (is_wp_error($svg)) {
        return new WP_REST_Response(['error' => $svg->get_error_message()], 404);
      }
      return new WP_REST_Response($svg, 200, [
        'Content-Type'              => 'image/svg+xml; charset=UTF-8',
        'Cache-Control'             => 'public, max-age=31536000, immutable',
        'X-Content-Type-Options'    => 'nosniff',
      ]);
    },
    'permission_callback' => '__return_true',
  ]);
});

add_action('init', function () {
  add_shortcode('svg_raw', function($atts){
    $id = intval($atts['id'] ?? 0);
    $svg = cielos_get_raw_svg($id);
    if (is_wp_error($svg)) {
      return '<!-- svg_raw error: '.esc_html($svg->get_error_message()).' -->';
    }
    return $svg;
  });
});
// 404を起こすCSS URLを正しいURLへ置換（と同時に script→style に修正）: 超後段で実行
// プラグイン有効時だけこのCSSを止める（将来の再有効化に備えるならこちらもあり）
add_action('wp_enqueue_scripts', function () {
  if (wp_style_is('child-pages-shortcode-css', 'registered') || wp_style_is('child-pages-shortcode-css', 'enqueued')) {
    wp_dequeue_style('child-pages-shortcode-css');
    wp_deregister_style('child-pages-shortcode-css');
  }
}, PHP_INT_MAX);

// 古い/混入の jQuery をやめて jQuery 4.0 CDN に切替
add_action('wp_enqueue_scripts', function () {
  // もしテーマやプラグインが独自 jQuery を登録しているなら消す
  wp_deregister_script('jquery');
  wp_dequeue_script('jquery');

  // jQuery 4.0 CDN
  wp_register_script('jquery', 'https://code.jquery.com/jquery-4.0.0.min.js', [], '4.0.0', true);
  wp_enqueue_script('jquery');
}, 100);

/**
 * Vite manifest を読んで、エントリと依存(Imports)の JS/CSS を <head> に preload する
 * - JS: <link rel="modulepreload">（モダン） / 互換を重視するなら as="script" も追加可
 * - CSS: <link rel="preload" as="style">
 *
 * 使い方：
 * add_action('wp_head', function () {
 *   cielos_preload_vite(['src/main.ts', 'src/blocks/my-block-editor.ts']);
 * }, 8);
 */
function cielos_preload_vite(array $entries, bool $only_prod = true): void {
  if ($only_prod && (!defined('WP_ENVIRONMENT_TYPE') || WP_ENVIRONMENT_TYPE !== 'production')) {
    // Dev時は HMR が解決するので、preload は基本不要（必要なら false に）
    // Devにヒントを出したい場合は preconnect を投げておく
    echo '<link rel="preconnect" href="http://127.0.0.1:5173">' . "\n";
    return;
  }

  // 1) manifest の場所（子 → 親）
  $child = get_stylesheet_directory() . '/dist/.vite/manifest.json';
  $parent= get_template_directory()   . '/dist/.vite/manifest.json';
  $path  = file_exists($child) ? $child : (file_exists($parent) ? $parent : '');
  if (!$path) return;

  $man = json_decode(file_get_contents($path), true);
  if (!is_array($man)) return;

  $base = (file_exists($child) ? get_stylesheet_directory_uri() : get_template_directory_uri()) . '/dist/';

  // 2) 対象URLを重複なく収集
  $js  = []; // modulepreload 用
  $css = [];

  // imports を辿って依存も preload
  $push_entry = function($key) use (&$push_entry, $man, $base, &$js, &$css) {
    if (empty($man[$key])) return;
    $entry = $man[$key];

    // JS本体
    if (!empty($entry['file'])) {
      $href = $base . ltrim($entry['file'], '/');
      $js[$href] = true;
    }
    // CSS ひも付き
    if (!empty($entry['css']) && is_array($entry['css'])) {
      foreach ($entry['css'] as $c) {
        $href = $base . ltrim($c, '/');
        $css[$href] = true;
      }
    }
    // 依存（imports）は再帰で辿る
    if (!empty($entry['imports']) && is_array($entry['imports'])) {
      foreach ($entry['imports'] as $imp_key) {
        // import は manifest 内の別キー名。そこから file/css を取得
        if (!empty($man[$imp_key])) {
          $imp = $man[$imp_key];
          if (!empty($imp['file'])) {
            $href = $base . ltrim($imp['file'], '/');
            $js[$href] = true;
          }
          if (!empty($imp['css']) && is_array($imp['css'])) {
            foreach ($imp['css'] as $c2) {
              $href = $base . ltrim($c2, '/');
              $css[$href] = true;
            }
          }
          // さらにその imports も辿る（深い依存）
          if (!empty($imp['imports'])) {
            $push_entry($imp_key);
          }
        }
      }
    }
  };

  foreach ($entries as $ek) { $push_entry($ek); }

  // 3) 出力（重複排除済み）
  foreach (array_keys($js) as $href) {
    echo '<link rel="modulepreload" href="' . esc_url($href) . '">' . "\n";
    // 互換をより重視するなら次行を有効化（as="script" の preload を併用）
    // echo '<link rel="preload" as="script" href="' . esc_url($href) . '">' . "\n";
  }
  foreach (array_keys($css) as $href) {
    echo '<link rel="preload" as="style" href="' . esc_url($href) . '">' . "\n";
  }
}

// 本番だけ preload（開発時は preconnect のみ）
add_action('wp_head', function () {
  cielos_preload_vite([
    'src/main.ts',
  ]);
}, 8);

// 開発サーバへ preconnect（体感が少しスムーズ）
add_action('wp_head', function () {
  if (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'development') {
    echo '<link rel="preconnect" href="http://127.0.0.1:5173">' . "\n";
  }
}, 2);

/* -------------------------------------------------------------------------- */
/* Favicon bundle (theme-local files)                                         */
/* -------------------------------------------------------------------------- */
function cielos_output_favicons(): void {
  // Use WordPress Site Icon when configured in Customizer.
  if (function_exists('has_site_icon') && has_site_icon()) {
    return;
  }

  $base_uri = '/wp-content/themes/' . get_template() . '/public/favicons';
  $base_dir = trailingslashit(get_template_directory()) . 'public/favicons';
  $asset = static function (string $name) use ($base_uri, $base_dir): string {
    $path = $base_dir . '/' . $name;
    $ver = file_exists($path) ? (string)filemtime($path) : (string)time();
    return $base_uri . '/' . $name . '?v=' . rawurlencode($ver);
  };

  // Keep tab favicon deterministic: single URL only (avoid post-load swaps).
  $icon = esc_url($asset('favicon-32x32.png'));
  echo '<link rel="icon" type="image/png" sizes="32x32" href="' . $icon . '">' . "\n";
  echo '<meta name="theme-color" content="#0b1220">' . "\n";
}
add_action('wp_head', 'cielos_output_favicons', 1);

/* -------------------------------------------------------------------------- */
/* Child Pagesショートコードで大きな画像サイズを使用 */
/* -------------------------------------------------------------------------- */
add_action('init', function() {
    // プラグインのショートコードを削除
    remove_shortcode('child_pages');

    // カスタムショートコードを追加（デフォルトサイズを medium_large に変更）
    add_shortcode('child_pages', function($atts, $content = null) {
        // デフォルトサイズを medium_large に設定
        if (!isset($atts['size'])) {
            $atts['size'] = 'medium_large';
        }

        // 元のプラグインクラスのメソッドを呼び出す
        global $child_pages_shortcode;
        if (isset($child_pages_shortcode) && method_exists($child_pages_shortcode, 'shortcode')) {
            return $child_pages_shortcode->shortcode($atts, $content);
        }

        return '';
    });
}, 20); // プラグインの init より後に実行

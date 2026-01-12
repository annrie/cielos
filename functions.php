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
require_once 'library/widgets/toc.php';
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
/* Script tag tweaks（fontawesomeのみ。mainは上でtype/defer済み） */
/* -------------------------------------------------------------------------- */
// module を付けるのは “自分のESMだけ”。jQueryなどには付けない
add_filter('script_loader_tag', function ($tag, $handle) {
  $module_handles = ['cielos-main','cielos-theme-watcher']; // ←必要に応じて更新
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
        error_log('cielos_svg_image: no id');
        return '';
    }

    $mime = get_post_mime_type($att_id);
    if ($mime !== 'image/svg+xml') {
        error_log("cielos_svg_image: not svg (mime=$mime, id=$att_id)");
        return '';
    }

    $path = get_attached_file($att_id);
    if (!$path || !file_exists($path) || !is_readable($path)) {
        error_log("cielos_svg_image: file missing or not readable ($path)");
        return '';
    }

    $size_kb = ceil(filesize($path) / 1024);
    if ($size_kb > $args['max_kb']) {
        error_log("cielos_svg_image: svg too large ({$size_kb}KB)");
        return '';
    }

    $svg = file_get_contents($path);
    if ($svg === false || $svg === '') {
        error_log("cielos_svg_image: empty svg");
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

/**
 * Theme watcher (OS color-scheme follow)
 * dev:  http://localhost:5173/src/assets/js/theme-watcher.unomoon.js（type="module"）
 * prod: dist/.vite/manifest.json の "src/assets/js/theme-watcher.unomoon.js"
 * not found: 読み込まない（/src/直読みはしない）
 */
add_action('wp_enqueue_scripts', function () {
  $handle    = 'cielos-theme-watcher';

  // 二重登録防止
  if (wp_script_is($handle, 'enqueued') || wp_script_is($handle, 'registered')) return;

  // --- dev（Vite HMR） ---
  if (function_exists('cielos_is_vite_dev') && cielos_is_vite_dev()) {
    $src = 'http://localhost:5173/src/assets/js/theme-watcher.unomoon.js';
    wp_enqueue_script($handle, $src, [], null, true);
    if (function_exists('wp_script_add_data')) {
      wp_script_add_data($handle, 'type', 'module'); // devはESMとして読む
      wp_script_add_data($handle, 'defer', true);
    }
    return;
  }

  // --- prod（manifest 解決：子→親）---
  $theme_dir_child = get_stylesheet_directory();
  $theme_dir_parent = get_template_directory();
  $theme_uri_child = get_stylesheet_directory_uri();
  $theme_uri_parent = get_template_directory_uri();

  $manifest_paths = [
    [$theme_dir_child . '/dist/.vite/manifest.json', $theme_uri_child . '/dist/'],
    [$theme_dir_parent . '/dist/.vite/manifest.json', $theme_uri_parent . '/dist/'],
  ];

  $map = null;
  $base_uri = null;
  foreach ($manifest_paths as [$m, $u]) {
    if (file_exists($m)) {
      $tmp = json_decode(file_get_contents($m), true);
      if (is_array($tmp)) { $map = $tmp; $base_uri = $u; break; }
    }
  }
  if (!$map) return; // 見つからなければ読み込まない

  $entry_key = 'src/assets/js/theme-watcher.unomoon.js';
  if (empty($map[$entry_key]['file'])) {
    // 固定パスのフォールバック（ビルドで同名を出している場合のみ）
    $fallback = $base_uri . 'assets/js/theme-watcher.unomoon.js';
    // 存在確認が難しいので、ここでは無理に出さず return
    return;
  }

  $src = $base_uri . ltrim($map[$entry_key]['file'], '/');
  wp_enqueue_script($handle, $src, [], null, true);

  // ビルド結果が ESM なら type="module" を、IIFE なら不要。
  // どちらか不明なら defer のみ付与（import/export を使っているなら module を追加）
  if (function_exists('wp_script_add_data')) {
    wp_script_add_data($handle, 'defer', true);
    // 必要なら↓を有効化（ビルドがESMの場合）
    // wp_script_add_data($handle, 'type', 'module');
  }
}, 20);

// dist/.vite/manifest.json から "file" を拾って <link rel="preload"> を出す
add_action('wp_head', function () {
  if (!defined('WP_ENVIRONMENT_TYPE') || WP_ENVIRONMENT_TYPE !== 'production') return;

  $theme_dir = get_stylesheet_directory();
  $manifest_path = $theme_dir . '/dist/.vite/manifest.json';
  if (!file_exists($manifest_path)) return;

  $man = json_decode(file_get_contents($manifest_path), true);
  if (!is_array($man)) return;

  $want = [
    'src/main.ts',        // ←エントリキー（必要に応じて追加）
    // 'src/js/theme-watcher.unomoon.js',
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
/* Single machaki: ヒーローに primary-book の画像をフェードインで重ねる（クローン） */
/* -------------------------------------------------------------------------- */
add_action('wp_footer', function () {
  if (!is_singular('machaki')) return;
  global $post;
  // PHPから直接画像URLを取得（loading="lazy" の影響を回避）
  $book_img_id = get_post_meta($post->ID, 'fm_img_1', true);
  if (empty($book_img_id)) return;
  $book_img = wp_get_attachment_image_src($book_img_id, 'medium_large');
  if (empty($book_img[0])) return;
  $book_img_url = esc_url($book_img[0]);
  $book_img_alt = esc_attr(get_the_title());
  ?>
  <script>
  (function(){
    try{
      var hero = document.querySelector('.hero-feature');
      if (!hero) return;
      // 既に配置済みなら二重作成しない
      if (hero.querySelector('.machaki-hero-book')) return;

      var wrap = document.createElement('div');
      wrap.className = 'machaki-hero-book';
      var img = document.createElement('img');
      img.src = <?php echo json_encode($book_img_url); ?>;
      img.alt = <?php echo json_encode($book_img_alt); ?>;
      wrap.appendChild(img);
      hero.appendChild(wrap);

      // 中央配置（高さに基づく計算）
      var retryCount = 0;
      function place() {
        if (!hero || !wrap || !img) return;
        var hh = hero.getBoundingClientRect().height || 0;
        var ih = img.getBoundingClientRect().height || 0;
        // 画像高さが小さすぎる場合はリトライ（最大15回）
        if (!hh || !ih || (ih < 50 && retryCount < 15)) {
          retryCount++;
          requestAnimationFrame(place);
          return;
        }
        wrap.style.position = 'absolute';
        wrap.style.left = '50%';
        wrap.style.transform = 'translateX(-50%)';
        wrap.style.top = Math.max(0, (hh - ih) / 2 + 10) + 'px';
      }
      function ready(){ place(); wrap.classList.add('is-ready'); }
      if (img.complete && img.naturalHeight > 0) {
        requestAnimationFrame(ready);
      } else {
        img.addEventListener('load', function(){ requestAnimationFrame(ready); }, { once: true });
      }
      window.addEventListener('resize', function(){ requestAnimationFrame(place); });
    }catch(e){ /* noop */ }
  })();
  </script>
  <?php
}, 100);

/* -------------------------------------------------------------------------- */
/* Body class: MW WP Form を含むページに識別子を付与（has-mwform） */
/* -------------------------------------------------------------------------- */
add_filter('body_class', function (array $classes) {
  if (is_page()) {
    $post = get_post();
    $content = $post && isset($post->post_content) ? (string)$post->post_content : '';
    // MW WP Form のショートコードが含まれるかを緩めに検出
    if ($content && (strpos($content, '[mwform_') !== false || strpos($content, '[mwform') !== false)) {
      $classes[] = 'has-mwform';
    }
  }
  return $classes;
});

// どのキーが manifest にあり、何を enqueue したかをログに出すデバッガ
add_action('wp_enqueue_scripts', function () {
  if (!defined('WP_ENVIRONMENT_TYPE') || WP_ENVIRONMENT_TYPE !== 'production') return;

  $manifest_path_child = get_stylesheet_directory() . '/dist/.vite/manifest.json';
  $manifest_path_parent = get_template_directory() . '/dist/.vite/manifest.json';

  $path = file_exists($manifest_path_child) ? $manifest_path_child : (file_exists($manifest_path_parent) ? $manifest_path_parent : '');
  if (!$path) { error_log('[VITE] manifest not found'); return; }

  $man = json_decode(file_get_contents($path), true);
  if (!is_array($man)) { error_log('[VITE] manifest broken'); return; }

  // まず全キーを出力（どんな key があるか把握）
  $keys = implode(', ', array_keys($man));
  error_log('[VITE] keys: ' . $keys);

  $entry = 'src/main.ts'; // ←あなたのエントリ
  if (empty($man[$entry])) { error_log("[VITE] missing entry: $entry"); return; }

  $base = trailingslashit(dirname(str_replace(ABSPATH, site_url('/'), $path))) . '../';

  // JS
  if (!empty($man[$entry]['file'])) {
    $js = $base . ltrim($man[$entry]['file'], '/');
    error_log('[VITE] enqueue JS: ' . $js);
    wp_enqueue_script('cielos-'.$entry, $js, [], null, true);
    add_filter('script_loader_tag', function($tag,$h) use($entry){
      return $h === 'cielos-'.$entry ? str_replace('<script ', '<script type="module" ', $tag) : $tag;
    }, 10, 2);
  }

  // CSS
  if (!empty($man[$entry]['css']) && is_array($man[$entry]['css'])) {
    foreach ($man[$entry]['css'] as $i => $css) {
      $href = $base . ltrim($css, '/');
      error_log('[VITE] enqueue CSS: ' . $href);
      wp_enqueue_style('cielos-'.$entry.'-css-'.$i, $href, [], null);
    }
  } else {
    error_log('[VITE] no css array for entry (UnoCSS未取込 or import漏れの可能性)');
  }
}, 19);

// manifestからエントリのJS + ひも付くCSSをまとめてenqueue
// === Vite 自動ローダー（DevならHMR、無ければmanifestでJS+CSSをenqueue） ===
// === 超シンプル Vite ローダー（DevはHMR、ProdはmanifestからJS+CSS） ===
add_action('wp_enqueue_scripts', function () {
  // ← ここに必要なエントリキーを列挙（manifest のキー名）
  $entries = ['src/main.ts', 'src/blocks/my-block-editor.ts', 'src/assets/js/theme-watcher.unomoon.js']; // 例: 他にあれば 'src/blocks/my-block-editor.ts' などを追加

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

  if (!$manifest_path) { error_log('[VITE] manifest not found'); return; }

  $man = json_decode(file_get_contents($manifest_path), true);
  if (!is_array($man)) { error_log('[VITE] manifest decode fail'); return; }

  // ★ base は素直に /dist/ 直下を指す（パス組み立ての迷子を防止）
  $base = ($use_child ? get_stylesheet_directory_uri() : get_template_directory_uri()) . '/dist/';

  foreach ($entries as $key) {
    if (empty($man[$key])) { error_log("[VITE] missing entry: $key"); continue; }
    $entry = $man[$key];

    // JS
    if (!empty($entry['file'])) {
      $js = $base . ltrim($entry['file'], '/');
      $h  = 'vite-entry-'.md5($key);
      wp_enqueue_script($h, $js, [], null, true);
      add_filter('script_loader_tag', function($tag,$hh) use($h){
        return $hh===$h ? str_replace('<script ', '<script type="module" ', $tag) : $tag;
      },10,2);
      error_log('[VITE] JS '.$key.' => '.$js);
    } else {
      error_log("[VITE] no JS file for $key");
    }

    // CSS（エントリー直接）
    if (!empty($entry['css']) && is_array($entry['css'])) {
      foreach ($entry['css'] as $i => $css) {
        $href = $base . ltrim($css, '/');
        wp_enqueue_style('vite-style-'.md5($key).'-'.$i, $href, [], null);
       // error_log('[VITE] CSS '.$key.' => '.$href); // 必要なら残す
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

  wp_localize_script($handle, 'unomoonPagination', array(
    'currentPage' => max(1, get_query_var('paged')),
    'totalPages'  => max(0, intval($wp_query->max_num_pages) - 1),
    'base'        => get_permalink(get_option('page_for_posts')) . user_trailingslashit('page/%#%/', 'paged'),
  ));

  // Comment pagination data (single posts/pages only)
  if (is_singular() && (comments_open() || get_comments_number())) {
    $comment_pages = get_comment_pages_count();
    if ($comment_pages > 1) {
      wp_localize_script($handle, 'unomoonCommentPagination', array(
        'currentPage' => get_query_var('cpage') ? intval(get_query_var('cpage')) : 1,
        'totalPages'  => $comment_pages,
        'links'       => paginate_comments_links(array('type' => 'array', 'echo' => false)),
      ));
    }
  }

    /* --- Third-party scripts（必要なら継続） --- */
    wp_enqueue_script(
        'fontawesome',
        'https://kit.fontawesome.com/9d5f8281c5.js',
        [],
        '6',
        true
    );
    wp_enqueue_script(
        'googlemapapi',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyC1ok--EfDe-1tYrqFco5G9G6CRaIzKU',
        [],
        null,
        true
    );
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
  register_rest_route('unomoon/v1', '/svg-raw/(?P<id>\d+)', [
    'methods'  => 'GET',
    'callback' => function($req) {
      $id  = (int) $req['id'];
      $svg = cielos_get_raw_svg($id);

      // ログで実体確認
      if (is_string($svg)) {
        error_log('[svg-raw] id='.$id.' bytes='.strlen($svg).' head='.substr(trim($svg),0,20));
      } else {
        error_log('[svg-raw] id='.$id.' error='. (is_wp_error($svg)?$svg->get_error_message():'unknown'));
      }

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
      error_log('svg_raw: '.$svg->get_error_message());
      return '<!-- svg_raw error: '.esc_html($svg->get_error_message()).' -->';
    }
    return $svg;
  });
});
// /wp-json/unomoon/v1/svg-raw/{id} で生SVGを返す
add_action('rest_api_init', function () {
  register_rest_route('unomoon/v1', '/svg-raw/(?P<id>\d+)', [
    'methods'  => 'GET',
    'callback' => function($req) {
      $id  = (int) $req['id'];
      $svg = cielos_get_raw_svg($id); // ここで addslashes/esc_attr しない
      if (is_wp_error($svg)) {
        return new WP_REST_Response(['error' => $svg->get_error_message()], 404);
      }
      return new WP_REST_Response($svg, 200, ['Content-Type' => 'image/svg+xml; charset=UTF-8']);
    },
    'permission_callback' => '__return_true',
  ]);
});

// （任意）すでに fontawesome 用の script_loader_tag を入れているならそれでOK。
// theme-watcher は上で defer/type を付けるので loader_tag 側の特別処理は不要です。

// 404を起こすCSS URLを正しいURLへ置換（と同時に script→style に修正）: 超後段で実行
// プラグイン有効時だけこのCSSを止める（将来の再有効化に備えるならこちらもあり）
add_action('wp_enqueue_scripts', function () {
  if (wp_style_is('child-pages-shortcode-css', 'registered') || wp_style_is('child-pages-shortcode-css', 'enqueued')) {
    wp_dequeue_style('child-pages-shortcode-css');
    wp_deregister_style('child-pages-shortcode-css');
  }
}, PHP_INT_MAX);

// 古い/混入の jQuery をやめて WP同梱 or CDN に切替
add_action('wp_enqueue_scripts', function () {
  // もしテーマやプラグインが独自 jQuery を登録しているなら消す
  wp_deregister_script('jquery');
  wp_dequeue_script('jquery');

  // A) WP 同梱の jQuery（無難）
  wp_enqueue_script('jquery');

  // B) もしくは最新版 3.7.1 を使うなら（どちらか片方だけ）
//   wp_enqueue_script('jquery-cdn', 'https://code.jquery.com/jquery-3.7.1.min.js', [], '3.7.1', true);
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
    // 'src/blocks/my-block-editor.ts',
    // 'src/assets/js/theme-watcher.unomoon.js',
  ]);
}, 8);

// 開発サーバへ preconnect（体感が少しスムーズ）
add_action('wp_head', function () {
  if (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'development') {
    echo '<link rel="preconnect" href="http://127.0.0.1:5173">' . "\n";
  }
}, 2);

// === Theme toggle UI（System / Light / Dark を保存・適用）===
// - クリック: system → light → dark を巡回
// - 右クリック: 即 system
// - 保存先: localStorage 'unomoon:theme'（旧 'theme' から移行）
// DISABLED: nav-enforcer-v5.js が統合制御するため無効化
/*
add_action('wp_enqueue_scripts', function () {
    $toggle_handle = 'cielos-theme-toggle';

    // watcher が存在すれば依存させて「後」に実行。無ければ単独で動く（フォールバック内蔵）。
    $deps = [];
    if (wp_script_is('cielos-theme-watcher', 'enqueued') || wp_script_is('cielos-theme-watcher', 'registered')) {
        $deps[] = 'cielos-theme-watcher';
    }

    // 本体は“空スクリプト”だが、依存関係で順序制御する
    wp_register_script($toggle_handle, '', $deps, null, true); // in footer

    $js = <<<'JS'
(function () {
  var btn = document.getElementById('theme-toggle-desktop');
  if (!btn) return;

  var KEY = 'unomoon:theme';
  var mql = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)')) || null;

  // 旧キー 'theme' → 'unomoon:theme' に移行
  try {
    var legacy = localStorage.getItem('theme');
    if (legacy === 'light' || legacy === 'dark' || legacy === 'system') {
      localStorage.setItem(KEY, legacy);
      localStorage.removeItem('theme');
    }
  } catch (e) {}

  function get() {
    try {
      var v = localStorage.getItem(KEY);
      return (v === 'light' || v === 'dark' || v === 'system') ? v : 'system';
    } catch (e) { return 'system'; }
  }
  function set(mode) {
    try { localStorage.setItem(KEY, mode); } catch (e) {}
    apply(mode);
    updateUI(mode);
  }

  // watcher が window に公開していない前提で“自前適用”を持つ（watcher が居ても両立可）
  var bound = false;
  function bindMql() {
    if (bound || !mql) return; bound = true;
    var handler = function (e) {
      if (get() === 'system') {
        document.documentElement.classList.toggle('dark', !!e.matches);
      }
    };
    if (mql.addEventListener) mql.addEventListener('change', handler);
    else if (mql.addListener) mql.addListener(handler); // Safari 旧
  }
  function apply(mode) {
    var root = document.documentElement;
    if (mode === 'system') {
      var isDark = mql ? mql.matches : false;
      root.classList.toggle('dark', !!isDark);
      bindMql(); // OS変更に追従
    } else {
      root.classList.toggle('dark', mode === 'dark');
    }
  }

  function cycle(mode) {
    var order = ['system', 'light', 'dark'];
    var i = order.indexOf(mode);
    return order[(i + 1) % order.length];
  }
  function label(mode) {
    return mode === 'system' ? 'System (OSに追従)' : (mode === 'dark' ? 'Dark' : 'Light');
  }
  function updateUI(mode) {
    btn.dataset.mode = mode;
    btn.setAttribute('aria-label', 'Theme: ' +  label(mode));
    btn.title = 'Theme: ' + label(mode) + '（クリックで切替／右クリックでSystem）';
  } function updateUI(mode) {
    btn.dataset.mode = mode;
    btn.setAttribute('aria-label', 'Theme: ' + label(mode));
    btn.title = 'Theme: ' + label(mode) + '（クリックで切替／右クリックでSystem）';
  }

  // イベント
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    set(cycle(get()));
  });
  btn.addEventListener('contextmenu', function (e) {
    e.preventDefault();
    set('system');
  });

  // 初期反映
  var mode = get();
  apply(mode);
  updateUI(mode);
})();
JS;

    // 空ハンドルにインラインJSを付けて実行
    wp_add_inline_script($toggle_handle, $js);
    wp_enqueue_script($toggle_handle);
}, 100);
*/

add_action('wp_enqueue_scripts', function () {
  // あなたのテーマのパスに合わせて
//  wp_enqueue_style( 'mobile-nav', get_template_directory_uri().'/assets/css/mobile-nav.css', [], null );

  // DISABLED: nav-enforcer-v5.js が統合制御するため個別スクリプトは無効化
  // wp_enqueue_script('mobile-nav', get_template_directory_uri().'/assets/js/mobile-nav.js', [], null, true);
  // wp_enqueue_script('theme-toggle', get_template_directory_uri().'/assets/js/theme-toggle.js', [], null, true);
});

/* -------------------------------------------------------------------------- */
/* サイドバーウィジェットの投稿タイトルにアイコンを追加（JavaScript使用） */
/* -------------------------------------------------------------------------- */

/* sidebar-icons.js, lang-tabs.js は src/assets/js/ に移動し、
   main.ts から import して Vite 経由でビルドされるため、
   ここでのエンキューは不要 */

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

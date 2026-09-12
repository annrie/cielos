<?php
/**
 * meta description / canonical / OGP / Twitter Card の出力
 *
 * SEO プラグインを入れていないため、テーマ側で最低限を出す。
 * 他のプラグインが同じものを出し始めたら二重になるので、
 * cielos_seo_meta_should_output() で抑止できるようにしてある。
 *
 * @package Cielos
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 出力してよいか。
 * Yoast / All in One SEO / SEO SIMPLE PACK などが有効なら、そちらに任せる。
 */
function cielos_seo_meta_should_output(): bool {
    $conflicts = array(
        'WPSEO_VERSION',          // Yoast SEO
        'AIOSEO_VERSION',         // All in One SEO
        'SEOPRESS_VERSION',       // SEOPress
        'RANK_MATH_VERSION',      // Rank Math
    );
    foreach ( $conflicts as $c ) {
        if ( defined( $c ) ) {
            return false;
        }
    }
    if ( class_exists( 'SEO_SIMPLE_PACK' ) ) {
        return false;
    }
    return (bool) apply_filters( 'cielos_seo_meta_enabled', true );
}

/**
 * 現在のページの説明文を返す。
 *
 * 記事・固定ページ: 抜粋 → 無ければ本文の先頭
 * アーカイブ: タクソノミーの説明 → 無ければ「〜の記事一覧」
 * それ以外: サイトのキャッチフレーズ
 */
function cielos_seo_description(): string {
    $desc = '';

    if ( is_singular() ) {
        $post = get_queried_object();
        if ( $post instanceof WP_Post ) {
            $desc = $post->post_excerpt;
            if ( '' === $desc ) {
                // ブロックのコメントとタグを落としてから切り出す
                $content = strip_shortcodes( $post->post_content );
                $content = preg_replace( '/<!--.*?-->/s', '', $content );
                $desc    = wp_strip_all_tags( $content );
            }
        }
    } elseif ( is_category() || is_tag() || is_tax() ) {
        $term = get_queried_object();
        if ( $term instanceof WP_Term ) {
            $desc = $term->description;
            if ( '' === $desc ) {
                /* translators: %s: タクソノミーの名前 */
                $desc = sprintf( __( '%sに関する記事の一覧です。', 'cielos' ), $term->name );
            }
        }
    } elseif ( is_home() && ! is_front_page() ) {
        $page_for_posts = (int) get_option( 'page_for_posts' );
        if ( $page_for_posts ) {
            $desc = get_post_field( 'post_excerpt', $page_for_posts );
        }
    }

    if ( '' === trim( (string) $desc ) ) {
        $desc = get_bloginfo( 'description' );
    }

    // 全角120字で切る。検索結果のスニペットに収まる長さ
    $desc = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $desc ) ) );
    if ( mb_strlen( $desc ) > 120 ) {
        $desc = mb_substr( $desc, 0, 119 ) . '…';
    }

    return $desc;
}

/**
 * og:image に使う URL を返す。
 * アイキャッチがあればそれ、無ければ共有用の既定画像。
 */
function cielos_seo_image(): string {
    if ( is_singular() && has_post_thumbnail() ) {
        $url = get_the_post_thumbnail_url( null, 'full' );
        if ( $url ) {
            return $url;
        }
    }
    return get_template_directory_uri() . '/public/images/og-default.png';
}

/**
 * 現在のページの正規URLを返す。
 */
function cielos_seo_canonical(): string {
    if ( is_front_page() ) {
        return home_url( '/' );
    }
    if ( is_singular() ) {
        return (string) get_permalink();
    }
    if ( is_category() || is_tag() || is_tax() ) {
        $link = get_term_link( get_queried_object() );
        return is_wp_error( $link ) ? home_url( '/' ) : (string) $link;
    }
    if ( is_home() ) {
        $page_for_posts = (int) get_option( 'page_for_posts' );
        if ( $page_for_posts ) {
            return (string) get_permalink( $page_for_posts );
        }
    }
    if ( is_search() ) {
        return (string) get_search_link();
    }
    return home_url( add_query_arg( array() ) );
}

/**
 * head に出力する。
 */
function cielos_seo_meta_output(): void {
    if ( ! cielos_seo_meta_should_output() ) {
        return;
    }
    // 検索結果や404は正規URLを持たせない
    if ( is_404() ) {
        return;
    }

    $desc      = cielos_seo_description();
    $canonical = cielos_seo_canonical();
    $image     = cielos_seo_image();
    $site_name = get_bloginfo( 'name' );

    // og:title はページの見出し。サイト名は og:site_name で別に出す
    if ( is_front_page() ) {
        $title = $site_name;
    } elseif ( is_singular() ) {
        $title = get_the_title();
    } elseif ( is_category() || is_tag() || is_tax() ) {
        $title = single_term_title( '', false );
    } elseif ( is_home() ) {
        $page_for_posts = (int) get_option( 'page_for_posts' );
        $title          = $page_for_posts ? get_the_title( $page_for_posts ) : $site_name;
    } else {
        $title = wp_get_document_title();
    }

    $type = is_singular( 'post' ) ? 'article' : 'website';

    echo "\n<!-- cielos SEO meta -->\n";
    printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
    printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );

    printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $type ) );
    printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
    printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
    printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $canonical ) );
    printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( $site_name ) );
    printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
    printf( '<meta property="og:image:width" content="1200">' . "\n" );
    printf( '<meta property="og:image:height" content="630">' . "\n" );
    printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( get_locale() ) );

    if ( 'article' === $type ) {
        printf( '<meta property="article:published_time" content="%s">' . "\n", esc_attr( get_the_date( 'c' ) ) );
        printf( '<meta property="article:modified_time" content="%s">' . "\n", esc_attr( get_the_modified_date( 'c' ) ) );
        foreach ( get_the_category() as $cat ) {
            printf( '<meta property="article:section" content="%s">' . "\n", esc_attr( $cat->name ) );
        }
        $tags = get_the_tags();
        if ( $tags ) {
            foreach ( $tags as $tag ) {
                printf( '<meta property="article:tag" content="%s">' . "\n", esc_attr( $tag->name ) );
            }
        }
    }

    printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
    printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
    printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
    printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image ) );
    echo "<!-- /cielos SEO meta -->\n\n";
}
add_action( 'wp_head', 'cielos_seo_meta_output', 2 );

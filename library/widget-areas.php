<?php
/**
 * Widget Areas Registration
 * Cocoon-style comprehensive widget areas for Cielos theme
 *
 * @package Cielos
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

// ウィジェット名プレフィックス
define('CIELOS_WIDGET_PREFIX', '[C] ');

/**
 * 共通のウィジェットラッパー設定を取得
 */
function cielos_get_widget_defaults($type = 'default') {
    $defaults = array(
        'before_widget' => '<div id="%1$s" class="widget cielos-widget %2$s mb-6 p-4 bg-[var(--c-panel)] rounded-lg border border-[var(--c-border)]">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-lg font-bold mb-4 pb-2 border-b-2 border-[var(--c-primary)] text-[var(--c-fg)]">',
        'after_title'   => '</h3>',
    );

    // コンテンツエリア用（パネル背景なし）
    if ($type === 'content') {
        $defaults['before_widget'] = '<div id="%1$s" class="widget cielos-widget cielos-widget-content %2$s mb-6">';
    }

    // フッター用
    if ($type === 'footer') {
        $defaults['before_widget'] = '<div id="%1$s" class="widget cielos-widget cielos-widget-footer %2$s mb-4">';
        $defaults['before_title']  = '<h3 class="widget-title text-base font-bold mb-3 text-[var(--c-fg-inv)]">';
    }

    return $defaults;
}

if (! function_exists('cielos_register_widget_areas')) :
/**
 * Register all widget areas
 */
function cielos_register_widget_areas()
{
    $default = cielos_get_widget_defaults();
    $content = cielos_get_widget_defaults('content');
    $footer  = cielos_get_widget_defaults('footer');

    // =========================================================================
    // サイドバー
    // =========================================================================

    register_sidebar(array_merge($default, array(
        'id'          => 'sidebar',
        'name'        => CIELOS_WIDGET_PREFIX . __('サイドバー', 'cielos'),
        'description' => __('メインサイドバー。全ページに表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($default, array(
        'id'          => 'sidebar-scroll',
        'name'        => CIELOS_WIDGET_PREFIX . __('サイドバー（追従）', 'cielos'),
        'description' => __('スクロールに追従するサイドバーエリア。', 'cielos'),
        'before_widget' => '<div id="%1$s" class="widget cielos-widget cielos-widget-sticky %2$s mb-6 p-4 bg-[var(--c-panel)] rounded-lg border border-[var(--c-border)] sticky top-4">',
    )));

    // =========================================================================
    // 投稿（Single Post）エリア
    // =========================================================================

    register_sidebar(array_merge($content, array(
        'id'          => 'single-title-top',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿タイトル上', 'cielos'),
        'description' => __('投稿タイトルの上に表示されます。（広告やCTAなど）', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-title-bottom',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿タイトル下', 'cielos'),
        'description' => __('投稿タイトルの下に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-content-top',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿本文上', 'cielos'),
        'description' => __('投稿本文の上に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-content-middle',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿本文中', 'cielos'),
        'description' => __('最初の見出しの手前に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-content-bottom',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿本文下', 'cielos'),
        'description' => __('投稿本文の下に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-sns-top',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿SNSボタン上', 'cielos'),
        'description' => __('SNSシェアボタンの上に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-sns-bottom',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿SNSボタン下', 'cielos'),
        'description' => __('SNSシェアボタンの下に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-related-top',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿関連記事上', 'cielos'),
        'description' => __('関連記事セクションの上に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-related-bottom',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿関連記事下', 'cielos'),
        'description' => __('関連記事セクションの下に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-comment-top',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿コメント上', 'cielos'),
        'description' => __('コメントセクションの上に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'single-comment-bottom',
        'name'        => CIELOS_WIDGET_PREFIX . __('投稿コメント下', 'cielos'),
        'description' => __('コメントセクションの下に表示されます。', 'cielos'),
    )));

    // =========================================================================
    // 固定ページエリア
    // =========================================================================

    register_sidebar(array_merge($content, array(
        'id'          => 'page-title-top',
        'name'        => CIELOS_WIDGET_PREFIX . __('固定ページタイトル上', 'cielos'),
        'description' => __('固定ページのタイトル上に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'page-title-bottom',
        'name'        => CIELOS_WIDGET_PREFIX . __('固定ページタイトル下', 'cielos'),
        'description' => __('固定ページのタイトル下に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'page-content-top',
        'name'        => CIELOS_WIDGET_PREFIX . __('固定ページ本文上', 'cielos'),
        'description' => __('固定ページの本文上に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'page-content-bottom',
        'name'        => CIELOS_WIDGET_PREFIX . __('固定ページ本文下', 'cielos'),
        'description' => __('固定ページの本文下に表示されます。', 'cielos'),
    )));

    // =========================================================================
    // インデックスページエリア（アーカイブ、トップ、検索結果）
    // =========================================================================

    register_sidebar(array_merge($content, array(
        'id'          => 'index-top',
        'name'        => CIELOS_WIDGET_PREFIX . __('インデックストップ', 'cielos'),
        'description' => __('投稿一覧ページの最上部に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'index-middle',
        'name'        => CIELOS_WIDGET_PREFIX . __('インデックスミドル', 'cielos'),
        'description' => __('投稿一覧の途中（5件目の後など）に表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'index-bottom',
        'name'        => CIELOS_WIDGET_PREFIX . __('インデックスボトム', 'cielos'),
        'description' => __('投稿一覧ページの最下部（ページネーション前）に表示されます。', 'cielos'),
    )));

    // =========================================================================
    // フッターエリア
    // =========================================================================

    register_sidebar(array_merge($footer, array(
        'id'          => 'footer-left',
        'name'        => CIELOS_WIDGET_PREFIX . __('フッター（左）', 'cielos'),
        'description' => __('フッターの左カラムに表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($footer, array(
        'id'          => 'footer-center',
        'name'        => CIELOS_WIDGET_PREFIX . __('フッター（中央）', 'cielos'),
        'description' => __('フッターの中央カラムに表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($footer, array(
        'id'          => 'footer-right',
        'name'        => CIELOS_WIDGET_PREFIX . __('フッター（右）', 'cielos'),
        'description' => __('フッターの右カラムに表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($footer, array(
        'id'          => 'footer-mobile',
        'name'        => CIELOS_WIDGET_PREFIX . __('フッター（モバイル用）', 'cielos'),
        'description' => __('モバイル表示時のみ表示されるフッターエリア。', 'cielos'),
    )));

    // =========================================================================
    // 特殊エリア
    // =========================================================================

    register_sidebar(array_merge($default, array(
        'id'          => '404-page',
        'name'        => CIELOS_WIDGET_PREFIX . __('404ページ', 'cielos'),
        'description' => __('404エラーページに表示されます。', 'cielos'),
    )));

    register_sidebar(array_merge($content, array(
        'id'          => 'cta-box',
        'name'        => CIELOS_WIDGET_PREFIX . __('CTAボックス', 'cielos'),
        'description' => __('投稿末尾のCall-to-Actionエリア。', 'cielos'),
        'before_widget' => '<div id="%1$s" class="widget cielos-widget cielos-cta-box %2$s p-6 my-8 bg-gradient-to-r from-[var(--c-primary-light)] to-[var(--c-accent-light)] rounded-xl border border-[var(--c-primary)]">',
    )));

    // =========================================================================
    // 後方互換性（旧テーマからの移行用）
    // =========================================================================

    register_sidebar(array_merge($default, array(
        'id'          => 'sidebar-1',
        'name'        => __('Sidebar widgets (Legacy)', 'cielos'),
        'description' => __('旧サイドバー。「サイドバー」への移行を推奨。', 'cielos'),
    )));

    register_sidebar(array_merge($default, array(
        'id'          => 'sidebar-2',
        'name'        => __('Secondary Sidebar (Legacy)', 'cielos'),
        'description' => __('旧セカンダリサイドバー。', 'cielos'),
    )));

    register_sidebar(array_merge($footer, array(
        'id'          => 'footer-1',
        'name'        => __('Footer widgets1 (Legacy)', 'cielos'),
        'description' => __('旧フッター1。「フッター（左）」への移行を推奨。', 'cielos'),
    )));

    register_sidebar(array_merge($footer, array(
        'id'          => 'footer-2',
        'name'        => __('Footer widgets2 (Legacy)', 'cielos'),
        'description' => __('旧フッター2。「フッター（中央）」への移行を推奨。', 'cielos'),
    )));

    register_sidebar(array_merge($footer, array(
        'id'          => 'footer-3',
        'name'        => __('Footer widgets3 (Legacy)', 'cielos'),
        'description' => __('旧フッター3。「フッター（右）」への移行を推奨。', 'cielos'),
    )));
}

add_action('widgets_init', 'cielos_register_widget_areas');
endif;

/**
 * ウィジェットエリアを出力するヘルパー関数
 *
 * @param string $id ウィジェットエリアID
 * @param string $wrapper_class 追加のラッパークラス
 * @return void
 */
function cielos_widget_area($id, $wrapper_class = '') {
    if (is_active_sidebar($id)) {
        $class = 'cielos-widget-area cielos-widget-area-' . esc_attr($id);
        if ($wrapper_class) {
            $class .= ' ' . esc_attr($wrapper_class);
        }
        echo '<div class="' . $class . '">';
        dynamic_sidebar($id);
        echo '</div>';
    }
}

/**
 * ウィジェットエリアが有効かどうかをチェック
 *
 * @param string $id ウィジェットエリアID
 * @return bool
 */
function cielos_has_widget_area($id) {
    return is_active_sidebar($id);
}

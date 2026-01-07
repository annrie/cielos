<?php
/**
 * Widget Display Control System
 * Cocoon-style widget visibility control for Cielos theme
 *
 * @package Cielos
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget Display Control Class
 */
class Cielos_Widget_Display_Control {

    /**
     * Instance
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // ウィジェットフォームに表示設定を追加
        add_action('in_widget_form', array($this, 'extend_widget_form'), 10, 3);
        // ウィジェット設定を保存
        add_filter('widget_update_callback', array($this, 'update_widget_settings'), 10, 4);
        // ウィジェット表示をフィルタ
        add_filter('widget_display_callback', array($this, 'filter_widget_display'), 10, 3);
    }

    /**
     * ウィジェットフォームに表示設定を追加
     */
    public function extend_widget_form($widget, $return, $instance) {
        $display_settings = isset($instance['cielos_display']) ? $instance['cielos_display'] : array();

        // デフォルト値
        $defaults = array(
            'page_type'    => array(),
            'categories'   => array(),
            'post_types'   => array(),
            'device'       => 'all',
            'logged_in'    => 'all',
            'exclude_ids'  => '',
        );
        $display_settings = wp_parse_args($display_settings, $defaults);
        ?>

        <div class="cielos-widget-display-control" style="margin-top: 15px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
            <p style="font-weight: bold; margin-bottom: 10px; color: #333;">
                <span class="dashicons dashicons-visibility" style="vertical-align: middle;"></span>
                <?php _e('表示制御設定', 'cielos'); ?>
            </p>

            <!-- ページタイプ -->
            <p style="margin-bottom: 10px;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">
                    <?php _e('表示するページタイプ', 'cielos'); ?>
                </label>
                <small style="color: #666; display: block; margin-bottom: 8px;">
                    <?php _e('未選択の場合は全ページで表示', 'cielos'); ?>
                </small>
                <?php
                $page_types = array(
                    'front_page'  => __('フロントページ', 'cielos'),
                    'home'        => __('投稿ページ（ブログ）', 'cielos'),
                    'single'      => __('投稿（個別）', 'cielos'),
                    'page'        => __('固定ページ', 'cielos'),
                    'archive'     => __('アーカイブ', 'cielos'),
                    'category'    => __('カテゴリーページ', 'cielos'),
                    'tag'         => __('タグページ', 'cielos'),
                    'author'      => __('著者ページ', 'cielos'),
                    'search'      => __('検索結果', 'cielos'),
                    '404'         => __('404ページ', 'cielos'),
                );
                foreach ($page_types as $key => $label) :
                    $checked = in_array($key, $display_settings['page_type']) ? 'checked' : '';
                ?>
                    <label style="display: inline-block; margin-right: 12px; margin-bottom: 5px;">
                        <input type="checkbox"
                               name="<?php echo $widget->get_field_name('cielos_display'); ?>[page_type][]"
                               value="<?php echo esc_attr($key); ?>"
                               <?php echo $checked; ?> />
                        <?php echo esc_html($label); ?>
                    </label>
                <?php endforeach; ?>
            </p>

            <!-- カテゴリー -->
            <p style="margin-bottom: 10px;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">
                    <?php _e('表示するカテゴリー', 'cielos'); ?>
                </label>
                <small style="color: #666; display: block; margin-bottom: 8px;">
                    <?php _e('投稿・カテゴリーページで有効。未選択は全カテゴリー', 'cielos'); ?>
                </small>
                <select multiple
                        name="<?php echo $widget->get_field_name('cielos_display'); ?>[categories][]"
                        style="width: 100%; height: 120px;">
                    <?php
                    $categories = get_categories(array('hide_empty' => false));
                    foreach ($categories as $cat) :
                        $selected = in_array($cat->term_id, $display_settings['categories']) ? 'selected' : '';
                    ?>
                        <option value="<?php echo esc_attr($cat->term_id); ?>" <?php echo $selected; ?>>
                            <?php echo esc_html($cat->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <!-- 投稿タイプ -->
            <p style="margin-bottom: 10px;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">
                    <?php _e('表示する投稿タイプ', 'cielos'); ?>
                </label>
                <?php
                $post_types = get_post_types(array('public' => true), 'objects');
                foreach ($post_types as $pt) :
                    if ($pt->name === 'attachment') continue;
                    $checked = in_array($pt->name, $display_settings['post_types']) ? 'checked' : '';
                ?>
                    <label style="display: inline-block; margin-right: 12px; margin-bottom: 5px;">
                        <input type="checkbox"
                               name="<?php echo $widget->get_field_name('cielos_display'); ?>[post_types][]"
                               value="<?php echo esc_attr($pt->name); ?>"
                               <?php echo $checked; ?> />
                        <?php echo esc_html($pt->label); ?>
                    </label>
                <?php endforeach; ?>
            </p>

            <!-- デバイス -->
            <p style="margin-bottom: 10px;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">
                    <?php _e('表示デバイス', 'cielos'); ?>
                </label>
                <?php
                $devices = array(
                    'all'     => __('すべて', 'cielos'),
                    'desktop' => __('PC のみ', 'cielos'),
                    'mobile'  => __('モバイルのみ', 'cielos'),
                );
                foreach ($devices as $key => $label) :
                    $checked = ($display_settings['device'] === $key) ? 'checked' : '';
                ?>
                    <label style="display: inline-block; margin-right: 12px;">
                        <input type="radio"
                               name="<?php echo $widget->get_field_name('cielos_display'); ?>[device]"
                               value="<?php echo esc_attr($key); ?>"
                               <?php echo $checked; ?> />
                        <?php echo esc_html($label); ?>
                    </label>
                <?php endforeach; ?>
            </p>

            <!-- ログイン状態 -->
            <p style="margin-bottom: 10px;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">
                    <?php _e('ログイン状態', 'cielos'); ?>
                </label>
                <?php
                $logged_options = array(
                    'all'        => __('すべてのユーザー', 'cielos'),
                    'logged_in'  => __('ログインユーザーのみ', 'cielos'),
                    'logged_out' => __('非ログインユーザーのみ', 'cielos'),
                );
                foreach ($logged_options as $key => $label) :
                    $checked = ($display_settings['logged_in'] === $key) ? 'checked' : '';
                ?>
                    <label style="display: inline-block; margin-right: 12px;">
                        <input type="radio"
                               name="<?php echo $widget->get_field_name('cielos_display'); ?>[logged_in]"
                               value="<?php echo esc_attr($key); ?>"
                               <?php echo $checked; ?> />
                        <?php echo esc_html($label); ?>
                    </label>
                <?php endforeach; ?>
            </p>

            <!-- 除外ページID -->
            <p style="margin-bottom: 0;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">
                    <?php _e('除外するページID', 'cielos'); ?>
                </label>
                <small style="color: #666; display: block; margin-bottom: 8px;">
                    <?php _e('カンマ区切りで入力（例: 123,456,789）', 'cielos'); ?>
                </small>
                <input type="text"
                       name="<?php echo $widget->get_field_name('cielos_display'); ?>[exclude_ids]"
                       value="<?php echo esc_attr($display_settings['exclude_ids']); ?>"
                       style="width: 100%;"
                       placeholder="123,456,789" />
            </p>
        </div>

        <?php
        return $instance;
    }

    /**
     * ウィジェット設定を保存
     */
    public function update_widget_settings($instance, $new_instance, $old_instance, $widget) {
        if (isset($new_instance['cielos_display'])) {
            $display = $new_instance['cielos_display'];

            $instance['cielos_display'] = array(
                'page_type'    => isset($display['page_type']) ? array_map('sanitize_text_field', $display['page_type']) : array(),
                'categories'   => isset($display['categories']) ? array_map('intval', $display['categories']) : array(),
                'post_types'   => isset($display['post_types']) ? array_map('sanitize_text_field', $display['post_types']) : array(),
                'device'       => isset($display['device']) ? sanitize_text_field($display['device']) : 'all',
                'logged_in'    => isset($display['logged_in']) ? sanitize_text_field($display['logged_in']) : 'all',
                'exclude_ids'  => isset($display['exclude_ids']) ? sanitize_text_field($display['exclude_ids']) : '',
            );
        }

        return $instance;
    }

    /**
     * ウィジェット表示をフィルタ
     */
    public function filter_widget_display($instance, $widget, $args) {
        if (empty($instance['cielos_display'])) {
            return $instance;
        }

        $display = $instance['cielos_display'];

        // ページタイプチェック
        if (!empty($display['page_type'])) {
            if (!$this->check_page_type($display['page_type'])) {
                return false;
            }
        }

        // カテゴリーチェック
        if (!empty($display['categories'])) {
            if (!$this->check_categories($display['categories'])) {
                return false;
            }
        }

        // 投稿タイプチェック
        if (!empty($display['post_types'])) {
            if (!$this->check_post_types($display['post_types'])) {
                return false;
            }
        }

        // デバイスチェック
        if (!empty($display['device']) && $display['device'] !== 'all') {
            if (!$this->check_device($display['device'])) {
                return false;
            }
        }

        // ログイン状態チェック
        if (!empty($display['logged_in']) && $display['logged_in'] !== 'all') {
            if (!$this->check_logged_in($display['logged_in'])) {
                return false;
            }
        }

        // 除外ページIDチェック
        if (!empty($display['exclude_ids'])) {
            if ($this->check_excluded_ids($display['exclude_ids'])) {
                return false;
            }
        }

        return $instance;
    }

    /**
     * ページタイプをチェック
     */
    private function check_page_type($allowed_types) {
        foreach ($allowed_types as $type) {
            switch ($type) {
                case 'front_page':
                    if (is_front_page()) return true;
                    break;
                case 'home':
                    if (is_home()) return true;
                    break;
                case 'single':
                    if (is_single()) return true;
                    break;
                case 'page':
                    if (is_page() && !is_front_page()) return true;
                    break;
                case 'archive':
                    if (is_archive()) return true;
                    break;
                case 'category':
                    if (is_category()) return true;
                    break;
                case 'tag':
                    if (is_tag()) return true;
                    break;
                case 'author':
                    if (is_author()) return true;
                    break;
                case 'search':
                    if (is_search()) return true;
                    break;
                case '404':
                    if (is_404()) return true;
                    break;
            }
        }
        return false;
    }

    /**
     * カテゴリーをチェック
     */
    private function check_categories($allowed_categories) {
        // 投稿ページの場合
        if (is_single()) {
            $post_categories = wp_get_post_categories(get_the_ID());
            foreach ($allowed_categories as $cat_id) {
                if (in_array($cat_id, $post_categories)) {
                    return true;
                }
            }
        }

        // カテゴリーアーカイブの場合
        if (is_category()) {
            $current_cat = get_queried_object_id();
            if (in_array($current_cat, $allowed_categories)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 投稿タイプをチェック
     */
    private function check_post_types($allowed_types) {
        $current_type = get_post_type();
        return in_array($current_type, $allowed_types);
    }

    /**
     * デバイスをチェック
     */
    private function check_device($device) {
        $is_mobile = wp_is_mobile();

        if ($device === 'desktop' && !$is_mobile) {
            return true;
        }

        if ($device === 'mobile' && $is_mobile) {
            return true;
        }

        return false;
    }

    /**
     * ログイン状態をチェック
     */
    private function check_logged_in($logged_in) {
        $is_logged = is_user_logged_in();

        if ($logged_in === 'logged_in' && $is_logged) {
            return true;
        }

        if ($logged_in === 'logged_out' && !$is_logged) {
            return true;
        }

        return false;
    }

    /**
     * 除外ページIDをチェック
     */
    private function check_excluded_ids($exclude_ids) {
        $ids = array_map('trim', explode(',', $exclude_ids));
        $ids = array_filter($ids, 'is_numeric');
        $ids = array_map('intval', $ids);

        $current_id = get_the_ID();
        return in_array($current_id, $ids);
    }
}

// 初期化
Cielos_Widget_Display_Control::get_instance();

/**
 * モバイル判定のCSSクラスを body に追加
 */
add_filter('body_class', function($classes) {
    if (wp_is_mobile()) {
        $classes[] = 'is-mobile';
    } else {
        $classes[] = 'is-desktop';
    }
    return $classes;
});

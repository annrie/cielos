<?php
/**
 * Table of Contents Widget
 * 投稿の目次を自動生成して表示
 *
 * @package Cielos
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

class Cielos_TOC_Widget extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'cielos_toc',
            CIELOS_WIDGET_PREFIX . __('目次', 'cielos'),
            array(
                'description' => __('投稿内の見出しから目次を自動生成します。', 'cielos'),
                'classname'   => 'cielos-toc-widget',
            ),
            array('width' => 400, 'height' => 350)
        );
    }

    /**
     * Widget output
     */
    public function widget($args, $instance) {
        // 投稿・固定ページのみで表示
        if (!is_singular(array('post', 'page'))) {
            return;
        }

        global $post;
        if (!$post) return;

        $title       = apply_filters('widget_title', empty($instance['title']) ? __('目次', 'cielos') : $instance['title']);
        $depth       = empty($instance['depth']) ? 3 : absint($instance['depth']);
        $min_count   = empty($instance['min_count']) ? 2 : absint($instance['min_count']);
        $is_numbered = !empty($instance['is_numbered']);
        $is_toggle   = !empty($instance['is_toggle']);
        $default_open = isset($instance['default_open']) ? $instance['default_open'] : 1;

        // 見出しを抽出
        $headings = $this->extract_headings($post->post_content, $depth);

        // 最小件数に満たない場合は表示しない
        if (count($headings) < $min_count) {
            return;
        }

        echo $args['before_widget'];

        $toggle_id = 'cielos-toc-toggle-' . $this->id;
        $content_id = 'cielos-toc-content-' . $this->id;
        ?>

        <div class="cielos-toc <?php echo $is_toggle ? 'cielos-toc--collapsible' : ''; ?>">
            <?php if ($title) : ?>
                <div class="cielos-toc-header flex items-center justify-between mb-4 pb-2 border-b-2 border-[var(--c-primary)]">
                    <h3 class="cielos-toc-title text-lg font-bold text-[var(--c-fg)] m-0">
                        <i class="fas fa-list-ul mr-2" aria-hidden="true"></i><?php echo esc_html($title); ?>
                    </h3>
                    <?php if ($is_toggle) : ?>
                        <button type="button"
                                id="<?php echo esc_attr($toggle_id); ?>"
                                class="cielos-toc-toggle p-2 text-[var(--c-muted)] hover:text-[var(--c-fg)] transition-colors"
                                aria-expanded="<?php echo $default_open ? 'true' : 'false'; ?>"
                                aria-controls="<?php echo esc_attr($content_id); ?>">
                            <i class="fas fa-chevron-down transition-transform" aria-hidden="true"></i>
                            <span class="sr-only"><?php _e('目次を開閉', 'cielos'); ?></span>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <nav id="<?php echo esc_attr($content_id); ?>"
                 class="cielos-toc-content <?php echo ($is_toggle && !$default_open) ? 'hidden' : ''; ?>"
                 aria-label="<?php _e('目次', 'cielos'); ?>">
                <?php echo $this->render_toc($headings, $is_numbered); ?>
            </nav>
        </div>

        <?php if ($is_toggle) : ?>
        <script>
        (function() {
            var toggle = document.getElementById('<?php echo esc_js($toggle_id); ?>');
            var content = document.getElementById('<?php echo esc_js($content_id); ?>');
            if (!toggle || !content) return;

            toggle.addEventListener('click', function() {
                var expanded = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', !expanded);
                content.classList.toggle('hidden');
                toggle.querySelector('i').style.transform = expanded ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        })();
        </script>
        <?php endif; ?>

        <?php
        echo $args['after_widget'];
    }

    /**
     * 見出しを抽出
     */
    private function extract_headings($content, $max_depth) {
        $headings = array();

        // 対象の見出しレベル
        $levels = range(2, min($max_depth + 1, 6));
        $pattern = '/<h([' . implode('', $levels) . '])([^>]*)>(.*?)<\/h\1>/is';

        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $level = (int) $match[1];
                $attrs = $match[2];
                $text  = strip_tags($match[3]);

                // ID を取得または生成
                $id = '';
                if (preg_match('/id=["\']([^"\']+)["\']/', $attrs, $id_match)) {
                    $id = $id_match[1];
                } else {
                    $id = sanitize_title($text);
                }

                $headings[] = array(
                    'level' => $level,
                    'text'  => $text,
                    'id'    => $id,
                );
            }
        }

        return $headings;
    }

    /**
     * 目次をレンダリング
     */
    private function render_toc($headings, $is_numbered) {
        if (empty($headings)) return '';

        $output = '<ol class="cielos-toc-list ' . ($is_numbered ? 'list-decimal' : 'list-disc') . ' pl-5 space-y-2 text-sm">';

        $prev_level = $headings[0]['level'];
        $level_stack = array();

        foreach ($headings as $heading) {
            $level = $heading['level'];

            // レベルが深くなった
            while ($level > $prev_level) {
                $output .= '<ol class="cielos-toc-sublist ' . ($is_numbered ? 'list-decimal' : 'list-disc') . ' pl-5 mt-2 space-y-1">';
                array_push($level_stack, $prev_level);
                $prev_level++;
            }

            // レベルが浅くなった
            while ($level < $prev_level && !empty($level_stack)) {
                $output .= '</li></ol>';
                $prev_level = array_pop($level_stack);
            }

            // 同じレベル
            if ($level === $prev_level && $heading !== $headings[0]) {
                $output .= '</li>';
            }

            $output .= '<li class="cielos-toc-item">';
            $output .= '<a href="#' . esc_attr($heading['id']) . '" class="cielos-toc-link text-[var(--c-fg)] hover:text-[var(--c-primary)] transition-colors">';
            $output .= esc_html($heading['text']);
            $output .= '</a>';

            $prev_level = $level;
        }

        // 残りの閉じタグ
        while (!empty($level_stack)) {
            $output .= '</li></ol>';
            array_pop($level_stack);
        }
        $output .= '</li></ol>';

        return $output;
    }

    /**
     * Widget form
     */
    public function form($instance) {
        $defaults = array(
            'title'        => __('目次', 'cielos'),
            'depth'        => 3,
            'min_count'    => 2,
            'is_numbered'  => 1,
            'is_toggle'    => 1,
            'default_open' => 1,
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('タイトル:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('depth'); ?>"><?php _e('見出しの深さ:', 'cielos'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('depth'); ?>" name="<?php echo $this->get_field_name('depth'); ?>">
                <option value="2" <?php selected($instance['depth'], 2); ?>><?php _e('H2 のみ', 'cielos'); ?></option>
                <option value="3" <?php selected($instance['depth'], 3); ?>><?php _e('H2〜H3', 'cielos'); ?></option>
                <option value="4" <?php selected($instance['depth'], 4); ?>><?php _e('H2〜H4', 'cielos'); ?></option>
                <option value="5" <?php selected($instance['depth'], 5); ?>><?php _e('H2〜H5', 'cielos'); ?></option>
                <option value="6" <?php selected($instance['depth'], 6); ?>><?php _e('H2〜H6', 'cielos'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('min_count'); ?>"><?php _e('表示する最小見出し数:', 'cielos'); ?></label>
            <input id="<?php echo $this->get_field_id('min_count'); ?>" name="<?php echo $this->get_field_name('min_count'); ?>" type="number" value="<?php echo esc_attr($instance['min_count']); ?>" min="1" max="10" style="width: 60px;" />
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('is_numbered'); ?>" name="<?php echo $this->get_field_name('is_numbered'); ?>" value="1" <?php checked($instance['is_numbered'], 1); ?> />
            <label for="<?php echo $this->get_field_id('is_numbered'); ?>"><?php _e('番号付きリストにする', 'cielos'); ?></label>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('is_toggle'); ?>" name="<?php echo $this->get_field_name('is_toggle'); ?>" value="1" <?php checked($instance['is_toggle'], 1); ?> />
            <label for="<?php echo $this->get_field_id('is_toggle'); ?>"><?php _e('開閉ボタンを表示', 'cielos'); ?></label>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('default_open'); ?>" name="<?php echo $this->get_field_name('default_open'); ?>" value="1" <?php checked($instance['default_open'], 1); ?> />
            <label for="<?php echo $this->get_field_id('default_open'); ?>"><?php _e('初期状態で開いておく', 'cielos'); ?></label>
        </p>

        <?php
    }

    /**
     * Widget update
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title']        = sanitize_text_field($new_instance['title']);
        $instance['depth']        = absint($new_instance['depth']);
        $instance['min_count']    = absint($new_instance['min_count']);
        $instance['is_numbered']  = !empty($new_instance['is_numbered']) ? 1 : 0;
        $instance['is_toggle']    = !empty($new_instance['is_toggle']) ? 1 : 0;
        $instance['default_open'] = !empty($new_instance['default_open']) ? 1 : 0;

        return $instance;
    }
}

// ウィジェット登録
add_action('widgets_init', function() {
    register_widget('Cielos_TOC_Widget');
});

/**
 * 投稿の見出しにIDを自動付与
 */
add_filter('the_content', function($content) {
    if (!is_singular()) return $content;

    // h2-h6 にIDがなければ追加
    $content = preg_replace_callback(
        '/<h([2-6])([^>]*)>(.*?)<\/h\1>/is',
        function($matches) {
            $level = $matches[1];
            $attrs = $matches[2];
            $text  = $matches[3];

            // 既にIDがあればスキップ
            if (preg_match('/\bid=["\']/', $attrs)) {
                return $matches[0];
            }

            // ID生成
            $id = sanitize_title(strip_tags($text));
            if (empty($id)) {
                $id = 'heading-' . wp_rand(1000, 9999);
            }

            return '<h' . $level . ' id="' . esc_attr($id) . '"' . $attrs . '>' . $text . '</h' . $level . '>';
        },
        $content
    );

    return $content;
}, 5);

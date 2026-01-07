<?php
/**
 * New Entries Widget
 * 新着記事リストをサムネイル付きで表示
 *
 * @package Cielos
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

class Cielos_New_Entries_Widget extends WP_Widget {

    /**
     * 表示タイプの定数
     */
    const TYPE_DEFAULT = 'default';       // デフォルト（サムネイル＋タイトル）
    const TYPE_LARGE   = 'large';         // 大きなサムネイル
    const TYPE_CARD    = 'card';          // カード型
    const TYPE_SIMPLE  = 'simple';        // シンプル（タイトルのみ）

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'cielos_new_entries',
            CIELOS_WIDGET_PREFIX . __('新着記事', 'cielos'),
            array(
                'description' => __('新着記事リストをサムネイル付きで表示します。', 'cielos'),
                'classname'   => 'cielos-new-entries-widget',
            ),
            array('width' => 400, 'height' => 350)
        );
    }

    /**
     * Widget output
     */
    public function widget($args, $instance) {
        $title       = apply_filters('widget_title', empty($instance['title']) ? __('新着記事', 'cielos') : $instance['title']);
        $count       = empty($instance['count']) ? 5 : absint($instance['count']);
        $type        = empty($instance['type']) ? self::TYPE_DEFAULT : $instance['type'];
        $show_date   = !empty($instance['show_date']);
        $show_cat    = !empty($instance['show_cat']);
        $categories  = empty($instance['categories']) ? array() : $instance['categories'];
        $exclude_ids = empty($instance['exclude_ids']) ? '' : $instance['exclude_ids'];
        $order_by    = empty($instance['order_by']) ? 'date' : $instance['order_by'];

        // クエリ引数
        $query_args = array(
            'post_type'           => 'post',
            'posts_per_page'      => $count,
            'orderby'             => $order_by,
            'order'               => 'DESC',
            'ignore_sticky_posts' => empty($instance['show_sticky']),
            'no_found_rows'       => true,
        );

        // カテゴリーフィルター
        if (!empty($categories)) {
            $query_args['category__in'] = $categories;
        }

        // 除外ID
        if (!empty($exclude_ids)) {
            $ids = array_map('trim', explode(',', $exclude_ids));
            $ids = array_filter($ids, 'is_numeric');
            if (!empty($ids)) {
                $query_args['post__not_in'] = array_map('intval', $ids);
            }
        }

        $query = new WP_Query($query_args);

        if (!$query->have_posts()) {
            return;
        }

        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        // 表示タイプに応じたクラス
        $list_class = 'cielos-new-entries cielos-entry-list cielos-entry-list--' . esc_attr($type);
        ?>

        <ul class="<?php echo $list_class; ?>">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php $this->render_entry($type, $show_date, $show_cat); ?>
            <?php endwhile; ?>
        </ul>

        <?php
        wp_reset_postdata();

        echo $args['after_widget'];
    }

    /**
     * エントリーを描画
     */
    private function render_entry($type, $show_date, $show_cat) {
        $permalink = get_permalink();
        $title     = get_the_title();
        $thumb_id  = get_post_thumbnail_id();
        $date      = get_the_date('Y.m.d');

        // サムネイルサイズを表示タイプで変更
        $thumb_size = ($type === self::TYPE_LARGE || $type === self::TYPE_CARD) ? 'medium' : 'thumbnail';

        switch ($type) {
            case self::TYPE_CARD:
                $this->render_card_entry($permalink, $title, $thumb_id, $thumb_size, $date, $show_date, $show_cat);
                break;
            case self::TYPE_SIMPLE:
                $this->render_simple_entry($permalink, $title, $date, $show_date);
                break;
            case self::TYPE_LARGE:
                $this->render_large_entry($permalink, $title, $thumb_id, $thumb_size, $date, $show_date, $show_cat);
                break;
            default:
                $this->render_default_entry($permalink, $title, $thumb_id, $thumb_size, $date, $show_date, $show_cat);
        }
    }

    /**
     * デフォルト表示
     */
    private function render_default_entry($permalink, $title, $thumb_id, $thumb_size, $date, $show_date, $show_cat) {
        ?>
        <li class="cielos-entry-item flex gap-3 mb-4 last:mb-0">
            <?php if ($thumb_id) : ?>
                <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-thumb flex-shrink-0 w-20 h-20">
                    <?php echo wp_get_attachment_image($thumb_id, $thumb_size, false, array(
                        'class' => 'w-full h-full object-cover rounded',
                        'alt'   => esc_attr($title),
                        'loading' => 'lazy',
                    )); ?>
                </a>
            <?php endif; ?>
            <div class="cielos-entry-content flex-1 min-w-0">
                <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-title block text-sm font-medium text-[var(--c-fg)] hover:text-[var(--c-primary)] line-clamp-2 mb-1">
                    <?php echo esc_html($title); ?>
                </a>
                <?php $this->render_meta($date, $show_date, $show_cat); ?>
            </div>
        </li>
        <?php
    }

    /**
     * 大きなサムネイル表示
     */
    private function render_large_entry($permalink, $title, $thumb_id, $thumb_size, $date, $show_date, $show_cat) {
        ?>
        <li class="cielos-entry-item mb-6 last:mb-0">
            <?php if ($thumb_id) : ?>
                <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-thumb block mb-3">
                    <?php echo wp_get_attachment_image($thumb_id, $thumb_size, false, array(
                        'class' => 'w-full h-auto aspect-video object-cover rounded-lg',
                        'alt'   => esc_attr($title),
                        'loading' => 'lazy',
                    )); ?>
                </a>
            <?php endif; ?>
            <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-title block text-base font-medium text-[var(--c-fg)] hover:text-[var(--c-primary)] line-clamp-2 mb-2">
                <?php echo esc_html($title); ?>
            </a>
            <?php $this->render_meta($date, $show_date, $show_cat); ?>
        </li>
        <?php
    }

    /**
     * カード型表示
     */
    private function render_card_entry($permalink, $title, $thumb_id, $thumb_size, $date, $show_date, $show_cat) {
        ?>
        <li class="cielos-entry-item cielos-entry-card bg-[var(--c-panel)] rounded-lg overflow-hidden border border-[var(--c-border)] mb-4 last:mb-0 hover:shadow-md transition-shadow">
            <?php if ($thumb_id) : ?>
                <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-thumb block">
                    <?php echo wp_get_attachment_image($thumb_id, $thumb_size, false, array(
                        'class' => 'w-full h-auto aspect-video object-cover',
                        'alt'   => esc_attr($title),
                        'loading' => 'lazy',
                    )); ?>
                </a>
            <?php endif; ?>
            <div class="cielos-entry-content p-4">
                <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-title block text-sm font-medium text-[var(--c-fg)] hover:text-[var(--c-primary)] line-clamp-2 mb-2">
                    <?php echo esc_html($title); ?>
                </a>
                <?php $this->render_meta($date, $show_date, $show_cat); ?>
            </div>
        </li>
        <?php
    }

    /**
     * シンプル表示
     */
    private function render_simple_entry($permalink, $title, $date, $show_date) {
        ?>
        <li class="cielos-entry-item cielos-entry-simple py-2 border-b border-[var(--c-border)] last:border-b-0">
            <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-title block text-sm text-[var(--c-fg)] hover:text-[var(--c-primary)]">
                <?php if ($show_date) : ?>
                    <span class="cielos-entry-date text-xs text-[var(--c-muted)] mr-2"><?php echo esc_html($date); ?></span>
                <?php endif; ?>
                <?php echo esc_html($title); ?>
            </a>
        </li>
        <?php
    }

    /**
     * メタ情報を描画
     */
    private function render_meta($date, $show_date, $show_cat) {
        if (!$show_date && !$show_cat) return;
        ?>
        <div class="cielos-entry-meta flex flex-wrap gap-2 text-xs text-[var(--c-muted)]">
            <?php if ($show_date) : ?>
                <span class="cielos-entry-date">
                    <i class="fas fa-calendar-alt mr-1" aria-hidden="true"></i><?php echo esc_html($date); ?>
                </span>
            <?php endif; ?>
            <?php if ($show_cat) :
                $cats = get_the_category();
                if (!empty($cats)) : ?>
                    <span class="cielos-entry-cat">
                        <i class="fas fa-folder mr-1" aria-hidden="true"></i><?php echo esc_html($cats[0]->name); ?>
                    </span>
                <?php endif;
            endif; ?>
        </div>
        <?php
    }

    /**
     * Widget form
     */
    public function form($instance) {
        $defaults = array(
            'title'       => __('新着記事', 'cielos'),
            'count'       => 5,
            'type'        => self::TYPE_DEFAULT,
            'show_date'   => 1,
            'show_cat'    => 0,
            'categories'  => array(),
            'exclude_ids' => '',
            'order_by'    => 'date',
            'show_sticky' => 0,
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        $types = array(
            self::TYPE_DEFAULT => __('デフォルト', 'cielos'),
            self::TYPE_LARGE   => __('大きなサムネイル', 'cielos'),
            self::TYPE_CARD    => __('カード型', 'cielos'),
            self::TYPE_SIMPLE  => __('シンプル（タイトルのみ）', 'cielos'),
        );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('タイトル:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('表示件数:', 'cielos'); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" value="<?php echo esc_attr($instance['count']); ?>" min="1" max="20" style="width: 60px;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('表示タイプ:', 'cielos'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
                <?php foreach ($types as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['type'], $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('並び順:', 'cielos'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
                <option value="date" <?php selected($instance['order_by'], 'date'); ?>><?php _e('投稿日', 'cielos'); ?></option>
                <option value="modified" <?php selected($instance['order_by'], 'modified'); ?>><?php _e('更新日', 'cielos'); ?></option>
                <option value="rand" <?php selected($instance['order_by'], 'rand'); ?>><?php _e('ランダム', 'cielos'); ?></option>
            </select>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" value="1" <?php checked($instance['show_date'], 1); ?> />
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('日付を表示', 'cielos'); ?></label>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_cat'); ?>" name="<?php echo $this->get_field_name('show_cat'); ?>" value="1" <?php checked($instance['show_cat'], 1); ?> />
            <label for="<?php echo $this->get_field_id('show_cat'); ?>"><?php _e('カテゴリーを表示', 'cielos'); ?></label>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_sticky'); ?>" name="<?php echo $this->get_field_name('show_sticky'); ?>" value="1" <?php checked($instance['show_sticky'], 1); ?> />
            <label for="<?php echo $this->get_field_id('show_sticky'); ?>"><?php _e('先頭固定表示を含む', 'cielos'); ?></label>
        </p>

        <p>
            <label><?php _e('表示カテゴリー:', 'cielos'); ?></label><br />
            <small style="color: #666;"><?php _e('未選択の場合は全カテゴリー', 'cielos'); ?></small>
            <select multiple name="<?php echo $this->get_field_name('categories'); ?>[]" style="width: 100%; height: 100px;">
                <?php
                $cats = get_categories(array('hide_empty' => false));
                foreach ($cats as $cat) :
                    $selected = in_array($cat->term_id, $instance['categories']) ? 'selected' : '';
                ?>
                    <option value="<?php echo esc_attr($cat->term_id); ?>" <?php echo $selected; ?>><?php echo esc_html($cat->name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('exclude_ids'); ?>"><?php _e('除外投稿ID:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('exclude_ids'); ?>" name="<?php echo $this->get_field_name('exclude_ids'); ?>" type="text" value="<?php echo esc_attr($instance['exclude_ids']); ?>" placeholder="123,456,789" />
            <small style="color: #666;"><?php _e('カンマ区切りで入力', 'cielos'); ?></small>
        </p>

        <?php
    }

    /**
     * Widget update
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title']       = sanitize_text_field($new_instance['title']);
        $instance['count']       = absint($new_instance['count']);
        $instance['type']        = sanitize_text_field($new_instance['type']);
        $instance['show_date']   = !empty($new_instance['show_date']) ? 1 : 0;
        $instance['show_cat']    = !empty($new_instance['show_cat']) ? 1 : 0;
        $instance['show_sticky'] = !empty($new_instance['show_sticky']) ? 1 : 0;
        $instance['categories']  = isset($new_instance['categories']) ? array_map('intval', $new_instance['categories']) : array();
        $instance['exclude_ids'] = sanitize_text_field($new_instance['exclude_ids']);
        $instance['order_by']    = sanitize_text_field($new_instance['order_by']);

        return $instance;
    }
}

// ウィジェット登録
add_action('widgets_init', function() {
    register_widget('Cielos_New_Entries_Widget');
});

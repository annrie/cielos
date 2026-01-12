<?php
/**
 * Popular Entries Widget
 * 人気記事リストを表示（コメント数/PV数ベース）
 *
 * @package Cielos
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

class Cielos_Popular_Entries_Widget extends WP_Widget {

    /**
     * 集計方法
     */
    const METHOD_COMMENTS = 'comments';  // コメント数
    const METHOD_VIEWS    = 'views';     // ページビュー（要カスタムフィールド）

    /**
     * 期間
     */
    const PERIOD_ALL   = 'all';
    const PERIOD_MONTH = 'month';
    const PERIOD_WEEK  = 'week';

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'cielos_popular_entries',
            CIELOS_WIDGET_PREFIX . __('人気記事', 'cielos'),
            array(
                'description' => __('人気記事をランキング形式で表示します。', 'cielos'),
                'classname'   => 'cielos-popular-entries-widget',
            ),
            array('width' => 400, 'height' => 350)
        );
    }

    /**
     * Widget output
     */
    public function widget($args, $instance) {
        $title      = apply_filters('widget_title', empty($instance['title']) ? __('人気記事', 'cielos') : $instance['title']);
        $count      = empty($instance['count']) ? 5 : absint($instance['count']);
        $method     = empty($instance['method']) ? self::METHOD_COMMENTS : $instance['method'];
        $period     = empty($instance['period']) ? self::PERIOD_ALL : $instance['period'];
        $show_count = !empty($instance['show_count']);
        $show_rank  = !empty($instance['show_rank']);
        $categories = empty($instance['categories']) ? array() : $instance['categories'];

        // クエリ引数
        $query_args = array(
            'post_type'           => 'post',
            'posts_per_page'      => $count,
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        );

        // 期間フィルター
        if ($period !== self::PERIOD_ALL) {
            $query_args['date_query'] = array(
                array(
                    'after' => $period === self::PERIOD_WEEK ? '1 week ago' : '1 month ago',
                ),
            );
        }

        // カテゴリーフィルター
        if (!empty($categories)) {
            $query_args['category__in'] = $categories;
        }

        // 集計方法
        if ($method === self::METHOD_COMMENTS) {
            $query_args['orderby'] = 'comment_count';
            $query_args['order']   = 'DESC';
        } elseif ($method === self::METHOD_VIEWS) {
            // カスタムフィールド 'post_views' または 'views' で集計
            $query_args['meta_key'] = apply_filters('cielos_popular_views_meta_key', 'post_views');
            $query_args['orderby']  = 'meta_value_num';
            $query_args['order']    = 'DESC';
        }

        $query = new WP_Query($query_args);

        if (!$query->have_posts()) {
            return;
        }

        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        ?>
        <ul class="cielos-popular-entries cielos-entry-list">
            <?php
            $rank = 1;
            while ($query->have_posts()) : $query->the_post();
                $this->render_entry($rank, $show_rank, $show_count, $method);
                $rank++;
            endwhile;
            ?>
        </ul>
        <?php

        wp_reset_postdata();

        echo $args['after_widget'];
    }

    /**
     * エントリーを描画
     */
    private function render_entry($rank, $show_rank, $show_count, $method) {
        $permalink = get_permalink();
        $title     = get_the_title();
        $thumb_id  = get_post_thumbnail_id();
        $date      = get_the_date('Y.m.d');

        // カウント取得
        $count_value = 0;
        if ($method === self::METHOD_COMMENTS) {
            $count_value = get_comments_number();
        } elseif ($method === self::METHOD_VIEWS) {
            $meta_key = apply_filters('cielos_popular_views_meta_key', 'post_views');
            $count_value = get_post_meta(get_the_ID(), $meta_key, true);
        }

        // ランキングバッジの色
        $rank_colors = array(
            1 => 'bg-amber-500 text-white',       // 金（濃いめ）
            2 => 'bg-gray-500 text-white',        // 銀（濃いめ）
            3 => 'bg-amber-700 text-white',       // 銅
        );
        $rank_class = isset($rank_colors[$rank]) ? $rank_colors[$rank] : 'bg-[var(--c-muted)] text-[var(--c-fg-inv)]';
        ?>

        <li class="cielos-entry-item cielos-popular-item flex gap-3 mb-4 last:mb-0">
            <div class="cielos-entry-thumb-wrap relative flex-shrink-0 w-20 h-20">
                <?php if ($show_rank) : ?>
                    <span class="cielos-rank absolute top-0 left-0 w-6 h-6 flex items-center justify-center text-xs font-bold rounded-sm <?php echo $rank_class; ?> z-10 shadow-sm">
                        <?php echo esc_html($rank); ?>
                    </span>
                <?php endif; ?>

                <?php if ($thumb_id) : ?>
                    <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-thumb block w-full h-full">
                        <?php echo wp_get_attachment_image($thumb_id, 'thumbnail', false, array(
                            'class' => 'w-full h-full object-cover rounded',
                            'alt'   => esc_attr($title),
                            'loading' => 'lazy',
                        )); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="cielos-entry-content flex-1 min-w-0">
                <a href="<?php echo esc_url($permalink); ?>" class="cielos-entry-title block text-sm font-medium text-[var(--c-fg)] hover:text-[var(--c-primary)] line-clamp-2 mb-1">
                    <?php echo esc_html($title); ?>
                </a>
                <div class="cielos-entry-meta flex flex-wrap gap-2 text-xs text-[var(--c-muted)]">
                    <span class="cielos-entry-date"><?php echo esc_html($date); ?></span>
                    <?php if ($show_count && $count_value > 0) : ?>
                        <span class="cielos-entry-count">
                            <?php if ($method === self::METHOD_COMMENTS) : ?>
                                <?php echo number_format($count_value); ?> コメント
                            <?php else : ?>
                                <?php echo number_format($count_value); ?> PV
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <?php
    }

    /**
     * Widget form
     */
    public function form($instance) {
        $defaults = array(
            'title'      => __('人気記事', 'cielos'),
            'count'      => 5,
            'method'     => self::METHOD_COMMENTS,
            'period'     => self::PERIOD_ALL,
            'show_count' => 1,
            'show_rank'  => 1,
            'categories' => array(),
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        $methods = array(
            self::METHOD_COMMENTS => __('コメント数', 'cielos'),
            self::METHOD_VIEWS    => __('ページビュー', 'cielos'),
        );

        $periods = array(
            self::PERIOD_ALL   => __('全期間', 'cielos'),
            self::PERIOD_MONTH => __('過去1ヶ月', 'cielos'),
            self::PERIOD_WEEK  => __('過去1週間', 'cielos'),
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
            <label for="<?php echo $this->get_field_id('method'); ?>"><?php _e('集計方法:', 'cielos'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('method'); ?>" name="<?php echo $this->get_field_name('method'); ?>">
                <?php foreach ($methods as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['method'], $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
            <small style="color: #666;"><?php _e('※ページビューにはカスタムフィールド "post_views" が必要です', 'cielos'); ?></small>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('period'); ?>"><?php _e('集計期間:', 'cielos'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('period'); ?>" name="<?php echo $this->get_field_name('period'); ?>">
                <?php foreach ($periods as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['period'], $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_rank'); ?>" name="<?php echo $this->get_field_name('show_rank'); ?>" value="1" <?php checked($instance['show_rank'], 1); ?> />
            <label for="<?php echo $this->get_field_id('show_rank'); ?>"><?php _e('ランキングバッジを表示', 'cielos'); ?></label>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" value="1" <?php checked($instance['show_count'], 1); ?> />
            <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('カウントを表示', 'cielos'); ?></label>
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

        <?php
    }

    /**
     * Widget update
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title']      = sanitize_text_field($new_instance['title']);
        $instance['count']      = absint($new_instance['count']);
        $instance['method']     = sanitize_text_field($new_instance['method']);
        $instance['period']     = sanitize_text_field($new_instance['period']);
        $instance['show_count'] = !empty($new_instance['show_count']) ? 1 : 0;
        $instance['show_rank']  = !empty($new_instance['show_rank']) ? 1 : 0;
        $instance['categories'] = isset($new_instance['categories']) ? array_map('intval', $new_instance['categories']) : array();

        return $instance;
    }
}

// ウィジェット登録
add_action('widgets_init', function() {
    register_widget('Cielos_Popular_Entries_Widget');
});

/**
 * ページビューをカウント（シンプルな実装）
 * より高度な実装が必要な場合はプラグインを使用してください
 */
add_action('wp_head', function() {
    if (!is_single() || is_admin()) return;

    $post_id = get_the_ID();
    if (!$post_id) return;

    $meta_key = apply_filters('cielos_popular_views_meta_key', 'post_views');
    $count = (int) get_post_meta($post_id, $meta_key, true);
    update_post_meta($post_id, $meta_key, $count + 1);
});

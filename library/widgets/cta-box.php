<?php
/**
 * CTA Box Widget
 * Call-to-Action ボックスを表示
 *
 * @package Cielos
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

class Cielos_CTA_Box_Widget extends WP_Widget {

    /**
     * スタイルプリセット
     */
    const STYLE_DEFAULT  = 'default';   // 標準
    const STYLE_GRADIENT = 'gradient';  // グラデーション
    const STYLE_OUTLINE  = 'outline';   // アウトライン
    const STYLE_MINIMAL  = 'minimal';   // ミニマル

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'cielos_cta_box',
            CIELOS_WIDGET_PREFIX . __('CTAボックス', 'cielos'),
            array(
                'description' => __('アクションを促すボックスを表示します。', 'cielos'),
                'classname'   => 'cielos-cta-box-widget',
            ),
            array('width' => 400, 'height' => 400)
        );
    }

    /**
     * Widget output
     */
    public function widget($args, $instance) {
        $heading      = empty($instance['heading']) ? '' : $instance['heading'];
        $description  = empty($instance['description']) ? '' : $instance['description'];
        $button_text  = empty($instance['button_text']) ? __('詳しく見る', 'cielos') : $instance['button_text'];
        $button_url   = empty($instance['button_url']) ? '' : $instance['button_url'];
        $button_new   = !empty($instance['button_new']);
        $image_id     = empty($instance['image_id']) ? 0 : absint($instance['image_id']);
        $style        = empty($instance['style']) ? self::STYLE_DEFAULT : $instance['style'];
        $show_border  = !empty($instance['show_border']);

        echo $args['before_widget'];

        // スタイルクラス
        $box_classes = array(
            'cielos-cta-box',
            'cielos-cta-box--' . esc_attr($style),
            'rounded-xl',
            'overflow-hidden',
            'my-6',
        );

        // スタイル別のクラス
        switch ($style) {
            case self::STYLE_GRADIENT:
                $box_classes[] = 'bg-gradient-to-br from-[var(--c-primary)] to-[var(--c-primary-dark)] text-white';
                break;
            case self::STYLE_OUTLINE:
                $box_classes[] = 'bg-transparent border-2 border-[var(--c-primary)]';
                break;
            case self::STYLE_MINIMAL:
                $box_classes[] = 'bg-[var(--c-bg)]';
                break;
            default:
                $box_classes[] = 'bg-[var(--c-panel)]';
        }

        if ($show_border && $style !== self::STYLE_OUTLINE) {
            $box_classes[] = 'border border-[var(--c-border)]';
        }
        ?>

        <div class="<?php echo implode(' ', $box_classes); ?>">
            <?php if ($image_id) : ?>
                <div class="cielos-cta-image">
                    <?php echo wp_get_attachment_image($image_id, 'medium_large', false, array(
                        'class' => 'w-full h-auto object-cover',
                        'alt'   => esc_attr($heading),
                        'loading' => 'lazy',
                    )); ?>
                </div>
            <?php endif; ?>

            <div class="cielos-cta-content p-6 <?php echo $image_id ? '' : 'text-center'; ?>">
                <?php if ($heading) : ?>
                    <h3 class="cielos-cta-heading text-xl font-bold mb-3 <?php echo $style === self::STYLE_GRADIENT ? 'text-white' : 'text-[var(--c-fg)]'; ?>">
                        <?php echo esc_html($heading); ?>
                    </h3>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <div class="cielos-cta-description text-sm mb-4 <?php echo $style === self::STYLE_GRADIENT ? 'text-white/90' : 'text-[var(--c-muted)]'; ?>">
                        <?php echo wp_kses_post(nl2br($description)); ?>
                    </div>
                <?php endif; ?>

                <?php if ($button_url) :
                    $btn_classes = 'cielos-cta-button inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg font-medium transition-all';

                    if ($style === self::STYLE_GRADIENT) {
                        $btn_classes .= ' bg-white text-[var(--c-primary)] hover:bg-white/90';
                    } else {
                        $btn_classes .= ' bg-[var(--c-primary)] text-white hover:bg-[var(--c-primary-dark)]';
                    }
                ?>
                    <a href="<?php echo esc_url($button_url); ?>"
                       class="<?php echo $btn_classes; ?>"
                       <?php echo $button_new ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <?php echo esc_html($button_text); ?>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php
        echo $args['after_widget'];
    }

    /**
     * Widget form
     */
    public function form($instance) {
        $defaults = array(
            'heading'     => '',
            'description' => '',
            'button_text' => __('詳しく見る', 'cielos'),
            'button_url'  => '',
            'button_new'  => 0,
            'image_id'    => 0,
            'style'       => self::STYLE_DEFAULT,
            'show_border' => 1,
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        $styles = array(
            self::STYLE_DEFAULT  => __('標準', 'cielos'),
            self::STYLE_GRADIENT => __('グラデーション', 'cielos'),
            self::STYLE_OUTLINE  => __('アウトライン', 'cielos'),
            self::STYLE_MINIMAL  => __('ミニマル', 'cielos'),
        );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('heading'); ?>"><?php _e('見出し:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('heading'); ?>" name="<?php echo $this->get_field_name('heading'); ?>" type="text" value="<?php echo esc_attr($instance['heading']); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('説明文:', 'cielos'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" rows="4"><?php echo esc_textarea($instance['description']); ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('ボタンテキスト:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo esc_attr($instance['button_text']); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e('ボタンURL:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="url" value="<?php echo esc_url($instance['button_url']); ?>" placeholder="https://" />
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('button_new'); ?>" name="<?php echo $this->get_field_name('button_new'); ?>" value="1" <?php checked($instance['button_new'], 1); ?> />
            <label for="<?php echo $this->get_field_id('button_new'); ?>"><?php _e('新しいタブで開く', 'cielos'); ?></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image_id'); ?>"><?php _e('画像ID:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image_id'); ?>" name="<?php echo $this->get_field_name('image_id'); ?>" type="number" value="<?php echo esc_attr($instance['image_id']); ?>" placeholder="<?php _e('メディアライブラリのID', 'cielos'); ?>" />
            <small style="color: #666;"><?php _e('メディアライブラリの画像IDを入力', 'cielos'); ?></small>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('スタイル:', 'cielos'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
                <?php foreach ($styles as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['style'], $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_border'); ?>" name="<?php echo $this->get_field_name('show_border'); ?>" value="1" <?php checked($instance['show_border'], 1); ?> />
            <label for="<?php echo $this->get_field_id('show_border'); ?>"><?php _e('ボーダーを表示', 'cielos'); ?></label>
        </p>

        <?php
    }

    /**
     * Widget update
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['heading']     = sanitize_text_field($new_instance['heading']);
        $instance['description'] = wp_kses_post($new_instance['description']);
        $instance['button_text'] = sanitize_text_field($new_instance['button_text']);
        $instance['button_url']  = esc_url_raw($new_instance['button_url']);
        $instance['button_new']  = !empty($new_instance['button_new']) ? 1 : 0;
        $instance['image_id']    = absint($new_instance['image_id']);
        $instance['style']       = sanitize_text_field($new_instance['style']);
        $instance['show_border'] = !empty($new_instance['show_border']) ? 1 : 0;

        return $instance;
    }
}

// ウィジェット登録
add_action('widgets_init', function() {
    register_widget('Cielos_CTA_Box_Widget');
});

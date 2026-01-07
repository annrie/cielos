<?php
/**
 * Profile Widget
 * 著者プロフィールを表示
 *
 * @package Cielos
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

class Cielos_Profile_Widget extends WP_Widget {

    /**
     * レイアウト
     */
    const LAYOUT_CARD     = 'card';      // カード型
    const LAYOUT_SIDEBAR  = 'sidebar';   // サイドバー用コンパクト
    const LAYOUT_BANNER   = 'banner';    // 横長バナー

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'cielos_profile',
            CIELOS_WIDGET_PREFIX . __('プロフィール', 'cielos'),
            array(
                'description' => __('著者のプロフィールを表示します。', 'cielos'),
                'classname'   => 'cielos-profile-widget',
            ),
            array('width' => 400, 'height' => 400)
        );
    }

    /**
     * Widget output
     */
    public function widget($args, $instance) {
        $title        = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
        $name         = empty($instance['name']) ? get_bloginfo('name') : $instance['name'];
        $description  = empty($instance['description']) ? '' : $instance['description'];
        $avatar_id    = empty($instance['avatar_id']) ? 0 : absint($instance['avatar_id']);
        $layout       = empty($instance['layout']) ? self::LAYOUT_CARD : $instance['layout'];
        $show_sns     = !empty($instance['show_sns']);
        $sns_twitter  = empty($instance['sns_twitter']) ? '' : $instance['sns_twitter'];
        $sns_facebook = empty($instance['sns_facebook']) ? '' : $instance['sns_facebook'];
        $sns_instagram = empty($instance['sns_instagram']) ? '' : $instance['sns_instagram'];
        $sns_youtube  = empty($instance['sns_youtube']) ? '' : $instance['sns_youtube'];
        $sns_github   = empty($instance['sns_github']) ? '' : $instance['sns_github'];
        $profile_url  = empty($instance['profile_url']) ? '' : $instance['profile_url'];

        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        // レイアウト別クラス
        $container_class = 'cielos-profile cielos-profile--' . esc_attr($layout);

        switch ($layout) {
            case self::LAYOUT_BANNER:
                $this->render_banner($name, $description, $avatar_id, $show_sns, compact('sns_twitter', 'sns_facebook', 'sns_instagram', 'sns_youtube', 'sns_github'), $profile_url);
                break;
            case self::LAYOUT_SIDEBAR:
                $this->render_sidebar($name, $description, $avatar_id, $show_sns, compact('sns_twitter', 'sns_facebook', 'sns_instagram', 'sns_youtube', 'sns_github'), $profile_url);
                break;
            default:
                $this->render_card($name, $description, $avatar_id, $show_sns, compact('sns_twitter', 'sns_facebook', 'sns_instagram', 'sns_youtube', 'sns_github'), $profile_url);
        }

        echo $args['after_widget'];
    }

    /**
     * カード型レイアウト
     */
    private function render_card($name, $description, $avatar_id, $show_sns, $sns, $profile_url) {
        ?>
        <div class="cielos-profile cielos-profile--card bg-[var(--c-panel)] rounded-xl border border-[var(--c-border)] overflow-hidden">
            <!-- ヘッダー背景 -->
            <div class="cielos-profile-header h-20 bg-gradient-to-r from-[var(--c-primary)] to-[var(--c-primary-dark)]"></div>

            <div class="cielos-profile-body px-6 pb-6 -mt-10">
                <!-- アバター -->
                <div class="cielos-profile-avatar w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden border-4 border-[var(--c-panel)] shadow-lg">
                    <?php if ($avatar_id) : ?>
                        <?php echo wp_get_attachment_image($avatar_id, 'thumbnail', false, array(
                            'class' => 'w-full h-full object-cover',
                            'alt'   => esc_attr($name),
                        )); ?>
                    <?php else : ?>
                        <div class="w-full h-full bg-[var(--c-muted)] flex items-center justify-center text-[var(--c-fg-inv)] text-2xl font-bold">
                            <?php echo esc_html(mb_substr($name, 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- 名前 -->
                <h4 class="cielos-profile-name text-lg font-bold text-center text-[var(--c-fg)] mb-2">
                    <?php echo esc_html($name); ?>
                </h4>

                <!-- 説明 -->
                <?php if ($description) : ?>
                    <p class="cielos-profile-description text-sm text-center text-[var(--c-muted)] mb-4">
                        <?php echo wp_kses_post(nl2br($description)); ?>
                    </p>
                <?php endif; ?>

                <!-- SNSリンク -->
                <?php if ($show_sns) : ?>
                    <?php $this->render_sns_links($sns); ?>
                <?php endif; ?>

                <!-- プロフィールリンク -->
                <?php if ($profile_url) : ?>
                    <a href="<?php echo esc_url($profile_url); ?>" class="cielos-profile-link block w-full text-center mt-4 px-4 py-2 bg-[var(--c-primary)] text-white rounded-lg hover:bg-[var(--c-primary-dark)] transition-colors text-sm font-medium">
                        <?php _e('プロフィールを見る', 'cielos'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /**
     * サイドバー用コンパクトレイアウト
     */
    private function render_sidebar($name, $description, $avatar_id, $show_sns, $sns, $profile_url) {
        ?>
        <div class="cielos-profile cielos-profile--sidebar">
            <div class="flex items-start gap-4">
                <!-- アバター -->
                <div class="cielos-profile-avatar w-16 h-16 flex-shrink-0 rounded-full overflow-hidden border-2 border-[var(--c-border)]">
                    <?php if ($avatar_id) : ?>
                        <?php echo wp_get_attachment_image($avatar_id, 'thumbnail', false, array(
                            'class' => 'w-full h-full object-cover',
                            'alt'   => esc_attr($name),
                        )); ?>
                    <?php else : ?>
                        <div class="w-full h-full bg-[var(--c-muted)] flex items-center justify-center text-[var(--c-fg-inv)] text-xl font-bold">
                            <?php echo esc_html(mb_substr($name, 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex-1 min-w-0">
                    <!-- 名前 -->
                    <h4 class="cielos-profile-name text-base font-bold text-[var(--c-fg)] mb-1">
                        <?php echo esc_html($name); ?>
                    </h4>

                    <!-- 説明 -->
                    <?php if ($description) : ?>
                        <p class="cielos-profile-description text-xs text-[var(--c-muted)] line-clamp-3">
                            <?php echo wp_kses_post($description); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SNSリンク -->
            <?php if ($show_sns) : ?>
                <div class="mt-4">
                    <?php $this->render_sns_links($sns, 'justify-start'); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * バナー型レイアウト
     */
    private function render_banner($name, $description, $avatar_id, $show_sns, $sns, $profile_url) {
        ?>
        <div class="cielos-profile cielos-profile--banner bg-[var(--c-panel)] rounded-xl border border-[var(--c-border)] p-6">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <!-- アバター -->
                <div class="cielos-profile-avatar w-24 h-24 flex-shrink-0 rounded-full overflow-hidden border-4 border-[var(--c-primary)]">
                    <?php if ($avatar_id) : ?>
                        <?php echo wp_get_attachment_image($avatar_id, 'thumbnail', false, array(
                            'class' => 'w-full h-full object-cover',
                            'alt'   => esc_attr($name),
                        )); ?>
                    <?php else : ?>
                        <div class="w-full h-full bg-[var(--c-muted)] flex items-center justify-center text-[var(--c-fg-inv)] text-3xl font-bold">
                            <?php echo esc_html(mb_substr($name, 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <!-- 名前 -->
                    <h4 class="cielos-profile-name text-xl font-bold text-[var(--c-fg)] mb-2">
                        <?php echo esc_html($name); ?>
                    </h4>

                    <!-- 説明 -->
                    <?php if ($description) : ?>
                        <p class="cielos-profile-description text-sm text-[var(--c-muted)] mb-4">
                            <?php echo wp_kses_post(nl2br($description)); ?>
                        </p>
                    <?php endif; ?>

                    <!-- SNSリンク -->
                    <?php if ($show_sns) : ?>
                        <?php $this->render_sns_links($sns, 'justify-center md:justify-start'); ?>
                    <?php endif; ?>
                </div>

                <!-- プロフィールリンク -->
                <?php if ($profile_url) : ?>
                    <a href="<?php echo esc_url($profile_url); ?>" class="cielos-profile-link flex-shrink-0 px-6 py-3 bg-[var(--c-primary)] text-white rounded-lg hover:bg-[var(--c-primary-dark)] transition-colors font-medium">
                        <?php _e('詳細を見る', 'cielos'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /**
     * SNSリンクを描画
     */
    private function render_sns_links($sns, $justify = 'justify-center') {
        $links = array();

        if (!empty($sns['sns_twitter'])) {
            $links[] = array(
                'url'   => 'https://twitter.com/' . $sns['sns_twitter'],
                'icon'  => 'fab fa-twitter',
                'label' => 'Twitter',
                'color' => 'hover:text-[#1DA1F2]',
            );
        }
        if (!empty($sns['sns_facebook'])) {
            $links[] = array(
                'url'   => 'https://facebook.com/' . $sns['sns_facebook'],
                'icon'  => 'fab fa-facebook-f',
                'label' => 'Facebook',
                'color' => 'hover:text-[#4267B2]',
            );
        }
        if (!empty($sns['sns_instagram'])) {
            $links[] = array(
                'url'   => 'https://instagram.com/' . $sns['sns_instagram'],
                'icon'  => 'fab fa-instagram',
                'label' => 'Instagram',
                'color' => 'hover:text-[#E4405F]',
            );
        }
        if (!empty($sns['sns_youtube'])) {
            $links[] = array(
                'url'   => 'https://youtube.com/' . $sns['sns_youtube'],
                'icon'  => 'fab fa-youtube',
                'label' => 'YouTube',
                'color' => 'hover:text-[#FF0000]',
            );
        }
        if (!empty($sns['sns_github'])) {
            $links[] = array(
                'url'   => 'https://github.com/' . $sns['sns_github'],
                'icon'  => 'fab fa-github',
                'label' => 'GitHub',
                'color' => 'hover:text-[#333]',
            );
        }

        if (empty($links)) return;
        ?>

        <div class="cielos-profile-sns flex <?php echo $justify; ?> gap-3">
            <?php foreach ($links as $link) : ?>
                <a href="<?php echo esc_url($link['url']); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-10 h-10 flex items-center justify-center rounded-full bg-[var(--c-bg)] text-[var(--c-muted)] <?php echo $link['color']; ?> transition-colors"
                   aria-label="<?php echo esc_attr($link['label']); ?>">
                    <i class="<?php echo esc_attr($link['icon']); ?>" aria-hidden="true"></i>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }

    /**
     * Widget form
     */
    public function form($instance) {
        $defaults = array(
            'title'         => '',
            'name'          => '',
            'description'   => '',
            'avatar_id'     => 0,
            'layout'        => self::LAYOUT_CARD,
            'show_sns'      => 1,
            'sns_twitter'   => '',
            'sns_facebook'  => '',
            'sns_instagram' => '',
            'sns_youtube'   => '',
            'sns_github'    => '',
            'profile_url'   => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        $layouts = array(
            self::LAYOUT_CARD    => __('カード型', 'cielos'),
            self::LAYOUT_SIDEBAR => __('コンパクト', 'cielos'),
            self::LAYOUT_BANNER  => __('バナー型', 'cielos'),
        );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('ウィジェットタイトル:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" placeholder="<?php _e('空欄でタイトル非表示', 'cielos'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('名前:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo esc_attr($instance['name']); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('説明:', 'cielos'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" rows="4"><?php echo esc_textarea($instance['description']); ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('avatar_id'); ?>"><?php _e('アバター画像ID:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('avatar_id'); ?>" name="<?php echo $this->get_field_name('avatar_id'); ?>" type="number" value="<?php echo esc_attr($instance['avatar_id']); ?>" placeholder="<?php _e('メディアライブラリのID', 'cielos'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('レイアウト:', 'cielos'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
                <?php foreach ($layouts as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['layout'], $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('profile_url'); ?>"><?php _e('プロフィールページURL:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('profile_url'); ?>" name="<?php echo $this->get_field_name('profile_url'); ?>" type="url" value="<?php echo esc_url($instance['profile_url']); ?>" placeholder="https://" />
        </p>

        <hr />

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_sns'); ?>" name="<?php echo $this->get_field_name('show_sns'); ?>" value="1" <?php checked($instance['show_sns'], 1); ?> />
            <label for="<?php echo $this->get_field_id('show_sns'); ?>"><?php _e('SNSリンクを表示', 'cielos'); ?></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sns_twitter'); ?>"><?php _e('Twitter ユーザー名:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('sns_twitter'); ?>" name="<?php echo $this->get_field_name('sns_twitter'); ?>" type="text" value="<?php echo esc_attr($instance['sns_twitter']); ?>" placeholder="@なしで入力" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sns_facebook'); ?>"><?php _e('Facebook ユーザー名:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('sns_facebook'); ?>" name="<?php echo $this->get_field_name('sns_facebook'); ?>" type="text" value="<?php echo esc_attr($instance['sns_facebook']); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sns_instagram'); ?>"><?php _e('Instagram ユーザー名:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('sns_instagram'); ?>" name="<?php echo $this->get_field_name('sns_instagram'); ?>" type="text" value="<?php echo esc_attr($instance['sns_instagram']); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sns_youtube'); ?>"><?php _e('YouTube チャンネル:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('sns_youtube'); ?>" name="<?php echo $this->get_field_name('sns_youtube'); ?>" type="text" value="<?php echo esc_attr($instance['sns_youtube']); ?>" placeholder="channel/ または @ユーザー名" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sns_github'); ?>"><?php _e('GitHub ユーザー名:', 'cielos'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('sns_github'); ?>" name="<?php echo $this->get_field_name('sns_github'); ?>" type="text" value="<?php echo esc_attr($instance['sns_github']); ?>" />
        </p>

        <?php
    }

    /**
     * Widget update
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title']         = sanitize_text_field($new_instance['title']);
        $instance['name']          = sanitize_text_field($new_instance['name']);
        $instance['description']   = wp_kses_post($new_instance['description']);
        $instance['avatar_id']     = absint($new_instance['avatar_id']);
        $instance['layout']        = sanitize_text_field($new_instance['layout']);
        $instance['show_sns']      = !empty($new_instance['show_sns']) ? 1 : 0;
        $instance['sns_twitter']   = sanitize_text_field($new_instance['sns_twitter']);
        $instance['sns_facebook']  = sanitize_text_field($new_instance['sns_facebook']);
        $instance['sns_instagram'] = sanitize_text_field($new_instance['sns_instagram']);
        $instance['sns_youtube']   = sanitize_text_field($new_instance['sns_youtube']);
        $instance['sns_github']    = sanitize_text_field($new_instance['sns_github']);
        $instance['profile_url']   = esc_url_raw($new_instance['profile_url']);

        return $instance;
    }
}

// ウィジェット登録
add_action('widgets_init', function() {
    register_widget('Cielos_Profile_Widget');
});

<?php
/**
 * Related Posts - カテゴリー/タグスコアリング方式
 *
 * 一般記事（post）用の関連記事機能
 * カテゴリーとタグの共通数でスコアリングして関連記事を取得
 *
 * @package Cielos
 * @since   1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class Cielos_Related_Posts_Scoring {

    /**
     * キャッシュキープレフィックス
     */
    private string $cache_prefix = 'cielos_related_';

    /**
     * キャッシュ有効期限（秒）
     */
    private int $cache_expiration = DAY_IN_SECONDS * 7;

    /**
     * シングルトンインスタンス
     */
    private static ?self $instance = null;

    /**
     * インスタンス取得
     */
    public static function get_instance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * コンストラクタ
     */
    private function __construct() {
        // 投稿保存時にキャッシュクリア
        add_action('save_post', [$this, 'clear_cache_on_save'], 10, 2);
    }

    /**
     * 投稿保存時にキャッシュをクリア
     */
    public function clear_cache_on_save(int $post_id, WP_Post $post): void {
        if ($post->post_type === 'post') {
            $this->clear_related_cache($post_id);
        }
    }

    /**
     * 関連記事キャッシュをクリア
     */
    public function clear_related_cache(int $post_id): void {
        for ($i = 1; $i <= 20; $i++) {
            delete_transient($this->cache_prefix . $post_id . '_' . $i);
        }
    }

    /**
     * 関連記事を取得（カテゴリー/タグスコアリング）
     *
     * @param int $post_id 投稿ID
     * @param int $count 取得件数
     * @return array 関連記事の配列 [['post_id' => int, 'score' => int], ...]
     */
    public function get_related_posts(int $post_id, int $count = 6): array {
        $cache_key = $this->cache_prefix . $post_id . '_' . $count;
        $cached = get_transient($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        $post = get_post($post_id);
        if (!$post || $post->post_type !== 'post') {
            return [];
        }

        // カテゴリーとタグを取得
        $categories = wp_get_post_categories($post_id, ['fields' => 'ids']);
        $tags = wp_get_post_tags($post_id, ['fields' => 'ids']);

        if (empty($categories) && empty($tags)) {
            return [];
        }

        // 候補記事を取得（カテゴリーまたはタグが一致するもの）
        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'post__not_in'   => [$post_id],
            'posts_per_page' => 50, // 多めに取得してスコアリング
            'fields'         => 'ids',
        ];

        // tax_query を構築
        $tax_query = ['relation' => 'OR'];

        if (!empty($categories)) {
            $tax_query[] = [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
            ];
        }

        if (!empty($tags)) {
            $tax_query[] = [
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $tags,
            ];
        }

        $args['tax_query'] = $tax_query;

        $candidates = get_posts($args);
        $scored = [];

        foreach ($candidates as $pid) {
            $score = 0;

            // カテゴリー一致: 重み 2
            $post_cats = wp_get_post_categories($pid, ['fields' => 'ids']);
            $score += count(array_intersect($categories, $post_cats)) * 2;

            // タグ一致: 重み 1
            $post_tags = wp_get_post_tags($pid, ['fields' => 'ids']);
            $score += count(array_intersect($tags, $post_tags));

            if ($score > 0) {
                $scored[] = [
                    'post_id' => $pid,
                    'score'   => $score,
                ];
            }
        }

        // スコア順でソート
        usort($scored, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $result = array_slice($scored, 0, $count);

        // キャッシュに保存
        set_transient($cache_key, $result, $this->cache_expiration);

        return $result;
    }
}

/**
 * グローバルアクセス用ヘルパー
 */
function cielos_related_scoring(): Cielos_Related_Posts_Scoring {
    return Cielos_Related_Posts_Scoring::get_instance();
}

/**
 * 関連記事を表示（テンプレートタグ）
 *
 * @param int|null $post_id 投稿ID（省略時は現在の投稿）
 * @param int $count 表示件数
 * @param string $title セクションタイトル
 */
function cielos_display_related_posts(?int $post_id = null, int $count = 6, string $title = '関連記事'): void {
    if ($post_id === null) {
        $post_id = get_the_ID();
    }

    $related = cielos_related_scoring()->get_related_posts($post_id, $count);

    if (empty($related)) {
        return;
    }
    ?>
    <section class="related-posts mt-12">
        <h2 class="text-2xl font-bold mb-6 border-b-2 border-gray-300 dark:border-gray-600 pb-2">
            <?php echo esc_html($title); ?>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($related as $item) :
                $rid = $item['post_id'];
                $thumb_url = get_the_post_thumbnail_url($rid, 'medium');
            ?>
            <a href="<?php echo esc_url(get_permalink($rid)); ?>"
               class="related-post-card block bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                <?php if ($thumb_url) : ?>
                <div class="aspect-video overflow-hidden">
                    <img src="<?php echo esc_url($thumb_url); ?>"
                         alt="<?php echo esc_attr(get_the_title($rid)); ?>"
                         class="w-full h-full object-cover"
                         loading="lazy" decoding="async">
                </div>
                <?php else : ?>
                <div class="aspect-video bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                    <span class="text-gray-400 dark:text-gray-500 text-4xl">📝</span>
                </div>
                <?php endif; ?>
                <div class="p-3">
                    <h3 class="text-sm font-medium line-clamp-2 text-gray-800 dark:text-gray-200">
                        <?php echo esc_html(get_the_title($rid)); ?>
                    </h3>
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">
                        <?php echo esc_html(get_the_date('Y.m.d', $rid)); ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

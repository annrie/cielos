<?php
/**
 * The sidebar containing the top widget area and data for SidebarTop Vue component
 *
 * @package Cielos
 * @since unomoon 1.0.0
 */

$sidebar_cat_list = array(
    'web'         => 4,
    'machaki'     => 4,
    'information' => 4,
);

$sidebar_data = [];

foreach ($sidebar_cat_list as $sidebar_cat_name => $sidebar_cat_num) :
    $category_obj = get_category_by_slug($sidebar_cat_name);
    $category_name = esc_html($category_obj->name);
    $category_link = get_term_link($sidebar_cat_name, 'category');

    $posts_data = [];
    $sidebar_posts = new WP_Query('posts_per_page=' . $sidebar_cat_num . '&category_name=' . $sidebar_cat_name);

    if ($sidebar_posts->have_posts()) :
        while ($sidebar_posts->have_posts()) :
            $sidebar_posts->the_post();
            // Get thumbnail URL with fallback
            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'fp-small');
            if (empty($thumbnail_url)) {
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            }
            if (empty($thumbnail_url)) {
                $thumbnail_url = get_template_directory_uri() . '/public/images/category/default.jpg';
            }

            $formatted_date = get_the_date('Y.m.d (D)');

            // Truncate excerpt to 30 characters
            $excerpt = strip_tags(get_the_excerpt());
            $limit = 120;
            if (mb_strlen($excerpt) > $limit) {
                $excerpt = mb_substr($excerpt, 0, $limit) . '...';
            }

            $posts_data[] = [
                'date'      => get_the_time('Y-m-d'),
                'formatted_date' => $formatted_date,
                'title'     => get_the_title(),
                'permalink' => get_the_permalink(),
                'excerpt'   => $excerpt,
                'thumbnail_url' => esc_url($thumbnail_url),
                'thumbnail_alt' => esc_attr(get_the_title()),
                'thumbnail_title' => esc_attr(get_the_title()),
            ];
        endwhile;
    endif;
    wp_reset_postdata();

    $sidebar_data[] = [
        'category_slug' => $sidebar_cat_name,
        'category_name' => $category_name,
        'category_link' => $category_link,
        'posts'         => $posts_data,
    ];
endforeach;
?>

<aside class="sidebar lg:col-span-1" id="side-nav">
    <div id="header-widget-area" class="space-y-6">
        <div class="widget-search"> <?php get_template_part('searchform'); ?> </div>
    </div><!-- #header-widget-area end -->

    <div id="primary" class="widget-area">
        <div id="sidebar-top-vue-app"></div>
        <script>
            window.sidebarTopData = <?php echo json_encode($sidebar_data); ?>;
        </script>
    </div><!-- #primary end -->
</aside>

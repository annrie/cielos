<?php
/**
 * The default template for displaying page content
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

?>

<meta property="og:type" content="blog">
<?php
if (is_single()) {
    if (have_posts()) :
        while (have_posts()) :
            the_post();
    echo '<meta property = "og:description" content = \'" str_replace( \"\n\", \"\", mb_substr(get_the_excerpt(), 0, 160) ."\'>';
    echo "\n";
    endwhile;
    endif;
    echo '<meta property = "og:title" content="';
    the_title();
    echo '">';
    echo "\n";
    echo '<meta property = "og:url" content = "';
    the_permalink();
    echo '">';
    echo "\n";
} else {
    echo '<meta property = "og:description" content="';
    bloginfo('description');
    echo '">';
    echo "\n";
    echo '<meta property = "og:title" content="';
    bloginfo('name');
    echo '">';
    echo '\n';
    echo '<meta property = "og:url" content="';
    echo esc_url(home_url());
    echo '">';
    echo "\n";
}
$str                = $post->post_content;
    $search_pattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';
if (is_single()) {
    if (has_post_thumbnail()) {
        $image_id = get_post_thumbnail_id();
        $image    = wp_get_attachment_image_src($image_id, 'full');
        echo '<meta property = "og:image" content = \'".$image[0]."\'>';
        echo "\n";
    } elseif (preg_match($search_pattern, $str, $imgurl) && ! is_archive()) {
        echo '<meta property = "og:image" content = \'".$imgurl[2]."\'>';
        echo "\n";
    } else {
        $ogp_image = get_template_directory_uri() . '/images/og-image.png';
        echo '<meta property = "og:image" content = \'".$ogp_image."\'>';
        echo "\n";
    }
} else {
    if (get_header_image()) {
        echo '<meta property = "og:image" content=\'".get_header_image()."\'>';
        echo "\n";
    } else {
        echo '<meta property = "og:image" content=\'".get_template_directory_uri().\'/screenshot.png\'>"';
        echo "\n";
    }
}
?>
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<meta property="og:locale" content="ja_JP" />
<meta property="fb:app_id" content="207844090171446">
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@muraie_jin">

<?php
$permalink = get_permalink();
$title = get_the_title();
?>
<div class="cielos-social-share-buttons flex space-x-2">
    <div class="cielos-social-share-button" data-platform="hatena" data-url="<?php echo esc_url($permalink); ?>" data-title="<?php echo esc_attr($title); ?>"></div>
    <div class="cielos-social-share-button" data-platform="twitter" data-url="<?php echo esc_url($permalink); ?>" data-title="<?php echo esc_attr($title); ?>"></div>
    <div class="cielos-social-share-button" data-platform="facebook" data-url="<?php echo esc_url($permalink); ?>" data-title="<?php echo esc_attr($title); ?>"></div>
</div>
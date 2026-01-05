<?php
/**
 * The template for displaying additional book information for machaki posts
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

// 1) 初版（基本情報）
$has_primary = (
  !empty($post->collection_of_books)
  || !empty($post->publisher)
  || !empty(get_field('date_of_issue'))
  || !empty($post->binding)
  || !empty($post->fm_img_1)
);

if ($has_primary) :
  $img1 = !empty($post->fm_img_1) ? wp_get_attachment_image_src($post->fm_img_1, 'medium_large') : null;
?>
<section class="primary-book mt-8 not-prose">
  <div class="grid gap-6 md:[grid-template-columns:max-content_1fr] justify-center items-start">
    <div>
      <?php if ($img1) : ?>
        <img class="w-full h-auto rounded-lg shadow-md" src="<?php echo esc_url($img1[0]); ?>" alt="<?php echo esc_attr($post->collection_of_books ?: get_the_title()); ?>" loading="lazy" decoding="async">
      <?php endif; ?>
    </div>
    <div>
      <table class="w-full text-left text-sm">
        <tbody class="align-top">
          <?php if (!empty($post->collection_of_books)) : ?>
          <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="py-2 pr-4 font-semibold w-1/4">叢書</th>
            <td class="py-2 text-gray-800 dark:text-gray-200"><?php echo esc_html($post->collection_of_books); ?></td>
          </tr>
          <?php endif; ?>
          <?php if (!empty($post->publisher)) : ?>
          <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="py-2 pr-4 font-semibold">出版社</th>
            <td class="py-2 text-gray-800 dark:text-gray-200"><?php echo esc_html($post->publisher); ?></td>
          </tr>
          <?php endif; ?>
          <?php $date0 = get_field('date_of_issue'); if (!empty($date0)) : $d0 = date_create($date0); ?>
          <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="py-2 pr-4 font-semibold">発行日</th>
            <td class="py-2 text-gray-800 dark:text-gray-200"><?php echo esc_html(date_format($d0, 'Y/m/d')); ?></td>
          </tr>
          <?php endif; ?>
          <?php if (!empty($post->binding)) : ?>
          <tr>
            <th class="py-2 pr-4 font-semibold">装幀</th>
            <td class="py-2 text-gray-800 dark:text-gray-200"><?php echo esc_html($post->binding); ?></td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
// 1.5) 収録作品 / 内容紹介（本文とは別にカスタムフィールドで管理されている想定）
if (!empty($post->works_in_the_collection)) : ?>
  <section class="mt-12 prose dark:prose-invert max-w-none">
    <h2 class="text-2xl font-bold mb-4 border-b-2 border-gray-300 dark:border-gray-600 pb-2">収録作品</h2>
    <blockquote class="machaki-works mt-4">
      <?php echo $post->works_in_the_collection; ?>
    </blockquote>
  </section>
<?php endif; ?>

<?php if (!empty($post->introducing)) : ?>
  <section class="mt-12 prose dark:prose-invert max-w-none">
    <h2 class="text-2xl font-bold mb-4 border-b-2 border-gray-300 dark:border-gray-600 pb-2">内容紹介</h2>
    <div class="mt-4">
      <?php echo wp_kses_post($post->introducing); ?>
    </div>
  </section>
<?php endif; ?>

<?php
// 2) 文庫・再刊（2〜8）
$has_reprint = false;
for ($i = 2; $i <= 8; $i++) {
  $cf = 'collection_of_books' . $i;
  if (!empty($post->$cf)) { $has_reprint = true; break; }
}

if ($has_reprint) :
?>
<div class="reprint-info mt-12">
  <h3 class="text-2xl font-bold mb-6 border-b-2 border-gray-300 dark:border-gray-600 pb-2">文庫・再刊情報</h3>
  <?php for ($i = 2; $i <= 8; $i++) {
    $collection_field = 'collection_of_books' . $i;
    if (empty($post->$collection_field)) continue;
    $publisher_field = 'publisher' . $i;
    $date_field      = 'date_of_issue' . $i;
    $binding_field   = 'binding' . $i;
    $image_field     = 'fm_img_' . $i;
    $appendix_field  = 'appendix' . $i;
    $image_url = !empty($post->$image_field) ? wp_get_attachment_image_src($post->$image_field, 'medium') : null;
  ?>
  <section class="reprint-item mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php if ($image_url) : ?>
      <div class="reprint-image md:col-span-1">
        <img class="w-full h-auto rounded-md shadow-lg" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($post->$collection_field); ?>" loading="lazy" decoding="async">
      </div>
      <?php endif; ?>
      <div class="reprint-details md:col-span-2">
        <table class="w-full text-left text-sm">
          <tbody class="align-top">
            <tr class="border-b border-gray-200 dark:border-gray-700">
              <th class="py-2 pr-4 font-semibold w-1/4">叢書</th>
              <td class="py-2 text-gray-800 dark:text-gray-200"><?php echo esc_html($post->$collection_field); ?></td>
            </tr>
            <tr class="border-b border-gray-200 dark:border-gray-700">
              <th class="py-2 pr-4 font-semibold">出版社</th>
              <td class="py-2 text-gray-800 dark:text-gray-200"><?php echo esc_html($post->$publisher_field); ?></td>
            </tr>
            <tr class="border-b border-gray-200 dark:border-gray-700">
              <th class="py-2 pr-4 font-semibold">発行日</th>
              <td class="py-2 text-gray-800 dark:text-gray-200">
                <?php $date_value = get_field($date_field); if ($date_value) { $date = date_create($date_value); echo esc_html(date_format($date, 'Y/m/d')); } ?>
              </td>
            </tr>
            <tr>
              <th class="py-2 pr-4 font-semibold">装幀</th>
              <td class="py-2 text-gray-800 dark:text-gray-200"><?php echo esc_html($post->$binding_field); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?php if (!empty($post->$appendix_field)) {
      echo '<div class="prose dark:prose-invert max-w-none mt-6">' . wp_kses_post($post->$appendix_field) . '</div>';
    } ?>
  </section>
  <?php } // end for ?>
</div>
<?php endif; ?>

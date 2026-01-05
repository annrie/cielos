<?php
/**
 * The template for displaying machaki archive content
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow duration-300 mb-8'); ?>>
  <div class="p-6">
    <header class="mb-10">
      <h2 class="entry-title heading13-4 font-normal text-h4" style="--h13-4-bc: #87cefa; --h13-4-base-color: #fff; --h13-4-bg: #87cefa;">
        <a href="<?php the_permalink(); ?>" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200"><?php the_title(); ?></a>
      </h2>
    </header>

    <div class="entry-content not-prose">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <?php if (has_post_thumbnail() || $post->fm_img_1) : ?>
            <a href="<?php the_permalink(); ?>">
              <figure class="overflow-hidden rounded-lg aspect-[3/4] bg-gray-100 dark:bg-gray-700">
                <?php
                $url = wp_get_attachment_image_src($post->fm_img_1, 'medium_large');
                if ($url) {
                    echo "<img class='w-full h-full object-cover hover:scale-105 transition-transform duration-300' src='{$url[0]}' alt='' loading=\"lazy\" decoding=\"async\" />";
                } else {
                    the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300','loading'=>'lazy','decoding'=>'async']);
                }
                ?>
              </figure>
            </a>
          <?php endif; ?>
        </div>
        <div class="machaki-archive-table">
          <table>
            <tbody>
              <?php if (!empty($post->collection_of_books)) : ?>
              <tr>
                <th>叢書</th>
                <td><?php echo esc_html($post->collection_of_books); ?></td>
              </tr>
              <?php endif; ?>
              <?php if (!empty($post->publisher)) : ?>
              <tr>
                <th>出版社</th>
                <td><?php echo esc_html($post->publisher); ?></td>
              </tr>
              <?php endif; ?>
              <?php $date = get_field('date_of_issue'); if (!empty($date)) : $d = date_create($date); ?>
              <tr>
                <th>発行日</th>
                <td><?php echo esc_html(date_format($d, 'Y/m/d')); ?></td>
              </tr>
              <?php endif; ?>
              <?php if (!empty($post->binding)) : ?>
              <tr>
                <th>装幀</th>
                <td><?php echo esc_html($post->binding); ?></td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-6 machaki-archive-section">
        <h3>内容紹介</h3>
        <div class="prose dark:prose-invert max-w-none">
          <?php the_excerpt(); ?>
        </div>
      </div>

      <?php if (!empty($post->works_in_the_collection)) : ?>
        <div class="mt-6 machaki-archive-section">
          <h4>収録作品</h4>
          <div class="prose dark:prose-invert max-w-none">
            <?php echo $post->works_in_the_collection; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <footer class="mt-6 pt-4 flex justify-end">
      <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        詳細を見る
        <i class="i-carbon-arrow-right"></i>
      </a>
    </footer>
  </div>
</article>

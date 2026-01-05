<?php
/**
 * The default template for displaying posts
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" aria-labelledby="entry-title" <?php post_class('prose dark:prose-invert max-w-none'); ?>>
  <header class="entry-header my-8">
    <?php the_title('<h1 class="entry-title heading05">', '</h1>'); ?>
    <div class="entry-meta text-gray-500 dark:text-gray-400 mt-2">
      <?php cielos_entry_meta(); ?>
    </div>
  </header>

  <?php
  $entry_content_classes = 'entry-content content-wrapper';
  if (wp_theme_has_theme_json()) {
      $entry_content_classes .= ' is-layout-constrained has-global-padding';
  }
  ?>
  <div class="<?php echo esc_attr($entry_content_classes); ?>">
    <?php if (has_post_thumbnail()) : ?>
      <div class="my-8 text-center">
        <?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded-lg shadow-md','loading'=>'lazy','decoding'=>'async')); ?>
      </div>
    <?php endif; ?>

    <?php the_content(); ?>

    <?php
    edit_post_link(__('(Edit)', 'cielos'), '<span class="edit-link mt-4 inline-block">', '</span>');
    ?>

    <?php
    wp_link_pages(
        array(
            'before' => '<nav id="page-nav" aria-label="Page navigation" class="mt-8"><p>' . __('Pages:', 'cielos'),
            'after'  => '</p></nav>',
        )
    );
    ?>
  </div>

  <?php
  $tags = get_the_tags();
  if ($tags) :
  ?>
  <footer class="mt-8 pt-4 pb-4 px-4 border-t border-gray-200 dark:border-gray-700 rounded-b-md">
        <div class="flex items-center gap-2 text-sm">
          <i class="i-carbon-tag text-gray-400 dark:text-gray-500"></i>
          <div class="flex flex-wrap gap-2">
            <?php foreach ($tags as $tag) : ?>
            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200 text-xs">
              <?php echo $tag->name; ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </footer>
  <?php endif; ?>
</article>

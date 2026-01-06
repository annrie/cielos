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
    <div class="entry-meta text-[var(--c-muted)] mt-2">
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
  <footer class="mt-8 pt-4 pb-4 px-4 border-t border-[var(--c-border)] rounded-b-md">
        <div class="flex items-center gap-2 text-sm">
          <i class="i-carbon-tag text-[var(--c-muted)]"></i>
          <div class="flex flex-wrap gap-2">
            <?php foreach ($tags as $tag) : ?>
            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="px-2 py-1 bg-[var(--c-bg)] text-[var(--c-muted)] rounded-md hover:bg-[var(--c-primary-light)] hover:text-[var(--c-primary-dark)] transition-colors duration-200 text-xs">
              <?php echo $tag->name; ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </footer>
  <?php endif; ?>
</article>

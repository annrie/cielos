<?php
/**
 * The default template for displaying page content
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('prose dark:prose-invert max-w-none'); ?> aria-labelledby="entry-title">
  <header class="entry-header mb-8">
    <h1 id="entry-title" class="entry-title heading05 lt-sm:text-h1 md:text-h3 tb:text-h1" style="display: none;"><?php the_title(); ?></h1>
    <div class="entry-meta text-[var(--c-muted)] mt-2">
        <?php cielos_entry_meta(); ?>
    </div>
  </header>
  <div class="entry-content content-wrapper">
    <?php the_content(); ?>
    <?php edit_post_link(__('(Edit)', 'cielos'), '<span class="edit-link mt-4 inline-block">', '</span>'); ?>
    <?php
    wp_link_pages(
        array(
            'before' => '<nav id="page-nav" class="mt-8"><p>' . __('Pages:', 'cielos'),
            'after'  => '</p></nav>',
        )
    );
    ?>
  </div>
  <?php
  $tags = get_the_tags();
  if ($tags) :
  ?>
  <footer class="mt-8 pt-4 border-t border-[var(--c-border)]">
    <div class="flex items-center gap-2">
      <span class="i-carbon-tag text-lg"></span>
      <div class="tags">
        <?php the_tags('<span class="tag-link inline-block bg-[var(--c-bg)] rounded-full px-3 py-1 text-sm font-semibold text-[var(--c-muted)] mr-2 mb-2">', '</span><span class="tag-link inline-block bg-[var(--c-bg)] rounded-full px-3 py-1 text-sm font-semibold text-[var(--c-muted)] mr-2 mb-2">', '</span>'); ?>
      </div>
    </div>
  </footer>
  <?php endif; ?>
</article>
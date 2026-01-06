<?php
/**
 * The default template for displaying blog content
 *
 * @package Cielos
 * @since unomoon 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-[var(--c-panel)] p-6 rounded-lg shadow-sm border border-[var(--c-border)] mb-8'); ?>>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="md:col-span-1 flex flex-col items-center text-center">
      <?php if (get_the_date() !== get_the_modified_date()) : ?>
        <div class="text-sm text-[var(--c-muted)] mb-2 hidden md:block">
          <time datetime="<?php echo get_the_date('c'); ?>" class="block text-[var(--c-primary)] font-medium text-lg"><?php echo get_the_date('Y.m.d'); ?></time>
          <time datetime="<?php echo get_the_modified_date('c'); ?>" class="block text-xs mt-1">更新: <?php echo get_the_modified_date('Y.m.d'); ?></time>
        </div>
      <?php else : ?>
        <div class="text-sm text-[var(--c-muted)] mb-2 hidden md:block">
          <time datetime="<?php echo get_the_date('c'); ?>" class="block text-[var(--c-primary)] font-medium text-lg"><?php echo get_the_date('Y.m.d'); ?></time>
        </div>
      <?php endif; ?>

      <?php if (has_post_thumbnail()) : ?>
        <div class="w-full mt-4">
          <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-lg aspect-square">
            <?php
            the_post_thumbnail(
                'medium', // Using 'medium' size for better control
                array(
                    'class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300 rounded-lg shadow-md',
                    'alt'   => the_title_attribute('echo=0'),
                    'title' => the_title_attribute('echo=0'),
                )
            );
            ?>
          </a>
        </div>
      <?php endif; ?>
    </div>

    <div class="md:col-span-3">
      <header class="mb-4">
        <h2 class="entry-title text-xl lg:text-2xl font-bold leading-tight">
          <a href="<?php the_permalink(); ?>" rel="bookmark" class="text-[var(--c-fg)] hover:text-[var(--c-primary)] transition-colors duration-200">
            <?php the_title(); ?>
          </a>
        </h2>
        <div class="text-sm text-[var(--c-muted)] mt-1 md:hidden">
          <?php cielos_entry_meta(); ?>
        </div>
      </header>

      <div class="entry-content prose prose-sm dark:prose-invert max-w-none mb-4">
        <?php the_excerpt(); ?>
      </div>

      <footer class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-[var(--c-muted)]">
        <div class="flex items-center gap-1">
          <i class="i-carbon-folder text-[var(--c-primary)]"></i>
          <?php the_category(' '); ?>
        </div>
        <?php if (has_tag()) : ?>
          <div class="flex items-center gap-1">
            <i class="i-carbon-tag text-[var(--c-primary)]"></i>
            <?php the_tags('', ', ', ''); ?>
          </div>
        <?php endif; ?>
        <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1 text-[var(--c-primary)] hover:text-[var(--c-primary-dark)] font-medium transition-colors duration-200 ml-auto">
          続きを読む <i class="i-carbon-arrow-right"></i>
        </a>
      </footer>
    </div>
  </div>
</article>
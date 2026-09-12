<?php
/**
 * The default template for displaying posts
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" aria-labelledby="entry-title" <?php post_class('prose dark:prose-invert max-w-none'); ?>>
  <?php
  // アイキャッチ画像が無い記事は、画像の代わりに見出し領域（.post-cover）を出す。
  // 技術名はタグかタイトルから拾い、サイト名と同じ Lobster で大きく見せる。
  $has_thumb     = has_post_thumbnail();
  $cover_eyebrow = '';
  if ( ! $has_thumb ) {
      // 1. カスタムフィールドで明示されていればそれを使う
      $cover_eyebrow = (string) get_post_meta( get_the_ID(), '_cielos_cover_eyebrow', true );

      // 2. 無ければタグから。get_the_tags() は名前順なので、英数字で始まる
      //    技術名らしいものを優先する（「CSS設計」より「UnoCSS」を出したい）
      if ( '' === $cover_eyebrow ) {
          $post_tags = get_the_tags();
          if ( $post_tags ) {
              foreach ( $post_tags as $t ) {
                  if ( preg_match( '/\A[A-Za-z]/', $t->name ) ) { $cover_eyebrow = $t->name; break; }
              }
              if ( '' === $cover_eyebrow ) { $cover_eyebrow = $post_tags[0]->name; }
          }
      }

      // 3. それも無ければタイトルから英数字の語を拾う
      if ( '' === $cover_eyebrow && preg_match( '/[A-Za-z][A-Za-z0-9.+#-]{2,}/', get_the_title(), $m ) ) {
          $cover_eyebrow = $m[0];
      }
  }
  ?>

  <?php if ( ! $has_thumb ) : ?>
    <header class="entry-header post-cover my-8">
      <div class="post-cover__inner">
        <?php if ( $cover_eyebrow ) : ?>
          <span class="post-cover__eyebrow" aria-hidden="true"><?php echo esc_html( $cover_eyebrow ); ?></span>
        <?php endif; ?>
        <h1 id="entry-title" class="post-cover__title"><?php echo esc_html( get_the_title() ); ?></h1>
        <div class="post-cover__meta">
          <?php
          $cats = get_the_category();
          if ( $cats ) :
              foreach ( array_slice( $cats, 0, 2 ) as $c ) :
          ?>
            <a class="post-cover__cat" href="<?php echo esc_url( get_category_link( $c->term_id ) ); ?>"><?php echo esc_html( $c->name ); ?></a>
          <?php
              endforeach;
          endif;
          ?>
          <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
        </div>
      </div>
    </header>
  <?php else : ?>
    <header class="entry-header my-8">
      <?php the_title( '<h1 id="entry-title" class="entry-title heading05">', '</h1>' ); ?>
      <div class="entry-meta text-[var(--c-muted)] mt-2">
        <?php cielos_entry_meta(); ?>
      </div>
    </header>
  <?php endif; ?>

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

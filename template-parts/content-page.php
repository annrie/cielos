<?php
/**
 * The default template for displaying page content
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

?>
<?php
// アイキャッチがあるページは template-parts/featured-image.php のヒーローが h1 (#entry-title) を出す。
// ないページはここで h1 を出さないと見出しがゼロになる。
$cielos_has_hero = (bool) get_the_post_thumbnail_url(null, 'full');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('prose dark:prose-invert max-w-none'); ?> aria-labelledby="entry-title">
  <?php if (!$cielos_has_hero) : ?>
    <?php
    // アイキャッチのない固定ページは、投稿(content-single.php)と同じ .post-cover で見出しを出す。
    // 以前は heading05 の帯を直置きしていたが、上下の余白がなくヘッダー直下で窮屈だった。
    // eyebrow はカスタムフィールド _cielos_cover_eyebrow だけを見る。投稿のようにタイトルから
    // 英単語を拾うと「Unomoon」+「Unomoon Form」のように同じ語が重なるため、固定ページでは使わない。
    $cielos_cover_eyebrow = (string) get_post_meta( get_the_ID(), '_cielos_cover_eyebrow', true );
    $cielos_is_updated    = get_the_date( 'Y-m-d' ) !== get_the_modified_date( 'Y-m-d' );
    ?>
    <header class="entry-header post-cover my-8">
      <div class="post-cover__inner">
        <?php if ( '' !== $cielos_cover_eyebrow ) : ?>
          <span class="post-cover__eyebrow" aria-hidden="true"><?php echo esc_html( $cielos_cover_eyebrow ); ?></span>
        <?php endif; ?>
        <h1 id="entry-title" class="post-cover__title"><?php echo esc_html( get_the_title() ); ?></h1>
        <div class="post-cover__meta">
          <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( sprintf( __( '公開 %s', 'cielos' ), get_the_date( 'Y.m.d' ) ) ); ?></time>
          <?php if ( $cielos_is_updated ) : ?>
            <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( sprintf( __( '更新 %s', 'cielos' ), get_the_modified_date( 'Y.m.d' ) ) ); ?></time>
          <?php endif; ?>
        </div>
      </div>
    </header>
  <?php else : ?>
    <header class="entry-header mb-8">
      <div class="entry-meta text-[var(--c-muted)] mt-2">
        <?php cielos_entry_meta(); ?>
      </div>
    </header>
  <?php endif; ?>
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
<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-8 prose dark:prose-invert max-w-none'); ?>>
    <header class="entry-header mb-4">
        <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title text-2xl lg:text-3xl font-bold">', '</h1>' );
        else :
            the_title( sprintf( '<h2 class="entry-title text-xl lg:text-2xl font-bold"><a href="%s" rel="bookmark" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200"> ', esc_url( get_permalink() ) ), '</a></h2>' );
        endif;
        ?>
        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
            <?php cielos_entry_meta(); ?>
        </div>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail mb-4">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('large', ['class' => 'w-full h-auto rounded-lg shadow-md','loading'=>'lazy','decoding'=>'async']); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if(is_singular()){
            the_content( __( 'Continue reading...', 'cielos' ) );
        } else {
            the_excerpt();
        }
        ?>
    </div>

    <footer class="entry-footer mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <?php
        if ( ! is_singular() ) {
            echo '<a href="' . get_permalink() . '" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors duration-200">' . __( 'Read more', 'cielos' ) . '<i class="i-carbon-arrow-right"></i></a>';
        }
        ?>
    </footer>
</article>

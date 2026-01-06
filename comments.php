<?php
/**
 * The template for displaying comments
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mt-12 bg-[var(--c-bg)] p-6 rounded-lg">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title text-2xl font-bold text-[var(--c-fg)] mb-6">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'cielos'),
                    '<span class="italic">' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'cielos')),
                    number_format_i18n($comment_count),
                    '<span class="italic">' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list space-y-6">
            <?php
            wp_list_comments(
                array(
                    'walker'      => new Cielos_Comments(),
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 64,
                )
            );
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => '<span class="text-sm text-[var(--c-primary)] hover:underline">&larr; ' . __('Older comments', 'cielos') . '</span>',
            'next_text' => '<span class="text-sm text-[var(--c-primary)] hover:underline">' . __('Newer comments', 'cielos') . ' &rarr;</span>',
        ));

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
            ?>
            <p class="no-comments mt-6 text-[var(--c-muted)]"><?php esc_html_e('Comments are closed.', 'cielos'); ?></p>
            <?php
        endif;

    endif; // Check for have_comments().

    // Display comment form.
    comment_form();
    ?>

</div><!-- #comments -->
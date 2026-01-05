<?php
/**
 * Cielos Comments Walker
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

if (!class_exists('Cielos_Comments')) :
    class Cielos_Comments extends Walker_Comment
    {
        public $tree_type = 'comment';

        public $db_fields = array(
            'parent' => 'comment_parent',
            'id'     => 'comment_ID',
        );

        /**
         * Starts the list before the CHILD elements are added.
         */
        public function start_lvl(&$output, $depth = 0, $args = array())
        {
            $GLOBALS['comment_depth'] = $depth + 1;
            $output .= '<ul class="children ml-6 lg:ml-12 mt-4 space-y-4">';
        }

        /**
         * Ends the children list of after the elements are added.
         */
        public function end_lvl(&$output, $depth = 0, $args = array())
        {
            $GLOBALS['comment_depth'] = $depth + 1;
            $output .= '</ul>';
        }

        /**
         * Outputs a single comment.
         */
        public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0)
        {
            $depth++;
            $GLOBALS['comment_depth'] = $depth;
            $GLOBALS['comment']       = $comment;
            $parent_class             = (empty($args['has_children']) ? '' : 'parent');

            $tag = ('div' === $args['style']) ? 'div' : 'li';
            ?>
            <<?php echo $tag; ?> <?php comment_class('p-4 rounded-lg ' . ($depth > 1 ? 'bg-gray-50 dark:bg-gray-900/50' : 'bg-white dark:bg-gray-800')); ?> id="comment-<?php comment_ID(); ?>">
                <article id="comment-body-<?php comment_ID(); ?>" class="comment-body flex gap-4">
                    <div class="comment-author-avatar flex-shrink-0">
                        <?php echo get_avatar($comment, $args['avatar_size'] ? $args['avatar_size'] : 64, '', '', ['class' => 'rounded-full shadow-md']); ?>
                    </div>

                    <div class="comment-content flex-grow">
                        <header class="comment-meta mb-2 flex items-center justify-between">
                            <div class="author-meta">
                                <cite class="fn font-bold text-gray-900 dark:text-white not-italic"><?php echo get_comment_author_link(); ?></cite>
                                <time datetime="<?php comment_time('c'); ?>" class="text-sm text-gray-500 dark:text-gray-400 ml-2">
                                    <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>" class="hover:underline">
                                        <?php printf('%1$s at %2$s', get_comment_date(),  get_comment_time()); ?>
                                    </a>
                                </time>
                            </div>
                            <div class="reply text-sm">
                                <?php
                                comment_reply_link(array_merge($args, array(
                                    'add_below' => 'comment-body',
                                    'depth'     => $depth,
                                    'max_depth' => $args['max_depth'],
                                    'before'    => '<span class="flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:underline">',
                                    'after'     => '</span>'
                                )));
                                ?>
                            </div>
                        </header>

                        <div class="prose prose-sm dark:prose-invert max-w-none">
                            <?php if ('0' == $comment->comment_approved) : ?>
                                <p class="notice bg-yellow-100 text-yellow-800 p-2 rounded-md">
                                    <?php _e('Your comment is awaiting moderation.', 'cielos'); ?>
                                </p>
                            <?php endif; ?>
                            <?php comment_text(); ?>
                        </div>

                        <?php edit_comment_link(__('(Edit)', 'cielos'), '<p class="text-sm text-gray-500 dark:text-gray-400 mt-2">', '</p>'); ?>
                    </div>
                </article>
            <?php
        }

        public function end_el(&$output, $comment, $depth = 0, $args = array())
        {
            $tag = ('div' === $args['style']) ? 'div' : 'li';
            $output .= "</$tag>";
        }
    }
endif;
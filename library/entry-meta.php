<?php
/**
 * Entry meta information for posts
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

if (! function_exists('cielos_entry_meta')) :
    function cielos_entry_meta()
    {
        echo '<time class="updated" datetime="' . get_the_time('c') . '">' . sprintf(__('<i class="fas fa-calendar" aria-hidden="true"></i> %1$s', 'cielos'), get_the_date('Y.m.d (D)')) . '</time>';
        if (get_the_date() !== get_the_modified_date()) :
            echo ' <i class="fas fa-hand-point-right" aria-hidden="true" style="color:green;"></i> <time class="updated" datetime="' . get_the_modified_time('c') . '">' . sprintf(__('<i class="fas fa-calendar-alt" aria-hidden="true"></i> %1$s', 'cielos'), get_the_modified_date('Y.m.d (D)')) . '</time>';
        endif;
        echo '<p class="byline author sr-only">' . __('Written by', 'cielos') . ' <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" rel="author" class="fn">' . get_the_author() . '</a></p>';
    }
endif;
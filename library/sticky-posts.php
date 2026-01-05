<?php
/**
 * ACF Option Pages
 *
 * PHP Version >=7.0
 *
 * @category unomoon
 * @package.json  unomoon
 * @author   annrie <blastspinner @gmail.com>
 * @license  MIT
 * @link     https://unomoon.cielos.com
 */

if ( ! function_exists('cielos_sticky_posts') ) :
    function cielos_sticky_posts( $classes ) {
        if (in_array('sticky', $classes, true) ) {
            $classes   = array_diff($classes, array( 'sticky' ));
            $classes[] = 'wp-sticky';
        }
        return $classes;
    }
    add_filter('post_class', 'cielos_sticky_posts');

endif;
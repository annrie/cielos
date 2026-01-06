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

if (! function_exists('cielos_sidebar_widgets')) :
    function cielos_sidebar_widgets()
    {
        register_sidebar(
            array(
                'id'            => 'sidebar-1',
                'name'          => __('Sidebar widgets', 'cielos'),
                'description'   => __('Drag widgets to this sidebar container.', 'cielos'),
                'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4 pb-2 border-b-2 border-[var(--c-border)] text-[var(--c-fg)]">',
                'after_title'   => '</h3>',
            )
        );

        register_sidebar(
            array(
                'id'            => 'sidebar-2',
                'name'          => __('Secondary Sidebar widgets', 'cielos'),
                'description'   => __('Drag widgets to this sidebar container', 'cielos'),
                'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4 pb-2 border-b-2 border-[var(--c-border)] text-[var(--c-fg)]">',
                'after_title'   => '</h3>',
            )
        );

        register_sidebar(
            array(
                'id'            => 'footer-1',
                'name'          => __('Footer widgets1', 'cielos'),
                'description'   => __('Drag widgets to this footer container', 'cielos'),
                'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4">',
                'after_title'   => '</h3>',
            )
        );
        register_sidebar(
            array(
                'id'            => 'footer-widgets1',
                'name'          => __('Footer widgets1 (Custom)', 'cielos'),
                'description'   => __('Drag widgets to this footer container (Custom)', 'cielos'),
                'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4">',
                'after_title'   => '</h3>',
            )
        );
        register_sidebar(
            array(
                'id'            => 'footer-2',
                'name'          => __('Footer widgets2', 'cielos'),
                'description'   => __('Drag widgets to this footer container', 'cielos'),
                'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4">',
                'after_title'   => '</h3>',
            )
        );
        register_sidebar(
            array(
                'id'            => 'footer-3',
                'name'          => __('Footer widgets3', 'cielos'),
                'description'   => __('Drag widgets to this footer container', 'cielos'),
                'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4">',
                'after_title'   => '</h3>',
            )
        );
    }

    add_action('widgets_init', 'cielos_sidebar_widgets');
endif;
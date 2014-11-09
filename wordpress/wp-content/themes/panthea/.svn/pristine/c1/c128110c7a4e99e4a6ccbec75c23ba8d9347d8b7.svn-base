<?php
/**
 * Your Inspiration Themes
 *
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

function yit_tab_blog_settings( $items ) {
    unset( $items[62], $items[64], $items[66], $items[68]  );


    $items[72] = array(
        'id'   => 'blog-show-icon-wrapper',
        'type' => 'onoff',
        'name' => __( 'Show the icon over the thumbnails', 'yit' ),
        'desc' => __( 'Select if you want to show the icon for standard/gallery posts over the thumbnail.', 'yit' ),
        'std'  => apply_filters( 'yit_blog-show-icon-wrapper_std', 1 )
    );

    $items[73] = array(
        'id'   => 'blog-show-author-info',
        'type' => 'onoff',
        'name' => __( 'Show a box with info about the author', 'yit' ),
        'desc' => __( 'Select if you want to show the box author info. ', 'yit' ),
        'std'  => apply_filters( 'yit_blog-show-author', 0 )
    );

    $items[74] = array(
        'id'   => 'blog-show-share',
        'type' => 'onoff',
        'name' => __( 'Show share', 'yit' ),
        'desc' => __( 'Select if you want to show the share buttons.', 'yit' ),
        'std'  => apply_filters( 'yit_blog-show-share_std', 1 ),
    );

    return $items;
}

add_filter( 'yit_submenu_tabs_theme_option_blog_settings', 'yit_tab_blog_settings' );

add_filter( 'yit_blog-read-more-text_std', create_function( '', 'return "READ MORE";' ) );

add_filter( 'yit_blog-type_std', create_function( '', 'return "big";' ) );

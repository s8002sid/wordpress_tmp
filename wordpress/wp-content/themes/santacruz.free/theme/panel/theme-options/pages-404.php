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
 
function yit_tab_pages_404( $items ) {
    unset( $items[15] );

    $items[50] = array(
        'id'   => '404-no-header-footer',
        'type' => 'onoff',
        'name' => __( 'Hide header and footer', 'yit' ),
        'desc' => __( 'Say if you want to hide the header and footer in the 404 page.', 'yit' ),
        'std'  => 0
    );
    
    return $items;
}
add_filter( 'yit_submenu_tabs_theme_option_pages_404', 'yit_tab_pages_404' );

function yit_404_text_std(){
    return '[two_fourth class="page404-left-content" last="no" ]
   <h2> whoops, our bad... </h2>
   <p class = "subtitle-left"> The page you requested was not found , and we have a fine guess why </p>
   <p class = "text"> - If you typed the URL directly, please make sure the spelling is correct.
       - If you clicked on a link to get here, the link is outdated.
   </p>


[/two_fourth]
[two_fourth class="page404-right-content" last="yes" ]
   <h2> what can i do </h2>
   <p class = "subtitle-right" > There are many ways you can get back on track with Santa Cruz Shop: </p>
   <p class = "text">
      - Go to the <a href = "#">home page</a>
      - Use the search form below
   </p>
[searchbox ]
[/two_fourth]';
}

add_filter( 'yit_404-text_std','yit_404_text_std' );

add_filter('yit_404-custom_std','yit_404_custom_std');
function yit_404_custom_std(){
    return 1;
}
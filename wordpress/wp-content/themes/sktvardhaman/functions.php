<?php
add_action( 'wp_enqueue_scripts', 'wpse26822_script_fix' );
function wpse26822_script_fix()
{
        wp_dequeue_script( 'skt_corp-custom_js' );
            wp_enqueue_script( 'skt_corp-custom_js', get_stylesheet_directory_uri() . '/js/custom.js');
}

/* Remove WooCommerce styles and scripts. */
function woo_remove_lightboxes() {

        // Styles
        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

        // Scripts
        wp_dequeue_script( 'prettyPhoto' );
        wp_dequeue_script( 'prettyPhoto-init' );
        wp_dequeue_script( 'fancybox' );
        wp_dequeue_script( 'enable-lightbox' );
}

add_action( 'wp_enqueue_scripts', 'woo_remove_lightboxes', 99 );


function df_woocommerce_single_product_image_html($html) {
        $html = str_replace('data-rel="prettyPhoto', 'rel="lightbox', $html);
            return $html;
}
add_filter('woocommerce_single_product_image_html', 'df_woocommerce_single_product_image_html', 99, 1); // single image
add_filter('woocommerce_single_product_image_thumbnail_html', 'df_woocommerce_single_product_image_html', 99, 1); // thumbnails

/**
    * * Change the add to cart text on single product pages
    * */
add_filter('woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text');
 
function woo_custom_cart_button_text() {
     
    global $woocommerce;
    foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
        $_product = $values['data'];
        if( get_the_ID() == $_product->id ) {
            return __('Already in cart - Add Again?', 'woocommerce');
        }
    }
    return __('Add to cart', 'woocommerce');
}
 
/**
 * * Change the add to cart text on product archives
 * */
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );
 
function woo_archive_custom_cart_button_text() {
     
    global $woocommerce;
    foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
        $_product = $values['data'];
        if( get_the_ID() == $_product->id ) {
            return __('Already in cart', 'woocommerce');
        }
    }
    return __('Add to cart', 'woocommerce');
} 

add_filter( 'wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2 );
 
function wti_loginout_menu_link( $items, $args ) 
{
    if ($args->theme_location == 'primary') 
    {
        if (is_user_logged_in()) 
        {
            /*get My Account page id*/
            $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
            if ( $myaccount_page_id ) {
                  $myaccount_page_url = get_permalink( $myaccount_page_id );
            }
            $items .= '<li><a href="'. $myaccount_page_url .'">My Account</a>';
            $items .= '<ul class="sub-menu">';
                $items .= '<li><a href="'. wp_logout_url() .'">Signout</a></li>';
            $items .= '</ul></li>';
        } 
        else 
        {
            $items .= '<li><a href="'. get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) .'">Signin</a></li>';
        }
    }
    return $items;
}
?>

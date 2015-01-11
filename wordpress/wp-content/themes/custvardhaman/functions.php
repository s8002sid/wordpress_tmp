<?php
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
?>


<?php
function df_woocommerce_single_product_image_html($html) {
        $html = str_replace('data-rel="prettyPhoto', 'rel="lightbox', $html);
            return $html;
}
add_filter('woocommerce_single_product_image_html', 'df_woocommerce_single_product_image_html', 99, 1); // single image
add_filter('woocommerce_single_product_image_thumbnail_html', 'df_woocommerce_single_product_image_html', 99, 1); // thumbnails
?>

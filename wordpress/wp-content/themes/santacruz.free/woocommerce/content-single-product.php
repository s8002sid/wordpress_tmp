<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

global $product, $woocommerce;

if ( ! yit_get_option( 'shop-enabled' ) ) {
    add_action( 'woocommerce_single_product_summary', 'yit_product_other_actions', 35 );
}

// grouped fix
global $product;
if ( $product->product_type == 'grouped' ) {
    remove_action( 'yit_product_box', 'woocommerce_template_single_add_to_cart', 20 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}

?>

<?php
/**
 * woocommerce_before_single_product hook
 *
 * @hooked woocommerce_show_messages - 10
 */
do_action( 'woocommerce_before_single_product' );
?>

    <div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

        <?php
        /**
         * woocommerce_show_product_images hook
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action( 'woocommerce_before_single_product_summary' );
        ?>



        <div class="summary entry-summary">

            <?php
            if ( ! is_shop_enabled() ) {
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
            }
            if ( ! is_shop_enabled() ) {
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            }

            remove_action( 'woocommerce_single_product_summary', '' );


            // add a separator after title and price
            add_action( 'woocommerce_single_product_summary', "yit_get_div_clear" );
            //add rating
            add_action('woocommerce_single_product_summary',function(){
                if(yit_get_option( 'shop-view-show-rating' ))
                {
                    global $product;
                    echo $product->get_rating_html();

                    $count_reviews=$product->get_rating_count();

                    if($count_reviews>0){
                       echo "<div class='number-reviews'><p>".$count_reviews." ".__("reviews")."</p></div>";
                    }

                    yit_get_div_clear();
                }

            });
           // add_action( 'woocommerce_single_product_summary', );



            /**
             * woocommerce_single_product_summary hook
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             */
            do_action( 'woocommerce_single_product_summary' );

            ?>

        </div>
        <!-- .summary -->

        <div class="after-product-summary">
            <?php

            /**
             * woocommerce_after_single_product_summary hook
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_output_related_products - 20
             */
            do_action( 'woocommerce_after_single_product_summary' ); ?>

        </div>


    </div><!-- #product-<?php the_ID(); ?> -->

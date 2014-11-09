<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( is_object( $product ) && ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$woocommerce_loop['li_class'] = array();

if ( !( isset( $woocommerce_loop['layout'] ) && ! empty( $woocommerce_loop['layout'] ) ) )
    $woocommerce_loop['layout'] = yit_get_option( 'shop-layout', 'with-hover' );

$woocommerce_loop['li_class'][] = $woocommerce_loop['layout'];

// open the hover on mobile
if ( yit_get_option( 'responsive-open-hover' ) && $woocommerce_loop['layout'] != 'classic' ) $woocommerce_loop['li_class'][] = 'open-on-mobile';

// open the hover on mobile
if ( yit_get_option( 'responsive-force-classic' ) && $woocommerce_loop['layout'] == 'with-hover' ) $woocommerce_loop['li_class'][] = 'force-classic-on-mobile';

yit_detect_span_catalog_image();  //automatically add the classes

if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
{
    $woocommerce_loop['li_class'][] = 'first';
    $prev_visible="visible" ;
}
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$woocommerce_loop['li_class'][] = 'last';

if ( ! is_shop_enabled() )  remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );

$image = yit_image( "size=shop_catalog&output=array" );
$height = isset( $image[2] ) ? $image[2] : 0;
?>
<li <?php post_class( $woocommerce_loop['li_class'] ); ?> >
    <div class="clearfix product-wrapper <?php echo ($product->get_price() == '') ? 'no-price' : '' ?>">
    	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    	<?php
    		/**
    		 * woocommerce_before_shop_loop_item_title hook
    		 *
    		 * @hooked woocommerce_show_product_loop_sale_flash - 10
    		 * @hooked woocommerce_template_loop_product_thumbnail - 10
    		 */
    		do_action( 'woocommerce_before_shop_loop_item_title' );
    	?>

            <h3> <?php the_title(); ?></h3>

        <?php
        /**
         * woocommerce_after_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_price - 10
         * @hooked woocommerce_template_loop_rating - 5
         */
        do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

        <div class="product-meta">
            <div class="product-meta-wrapper">

            	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

            </div>
        </div>

    </div>



</li>
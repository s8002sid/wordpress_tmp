<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product;

if ( ! $product->is_purchasable() ) return;
?>

<?php
	// Availability
	$availability = $product->get_availability();

	if ($availability['availability']) :
		echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
    endif;
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>

        <?php if ( ! $product->is_sold_individually() ) : ?>
        <div class="variations_button simple_product">

            <div class="add_to_cart_container">
                <div class="quantity_container">
                    <label><?php _e( 'Quantity', 'yit' ) ?></label>
                    <?php
                    woocommerce_quantity_input( array(
                        'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
                        'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
                    ) ); ?>
                </div>
                <div class="add_to_cart_button">
                    <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
                    <button type="submit" class="single_add_to_cart_button button alt"><?php echo apply_filters('single_add_to_cart_text', __( 'Add to cart', 'yit' ), $product->product_type); ?></button>

                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                </div>
                <div class="clear"></div>

            </div>
        </div>
        <?php endif; ?>                        
		


	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
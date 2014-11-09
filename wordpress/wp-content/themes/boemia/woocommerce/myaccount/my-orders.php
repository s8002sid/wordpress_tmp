<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$customer_id = get_current_user_id();

$args = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
    'numberposts' => $order_count,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
    'post_type'   => wc_get_order_types( 'view-orders' ),
    'post_status' => array_keys( wc_get_order_statuses() )
) ) );

$customer_orders = get_posts($args);

if ($customer_orders) :
?>
	<table class="shop_table my_account_orders">

		<thead>
			<tr>
				<th class="order-number"><span class="nobr"><?php _e('Order', 'yit'); ?></span></th>
				<th class="order-shipto"><span class="nobr"><?php _e('Ship to', 'yit'); ?></span></th>
				<th class="order-total"><span class="nobr"><?php _e('Total', 'yit'); ?></span></th>
				<th class="order-status" colspan="2"><span class="nobr"><?php _e('Status', 'yit'); ?></span></th>
			</tr>
		</thead>

		<tbody><?php
			foreach ($customer_orders as $customer_order) :

                $order      = wc_get_order();
                $order->populate( $customer_order );
                $item_count = $order->get_item_count();

				?><tr class="order">
					<td class="order-number" width="1%">
						<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>"><?php echo $order->get_order_number(); ?></a> &ndash; <time title="<?php echo esc_attr( strtotime($order->order_date) ); ?>"><?php echo date_i18n(get_option('date_format'), strtotime($order->order_date)); ?></time>
					</td>
					<td class="order-shipto"><address><?php if ($order->get_formatted_shipping_address()) echo $order->get_formatted_shipping_address(); else echo '&ndash;'; ?></address></td>
					<td class="order-total" width="1%"><?php echo $order->get_formatted_order_total(); ?></td>
					<td class="order-status" style="text-align:left; white-space:nowrap;">
                        <?php echo ucfirst( __( wc_get_order_status_name( $order->get_status() ), 'yit' ) ); ?>
						<?php if (in_array($order->status, array('pending', 'failed'))) : ?>
							<a href="<?php echo esc_url( $order->get_cancel_order_url() ); ?>" class="cancel" title="<?php _e('Click to cancel this order', 'yit'); ?>">(<?php _e('Cancel', 'yit'); ?>)</a>
						<?php endif; ?>
					</td>
					<td class="order-actions" style="text-align:right; white-space:nowrap;">

						<?php if (in_array($order->status, array('pending', 'failed'))) : ?>
							<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e('Pay', 'yit'); ?></a>
						<?php endif; ?>

						<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="button"><?php _e('View', 'yit'); ?></a>


					</td>
				</tr><?php
			endforeach;
		?></tbody>

	</table>
<?php
else :
?>
	<p><?php _e('You have no recent orders.', 'yit'); ?></p>
<?php
endif;
?>

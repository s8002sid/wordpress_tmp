<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
global $woocommerce, $product;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div id="product_title">
<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
<div class="info-review">
<?php if ( comments_open() ) : ?>
<?php
	if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
	$count = $product->get_rating_count();
	if ( $count > 0 ) {
	$average = $product->get_average_rating();
	echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average ).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
	}
	}
?>
<?php endif; ?>
<?php
	echo "<span class='total-review'>" .$count." Reviews</span>";
?>
<?php 
$title_reply = "";
echo '<span class="add_review"><a href="#review_form" class="inline show_review_form button" title="' . __( 'Add Your Review', 'woocommerce' ) . '">' . __( 'Add Your Review', 'woocommerce' ) . '</a></span>';

		$title_reply = __( 'Add a review', 'woocommerce' );
?>
</div>
</div>
<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 
$is_full_width = (bool)( yit_get_sidebar_layout() == 'sidebar-no' );
?>
	        <!-- START CONTENT -->
	        <div id="content-shop" class="span<?php echo $is_full_width ? 12 : 9 ?> content group">
<?php
/**
 * Content Wrappers
 */

if ( is_product() ) return;
?>
<!-- START PAGE META -->
<div id="page-meta" class="group<?php if ( is_product() ) echo ' span12' ?>">
    <?php if ( ! is_single() && yit_get_option( 'shop-products-title' ) ) : ?>


           <h1 class="page-title">
               <?php woocommerce_page_title() ?>
           </h1>
           <div class="clear"></div>

    <?php endif; ?>

    <?php do_action( 'shop_page_meta' ) ?>

</div>
<!-- END PAGE META -->
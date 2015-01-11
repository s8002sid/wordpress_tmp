<?php

add_action( 'foundation_enqueue_scripts', 'bauhaus_enqueue_scripts' );

function bauhaus_enqueue_scripts() {
	wp_enqueue_script(
		'bauhaus-js',
		BAUHAUS_URL . '/default/bauhaus.js',
		array( 'jquery' ),
		BAUHAUS_THEME_VERSION,
		true
	);
}

function bauhaus_should_show_thumbnail() {
	$settings = bauhaus_get_settings();

	switch( $settings->bauhaus_use_thumbnails ) {
		case 'none':
			return false;
		case 'index':
			return is_home();
		case 'index_single':
			return is_home() || is_single();
		case 'index_single_page':
			return is_home() || is_single() || is_page();
		case 'all':
			return is_home() || is_single() || is_page() || is_archive() || is_search();
		default:
			// in case we add one at some point
			return false;
	}
}

function bauhaus_should_show_taxonomy() {
	$settings = bauhaus_get_settings();

	if ( $settings->bauhaus_show_taxonomy ) {
		return true;
	} else {
		return false;
	}
}

function bauhaus_should_show_date(){
	$settings = bauhaus_get_settings();

	if ( $settings->bauhaus_show_date ) {
		return true;
	} else {
		return false;
	}
}

function bauhaus_should_show_author(){
	$settings = bauhaus_get_settings();

	if ( $settings->bauhaus_show_author ) {
		return true;
	} else {
		return false;
	}
}

function bauhaus_should_show_search(){
	$settings = bauhaus_get_settings();

	if ( $settings->bauhaus_show_search ) {
		return true;
	} else {
		return false;
	}
}

function bauhaus_should_show_comment_bubbles(){
	$settings = bauhaus_get_settings();

	if ( $settings->bauhaus_show_comment_bubbles ) {
		return true;
	} else {
		return false;
	}
}

/*Adding code for customizing product image */


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
add_filter('woocommerce_single_product_image_html', 'df_woocommerce_single_product_image_html', 99, 1); // single   image
add_filter('woocommerce_single_product_image_thumbnail_html', 'df_woocommerce_single_product_image_html', 99,       1); // thumbnails



<?php
/**
 * All functions and hooks for woocommerce plugin
 *
 * @package    WordPress
 * @subpackage YIThemes
 */

global $woocommerce;

add_filter( 'woocommerce_enqueue_styles', 'yit_enqueue_wc_styles' );


if ( ! is_active_widget( false, false, 'woocommerce_price_filter', true ) ) {
    add_filter( 'loop_shop_post_in', array( WC()->query, 'price_filter' ) );
}

$ismobile = wp_is_mobile();

/* Fix 2.1.7 */
if ( ! YIT_DEBUG ){
    $message = get_option( 'woocommerce_admin_notices', array() );
    $message = array_diff( $message, array( 'template_files' ));
    update_option( 'woocommerce_admin_notices', $message );
}


/* === GENERAL SETTINGS === */
add_theme_support( 'woocommerce' );
register_sidebar( yit_sidebar_args( 'Shop Sidebar' ) );


/* === HOOKS === */
add_action( 'wp_enqueue_scripts', 'yit_enqueue_woocommerce_assets' );
add_action( 'woocommerce_before_main_content', 'yit_shop_page_meta' );
add_action( 'shop_page_meta', 'yit_woocommerce_catalog_ordering',25 );
add_filter( 'loop_shop_per_page', 'yit_set_posts_per_page' );
add_filter( 'woocommerce_product_settings', 'yit_add_featured_products_slider_image_size' );
add_filter( 'woocommerce_get_image_size_shop_featured', 'yit_add_featured_image_size' );
add_action( 'wp_head', 'yit_size_images_style' );
add_action( 'woocommerce_before_main_content', 'yit_woocommerce_primary_start', 5 );
add_action( 'woocommerce_sidebar', 'yit_woocommerce_primary_end', 99 );

add_filter( 'yit_sample_data_tables', 'yit_save_woocommerce_tables' );
add_filter( 'yit_sample_data_options', 'yit_save_woocommerce_options' );
add_filter( 'yit_sample_data_options', 'yit_add_plugins_options' );

/* shop */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
if( yit_get_option('shop-view-show-rating') ) {
    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );
}
add_filter( 'woocommerce_breadcrumb_defaults', 'yit_change_breadcrumb_args' );


add_action( 'wp_head', 'yit_woocommerce_javascript_scripts' );
add_action( 'woocommerce_before_shop_loop_item_title', 'yit_woocommerce_out_of_stock_flash' );
add_filter( 'yith-wcan-frontend-args', 'yit_wcan_change_pagination_class' );


/* single */
remove_action( 'yit_after_header', 'yit_page_meta', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
if ( yit_get_option('shop-show-breadcrumb') ) {
    add_action( 'shop_page_meta', 'woocommerce_breadcrumb', 20 );
}
if ( yit_get_option('shop-single-show-breadcrumb') ) {
    add_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb', 20 );
}

add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash' );


if ( ! yit_get_option( 'shop-show-metas' ) ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
}

/* admin */
add_action( 'woocommerce_product_options_general_product_data', 'yit_woocommerce_admin_product_ribbon_onsale' );
add_action( 'woocommerce_process_product_meta', 'yit_woocommerce_process_product_meta', 2, 2 );
add_action( 'yit_after_import', create_function( '', 'update_option("woocommerce_responsive_images", "yes");' ) );


//add to cart button
add_filter( 'single_add_to_cart_text', 'yit_add_to_cart_text', 1 );
add_filter( 'add_to_cart_text', 'yit_add_to_cart_text', 1 );
function yit_add_to_cart_text( $text ) {
    global $product;

    if ( $product->product_type != 'external' ) {
        $text = __( yit_get_option( 'add-to-cart-text' ), 'yit' );
    }

    return $text;
}


/* === FUNCTIONS === */
function yit_product_layout() {
    return yit_get_option( 'shop-single-layout', 'layout-1' );
}

function yit_enqueue_woocommerce_assets() {
    wp_enqueue_script( 'yit-woocommerce', YIT_THEME_ASSETS_URL . '/js/woocommerce.js', array( 'jquery', 'jquery-cookie' ), '1.0', true );
    wp_localize_script( 'yit-woocommerce', 'yit_woocommerce', array(
        'no_filters' => __( 'No filters to apply!', 'yit' )
    ) );
}

function yit_woocommerce_javascript_scripts() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('body').bind('added_to_cart', function () {
                $('.add_to_cart_button.added').text('<?php echo apply_filters( 'yit_added_to_cart_text', __( 'ADDED!', 'yit' ) ); ?>');
            });
        });
    </script>
<?php
}

function yit_woocommerce_catalog_ordering() {
    if ( ! is_single() && have_posts() ) {
        woocommerce_catalog_ordering();
    }
}

function yit_set_posts_per_page( $cols ) {
    $items = yit_get_option( 'shop-products-per-page', $cols );
    return $items == 0 ? - 1 : $items;
}

function yit_woocommerce_show_product_thumbnails() {
    wc_get_template( '/single-product/thumbs.php' );
}

function yit_shop_page_meta() {
    if ( is_single() ) {
        return;
    }
    wc_get_template( '/global/page-meta.php' );
}

function yit_change_breadcrumb_args( $args ) {
    $args['delimiter'] = ' &gt; ';

    return $args;
}

function yit_product_buttons_wrapper_list_start() {
    ?><div class="buttons-list-wrapper"><?php
}

function yit_product_buttons_wrapper_list_end() {
    ?></div><?php
}



function yit_wcan_change_pagination_class( $args ) {
    $args['pagination'] = '.general-pagination';
    return $args;
}




function woocommerce_template_loop_product_thumbnail() {
    global $product;

    $attachments  = $product->get_gallery_attachment_ids();
    $active_hover = ( bool ) ( yit_get_option( 'active-flip-3d' ) && ! empty( $attachments ) && isset( $attachments[0] ) );

    echo '<a href="' . get_permalink() . '" class="thumb' . ( $active_hover ? ' flip' : '' ) . '"><span class="face">' . woocommerce_get_product_thumbnail() . '</span>';

    // add another image for hover
    if ( $active_hover ) {
        echo '<span class="face back">';
        yit_image( "id=$attachments[0]&size=shop_catalog&class=image-hover" );
        echo '</span>';
    }

    echo  '</a>';
}

function yit_product_rate_size() {
    return 13;
}


function yit_woocommerce_out_of_stock_flash() {
    global $product;

    if ( ! $product->is_in_stock() ) {
        echo '<span class="out-of-stock" style="display: inline;">out of stock</span>';
    }
}



/* checkout */

/*Display coupon form on checkout*/
if ( ! yit_get_option( 'shop-coupon-checkout' ) ) {
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}


/* admin */
function yit_woocommerce_admin_product_ribbon_onsale() {
    wc_get_template( '/admin/custom-onsale.php' );
}

function yit_woocommerce_process_product_meta( $post_id, $post ) {

    $active = ( isset( $_POST['_active_custom_onsale'] ) ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_active_custom_onsale', esc_attr( $active ) );

    if ( isset( $_POST['_preset_onsale_icon'] ) ) {
        update_post_meta( $post_id, '_preset_onsale_icon', esc_attr( $_POST['_preset_onsale_icon'] ) );
    }
    if ( isset( $_POST['_custom_onsale_icon'] ) ) {
        update_post_meta( $post_id, '_custom_onsale_icon', esc_attr( $_POST['_custom_onsale_icon'] ) );
    }
}

// Detect the span to use for the products list
function yit_detect_span_catalog_image() {

    global $woocommerce_loop, $yit_is_feature_tab, $post;

    $sidebar = yit_get_sidebar_layout() == 'sidebar-no' || is_product() && yit_get_option( 'product-single-layout' ) == 'layout-2' ? 'no' : 'yes';

    $content_width = $sidebar == 'no' ? 1170 : 870;
    if ( isset( $yit_is_feature_tab ) && $yit_is_feature_tab ) {
        $content_width -= 300;
    }
    $product_width = yit_shop_catalog_w() + ( $woocommerce_loop['layout'] == 'classic' ? 6 : 10 ) + 2; // 10 = padding & 2 = border
    $is_span       = false;

    if (  get_option("woocommerce_responsive_images")  == '1' or get_option("woocommerce_responsive_images")  == 'yes' ) {
        $is_span = true;
        if ( $sidebar == 'no' ) {
            if ( $product_width >= 0 && $product_width < 120 ) {
                $woocommerce_loop['li_class'][] = 'span1';
                $woocommerce_loop['columns']    = 12;
            }
            elseif ( $product_width >= 120 && $product_width < 220 ) {
                $woocommerce_loop['li_class'][] = 'span2';
                $woocommerce_loop['columns']    = 6;
            }
            elseif ( $product_width >= 220 && $product_width < 320 ) {
                $woocommerce_loop['li_class'][] = 'span3';
                $woocommerce_loop['columns']    = 4;
            }
            elseif ( $product_width >= 320 && $product_width < 470 ) {
                $woocommerce_loop['li_class'][] = 'span4';
                $woocommerce_loop['columns']    = 3;
            }
            elseif ( $product_width >= 470 && $product_width < 620 ) {
                $woocommerce_loop['li_class'][] = 'span6';
                $woocommerce_loop['columns']    = 2;
            }
            else {
                $is_span = false;
            }

        }
        else {
            if ( $product_width >= 0 && $product_width < 150 ) {
                $woocommerce_loop['li_class'][] = 'span1';
                $woocommerce_loop['columns']    = 12;
            }
            elseif ( $product_width >= 150 && $product_width < 620 ) {
                $woocommerce_loop['li_class'][] = 'span3';
                $woocommerce_loop['columns']    = 3;
            }
            else {
                $is_span = false;
            }

        }

    }
    else {
        $grid                           = yit_get_span_from_width( $product_width );
        $woocommerce_loop['li_class'][] = 'span' . $grid;
        $product_width                  = yit_width_of_span( $grid );
    }
    if ( $yit_is_feature_tab || ! $is_span ) {
        $woocommerce_loop['columns'] = floor( ( $content_width + 30 ) / ( $product_width + 30 ) );
    }
}


/**
 * SIZES
 */

    // shop small
    if ( ! function_exists( 'yit_shop_catalog_w' ) ) : function yit_shop_catalog_w() {
        $size = wc_get_image_size( 'shop_catalog' );
        return $size['width'];
    } endif;
    if ( ! function_exists( 'yit_shop_catalog_h' ) ) : function yit_shop_catalog_h() {
        $size = wc_get_image_size( 'shop_catalog' );
        return $size['height'];
    } endif;
    if ( ! function_exists( 'yit_shop_catalog_c' ) ) : function yit_shop_catalog_c() {
        $size = wc_get_image_size( 'shop_catalog' );
        return $size['crop'];
    } endif;
// shop thumbnail
    if ( ! function_exists( 'yit_shop_thumbnail_w' ) ) : function yit_shop_thumbnail_w() {
        $size = wc_get_image_size( 'shop_thumbnail' );
        return $size['width'];
    } endif;
    if ( ! function_exists( 'yit_shop_thumbnail_h' ) ) : function yit_shop_thumbnail_h() {
        $size = wc_get_image_size( 'shop_thumbnail' );
        return $size['height'];
    } endif;
    if ( ! function_exists( 'yit_shop_thumbnail_c' ) ) : function yit_shop_thumbnail_c() {
        $size = wc_get_image_size( 'shop_thumbnail' );
        return $size['crop'];
    } endif;
// shop large
    if ( ! function_exists( 'yit_shop_single_w' ) ) : function yit_shop_single_w() {
        $size = wc_get_image_size( 'shop_single' );
        return $size['width'];
    } endif;
    if ( ! function_exists( 'yit_shop_single_h' ) ) : function yit_shop_single_h() {
        $size = wc_get_image_size( 'shop_single' );
        return $size['height'];
    } endif;
    if ( ! function_exists( 'yit_shop_single_c' ) ) : function yit_shop_single_c() {
        $size = wc_get_image_size( 'shop_single' );
        return $size['crop'];
    } endif;
// shop featured
    if ( ! function_exists( 'yit_shop_featured_w' ) ) : function yit_shop_featured_w() {
        $size = wc_get_image_size( 'shop_featured' );
        return $size['width'];
    } endif;
    if ( ! function_exists( 'yit_shop_featured_h' ) ) : function yit_shop_featured_h() {
        $size = wc_get_image_size( 'shop_featured' );
        return $size['height'];
    } endif;
    if ( ! function_exists( 'yit_shop_featured_c' ) ) : function yit_shop_featured_c() {
        $size = wc_get_image_size( 'shop_featured' );
        return $size['crop'];
    } endif;



// shop large
if ( ! function_exists( 'yit_shop_large_w' ) ) {
    function yit_shop_large_w() {

        $size = wc_get_image_size( 'shop_single' );

        return $size['width'];
    }
}
if ( ! function_exists( 'yit_shop_large_h' ) ) {
    function yit_shop_large_h() {

        $size = wc_get_image_size( 'shop_single' );

        return $size['height'];
    }
}

// print style for small thumb size
function yit_size_images_style() {
    $content_width     = yit_get_sidebar_layout() == 'sidebar-no' ? 1170 : 870;
    $margin            = 30 / $content_width * 100; // 30px
    $margin_thumbnails = 8 / $content_width * 100; // 8px

    $images_container_w     = yit_shop_single_w() / $content_width * 100;
    $thumbnails_container_w = $content_width - ( yit_shop_single_w() + 30 ) - $margin_thumbnails;
    ?>
    <style type="text/css">

        .single-product.woocommerce div.product div.images {
            width: <?php echo $images_container_w ?>%;
        }

        .single-product.woocommerce div.product div.summary {
            width: <?php echo 100 - $images_container_w - $margin ?>%;
        }

            /* WooCommerce standard images */
        .single-product .images .thumbnails > a {
            width: <?php echo min( yit_shop_thumbnail_w(), 80 ) ?>px !important;
            height: <?php echo min( yit_shop_thumbnail_h(), 80 ) ?>px !important;
        }

            /* Slider images */
        .single-product .images .thumbnails li img {
            max-width: <?php echo min( yit_shop_thumbnail_w(), 80 ) ?>px !important;
        }

            /* Desktop above 1200px */

        <?php
        $single_product_image = get_option( 'shop_single_image_size' );
        $hard_crop_sp_image = $single_product_image['crop'];

        if( $hard_crop_sp_image ) :
        ?>
            .single-product div.images .yith_magnifier_zoom_wrap a img,
            .single-product div.images > a img {
                width: <?php echo yit_shop_large_w() ?>px;
                height: <?php echo yit_shop_large_h() ?>px;
            }

        <?php
        endif;
        ?>
            /* WooCommerce standard images */
            .single-product .images .thumbnails > a, .single-product .images .thumbnails li {
                width: <?php echo min( yit_shop_thumbnail_w(), 100 ) ?>px !important;
                height: <?php echo min( yit_shop_thumbnail_h(), 100 ) ?>px !important;
            }

            /* Slider images */
            .single-product .images .thumbnails li img {
                max-width: <?php echo min( yit_shop_thumbnail_w(), 100 ) ?>px !important;
            }


            /* Desktop above 1200px */
        @media (max-width: 979px) and (min-width: 768px) {
            /* WooCommerce standard images */
            .single-product .images .thumbnails > a, .single-product .images .thumbnails li {
                width: <?php echo min( yit_shop_thumbnail_w(), 63 ) ?>px !important;
                height: <?php echo min( yit_shop_thumbnail_h(), 63 ) ?>px !important;
            }

            /* Slider images */
            .single-product .images .thumbnails li img {
                max-width: <?php echo min( yit_shop_thumbnail_w(), 63 ) ?>px !important;
            }
        }

            /* Below 767px, mobiles included */
        @media (max-width: 767px) {
            .single-product div.images,
            .single-product div.summary {
                float: none;
                margin-left: 0px !important;
                width: 100% !important;
            }

            .single-product div.images {
                margin-bottom: 20px;
            }

            /* WooCommerce standard images */
            .single-product .images .thumbnails > a, .single-product .images .thumbnails li {
                width: <?php echo min( yit_shop_thumbnail_w(), 65 ) ?>px !important;
                height: <?php echo min( yit_shop_thumbnail_h(), 65 ) ?>px !important;
            }

            /* Slider images */
            .single-product .images .thumbnails li img {
                max-width: <?php echo min( yit_shop_thumbnail_w(), 65 ) ?>px !important;
            }
        }



    </style>
<?php
}

// ADD IMAGE CATEGORY OPTION
function yit_add_featured_products_slider_image_size( $options ) {

    global $woocommerce;

    $field_featured = array(
        'name' => __( 'Featured Products Widget', 'woocommerce' ),
        'desc'   => __( 'This size is usually used for the products thubmnails in the slider widget Featured Products.', 'yit' ),
        'id'   => 'shop_featured_image_size',
        'css'   => '',
        'type'   => 'image_width',
        'default' => array(
            'width' => 160,
            'height' => 160,
            'crop' => true
        ),
        'std'   => array(
            'width' => 160,
            'height' => 160,
            'crop' => true
        ),
        'desc_tip' =>  true,
    );

    $field_responsive = array(
        'name'  => __( 'Active responsive images', 'yit' ),
        'desc'   => __( 'Active this to make the images responsive and adaptable to the layout grid.', 'yit' ),
        'id'   => 'woocommerce_responsive_images',
        'std'   => 'yes',
        'default'   => 'yes',
        'type'   => 'checkbox'
    );

    $offset  = -6;
    $start   = array_slice( $options, 0, count( $options ) + $offset );
    $end     = array_slice( $options, $offset );
    $options = array_merge( $start, array( $field_featured, $field_responsive ), $end );

    return $options;
}

function yit_add_featured_image_size() {
    return get_option( 'shop_featured_image_size', array() );
}

// ADD IMAGE RESPONSIVE OPTION
function yit_add_responsive_image_option( $options ) {
    $tmp = $options[count( $options ) - 1];
    unset( $options[count( $options ) - 1] );

    $options[] = array(
        'name'    => __( 'Active responsive images', 'yit' ),
        'desc'    => __( 'Active this to make the images responsive and adaptable to the layout grid.', 'yit' ),
        'id'      => 'woocommerce_responsive_images',
        'std'     => 'yes',
        'default' => 'yes',
        'type'    => 'checkbox'
    );

    $options[] = $tmp;

    return $options;
}


/** NAV MENU
-------------------------------------------------------------------- */

add_action( 'admin_init', array( 'yitProductsPricesFilter', 'admin_init' ) );

class yitProductsPricesFilter {
    // We cannot call #add_meta_box yet as it has not been defined,
    // therefore we will call it in the admin_init hook
    static function admin_init() {

        if ( ! is_shop_enabled() || basename( $_SERVER['PHP_SELF'] ) != 'nav-menus.php' ) {
            return;
        }

        wp_enqueue_script( 'nav-menu-query', YIT_THEME_ASSETS_URL . '/js/metabox_nav_menu.js', 'nav-menu', false, true );
        add_meta_box( 'products-by-prices', 'Prices Filter', array( __CLASS__, 'nav_menu_meta_box' ), 'nav-menus', 'side', 'low' );
    }

    function nav_menu_meta_box() {
        ?>

        <div class="prices">
            <input type="hidden" name="woocommerce_currency" id="woocommerce_currency" value="<?php echo get_woocommerce_currency_symbol( get_option( 'woocommerce_currency' ) ) ?>" />
            <input type="hidden" name="woocommerce_shop_url" id="woocommerce_shop_url" value="<?php echo get_option( 'permalink_structure' ) == '' ? YIT_SITE_URL . '/?post_type=product' : get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ?>" />
            <input type="hidden" name="menu-item[-1][menu-item-url]" value="" />
            <input type="hidden" name="menu-item[-1][menu-item-title]" value="" />
            <input type="hidden" name="menu-item[-1][menu-item-type]" value="custom" />

            <p>
                <?php _e( sprintf( 'The values are already expressed in %s', get_woocommerce_currency_symbol( get_option( 'woocommerce_currency' ) ) ), 'yit' ) ?>
            </p>

            <p>
                <label class="howto" for="prices_filter_from">
                    <span><?php _e( 'From', 'yit' ); ?></span>
                    <input id="prices_filter_from" name="prices_filter_from" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e( 'From', 'yit' ); ?>" />
                </label>
            </p>

            <p style="display: block; margin: 1em 0; clear: both;">
                <label class="howto" for="prices_filter_to">
                    <span><?php _e( 'To', 'yit' ); ?></span>
                    <input id="prices_filter_to" name="prices_filter_to" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e( 'To' ); ?>" />
                </label>
            </p>

            <p class="button-controls">
			<span class="add-to-menu">
				<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" style="display: none;" />
				<input type="submit" class="button-secondary submit-add-to-menu" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-custom-menu-item" />
			</span>
            </p>

        </div>
    <?php
    }
}

/**
 * Add 'On Sale Filter to Product list in Admin
 */
add_filter( 'parse_query', 'on_sale_filter' );
function on_sale_filter( $query ) {
    global $pagenow, $typenow, $wp_query;

    if ( $typenow == 'product' && isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] ) :

        if ( $_GET['onsale_check'] == 'yes' ) :
            $query->query_vars['meta_compare'] = '>';
            $query->query_vars['meta_value']   = 0;
            $query->query_vars['meta_key']     = '_sale_price';
        endif;

        if ( $_GET['onsale_check'] == 'no' ) :
            $query->query_vars['meta_value'] = '';
            $query->query_vars['meta_key']   = '_sale_price';
        endif;

    endif;
}

add_action( 'restrict_manage_posts', 'woocommerce_products_by_on_sale' );
function woocommerce_products_by_on_sale() {
    global $typenow, $wp_query;
    if ( $typenow == 'product' ) :

        $onsale_check_yes = '';
        $onsale_check_no  = '';

        if ( isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] == 'yes' ) :
            $onsale_check_yes = ' selected="selected"';
        endif;

        if ( isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] == 'no' ) :
            $onsale_check_no = ' selected="selected"';
        endif;

        $output = "<select name='onsale_check' id='dropdown_onsale_check'>";
        $output .= '<option value="">' . __( 'Show all products (Sale Filter)', 'yit' ) . '</option>';
        $output .= '<option value="yes"' . $onsale_check_yes . '>' . __( 'Show products on sale', 'yit' ) . '</option>';
        $output .= '<option value="no"' . $onsale_check_no . '>' . __( 'Show products not on sale', 'yit' ) . '</option>';
        $output .= '</select>';

        echo $output;

    endif;
}


if ( yit_get_option( 'shop-customer-vat' ) && yit_get_option( 'shop-customer-ssn' ) ) {

    add_filter( 'woocommerce_billing_fields', 'woocommerce_add_billing_fields' );
    function woocommerce_add_billing_fields( $fields ) {
        //$fields['billing_country']['clear'] = true;
        $field = array( 'billing_ssn' => array(
            'label'       => apply_filters( 'yit_ssn_label', __( 'SSN', 'yit' ) ),
            'placeholder' => apply_filters( 'yit_ssn_label_x', _x( 'SSN', 'placeholder', 'yit' ) ),
            'required'    => false,
            'class'       => array( 'form-row-first' ),
            'clear'       => false
        ) );

        yit_array_splice_assoc( $fields, $field, 'billing_address_1' );

        $field = array( 'billing_vat' => array(
            'label'       => apply_filters( 'yit_vatssn_label', __( 'VAT', 'yit' ) ),
            'placeholder' => apply_filters( 'yit_vatssn_label_x', _x( 'VAT', 'placeholder', 'yit' ) ),
            'required'    => false,
            'class'       => array( 'form-row-last' ),
            'clear'       => true
        ) );

        yit_array_splice_assoc( $fields, $field, 'billing_address_1' );

        return $fields;
    }


    add_filter( 'woocommerce_shipping_fields', 'woocommerce_add_shipping_fields' );
    function woocommerce_add_shipping_fields( $fields ) {
        $field = array( 'shipping_ssn' => array(
            'label'       => apply_filters( 'yit_ssn_label', __( 'SSN', 'yit' ) ),
            'placeholder' => apply_filters( 'yit_ssn_label_x', _x( 'SSN', 'placeholder', 'yit' ) ),
            'required'    => false,
            'class'       => array( 'form-row-first' ),
            'clear'       => false
        ) );

        yit_array_splice_assoc( $fields, $field, 'shipping_address_1' );

        $field = array( 'shipping_vat' => array(
            'label'       => apply_filters( 'yit_vatssn_label', __( 'VAT', 'yit' ) ),
            'placeholder' => apply_filters( 'yit_vatssn_label_x', _x( 'VAT', 'placeholder', 'yit' ) ),
            'required'    => false,
            'class'       => array( 'form-row-last' ),
            'clear'       => true
        ) );

        yit_array_splice_assoc( $fields, $field, 'shipping_address_1' );
        return $fields;
    }


    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    function woocommerce_add_billing_shipping_fields_admin( $fields ) {
        $fields['vat'] = array(
            'label' => apply_filters( 'yit_vatssn_label', __( 'VAT', 'yit' ) )
        );
        $fields['ssn'] = array(
            'label' => apply_filters( 'yit_ssn_label', __( 'SSN', 'yit' ) )
        );

        return $fields;
    }

    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_data' );
    function woocommerce_add_var_load_order_data( $fields ) {
        $fields['billing_vat']  = '';
        $fields['shipping_vat'] = '';
        $fields['billing_ssn']  = '';
        $fields['shipping_ssn'] = '';
        return $fields;
    }


}
elseif ( yit_get_option( 'shop-customer-vat' ) ) {
    add_filter( 'woocommerce_billing_fields', 'woocommerce_add_billing_fields' );
    function woocommerce_add_billing_fields( $fields ) {
        $fields['billing_company']['class'] = array( 'form-row-first' );
        $fields['billing_company']['clear'] = false;
        //$fields['billing_country']['clear'] = true;
        $field = array( 'billing_vat' => array(
            'label'       => apply_filters( 'yit_vatssn_label', __( 'VAT/SSN', 'yit' ) ),
            'placeholder' => apply_filters( 'yit_vatssn_label_x', _x( 'VAT or SSN', 'placeholder', 'yit' ) ),
            'required'    => false,
            'class'       => array( 'form-row-last' ),
            'clear'       => true
        ) );

        yit_array_splice_assoc( $fields, $field, 'billing_address_1' );
        return $fields;
    }

    add_filter( 'woocommerce_shipping_fields', 'woocommerce_add_shipping_fields' );
    function woocommerce_add_shipping_fields( $fields ) {
        $fields['shipping_company']['class'] = array( 'form-row-first' );
        $fields['shipping_company']['clear'] = false;
        //$fields['shipping_country']['clear'] = true;
        $field = array( 'shipping_vat' => array(
            'label'       => apply_filters( 'yit_vatssn_label', __( 'VAT/SSN', 'yit' ) ),
            'placeholder' => apply_filters( 'yit_vatssn_label_x', _x( 'VAT or SSN', 'placeholder', 'yit' ) ),
            'required'    => false,
            'class'       => array( 'form-row-last' ),
            'clear'       => true
        ) );

        yit_array_splice_assoc( $fields, $field, 'shipping_address_1' );
        return $fields;
    }

    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    function woocommerce_add_billing_shipping_fields_admin( $fields ) {
        $fields['vat'] = array(
            'label' => apply_filters( 'yit_vatssn_label', __( 'VAT/SSN', 'yit' ) )
        );

        return $fields;
    }

    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_data' );
    function woocommerce_add_var_load_order_data( $fields ) {
        $fields['billing_vat']  = '';
        $fields['shipping_vat'] = '';
        return $fields;
    }
}
elseif ( yit_get_option( 'shop-customer-ssn' ) ) {
    add_filter( 'woocommerce_billing_fields', 'woocommerce_add_billing_ssn_fields' );
    function woocommerce_add_billing_ssn_fields( $fields ) {
        $fields['billing_company']['class'] = array( 'form-row-first' );
        $fields['billing_company']['clear'] = false;
        $field                              = array( 'billing_ssn' => array(
            'label'       => apply_filters( 'yit_ssn_label', __( 'SSN', 'yit' ) ),
            'placeholder' => apply_filters( 'yit_ssn_label_x', _x( 'SSN', 'placeholder', 'yit' ) ),
            'required'    => false,
            'class'       => array( 'form-row-last' ),
            'clear'       => true
        ) );

        yit_array_splice_assoc( $fields, $field, 'billing_address_1' );
        return $fields;
    }

    add_filter( 'woocommerce_shipping_fields', 'woocommerce_add_shipping_ssn_fields' );
    function woocommerce_add_shipping_ssn_fields( $fields ) {
        $fields['shipping_company']['class'] = array( 'form-row-first' );
        $fields['shipping_company']['clear'] = false;
        $field                               = array( 'shipping_ssn' => array(
            'label'       => apply_filters( 'yit_ssn_label', __( 'SSN', 'yit' ) ),
            'placeholder' => apply_filters( 'yit_ssn_label_x', _x( 'SSN', 'placeholder', 'yit' ) ),
            'required'    => false,
            'class'       => array( 'form-row-last' ),
            'clear'       => true
        ) );

        yit_array_splice_assoc( $fields, $field, 'shipping_address_1' );
        return $fields;
    }

    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_ssn_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_ssn_fields_admin' );
    function woocommerce_add_billing_shipping_ssn_fields_admin( $fields ) {
        $fields['ssn'] = array(
            'label' => apply_filters( 'yit_ssn_label', __( 'SSN', 'yit' ) )
        );

        return $fields;
    }

    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_ssn_data' );
    function woocommerce_add_var_load_order_ssn_data( $fields ) {
        $fields['billing_ssn']  = '';
        $fields['shipping_ssn'] = '';
        return $fields;
    }
}


if ( yit_get_option( 'shop-fields-order' ) ) {
    add_filter( 'woocommerce_billing_fields', 'woocommerce_restore_billing_fields_order' );
    function woocommerce_restore_billing_fields_order( $fields ) {
        global $woocommerce;


        $fields['billing_country']['class'][0] = 'form-row-first';
        $fields['billing_address_1']['class'][0] = 'form-row-first';
        $fields['billing_address_2']['class'][0] = 'form-row-last';

        /* FIX WOO 2.1.x */
        if ( version_compare( preg_replace( '/-beta-([0-9]+)/', '', $woocommerce->version ), '2.1', '>=' ) ) {
            $fields['billing_country']['class'][0] = 'form-row-wide';
        }

        $country = $fields['billing_country'];
        unset( $fields['billing_country'] );
        yit_array_splice_assoc( $fields, array('billing_country' => $country), 'billing_postcode' );

        return $fields;
    }

    add_filter( 'woocommerce_shipping_fields' , 'woocommerce_restore_shipping_fields_order' );
    function woocommerce_restore_shipping_fields_order( $fields ) {
        global $woocommerce;


        $fields['shipping_country']['class'][0] = 'form-row-first';
        $fields['shipping_address_1']['class'][0] = 'form-row-first';
        $fields['shipping_address_2']['class'][0] = 'form-row-last';

        /* FIX WOO 2.1.x */
        if ( version_compare( preg_replace( '/-beta-([0-9]+)/', '', $woocommerce->version ), '2.1', '>=' ) ) {
            $fields['shipping_country']['class'][0] = 'form-row-wide';
            $fields['shipping_postcode']['class'][0] = 'form-row-wide';
        }

        $country = $fields['shipping_country'];
        unset( $fields['shipping_country'] );
        yit_array_splice_assoc( $fields, array('shipping_country' => $country), 'shipping_postcode' );

        return $fields;
    }
}


/**
 * Return the following cart info:
 *    - items
 *  - subtotal
 *  - currency
 *
 * @return array
 */
function yit_get_current_cart_info() {
    global $woocommerce;

    if ( get_option( 'woocommerce_display_cart_prices_excluding_tax' ) == 'yes' || $woocommerce->customer->is_vat_exempt() ) {
        $subtotal = $woocommerce->cart->subtotal_ex_tax;
    }
    else {
        $subtotal = $woocommerce->cart->subtotal;
    }

    $items = yit_get_option( 'minicart-total-items' ) ? $woocommerce->cart->get_cart_contents_count() : count( $woocommerce->cart->get_cart() );

    return array(
        $items,
        $subtotal,
        get_woocommerce_currency_symbol()
    );
}

function yit_format_cart_subtotal( $price ) {
    $num_decimals = (int) get_option( 'woocommerce_price_num_decimals' );

    $price = apply_filters( 'raw_woocommerce_price', (double) $price );
    $price = number_format( $price, $num_decimals, stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ), stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) );

    return explode( get_option( 'woocommerce_price_decimal_sep' ), $price );
}

function yit_add_to_cart_success_ajax( $datas ) {
    global $woocommerce;

    list( $cart_items, $cart_subtotal, $cart_currency ) = yit_get_current_cart_info();

    $label                                             = $cart_items == 1 ? __( 'Item', 'yit' ) : __( 'Items', 'yit' );
    $datas['.yit_cart_widget .cart_label .cart-items'] = '<a class="cart-items" href="' . $woocommerce->cart->get_cart_url() . '"><span class="cart-items-number">' . $cart_items . '</span> ' . $label;


    return $datas;
}

add_filter( 'add_to_cart_fragments', 'yit_add_to_cart_success_ajax' );



/**
 * Backup woocoomerce options when create the export gz
 *
 */
function yit_save_woocommerce_tables( $tables ) {
    $tables[] = 'woocommerce_termmeta';
    $tables[] = 'woocommerce_attribute_taxonomies';
    return $tables;
}

/**
 * Backup woocoomerce options when create the export gz
 *
 */
function yit_save_woocommerce_options( $options ) {
    $options[] = '%woocommerce%';
    $options[] = '%wc_average_rating%';
    $options[] = '%wc_product_children_ids%';
    $options[] = '%wc_term_counts%';
    $options[] = '%wc_products_onsale%';
    $options[] = '%wc_needs_pages%';
    $options[] = '%wc_needs_update%';
    $options[] = '%wc_activation_redirect%';
    $options[] = '%wc_hidden_product_ids%';
    $options[] = '%shop_catalog_image_size%';
    $options[] = '%shop_featured_image_size%';
    $options[] = '%shop_single_image_size%';
    $options[] = '%shop_thumbnail_image_size%';

    return $options;
}


function woocommerce_taxonomy_archive_description() {
    if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
        global $wp_query;

        $cat          = $wp_query->get_queried_object();
        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
        $image        = wp_get_attachment_image_src( $thumbnail_id, 'full' );

        $description = apply_filters( 'the_content', term_description() );

        if ( $image && yit_get_option( 'shop-category-image' ) == 1 ) {
            echo '<div class="term-header-image"><img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[1] . '" alt="' . $cat->name . '" /></div>';
        }

        if ( $description ) {
            echo '<div class="term-description">' . $description . '</div>';
        }
    }
}




/**
 * Ajax search products
 */
function yit_ajax_search_products() {
    global $woocommerce;

    $search_keyword = esc_attr( $_REQUEST['query'] );
    $ordering_args  = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );
    $products       = array();

    $args           = array(
        's'                   => apply_filters( 'yit_ajax_search_products_search_query', $search_keyword ),
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby'             => $ordering_args['orderby'],
        'order'               => $ordering_args['order'],
        'posts_per_page'      => apply_filters( 'yit_ajax_search_products_posts_per_page', 10 ),
        'meta_query'          => array(
            array(
                'key'     => '_visibility',
                'value'   => array( 'catalog', 'visible' ),
                'compare' => 'IN'
            )
        )
    );
    $products_query = new WP_Query( $args );

    if ( $products_query->have_posts() ) {
        while ( $products_query->have_posts() ) {
            $products_query->the_post();

            $products[] = array(
                'id'    => get_the_ID(),
                'value' => get_the_title(),
                'url'   => get_permalink()
            );
        }
    }
    else {
        $products[] = array(
            'id'    => - 1,
            'value' => __( 'No results', 'yit' ),
            'url'   => ''
        );
    }
    wp_reset_postdata();


    $products = array(
        'suggestions' => $products
    );


    echo json_encode( $products );
    die();
}

add_action( 'wp_ajax_yit_ajax_search_products', 'yit_ajax_search_products' );
add_action( 'wp_ajax_nopriv_yit_ajax_search_products', 'yit_ajax_search_products' );


/* Function to add compatibility with WC 2.1 */
function yit_woocommerce_primary_start() {
    wc_get_template( '/global/primary-start.php' );
}

function yit_woocommerce_primary_end() {
    wc_get_template( '/global/primary-end.php' );
}

function yit_enqueue_wc_styles( $styles ) {
    unset( $styles['woocommerce-layout'], $styles['woocommerce-smallscreen'], $styles['woocommerce-general'] );

    $styles ['yit-layout'] = array(
        'src'     => get_stylesheet_directory_uri() . '/woocommerce/style.css',
        'deps'    => '',
        'version' => '1.0',
        'media'   => ''
    );
    return $styles;
}

/* Fix Price Old Style */

// Use WC 2.0 variable price format, now include sale price strikeout
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_price_format', 10, 2 );

function wc_wc20_price_format( $price, $product ) {
    // Main Price
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $price = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
    // Sale Price
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $saleprice = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    if ( $price !== $saleprice ) {

        $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }
    return '<span class="from">'.__("from").'</span>&nbsp;'.$price;
}

// Place in your theme's functions.php file
// Revert grouped product prices to WooCommerce 2.0 format
add_filter( 'woocommerce_grouped_price_html', 'wc_wc20_grouped_price_format', 10, 2 );
function wc_wc20_grouped_price_format( $price, $product ) {
    $tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
    $child_prices     = array();

    foreach ( $product->get_children() as $child_id ) {
        $child_prices[] = get_post_meta( $child_id, '_price', true );
    }

    $child_prices     = array_unique( $child_prices );
    $get_price_method = 'get_price_' . $tax_display_mode . 'uding_tax';

    if ( ! empty( $child_prices ) ) {
        $min_price = min( $child_prices );
        $max_price = max( $child_prices );
    } else {
        $min_price = '';
        $max_price = '';
    }

    if ( $min_price == $max_price ) {
        $display_price = wc_price( $product->$get_price_method( 1, $min_price ) );
    } else {
        $from          = wc_price( $product->$get_price_method( 1, $min_price ) );
        $display_price = sprintf( __( '%1$s', 'woocommerce' ), $from );
    }
    return '<span class="from">'.__("from").'</span>&nbsp;'.$display_price;
}

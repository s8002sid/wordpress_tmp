<?php
/**
 * Your Inspiration Themes
 * 
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
 
/**
 * Class to print fields in the tab Shop -> Products details page
 * 
 * @since 1.0.0
 */
class YIT_Submenu_Tabs_Theme_option_Shop_Products_details_page extends YIT_Submenu_Tabs_Abstract {
    /**
     * Default fields
     * 
     * @var array
     * @since 1.0.0
     */
    public $fields;
    
    /**
     * Merge default fields with theme specific fields using the filter yit_submenu_tabs_theme_option_shop_products_details_page
     * 
     * @param array $fields
     * @since 1.0.0
     */
    public function __construct() {
        $fields = $this->init();
        $this->fields = apply_filters( strtolower( __CLASS__ ), $fields );
    }
    
    /**
     * Set default values
     * 
     * @return array
     * @since 1.0.0
     */
    public function init() {
        return array(
            40 => array(
                'id'   => 'shop-single-show-breadcrumb',
                'type' => 'onoff',
                'name' => __( 'Show breadcrumb', 'yit' ),
                'desc' => __( 'Say if you want the breadcrumb in the product detail page.', 'yit' ),
                'std'  => true,
            ),
        	60 => array(
                'id'   => 'shop-products-details-title',
                'type' => 'onoff',
                'name' => __( 'Show products details page title', 'yit' ),
                'desc' => __( 'Activate/Deactivate the page title on Products details.', 'yit' ),
                'std'  => true,
            ),
            250 => array(
                'id'   => 'shop-show-metas',
                'type' => 'onoff',
                'name' => __( 'Show product metas (categories and tags)', 'yit' ),
                'desc' => __( 'Say if you want to show product metas in your single product page. It also remove Bands if you are using WooCommerce Brands Addon.', 'yit' ),
                'std'  => apply_filters( 'yit_shop-show-metas_std', 1 ),
            )
        );
    }
}
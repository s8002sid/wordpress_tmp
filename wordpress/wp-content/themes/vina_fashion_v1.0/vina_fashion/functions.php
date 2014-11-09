<?php
    /**
 * @package Vina Fashion
 * @author VinaThemes.biz http://www.VinaThemes.biz
 * @copyright Copyright (c) 2013 VinaThemes.biz
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

    define('_THEME', get_template()); //Define _THEME

    $require_helix_text = '"'.wp_get_theme().'" required Helix plugin. <a target="_blank" href="http://www.joomshaper.com/helix/wordpress">Please install and activate Helix plugin.</a>';

    function showMessage()
    {
        global $require_helix_text;
        echo '<div id="message" class="error">';
        echo "<p><strong>$require_helix_text</strong></p></div>";
    }

    if( !class_exists('Helix') ){
        if( is_admin() and $pagenow=='customize.php' ){
            wp_die( $require_helix_text );
        }
        elseif(!is_admin()){
            wp_die( $require_helix_text );
        } else {
            add_action('admin_notices', 'showMessage');
            return;
        }
    }

    Helix::getInstance();
    $_preset = Helix::preset(); 
    $_direction = Helix::direction(); 

    if(!is_admin()) {
        Helix::setLessVariables(array(
                'preset'=> $_preset,
                'bg_color'=> Helix::PresetParam('_bg'),
                'header_color'=> Helix::PresetParam('_header'),
                'text_color'=> Helix::PresetParam('_text'),
                'link_color'=> Helix::PresetParam('_link')
            ))
        ->addLess('master', 'theme')
        ->addLess( 'presets',  'presets/'. $_preset );
        Helix::addJS('menu.js');
    }

    //add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') ); //for future use
	add_action( 'widgets_init', 'override_woocommerce_widgets', 15 );
 
	function override_woocommerce_widgets() {
	  // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
	 
	  if ( class_exists( 'WP_Widget' ) ) {
		unregister_widget( 'WP_Widget' );
	 
		include_once( 'widgets/class-wc-widget-best-sellers.php' );
	 
		register_widget( 'Custom_WooCommerce_Widget_Best_Sellers' );
	  }
	 
	}
	
	
	add_action( 'widgets_init', 'override_woocommerce_widgets_1', 15 );
 
	function override_woocommerce_widgets_1() {
	  // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
	 
	  if ( class_exists( 'WP_Widget' ) ) {
		unregister_widget( 'WP_Widget' );
	 
		include_once( 'widgets/class-wc-widget-cart.php' );
	 
		register_widget( 'WOOC_Widget_Cart' );
	  }
	 
	}
	
	add_action( 'widgets_init', 'override_woocommerce_widgets_2', 15 );
 
	function override_woocommerce_widgets_2() {
	  // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
	 
	  if ( class_exists( 'WP_Widget' ) ) {
		unregister_widget( 'WP_Widget' );
	 
		include_once( 'widgets/class-wc-widget-layered-nav.php' );
	 
		register_widget( 'Vina_Widget_Layered_Nav' );
	  }
	 
	}
	
	register_nav_menus( array(
		 'twomenu' => __( 'Two Menu', 'Helix'),
		 ) );


	// Redefine woocommerce_output_related_products()
function woocommerce_output_related_products() {
woocommerce_related_products(4,4); // Display 4 products in rows of 2
}
if( isset( $_GET['product_cat'] ) ){ 
    add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 16;' ) ); 
} else {
    add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 4;' ) );
}



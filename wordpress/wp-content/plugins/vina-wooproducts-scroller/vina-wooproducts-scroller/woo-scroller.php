<?php
/*
Plugin Name:  Vina Wooproducts Scroller
Plugin URI: http://VinaThemes.biz
Description: This is a highly customizable plugin to show you or your customer's services, portfolio items, blog products ... basically all business information thinkable.
Version: 1.0
Author: VinaThemes
Author URI: http://VinaThemes.biz
Author email: mr_hiennc@yahoo.com
Demo URI: http://VinaDemo.biz
Forum URI: http://laptrinhvien-vn.com
License: GPLv3+
*/

//Defined global variables
if(!defined('VINA_WOO_SCROLLER_DIRECTORY')) 	define('VINA_WOO_SCROLLER_DIRECTORY', dirname(__FILE__));
if(!defined('VINA_WOO_SCROLLER_INC_DIRECTORY')) define('VINA_WOO_SCROLLER_INC_DIRECTORY', VINA_WOO_SCROLLER_DIRECTORY . '/includes');
if(!defined('VINA_WOO_SCROLLER_URI')) 		define('VINA_WOO_SCROLLER_URI', get_bloginfo('url') . '/wp-content/plugins/vina-wooproducts-scroller');
if(!defined('VINA_WOO_SCROLLER_INC_URI')) 	define('VINA_WOO_SCROLLER_INC_URI', VINA_WOO_SCROLLER_URI . '/includes');

//Include library
if(!defined('TCVN_FUNCTIONS')) {
    include_once VINA_WOO_SCROLLER_INC_DIRECTORY . '/functions.php';
    define('TCVN_FUNCTIONS', 1);
}
if(!defined('TCVN_FIELDS')) {
    include_once VINA_WOO_SCROLLER_INC_DIRECTORY . '/fields.php';
    define('TCVN_FIELDS', 1);
}
if(!defined('TCVN_WOO_FIELD')) {
    include_once VINA_WOO_SCROLLER_INC_DIRECTORY . '/field_woo.php';
    define('TCVN_WOO_FIELD', 1);
}
if(!defined('TCVN_WOO_FUNCTION')) {
    include_once VINA_WOO_SCROLLER_INC_DIRECTORY . '/woo-function.php';
    define('TCVN_WOO_FUNCTION', 1);
}

class WooScroller_Widget extends WP_Widget 
{
    function WooScroller_Widget()
    {
        $widget_ops = array(
            'classname' => 'wooscroller_widget',
            'description' => __("This is a highly customizable plugin to show you or your customer's services, portfolio items, blog contents ... basically all business information thinkable.")
        );
        $this->WP_Widget('wooscroller_widget', __('Vina Wooproducts Scroller'), $widget_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args( 
            (array) $instance, 
            array( 
                'title' 	=> '',
                'category_name' => '',
                'noItem' 	=> '5',
                'ordering' 	=> 'id',
                'orderingDirection' => 'desc',
                
                'width'		=> '545',
                'height'	=> '290',
                'moduleStyle'   => 'theme1',
                'slideAmount'	=> '2',
                'slideSpacing'	=> '30',
                'touchEnabled'	=> 'on',
                'mouseWheel'	=> 'on',
                'hoverAlpha'	=> 'off',
                'hoverEffect'	=> 'on',
                'slideshow'	=> '3000',

                'showTitle'	=> 'yes',
                'linkTitle'	=> 'no',
                'thumbImage'	=> 'yes',
                'imageWidth'	=> '258',
                'imageHeight'	=> '130',
                'linkImage'	=> 'yes',
                'readmore'	=> 'yes',
                'display_type'  => 'none',
                'show_description'  => 'yes',
                'limit_description' => '8',
                'show_price'    => 'yes'
            )
        );

        $title			= esc_attr($instance['title']);
        $category_name		= $instance['category_name'];
        $noItem			= esc_attr($instance['noItem']);
        $ordering		= esc_attr($instance['ordering']);
        $orderingDirection      = esc_attr($instance['orderingDirection']);

        $width			= esc_attr($instance['width']);
        $height			= esc_attr($instance['height']);
        $moduleStyle            = esc_attr($instance['moduleStyle']);
        $slideAmount            = esc_attr($instance['slideAmount']);
        $slideSpacing           = esc_attr($instance['slideSpacing']);
        $touchEnabled           = esc_attr($instance['touchEnabled']);
        $mouseWheel		= esc_attr($instance['mouseWheel']);
        $hoverAlpha		= esc_attr($instance['hoverAlpha']);
        $hoverEffect            = esc_attr($instance['hoverEffect']);
        $slideshow		= esc_attr($instance['slideshow']);

        $showTitle		= esc_attr($instance['showTitle']);
        $linkTitle		= esc_attr($instance['linkTitle']);
        $thumbImage		= esc_attr($instance['thumbImage']);
        $imageWidth		= esc_attr($instance['imageWidth']);
        $imageHeight            = esc_attr($instance['imageHeight']);
        $linkImage		= esc_attr($instance['linkImage']);
        $readmore		= esc_attr($instance['readmore']);
        $display_type           = esc_attr($instance['display_type']);
        $show_description       = esc_attr($instance['show_description']);
        $limit_description      = esc_attr($instance['limit_description']);
        $category               = (!empty($category_name)) ? implode(",",$category_name) : ''; 
        $Shortcode		= "[wooscroller_widget id='".$this->id_base."-".$this->number."' category_name='".$category."']";

        ?>
        <div id="tcvn-accordion" class="tcvn-plugins-container">
            <div id="tcvn-tabs-container">
                <ul id="tcvn-tabs">
                    <li class="active"><a href="#basic"><?php _e('Basic'); ?></a></li>
                    <li><a href="#display"><?php _e('Display'); ?></a></li>
                    <li><a href="#advanced"><?php _e('Advanced'); ?></a></li>
                </ul>
            </div>
            <div id="tcvn-elements-container">
                <!-- Basic Block -->
                <div id="basic" class="tcvn-telement" style="display: block;">
                    <p><input type="hidden" id="<?php echo $this->get_field_id('id') ?>" name="<?php echo $this->get_field_name('id') ?>" value="<?php echo $this->id; ?>" /></p>
                    <p><?php echo eTextField($this, 'Shortcode', 'Shortcode', $Shortcode); ?></p>
                    <p><?php echo eTextField($this, 'title', 'Title', $title); ?></p>
                    <p><?php echo eSelectOption($this, 'display_type', 'Type Display Products',array('none'=>'New Products', 'recentproducts'=>'Recent products','topratedproducts'=>'Top rated products','recentlyviewedproducts'=>'Recently viewed products','featuredproducts'=>'Featured Products','bestsellingproducts'=>'Best Selling Products'), $display_type); ?></p>
                    <p><?php echo eSelectDataWoo($this,'category_name', 'Category', buildWooCategoriesList('Select all Categories.'),$category_name); ?></p>
                    <p><?php echo eTextField($this, 'noItem', 'Number of Product', $noItem, 'Number of product to show. Default is: 5.'); ?></p>
                    <p><?php echo eSelectOption($this, 'ordering', 'Product Field to Order By', array('id'=>'ID', 'title'=>'Title', 'comment_count'=>'Comment Count', 'post_date'=>'Published Date'), $ordering); ?></p>
                    <p><?php echo eSelectOption($this, 'orderingDirection', 'Ordering Direction', array('asc'=>'Ascending', 'desc'=>'Descending'), $orderingDirection, 'Select the direction you would like Articles to be ordered by.'); ?></p>
                </div>
                <!-- Display Block -->
                <div id="display" class="tcvn-telement">
                    <p><?php echo eTextField($this, 'width', 'Module Width', $width); ?></p>
                    <p><?php echo eTextField($this, 'height', 'Module Height', $height); ?></p>
                    <p><?php echo eSelectOption($this, 'moduleStyle', 'Module Style', array('theme1'=>'White Theme', 'theme2'=>'Black Theme'), $moduleStyle); ?></p>
                    <p><?php echo eTextField($this, 'slideAmount', 'Slide Amount', $slideAmount); ?></p>
                    <p><?php echo eTextField($this, 'slideSpacing', 'Slide Spacing', $slideSpacing); ?></p>
                    <p><?php echo eSelectOption($this, 'touchEnabled', 'Touch Enabled', array('on'=>'Enable', 'off'=>'Disable'), $touchEnabled); ?></p>
                    <p><?php echo eSelectOption($this, 'mouseWheel', 'Mouse Wheel',array('on'=>'Enable', 'off'=>'Disable'), $mouseWheel); ?></p>
                    <p><?php echo eSelectOption($this, 'hoverAlpha', 'Hover Alpha',array('on'=>'Enable', 'off'=>'Disable'), $hoverAlpha); ?></p>
                    <p><?php echo eSelectOption($this, 'hoverEffect', 'Hover Effect',array('on'=>'Enable', 'off'=>'Disable'), $hoverEffect); ?></p>
                    <p><?php echo eTextField($this, 'slideshow', 'Duration Time (ms)', $slideshow); ?></p>  
                </div>
                <!-- Advanced Block -->
                <div id="advanced" class="tcvn-telement">
                    <p><?php echo eSelectOption($this, 'showTitle', 'Product Title', array('yes'=>'Show', 'no'=>'Hide'), $showTitle); ?></p>
                    <p><?php echo eSelectOption($this, 'linkTitle', 'Link on Title',array('yes'=>'Yes', 'no'=>'No'), $linkTitle); ?></p>
                    <p><?php echo eSelectOption($this, 'thumbImage', 'Thumbnail Image', array('yes'=>'Show thumbnail image', 'no'=>'Hide thumbnail image'), $thumbImage); ?></p>
                    <p><?php echo eTextField($this, 'imageWidth', 'Image Width (px)', $imageWidth); ?></p>
                    <p><?php echo eTextField($this, 'imageHeight', 'Image Height (px)', $imageHeight); ?></p>
                    <p><?php echo eSelectOption($this, 'linkImage', 'Link on Image', array('yes'=>'Yes', 'no'=>'No'), $linkImage); ?></p>
                    <p><?php echo eSelectOption($this, 'show_description', 'Show Description', array('yes'=>'Yes', 'no'=>'No'), $show_description); ?></p>
                    <p><?php echo eTextField($this, 'limit_description', 'Description Limit', $limit_description); ?></p>
                    <p><?php echo eSelectOption($this, 'readmore', 'Add To Cart', array('yes'=>'Show', 'no'=>'Hide'), $readmore); ?></p>
                    <p><?php echo eSelectOption($this, 'show_price', 'Show Price', array('yes'=>'Show', 'no'=>'Hide'), $show_price); ?></p>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready(function($){
                var prefix = '#tcvn-accordion ';
                $(prefix + "li").click(function() {
                    $(prefix + "li").removeClass('active');
                    $(this).addClass("active");
                    $(prefix + ".tcvn-telement").hide();

                    var selectedTab = $(this).find("a").attr("href");
                    $(prefix + selectedTab).show();

                    return false;
                });
            });
        </script>
        <?php
	}
	
	function update($new_instance, $old_instance) 
	{
            return $new_instance;
	}
	
	function widget($args, $instance) 
	{
            global $woocommerce;
            extract($args);

            $title 			= getConfigValue($instance, 'title',		'');
            $category_name		= getConfigValue($instance, 'category_name',	'');
            $no_item                    = getConfigValue($instance, 'noItem',		'5');
            $ordering                   = getConfigValue($instance, 'ordering',		'id');
            $ordering_direction         = getConfigValue($instance, 'orderingDirection',	'desc');

            $width			= getConfigValue($instance, 'width',	'545');
            $height			= getConfigValue($instance, 'height',	'290');
            $module_style               = getConfigValue($instance, 'moduleStyle',	'theme1');
            $slide_amount               = getConfigValue($instance, 'slideAmount',	'2');
            $slide_spacing              = getConfigValue($instance, 'slideSpacing',	'30');
            $touch_enabled              = getConfigValue($instance, 'touchEnabled',	'on');
            $mouse_wheel		= getConfigValue($instance, 'mouseWheel',	'on');
            $hover_alpha		= getConfigValue($instance, 'hoverAlpha',	'off');
            $hover_effect               = getConfigValue($instance, 'hoverEffect',	'on');
            $slide_show                 = getConfigValue($instance, 'slideshow',	'0');

            $show_title                 = getConfigValue($instance, 'showTitle',	'yes');
            $link_title                 = getConfigValue($instance, 'linkTitle',	'yes');
            $thumb_image		= getConfigValue($instance, 'thumbImage',	'yes');
            $image_width		= getConfigValue($instance, 'imageWidth',	'258');
            $image_height               = getConfigValue($instance, 'imageHeight',	'130');
            $link_image                 = getConfigValue($instance, 'linkImage',	'yes');
            $readmore                   = getConfigValue($instance, 'readmore',		'yes');
            $display_type               = getConfigValue($instance, 'display_type',     'none');
            $show_description           = getConfigValue($instance, 'show_description', 'yes');
            $limit_description          = getConfigValue($instance, 'limit_description', '8');
            $show_price                 = getConfigValue($instance, 'show_price', 'yes');
            $products = array();
            $category_name              = (!empty($category_name)) ? implode(",",$category_name) : ''; 
            if($display_type == 'none')
            {
                $query_args = array( 
                        'post_type'      => 'product', 
                        'posts_per_page' => $no_item, 
                        'product_cat'    => $category_name, 
                        'orderby'        => $ordering
                );
            }
            else if ($display_type == 'recentproducts'){
                $query_args = array('posts_per_page' => $no_item,'product_cat' => $category_name, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product');
                $query_args['meta_query'] = array();
                if ( $show_variations == '0' ) {
                        $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                        $query_args['parent'] = '0';
                }
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query']   = array_filter( $query_args['meta_query'] );
            }
            else if($display_type == 'topratedproducts'){
                add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
                $query_args = array('posts_per_page' => $no_item, 'no_found_rows' => 1,'product_cat' => $category_name, 'post_status' => 'publish', 'post_type' => 'product' );
                $query_args['meta_query'] = $woocommerce->query->get_meta_query();
            }else if($display_type == 'recentlyviewedproducts'){
                $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
                $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

                if ( empty( $viewed_products ) )
                        return;
                $query_args = array('posts_per_page' => $no_item,'product_cat' => $category_name, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'post__in' => $viewed_products, 'orderby' => 'rand');

                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'] = array_filter( $query_args['meta_query'] );

            }else if($display_type == 'featuredproducts')
            {
                $query_args = array('posts_per_page' => $no_item,'product_cat' => $category_name, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );
                $query_args['meta_query'] = $woocommerce->query->get_meta_query();
                $query_args['meta_query'][] = array(
                        'key' => '_featured',
                        'value' => 'yes'
                );
            }else{
                $query_args = array(
                    'posts_per_page' => $no_item,
                    'post_status'    => 'publish',
                    'product_cat'    => $category_name,
                    'post_type'      => 'product',
                    'meta_key'       => 'total_sales',
                    'orderby'        => 'meta_value_num',
                    'no_found_rows'  => 1,
                );
                $query_args['meta_query'] = $woocommerce->query->get_meta_query();
            }
            $product  = new WP_Query( $query_args ); 
            $product  = $product->posts;
            $products = $product;
            if(!empty($products)) : 
                $layout = loadLayout_wooscroller();
                include $layout;
            endif;
	}
}

function loadLayout_wooscroller(){
   if(!is_file(get_template_directory().'/widgets/vina-wooproducts-scroller/default.php')){
       return dirname(__FILE__) .'/default.php';
   }
   return get_template_directory().'/widgets/vina-wooproducts-scroller/default.php';
}

function shortcode_wooscroller($atts = '') 
{
    global $woocommerce;
    extract(shortcode_atts(array(
        'id'                 => '',
        'title'              => '',
        'category_name'      => '',
        'no_item'            => '5',
        'ordering'	     => 'id',
        'ordering_direction' => 'desc',
        'width'		     => '545',
        'height'             => '290',
        'module_style'       => 'theme1',
        'slide_amount'       => '2',
        'slide_spacing'      => '30',
        'touch_enabled'      => 'on',
        'mouse_wheel'        => 'on',
        'hover_alpha'        => 'off',
        'hover_effect'	     => 'on',
        'slide_show'         => '3000',
        'show_title'         => 'yes',
        'link_title'         => 'yes',
        'thumb_image'        => 'yes',
        'image_width'        => '258',
        'image_height'	     => '130',
        'link_image'         => 'yes',
        'limit_description'  => '8',
        'show_description'   => 'yes',
        'show_price'         => 'yes',
        'display_type'       => 'none',
        'readmore'	     => 'yes'),$atts));
    ob_start();
    $products = array();
    if($display_type == 'none')
    {
        $query_args = array( 
            'post_type'      => 'product', 
            'posts_per_page' => $no_item, 
            'product_cat'    => $category_name, 
            'orderby'        => $ordering
        );
    }
    else if ($display_type == 'recentproducts'){
        $query_args = array('posts_per_page' => $no_item,'product_cat' => $category_name, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product');
        $query_args['meta_query'] = array();
        if ( $show_variations == '0' ) {
            $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $query_args['parent'] = '0';
        }
        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
        $query_args['meta_query']   = array_filter( $query_args['meta_query'] );
    }
    else if($display_type == 'topratedproducts'){
        add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
        $query_args = array('posts_per_page' => $no_item, 'no_found_rows' => 1,'product_cat' => $category_name, 'post_status' => 'publish', 'post_type' => 'product' );
        $query_args['meta_query'] = $woocommerce->query->get_meta_query();
    }else if($display_type == 'recentlyviewedproducts'){
        $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
        $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

        if ( empty( $viewed_products ) )
                return;
        $query_args = array('posts_per_page' => $no_item,'product_cat' => $category_name, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'post__in' => $viewed_products, 'orderby' => 'rand');

        $query_args['meta_query'] = array();
        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
        $query_args['meta_query'] = array_filter( $query_args['meta_query'] );

    }else if($display_type == 'featuredproducts')
    {
        $query_args = array('posts_per_page' => $no_item,'product_cat' => $category_name, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );
        $query_args['meta_query'] = $woocommerce->query->get_meta_query();
        $query_args['meta_query'][] = array(
            'key' => '_featured',
            'value' => 'yes'
        );
    }else{
        $query_args = array(
            'posts_per_page' => $no_item,
            'post_status'    => 'publish',
            'product_cat'    => $category_name,
            'post_type'      => 'product',
            'meta_key'       => 'total_sales',
            'orderby'        => 'meta_value_num',
            'no_found_rows'  => 1,
        );
        $query_args['meta_query'] = $woocommerce->query->get_meta_query();
    }
    $product  = new WP_Query( $query_args ); 
    $product  = $product->posts;
    $products = $product;

    if(!empty($products)) : 
        $layout = loadLayout_wooscroller();
        include $layout;
    endif;
    $output = ob_get_clean();
    return $output;
}


//Add button to editer
function add_wooscroller_new_button()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;
    if ( get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'add_wooscroller_tinymce_plugin');
        add_filter('mce_buttons', 'register_wooscroller_button');
    }
}

add_action('init', 'add_wooscroller_new_button');

function register_wooscroller_button($buttons){
    array_push($buttons, "|", "button_wooscroller");
    return $buttons;
}

function add_wooscroller_tinymce_plugin($plugin_array){
    $plugin_array['button_wooscroller'] = VINA_WOO_SCROLLER_INC_URI.'/js/wooscroller_shortcode.js';
    return $plugin_array;

}


wp_enqueue_script("jquery");
add_shortcode('wooscroller_widget', 'shortcode_wooscroller');
add_action('widgets_init', create_function('', 'return register_widget("WooScroller_Widget");'));
wp_enqueue_style('vina-woo-scroller-css',       VINA_WOO_SCROLLER_INC_URI . '/css/style.css', '', '1.0', 'screen' );
wp_enqueue_style('vina-woo-scroller-admin-css', VINA_WOO_SCROLLER_INC_URI . '/admin/css/style.css', '', '1.0', 'screen' );
wp_enqueue_script('vina-tooltips', 	    VINA_WOO_SCROLLER_INC_URI . '/admin/js/jquery.simpletip-1.3.1.js', 'jquery', '1.0', true);

wp_enqueue_script('vina-animate',           VINA_WOO_SCROLLER_INC_URI . '/js/jquery.cssAnimate.mini.js', 'jquery', '1.0', true);
wp_enqueue_script('vina-easing', 	    VINA_WOO_SCROLLER_INC_URI . '/js/jquery.easing.1.3.js', 'jquery', '1.0', true);
wp_enqueue_script('vina-mousewheel', 	    VINA_WOO_SCROLLER_INC_URI . '/js/jquery.mousewheel.min.js', 'jquery', '1.0', true);
wp_enqueue_script('vina-touchwipe', 	    VINA_WOO_SCROLLER_INC_URI . '/js/jquery.touchwipe.min.js', 'jquery', '1.0', true);
wp_enqueue_script('vina-scroller', 	    VINA_WOO_SCROLLER_INC_URI . '/js/scroller.min.js', 'jquery', '1.0', true);
?>
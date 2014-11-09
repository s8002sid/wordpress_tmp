<?php
/*
Plugin Name: Vina Camera Slideshow Widget
Plugin URI: http://VinaThemes.biz
Description: A jQuery slideshow with a responsive layout, easy to use with an extended admin panel.
Version: 1.1
Author: VinaThemes
Author URI: http://VinaThemes.biz
Author email: mr_hiennc@yahoo.com
Demo URI: http://VinaDemo.biz
Forum URI: http://laptrinhvien-vn.com
License: GPLv3+
*/

//Defined global variables
if(!defined('VINA_CAMERA_DIRECTORY')) 		define('VINA_CAMERA_DIRECTORY', dirname(__FILE__));
if(!defined('VINA_CAMERA_INC_DIRECTORY')) 	define('VINA_CAMERA_INC_DIRECTORY', VINA_CAMERA_DIRECTORY . '/includes');
if(!defined('VINA_CAMERA_URI')) 			define('VINA_CAMERA_URI', get_bloginfo('url') . '/wp-content/plugins/vina-camera-widget');
if(!defined('VINA_CAMERA_INC_URI')) 		define('VINA_CAMERA_INC_URI', VINA_CAMERA_URI . '/includes');

//Include library
if(!defined('TCVN_FUNCTIONS')) {
    include_once VINA_CAMERA_INC_DIRECTORY . '/functions.php';
    define('TCVN_FUNCTIONS', 1);
}
if(!defined('TCVN_FIELDS')) {
    include_once VINA_CAMERA_INC_DIRECTORY . '/fields.php';
    define('TCVN_FIELDS', 1);
}
if(!defined('TCVN_FIELD_MULTI_CAT')) {
    include_once VINA_CAMERA_INC_DIRECTORY . '/field.php';
    define('TCVN_FIELD_MULTI_CAT', 1);
}



class Camera_Widget extends WP_Widget 
{
    function Camera_Widget()
    {
        $widget_ops = array(
            'classname' => 'camera_widget',
            'description' => __("A jQuery slideshow with a responsive layout, easy to use with an extended admin panel.")
        );
        $this->WP_Widget('camera_widget', __('Vina Camera Slideshow Widget'), $widget_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args( 
            (array) $instance, 
            array( 
                'title' 	=> '',
                'categoryId' 	=> null,
                'noItem' 	=> '5',
                'ordering' 	=> 'id',
                'orderingDirection' => 'desc',

                'width'		=> '545',
                'height'	=> '290',
                'moduleStyle'	=> 'camera_amber_skin',
                'alignment'	=> 'center',
                'autoAdvance'	=> 'yes',
                'hover'		=> 'yes',
                'navigation'	=> 'yes',

                'showTitle'	=> 'yes',
                'linkTitle'	=> 'no',
                'showContent'	=> 'yes',
                'readmore'	=> 'yes',
            )
        );

        $title		= esc_attr($instance['title']);
        $categoryId	= $instance['categoryId'];
        $noItem		= esc_attr($instance['noItem']);
        $ordering	= esc_attr($instance['ordering']);
        $orderingDirection  = esc_attr($instance['orderingDirection']);

        $width		= esc_attr($instance['width']);
        $height		= esc_attr($instance['height']);
        $moduleStyle	= esc_attr($instance['moduleStyle']);
        $alignment	= esc_attr($instance['alignment']);
        $autoAdvance	= esc_attr($instance['autoAdvance']);
        $hover		= esc_attr($instance['hover']);
        $navigation	= esc_attr($instance['navigation']);

        $showTitle	= esc_attr($instance['showTitle']);
        $linkTitle	= esc_attr($instance['linkTitle']);
        $showContent	= esc_attr($instance['showContent']);
        $readmore	= esc_attr($instance['readmore']);
        $catId          = implode(",", (is_array($categoryId)) ? $categoryId : $categoryId = array());
        $Shortcode	= "[camera_widget id='".$this->id_base."-".$this->number."' category_ids='".$catId."']";
        ?>
        <div id="tcvn-camera" class="tcvn-plugins-container">
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
                    <p><?php echo eTextField($this, 'Shortcode', 'Shortcode', $Shortcode); ?></p>
                    <p><?php echo eTextField($this, 'title', 'Title', $title); ?></p>
                    <p><?php echo eSelectData($this, 'categoryId', 'Category', buildCategoriesList('Select all Categories.'), $categoryId); ?></p>
                    <p><?php echo eTextField($this, 'noItem', 'Number of Post', $noItem, 'Number of posts to show. Default is: 5.'); ?></p>
                    <p><?php echo eSelectOption($this, 'ordering', 'Post Field to Order By',array('id'=>'ID', 'title'=>'Title', 'comment_count'=>'Comment Count', 'post_date'=>'Published Date'), $ordering); ?></p>
                    <p><?php echo eSelectOption($this, 'orderingDirection', 'Ordering Direction',array('asc'=>'Ascending', 'desc'=>'Descending'), $orderingDirection, 'Select the direction you would like Articles to be ordered by.'); ?></p>
                </div>
                <!-- Display Block -->
                <div id="display" class="tcvn-telement">
                    <p><?php echo eTextField($this, 'width', 'Module Width', $width); ?></p>
                    <p><?php echo eTextField($this, 'height', 'Module Height', $height); ?></p>
                    <p><?php echo eSelectOption($this, 'moduleStyle', 'Module Style', array('camera_amber_skin'=>'Camera Amber', 'camera_black_skin'=>'Camera Black', 'camera_blue_skin'=>'Camera Blue','camera_brown_skin'=>'Camera Brown', 'camera_chocolate_skin'=>'Camera Chocolate'), $moduleStyle); ?></p>
                    <p><?php echo eSelectOption($this, 'alignment', 'Alignment',array('center'=>'Center', 'topLeft'=>'Top Left', 'topCenter'=>'Top Center','topRight'=>'Camera Brown', 'centerLeft'=>'Center Left', 'centerRight'=>'Center Right','bottomLeft'=>'Bottom Left', 'bottomCenter'=>'Bottom Center', 'bottomRight'=>'Bottom Right'), $alignment); ?></p>
                    <p><?php echo eSelectOption($this, 'autoAdvance', 'Auto Advance',array('yes'=>'Yes', 'no'=>'No'), $autoAdvance); ?></p>
                    <p><?php echo eSelectOption($this, 'hover', 'Pause on Hover',array('yes'=>'Yes', 'no'=>'No'), $hover, 'Pause on state hover. Not available for mobile devices'); ?></p>
                    <p><?php echo eSelectOption($this, 'navigation', 'Show navigation', array('yes'=>'Yes', 'no'=>'No'), $navigation); ?></p>
                </div>
                <!-- Advanced Block -->
                <div id="advanced" class="tcvn-telement">
                    <p><?php echo eSelectOption($this, 'showTitle', 'Post Title',array('yes'=>'Show post title', 'no'=>'Hide post title'), $showTitle); ?></p>
                    <p><?php echo eSelectOption($this, 'linkTitle', 'Link on Title',array('yes'=>'Yes', 'no'=>'No'), $linkTitle); ?></p>
                    <p><?php echo eSelectOption($this, 'showContent', 'Post Content',array('yes'=>'Show post content', 'no'=>'Hide post content'), $showContent); ?></p>
                    <p><?php echo eSelectOption($this, 'readmore', 'Readmore',array('yes'=>'Show readmore button', 'no'=>'Hide readmore button'), $readmore); ?></p>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready(function($){
                var prefix = '#tcvn-camera ';
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
        extract($args);

        $title 			= getConfigValue($instance, 'title',		'');
        $category_ids		= getConfigValue($instance, 'categoryId',	'');
        $no_item		= getConfigValue($instance, 'noItem',		'5');
        $ordering		= getConfigValue($instance, 'ordering',		'id');
        $ordering_direction     = getConfigValue($instance, 'orderingDirection',	'desc');

        $width			= getConfigValue($instance, 'width',	'545');
        $height			= getConfigValue($instance, 'height',	'290');
        $module_style           = getConfigValue($instance, 'moduleStyle',	'theme1');
        $alignment		= getConfigValue($instance, 'alignment',	'center');
        $auto_advance           = getConfigValue($instance, 'autoAdvance',	'yes');
        $hover			= getConfigValue($instance, 'hover',		'yes');
        $navigation		= getConfigValue($instance, 'navigation',	'yes');

        $show_title		= getConfigValue($instance, 'showTitle',	'yes');
        $link_title		= getConfigValue($instance, 'linkTitle',	'yes');
        $show_content           = getConfigValue($instance, 'showContent',	'yes');
        $readmore		= getConfigValue($instance, 'readmore',		'yes');

        $params = array(
            'posts_per_page' 	=> $no_item, 
            'category__in'      => $category_ids,
            'orderby' 		=> $order,
            'order' 		=> $ordering_direction,
        );
        $posts = new WP_Query($params);
        $posts = $posts->posts;

        if($category_ids == '') {
            $params = array(
                'numberposts' 	=> $no_item, 
                'orderby' 	=> $order,
                'order' 	=> $ordering_direction,
            );
            $posts = get_posts($params);
        }

        if(!empty($posts)) : 
           $layout = loadLayout_camera();
           include $layout;
        endif;

        
    }
}

function loadLayout_camera(){
    if(!is_file(get_template_directory().'/widgets/vina-camera-widget/default.php')){
        return dirname(__FILE__) .'/default.php';
    }
    return get_template_directory().'/widgets/vina-camera-widget/default.php';
}

function shortcode_camera($atts="")
{
    extract(shortcode_atts(array(
       'id'                => '',
       'title'		   => '',
       'category_ids'      => '',
       'no_item'	   => '5',
       'ordering'	   => 'id',
       'ordering_direction' => 'desc',

       'width'             => '545',
       'height'            => '290',
       'module_style'	   => 'theme1',
       'alignment'	   => 'center',
       'auto_advance'	   => 'yes',
       'hover'             => 'yes',
       'navigation'        => 'yes',

       'show_title'	   => 'yes',
       'link_title'	   => 'yes',
       'show_content'	   => 'yes',
       'readmore'	   => 'yes'),$atts));
    
        ob_start();
        $category_ids = explode(",",$category_ids);
        
        $params = array(
            'posts_per_page' 	=> $no_item, 
            'category__in'      => $category_ids,
            'orderby' 		=> $order,
            'order' 		=> $ordering_direction,
        );
        $posts = new WP_Query($params);
        $posts = $posts->posts;

        if($category_ids == '') {
            $params = array(
                'numberposts' 	=> $no_item, 
                'orderby' 	=> $order,
                'order' 	=> $ordering_direction,
            );
            $posts = get_posts($params);
        }


        if(!empty($posts)) : 
            $layout = loadLayout_camera();
            include $layout;
        endif;

        $output = ob_get_clean();
        return $output;
}



//Add button to editer
function add_camera_new_button()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;
    if ( get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'add_camera_tinymce_plugin');
        add_filter('mce_buttons', 'register_camera_button');
    }
}
add_action('init', 'add_camera_new_button');
function register_camera_button($buttons){
    array_push($buttons, "|", "button_camera");
    return $buttons;
}
function add_camera_tinymce_plugin($plugin_array){
    $plugin_array['button_camera'] = VINA_CAMERA_INC_URI.'/js/camera_shortcode.js';
    return $plugin_array;

}
wp_enqueue_script("jquery");
add_shortcode('camera_widget', 'shortcode_camera');
add_action('widgets_init', create_function('', 'return register_widget("Camera_Widget");'));
wp_enqueue_style('vina-camera-css', 		VINA_CAMERA_INC_URI . '/css/camera.css', '', '1.0', 'screen' );
wp_enqueue_style('vina-camera-admin-css', VINA_CAMERA_INC_URI . '/admin/css/style.css', '', '1.0', 'screen' );
wp_enqueue_script('vina-tooltips', VINA_CAMERA_INC_URI . '/admin/js/jquery.simpletip-1.3.1.js', 'jquery', '1.0', true);

//wp_enqueue_script('vina-mobile', 	VINA_CAMERA_INC_URI . '/js/jquery.mobile.customized.min.js', 'jquery', '1.0', true);
wp_enqueue_script('vina-easing', 	VINA_CAMERA_INC_URI . '/js/jquery.easing.1.3.js', 'jquery', '1.0', true);
wp_enqueue_script('vina-camera', 	VINA_CAMERA_INC_URI . '/js/camera.min.js', 'jquery', '1.0', true);
?>
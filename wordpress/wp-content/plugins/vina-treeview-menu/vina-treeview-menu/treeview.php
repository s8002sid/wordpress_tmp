<?php
/*
Plugin Name: Vina Treeview Menu
Plugin URI: http://VinaThemes.biz
Description: This simple plugin helps you to display menu.
Version: 1.0
Author: VinaThemes
Author URI: http://VinaThemes.biz
Author email: mr_hiennc@yahoo.com
Demo URI: http://VinaDemo.biz
Forum URI: http://VinaForum.biz
License: GPLv3+
*/

if(!defined('VINA_TREEVIEW_MENU_DIRECTORY'))     define('VINA_TREEVIEW_MENU_DIRECTORY', dirname(__FILE__));
if(!defined('VINA_TREEVIEW_MENU_INC_DIRECTORY')) define('VINA_TREEVIEW_MENU_INC_DIRECTORY', VINA_TREEVIEW_MENU_DIRECTORY.'/includes');
if(!defined('VINA_TREEVIEW_MENU_URI'))           define('VINA_TREEVIEW_MENU_URI', get_bloginfo('url') .'/wp-content/plugins/vina-treeview-menu');
if(!defined('VINA_TREEVIEW_MENU_INC_URI'))       define('VINA_TREEVIEW_MENU_INC_URI',VINA_TREEVIEW_MENU_URI.'/includes');

//Include library
if(!defined('TCVN_FUNCTIONS')) {
    include_once VINA_TREEVIEW_MENU_INC_DIRECTORY . '/functions.php';
    define('TCVN_FUNCTIONS', 1);
}
if(!defined('TCVN_FIELDS')) {
    include_once VINA_TREEVIEW_MENU_INC_DIRECTORY . '/fields.php';
    define('TCVN_FIELDS', 1);
}
if(!defined('TCVN_WOO_FIELD')) {
    include_once VINA_TREEVIEW_MENU_INC_DIRECTORY . '/field_woo.php';
    define('TCVN_WOO_FIELD', 1);
}
if(!defined('TCVN_WOO_FUNCTION')) {
    include_once VINA_TREEVIEW_MENU_INC_DIRECTORY . '/woo-function.php';
    define('TCVN_WOO_FUNCTION', 1);
}
if(!defined('TCVN_THEM_LOCATION')) {
    include_once VINA_TREEVIEW_MENU_INC_DIRECTORY . '/function_menu.php';
    define('TCVN_THEM_LOCATION', 1);
}

class TreeviewMenu_Widget extends WP_Widget
{
    function TreeviewMenu_Widget()
    {
        $widget_ops = array(
            'classname' => 'treeviewmenu_widget',
            'description' => 'Vina Treeview Menu.'
        );
        $this->WP_Widget('TreeviewMenu_Widget',__('Vina Treeview Menu.'),$widget_ops);
    }
    function form($instance)
    {
        $instance = wp_parse_args(
            (array) $instance,
            array(
                'title'             => '',
                'show_menu'         => 'yes',
                'sub_menu'          => 0,
                'control'           => 'yes',
                'theme_location'    => 'primary',
                'show_menu_current' => 'yes',
                'width'             => '200px',
                'height'            => 'auto'
            )
        );
        
        $title             = esc_attr($instance['title']);
        $show_menu         = esc_attr($instance['show_menu']);
        $sub_menu          = esc_attr($instance['sub_menu']);
        $control           = esc_attr($instance['control']);
        $theme_location    = esc_attr($instance['theme_location']);
        $show_menu_current = esc_attr($instance['show_menu_current']);
        $width             = esc_attr($instance['width']);
        $height            = esc_attr($instance['height']);
        $Shortcode	= "[treeview_widget id='".$this->id_base."-".$this->number."']";
        ?>
        <div id="vina-woo-category" class="vina-plugins-container">
            <div id="vina-tabs-container">
                <ul id="vina-tabs">
                    <li class="active"><a href="#basic"><?php _e('Basic'); ?></a></li>
                </ul>
            </div>
            <div id="vina-elements-container">
                <!-- Basic Block -->
                <div id="basic" class="vina-telement" style="display: block;">
                    <p><input type="hidden" id="<?php echo $this->get_field_id('id') ?>" name="<?php echo $this->get_field_name('id') ?>" value="<?php echo $this->id; ?>" /></p>
                    <p><?php echo eTextField($this, 'Shortcode', 'Shortcode', $Shortcode); ?></p>
                    <p><?php echo eTextField($this, 'title', 'Title', $title); ?></p>
                    <p><?php echo eTextField($this, 'width', 'Width', $width); ?></p>
                    <p><?php echo eTextField($this, 'height', 'Height', $height); ?></p>
                    <p><?php echo eSelectOption($this, 'theme_location', 'Theme Location', buildThemeLocation(), $theme_location) ?></p>
                    <p><?php echo eSelectOption($this, 'show_menu', 'Show Navigation Menu', array('yes' => 'Yes','no' => 'No'), $show_menu) ?></p>
                    <p><?php echo eSelectOption($this, 'sub_menu', 'Show Sub Menu', array(0 => 'Yes',1 => 'No'), $sub_menu) ?></p>
                    <p><?php echo eSelectOption($this, 'control', 'Show Tree Control', array('yes' => 'Yes','no' => 'No'), $control) ?></p>
                    <p><?php echo eSelectOption($this, 'show_menu_current', 'Show Menu Current', array('yes' => 'Yes','no' => 'No'), $show_menu_current) ?></p>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready(function($){
                var prefix = '#vina-treeview-menu ';
                $(prefix + "li").click(function() {
                    $(prefix + "li").removeClass('active');
                    $(this).addClass("active");
                    $(prefix + ".vina-telement").hide();
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
    function widget($agrs, $instance)
    {
        extract($agrs);
        $title                = getConfigValue($instance,'title',            '');
        $show_menu            = getConfigValue($instance,'show_menu',        '');
        $sub_menu             = getConfigValue($instance, 'sub_menu',        0);
        $control              = getConfigValue($instance, 'control',         'yes');
        $theme_location       = getConfigValue($instance, 'theme_location',  'primary');
        $show_menu_current    = getConfigValue($instance, 'show_menu_current', 'yes');
        $width                = getConfigValue($instance, 'width', '200px');
        $height               = getConfigValue($instance, 'height', 'auto');
        $layout               = loadLayout_TreeviewMenu();
        include  $layout;
        
    }
	
}

function loadLayout_TreeviewMenu(){
    if(!is_file(get_template_directory().'/widgets/vina-treeview-menu/view/default.php')){
        return dirname(__FILE__) .'/view/default.php';
    }
    return get_template_directory().'/widgets/vina-treeview-menu/default.php';
}

function displayshortcode_Treeview($atts = '')
{
    extract(shortcode_atts(array(
        'id'		          => '',
        'title'                   => '',
        'show_menu'		  => 'yes',
        'sub_menu'                => 0,
        'control'                 => 'yes',
        'theme_location'          => 'primary',
        'show_menu_current'       => 'yes',
        'width'                   => '200px',
        'height'                  => 'auto'),$atts));
    ob_start();
    
    $layout = loadLayout_TreeviewMenu();
    include $layout;

    $output = ob_get_clean();
    return $output;
}
//Add button to editer
function add_treeview_new_button()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;
    if ( get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'add_treeview_tinymce_plugin');
        add_filter('mce_buttons', 'register_treeview_button');
    }
}
add_action('init', 'add_treeview_new_button');
function register_treeview_button($buttons){
    array_push($buttons, "|", "button_treeview");
    return $buttons;
}
function add_treeview_tinymce_plugin($plugin_array){
    $plugin_array['button_treeview'] =VINA_TREEVIEW_MENU_INC_URI.'/js/treeview.js';
    return $plugin_array;
}



function theme_wp_nav_menu_sub_menu_objects( $sorted_menu_items, $args ) {
    if ( isset( $args->sub_menu ) ) {
        $root_id = 0;
 
        foreach ( $sorted_menu_items as $menu_item ) {
            if ( $menu_item->current ) {
                $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
                break;
            }
        }

        $menu_item_parents = array();
        foreach ( $sorted_menu_items as $key => $item ) {
            if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;

            if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
                $menu_item_parents[] = $item->ID;
            } else {
                unset( $sorted_menu_items[$key] );
            }
        }
        return $sorted_menu_items;
        
        
    } else {
        return $sorted_menu_items;
    }
}
add_filter( 'wp_nav_menu_objects', 'theme_wp_nav_menu_sub_menu_objects', 10, 2 );

function theme_primary_menu($depth, $id, $theme_location) {
    $primary = wp_nav_menu( array(
        'theme_location'  => $theme_location,
        'container'       => '',
        'menu_id'         => $id,
        'container_class' => '',
        'echo'            => false,
        'fallback_cb'     => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth'           => $depth,
    ));

    echo $primary;
}
function theme_subnav_menu($depth, $id, $theme_location) {
    $subnav = wp_nav_menu( array(
        'theme_location'  => $theme_location,
        'container'       => '',
        'menu_id'         => $id,
        'container_class' => '',
        'fallback_cb'     => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s sub-menu">%3$s</ul>',
        'echo'            => false,
        'sub_menu'        => true,
        'depth'           => $depth,
    ) );
    $menu_items = substr_count( $subnav, 'class="menu-item ' );
    
    if ( $menu_items != 0 ) {
       echo $subnav;
    } else {
        if(empty($GLOBALS['currentMenuTitle']))
            theme_primary_menu($depth, $id, $theme_location); 
    }
 
}
add_filter( 'wp_nav_menu_objects', 'wp_nav_current_menu_objects' );
function wp_nav_current_menu_objects( $sorted_menu_items )
{
    foreach ( $sorted_menu_items as $menu_item ) {

        if ($menu_item->current ) {
            $GLOBALS['currentMenuTitle'] = $menu_item->title;
            $GLOBALS['currentMenuID']    = $menu_item->ID;
            $GLOBALS['currentMenuGUID']  = $menu_item->guid;
            break;
        }
    }
    return $sorted_menu_items;
}


add_action('widgets_init', create_function('', 'return register_widget("TreeviewMenu_Widget");'));
add_shortcode('treeview_widget', 'displayshortcode_Treeview');
wp_enqueue_style('vina-woocategory-admin-css', VINA_TREEVIEW_MENU_INC_URI . '/admin/css/style.css', '', '1.0', 'screen' );
wp_enqueue_style('vina-woocategory-site-css', VINA_TREEVIEW_MENU_INC_URI . '/css/style.css', '', '1.0', 'screen' );
wp_enqueue_script('vina-woocategory-site-js',VINA_TREEVIEW_MENU_INC_URI .'/js/jquery.cookie.js', 'jquery', '1.0', true);
wp_enqueue_script('vina-woocategory-site2-js',VINA_TREEVIEW_MENU_INC_URI .'/js/jquery.treeview.js', 'jquery', '1.0', true);
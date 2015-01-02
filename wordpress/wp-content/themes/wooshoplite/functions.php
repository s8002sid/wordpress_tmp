<?php

/********** DESSKY DEFINITION *************/
global $themeoptionsvalue, $themedata, $themename ; 

$themename 			=  'WooShop';
$admin_path 		= get_template_directory() . '/framework/adminoptions/';
$includes_path 		= get_template_directory() . '/framework/';
define('DESSKY_THEMENAME', $themename);
define('DESSKY_SHORTNAME', "dessky");
define('DESSKY_PARENTMENU_SLUG', 'desskytheme-settings');
define('DESSKY_FRAMEWORKPATH', get_template_directory() . '/framework/');

/********** END DESSKY DEFINITION *************/

//Theme Options
require_once get_template_directory() . '/options.php';

//Theme init
require_once $includes_path . 'theme-init.php';

//Metaboxes
require_once $includes_path . 'metaboxes.php';

//Widget and Sidebar
require_once $includes_path . 'sidebar-init.php';

require_once $includes_path . 'register-widgets.php';

//Additional function
require_once $includes_path . 'theme-function.php';

//Header function
require_once $includes_path . 'header-function.php';

//Footer function
require_once $includes_path . 'footer-function.php';

//Additional function
require_once $includes_path . 'theme-shortcode.php';

//Loading jQuery
require_once $includes_path . 'theme-scripts.php';

//Loading Style Css
require_once $includes_path . 'theme-styles.php';

require_once $includes_path . 'getqtycart.php';

// New Version Theme Update Notifier
require_once $includes_path . 'theme-update.php';
?>
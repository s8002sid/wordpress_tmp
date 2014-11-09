<?php
/**
 * @package Helix Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2013 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
?>

<div class="mobile-menu pull-right btn hidden-desktop" id="sp-moble-categories">
	Category Products &nbsp;
	<i class="icon-align-justify"></i>
</div>

<nav id="sp-main-categories" class="visible-desktop pull-left" role="navigation"><?php
		wp_nav_menu(
			array(
				'theme_location' 	=> 'twomenu',
				'menu_class' 		=> 'sp-menu level-0',
				'walker' 			=> new HelixMenuWalker(),
				'container'       	=> 'div',
				'container_class' 	=> 'main-navigation'
			)
		);
	?></nav>
<script type="text/javascript">
	jQuery(function($){
		
		//Mobile Menu
		$('#sp-main-categories > > ul').mobileMenu({
			defaultText:'<?php _e('--Select Menu--', _THEME); ?>',
			appendTo: '#sp-moble-categories'
		});
		
	});
	
</script>
<?php
/*
# ------------------------------------------------------------------------
# Function for Wordpress Widget
# ------------------------------------------------------------------------
# Copyright(C) 2008-2012 www.VinaThemes.biz. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaThemes.biz
# Websites: http://VinaThemes.biz
# Demo: http://VinaDemo.biz
# Forum:    http://laptrinhvien-vn.com/forum/
# ------------------------------------------------------------------------
*/

function buildThemeLocation()
{
	$theme_locations = get_nav_menu_locations();
	$rows       = array('' => _('Select Them Location'));
	
	foreach($theme_locations as $theme_location => $key) {
		$rows += array($theme_location => $theme_location);
	}
	
	return $rows;
}
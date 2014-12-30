<?php
/*
# ------------------------------------------------------------------------
# Function for WooCommerce Wordpress Widget
# ------------------------------------------------------------------------
# Copyright(C) 2008-2012 www.VinaThemes.biz. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaThemes.biz
# Websites: http://VinaThemes.biz
# Demo: http://VinaDemo.biz
# Forum:    http://laptrinhvien-vn.com/forum/
# ------------------------------------------------------------------------
*/
function buildWooCategoriesList()
{
    $categories = get_terms('product_cat');
    $rows       = array('' => _('Select category'));
    foreach($categories as $cagegory) {
        if((int)$cagegory->parent == 0)
            $rows += array($cagegory->term_id => $cagegory->name);
    }
    return $rows;
}
?>

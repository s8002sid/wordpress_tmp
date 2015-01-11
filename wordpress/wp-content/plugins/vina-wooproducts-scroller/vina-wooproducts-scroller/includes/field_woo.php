<?php 
/*
# ------------------------------------------------------------------------
# Field for Wordpress Widget
# ------------------------------------------------------------------------
# Copyright(C) 2013-2014 www.VinaThemes.biz. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaThemes.biz
# Websites: http://VinaThemes.biz
# Demo: http://VinaDemo.biz
# Forum:    http://laptrinhvien-vn.com/forum/
# ------------------------------------------------------------------------
*/

# Echo Select Mutil Categories
function eSelectDataWoo($field, $name, $title, $options, $value, $desc = null)
{
    $id      = $field->get_field_id($name);
    $name    = $field->get_field_name($name);
    if(is_array($value) == false)
            $value = array();
    $label = '<label'.(isset($desc) ? ' class="tcvn-tooltip" title="' . $desc . '"' : '').' for="' . $name . '">' . _($title) . ':</label> ';
    $text  = '<select multiple="multiple" name="' . $name . '[]" id="' . $id . '" style="width:100%; height:100px !important;">';
    foreach($options as $key => $val) {
            if(in_array($val, $value) !== FALSE)
                    $select = 'selected';
            else
                    $select = '';	
            $text .= '<option value="' . $val . '"'.$select.'>' . $val . '</option>';
            
            if(!empty($key)){
                $text.= getCategoriesWooList($key, $value, $select);
            }
    }
    $text .= '</select>';

    return $label . $text;
}
function getCategoriesWooList($key,$value,$select,$child = '')
{
    $categories=get_terms('product_cat','parent='.$key);
    $child .= ' - ';
    foreach($categories as $cat){
        if(in_array($cat->name, $value) !== FALSE)
            $select = 'selected';
        else
            $select = '';
        $text .= '<option value="' . $cat->name . '"'.$select.'>'.$child. $cat->name . '</option>';
        $text .= getCategoriesWooList($cat->name, $value, $select,$child);
    }
    return $text;
}
?>
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
function eSelectData($field, $name, $title, $options, $value, $desc = null)
{
    $id       = $field->get_field_id($name);
    $name    = $field->get_field_name($name);
    if(is_array($value) == false)
            $value = array();
    $label = '<label'.(isset($desc) ? ' class="tcvn-tooltip" title="' . $desc . '"' : '').' for="' . $name . '">' . _($title) . ':</label> ';
    $text  = '<select multiple="multiple" name="' . $name . '[]" id="' . $id . '" style="width:100%; height:100px !important;">';
    foreach($options as $key => $val) {
            if(in_array($key, $value) !== FALSE)
                    $select = 'selected';
            else
                    $select = '';	
            $text .= '<option value="' . $key . '"'.$select.'>' . $val . '</option>';
    }

    $text .= '</select>';

    return $label . $text;
}
?>
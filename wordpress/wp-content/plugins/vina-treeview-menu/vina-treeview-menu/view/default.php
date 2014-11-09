<?php
/*
------------- Vina Treeview Menu -------------------
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
echo $before_widget;
if($title) echo $before_title . $title . $after_title;
$vina_id = (isset($widget_id)) ? $widget_id : $id;
?>
<div class="vina-tree-view" id="vina-tree-view-<?php echo (isset($widget_id)) ? $widget_id : $id; ?>" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
    <div class="tree-view">
        <?php if(!empty($GLOBALS['currentMenuTitle']) && $show_menu_current == 'yes'): ?>
        <h3 class="current-menu-title"><?php echo $GLOBALS['currentMenuTitle']; ?></h3>
        <?php endif; ?>
        <?php if($control == 'yes'): ?>
        <div id="sidetreecontrol-<?php echo (isset($widget_id)) ? $widget_id : $id; ?>">
            <a href="?#">Collapse All</a> | <a href="?#">Expand All</a>
        </div>
        <?php endif; ?>
        <?php
        if($show_menu == 'yes')
            theme_subnav_menu($sub_menu, $vina_id, $theme_location);
        else
            theme_primary_menu($sub_menu, $vina_id, $theme_location);
        ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $(function() {
            $("#vina-tree-view-<?php echo (isset($widget_id)) ? $widget_id : $id; ?> #<?php echo $vina_id; ?>").treeview({
                collapsed: true,
                animated: "medium",
                control:"#sidetreecontrol-<?php echo (isset($widget_id)) ? $widget_id : $id; ?>",
                persist: "location"
            });
        })
    })
</script>
<?php 
echo $after_widget;
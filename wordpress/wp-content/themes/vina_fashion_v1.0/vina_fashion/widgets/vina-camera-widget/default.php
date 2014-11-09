<?php
/*
--------- Vina Camera Slideshow Widget -----------------
Plugin URI: http://VinaThemes.biz
Description: A jQuery slideshow with a responsive layout, easy to use with an extended admin panel.
Version: 1.0
Author: VinaThemes
Author URI: http://VinaThemes.biz
Author email: mr_hiennc@yahoo.com
Demo URI: http://VinaDemo.biz
Forum URI: http://laptrinhvien-vn.com
License: GPLv3+
*/
echo $before_widget;

if($title) echo $before_title . $title . $after_title;
?>
<div class="camera_wrap <?php echo $module_style; ?>" id="vina-camera-widget-<?php echo (isset($widget_id)) ? $widget_id : $id; ?>" style="height:<?php echo $height;?>; width:<?php echo $width;?>;">
    <?php 
        foreach($posts as $post) : 
            $thumbnailId = get_post_thumbnail_id($post->ID);				
            $thumbnail 	 = wp_get_attachment_image_src($thumbnailId , '70x45');	
            $altText 	 = get_post_meta($thumbnailId , '_wp_attachment_image_alt', true);
            $commentsNum = get_comments_number($post->ID);
            $text   = explode('<!--more-->', $post->post_content);
            $sumary = $text[0];
    ?>
    <div data-thumb="<?php echo $thumbnail[0]; ?>" data-src="<?php echo $thumbnail[0]; ?>">
        <div class="camera_caption fadeFromBottom">
            <!-- Title Block -->
            <?php if($show_title == 'yes') : ?>
            <?php if($link_title == 'yes') { ?>
            <h3>
                <a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title; ?>">
                <?php echo $post->post_title; ?>
                </a>
            </h3>
            <?php } else { ?>
            <h3><?php echo $post->post_title; ?></h3>
            <?php } ?>
            <?php endif; ?>

            <!-- Content Block -->
            <?php if($show_content == 'yes') : ?>
            <p class="content"><?php echo $sumary ?></p>
            <?php endif; ?>

            <!-- Readmore Block -->
            <?php if($readmore == 'yes') : ?>
            <p class="view-detail"><a class="buttonlight morebutton" href="<?php echo get_permalink($post->ID); ?>"><?php _e('View Detail'); ?></a></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#vina-camera-widget-<?php echo (isset($widget_id)) ? $widget_id : $id; ?>').camera({
            alignment: 		'<?php echo $alignment; ?>',
            autoAdvance:	<?php echo ($auto_advance == 'yes') ? 'true' : 'false'; ?>,
            hover: 		<?php echo ($hover == 'yes') ? 'true' : 'false'; ?>,
            navigation: 	<?php echo ($navigation == 'yes') ? 'true' : 'false'; ?>,
            height:             '<?php if($height == 'auto') echo '50%'; else if(is_numeric($height)) {echo (($height/$width) * 100).'%';} else echo $height; ?>'
        });
    });
</script>
<?php echo $after_widget; ?>
<?php
/*
----------- Vina Wooproducts Scroller --------------
Plugin URI: http://VinaThemes.biz
Description: This is a highly customizable plugin to show you or your customer's services, portfolio items, blog contents ... basically all business information thinkable.
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
<style type="text/css">
    #vina-woo-scroller-widget-<?php echo (isset($widget_id)) ? $widget_id : $id; ?> {
        width: <?php echo $width + $slide_spacing * 2; ?>px;
        height: <?php echo $height + $slide_spacing * 2; ?>px;
    }
</style>
<div id="vina-woo-scroller-widget-<?php echo (isset($widget_id)) ? $widget_id : $id; ?>" class="vina-woo-scroller-widget <?php echo $module_style; ?>">
    <ul>
        <?php 
        foreach ($products as $product): 
            $thumbnailId    = get_post_thumbnail_id($product->ID);				
            $thumbnail      = wp_get_attachment_image_src($thumbnailId , '70x45');	
            $altText        = get_post_meta($thumbnailId , '_wp_attachment_image_alt', true);
            $commentsNum    = get_comments_number($product->ID);

            $image          = VINA_WOO_SCROLLER_URI . '/includes/timthumb.php?w='.$image_width.'&h='.$image_height.'&a=c&q=99&z=0&src=';
            $text           = explode(" ",$product->post_excerpt);
            $des            = "";
            $price          = get_post_meta($product->ID, '_regular_price', true);
            $sale           = get_post_meta($product->ID, '_sale_price', true);
			if(empty($price))
			{
				$sale  = get_post_meta($product->ID, '_price', true);
				
			}
            for($i = 0 ;$i<$limit_description; $i++ ){
                $des = $des.$text[$i]." ";
            }
        ?>
        <li>
        	<div class="product-scoller-inner">
            	
                <?php if(!empty($thumbnail) && $thumb_image == 'yes') : ?>
                <?php if(!empty($sale)): ?>
                <span class="sale">Sale!</span>   
                <?php endif; ?>
                    <?php if($link_image == 'yes') { ?>
                    <a href="<?php echo $product->guid; ?>" title="<?php echo $product->post_title; ?>">
                        <?php echo '<img class="thumb" data-bw="' . $image.$thumbnail[0] . '" src="' . $image.$thumbnail[0] . '" alt="'. $altText .'"/>'; ?>
                    </a>
                    <?php } else { ?>
                    <?php echo '<img class="thumb" data-bw="' . $image.$thumbnail[0] . '" src="' . $image.$thumbnail[0] . '" alt="'. $altText .'"/>'; ?>
                    <?php } ?>
                <?php endif; ?>
                <div class="sp-title-price">
            	<div class="title-price">
				<?php if($show_title == 'yes') : ?>
                <?php if($link_title == 'yes') { ?>
                <h4 class="title">
                    <a href="<?php echo $product->guid; ?>" title="<?php echo $product->post_title; ?>">
                        <?php echo $product->post_title; ?>
                    </a>
                </h4>
                <?php } else { ?>
                <h4 class="title"><?php echo $product->post_title; ?></h4>
                <?php } ?>
                <?php endif; if($show_description == 'yes'): ?>
                <p class="description"><?php echo $des.' ...'; ?></p>
                <?php endif; if($show_price == 'yes'): ?>
                <div class="price">
                    <?php if(!empty($price)): ?>
                        <?php if(!empty($sale)) {?>
                        <del><?php echo  get_woocommerce_currency_symbol(). $price; ?></del>
                        <?php }else{ ?>
                            <span><?php echo get_woocommerce_currency_symbol(). $price;   ?></span>
                        <?php } ?>
                    <?php endif; if(!empty($sale)):?>
                    <span><?php echo get_woocommerce_currency_symbol(). $sale; ?></span>
                    <?php endif; ?>
                </div>
				<?php endif; if($readmore == 'yes') : ?>
                <a class="add-to-cart" href="?post_type=product&add-to-cart=<?php echo $product->ID; ?>"><?php _e('Add To Cart'); ?></a>
                <?php endif; ?>
                </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>

    <!-- Control Button -->
    <div class="toolbar">
        <div class="toolbar-inner left"><span> < </span></div>
        <div class="toolbar-inner right"><span> > </span></div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#vina-woo-scroller-widget-<?php echo (isset($widget_id)) ? $widget_id : $id; ?>').services({
        width:		<?php echo $width; ?>,
        height:		<?php echo $height; ?>,
        slideAmount:	<?php echo $slide_amount; ?>,
        slideSpacing:	<?php echo $slide_spacing; ?>,
        touchenabled:	"<?php echo $touch_enabled; ?>",
        mouseWheel:	"<?php echo $mouse_wheel; ?>",
        hoverAlpha:	"<?php echo $hover_alpha; ?>",
        slideshow:	<?php echo $slide_show; ?>,
        hovereffect:	"<?php echo $hover_effect; ?>",
        callBack:function() { }
    });
}); 
</script>
<?php echo $after_widget; ?>
<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
<div class="thumbnails">
    <div id="myCarousel1" class="carousel slide">
    <?php
            
            $loop2 = 0;
            $columns2 = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
            $count2 = 0;
			$count21 = 0;
            ?>
        <ol class="carousel-indicators">
        	<li data-target="#myCarousel1" data-slide-to="<?php echo $count21; ?>" class="active">
       		<?php
				foreach ( $attachment_ids as $attachment_id ) {
					$count2++;
					if($count2==4){
						$count21= $count21+1;
						echo '</li><li data-target="#myCarousel1" data-slide-to="'.$count21.'" class="">';
						$count2=0;	
					}
					$loop2++;
				}
			?>
            </li>
        </ol>
    	<div class="carousel-inner">
			<?php
            
            $loop = 0;
            $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
            $count = 0;
            ?>
            <div class="item active">
            <?php
            foreach ( $attachment_ids as $attachment_id ) {
                $classes = array( 'zoom' );
                
                if ( $loop == 0 || $loop % $columns == 0 )
                    $classes[] = 'first';
    
                if ( ( $loop + 1 ) % $columns == 0 )
                    $classes[] = 'last';
    
                $image_link = wp_get_attachment_url( $attachment_id );
                if ( ! $image_link )
                    continue;
    
                $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
                $image_class = esc_attr( implode( ' ', $classes ) );
                $image_title = esc_attr( get_the_title( $attachment_id ) );
                
                /*if($count == 0)
                {
                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="item">', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
                }*/
                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s"  rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
                $count ++;
                if($count == 4){
                    echo "</div> <div class='item'>";
					$count = 0;
                }
                $loop++;
            }
        ?>
        </div>
        </div>
         <a class="carousel-control left" href="#myCarousel1" data-slide="prev">&lsaquo;</a>
        <a class="carousel-control right" href="#myCarousel1" data-slide="next">&rsaquo;</a>
    </div>
</div>
	<?php
}
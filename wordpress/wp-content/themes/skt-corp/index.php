<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SKT Corp
 */

get_header(); 
?>

<?php if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) : ?>

    <div class="content-area">
        <div class="container">
            <section class="site-main" id="sitemain">
                <div class="blog-post">
					<?php
                    if ( have_posts() ) :
                        // Start the Loop.
                        while ( have_posts() ) : the_post();
                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                            get_template_part( 'content', get_post_format() );
                    
                        endwhile;
                        // Previous/next post navigation.
                        skt_corp_custom_blogpost_pagination();
                    
                    else :
                        // If no content, include the "No posts found" template.
                         get_template_part( 'no-results', 'index' );
                    
                    endif;
                    ?>
                </div><!-- blog-post -->
            </section>
            <?php get_sidebar();?>
            <div class="clear"></div>
        </div>
    </div>

<?php else: ?>

	<?php
    if( of_get_option('numsection', true) > 0 ) { 
        $numSections = esc_attr( of_get_option('numsection', true) );
        for( $s=1; $s<=$numSections; $s++ ){ 
            $title 		= ( of_get_option('sectiontitle'.$s, true) != '' ) ? esc_html( of_get_option('sectiontitle'.$s, true) ) : '';
            $class		= ( of_get_option('sectionclass'.$s, true) != '' ) ? esc_html( of_get_option('sectionclass'.$s, true) ) : '';
            $content	= ( of_get_option('sectioncontent'.$s, true) != '' ) ? of_get_option('sectioncontent'.$s, true) : ''; 
            $bgcolor	= ( of_get_option('sectionbgcolor'.$s, true) != '' ) ? of_get_option('sectionbgcolor'.$s, true) : ''; 
            ?>
            <section class="<?php echo $class; ?>" <?php if($bgcolor!=''){?>style="background-color:<?php echo $bgcolor;?>;"<?php } ?>>
                <div class="container">
                    <?php if( $title != '' ) { ?>
                        <h2><?php echo $title; ?></h2>
                    <?php } ?>
                    <?php skt_corp_the_content_format( $content ); ?>
                    <div class="clear"></div>
                </div>
            </section><?php 
        }
    }
    ?>
    	<section style="background-color:#f5f5f5;" class="features_more">
                <div class="container">
		<h3 class="home-blog-title"><?php _e('Recent From the Blog','skt-corp'); ?></h3>
        
     <?php    $args = array( 'posts_per_page' => 1, 'post__not_in' => get_option('sticky_posts'), 'orderby' => 'date', 'order' => 'desc', );
	$blog = '';
	query_posts( $args );
	$n = 0;
	if ( have_posts() ) {
		while ( have_posts() ) { 
			$n++;
			the_post(); ?>
				<div class="full_width">
			
			<div class="one_half"><div class="post-meta"><?php echo get_the_time('j'); ?><span><?php echo date('M'); ?></span></div><div class="post-next"><h4 class="blog-title"><a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title(); ?>">'<?php the_title(); ?></a></h4>
				<p><?php echo skt_corp_content(80); ?><a href="<?php esc_url(the_permalink()); ?>"><?php _e('Read More...','skt-corp'); ?></a></p></div></div>
		<?php }
	}else{
		$blog.= __('Sorry! There are no recent posts.','skt-corp');
	}
	wp_reset_query();
	 ?>
	<?php $argsnew = array( 'posts_per_page' => 2, 'post__not_in' => get_option('sticky_posts'), 'orderby' => 'date', 'order' => 'desc', 'offset' => 1 );
	query_posts( $argsnew );
	$n = 0; ?>
		<div class="one_half last_column">
	<?php if ( have_posts() ) {
		while ( have_posts() ) { 
			$n++;
			the_post(); ?>
			<div class="full_width">
			
			<div class="post-meta-small"><?php echo get_the_time('j'); ?><span><?php echo date('M'); ?></span></div><div class="post-next"><h4 class="blog-title"><a href="<?php esc_url(the_permalink()); ?>" title="<?php  the_title(); ?>"><?php the_title(); ?></a></h4>
				<p><?php echo skt_corp_content(20); ?><a href="<?php esc_url(the_permalink()); ?>"><?php _e('Read More...','skt-corp'); ?></a></p></div><div class="clear"></div>
	<?php	}
	}else{ ?>
		<p><?php _e('Sorry! There are no recent posts.','skt-corp'); ?></p>
	<?php }
	wp_reset_query();
 ?>	
	</div><div class="clear"></div></div></div>
    </div><div class="clear"></div>
    </section>
 
<?php endif; ?>


<?php get_footer(); ?>
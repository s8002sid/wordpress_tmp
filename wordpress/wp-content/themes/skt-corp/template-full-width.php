<?php
/**
Template name: Full Width

 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SKT Corp
 */

get_header(); ?>

<?php
if( has_post_thumbnail() ){
	echo '<div class="container">';
	the_post_thumbnail('full');
	echo '</div>';
}
?>

<div class="content-area">
    <div class="container">
        <section class="site-main" id="sitefull">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
                <?php
				$bodybgurl = esc_url( get_post_meta( get_the_ID(), 'bodybgurl', true ) );
				if( $bodybgurl != '' ){ ?>
					<style type="text/css">body{background:url(<?php echo $bodybgurl; ?>) no-repeat center top; background-attachment:fixed; background-size:cover;}</style>
				<?php } ?>
			<?php endwhile; // end of the loop. ?>
        </section>
        <div class="clear"></div>
    </div>
</div>

<?php get_footer(); ?>
<?php get_header(); ?>
<div class="content-area">
    <div class="container">
        <section class="site-main" id="sitemain">
            <div class="blog-post">
			<?php woocommerce_content(); ?>
		   </div><!-- blog-post -->
        </section>
        <?php get_sidebar();?>
        <div class="clear"></div>
    </div>
</div>
     
<?php get_footer(); ?>
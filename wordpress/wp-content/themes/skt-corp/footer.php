
<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SKT Corp
 */
?>
	<div class="clear"></div>
</div>
<footer id="footer">
	<div class="container">
        <aside class="widget">
        	<?php dynamic_sidebar('footer-1'); ?>
        </aside>
        <aside class="widget">
        	<?php dynamic_sidebar('footer-2'); ?>
        </aside>
        <aside class="widget last">
        	<?php dynamic_sidebar('footer-3'); ?>
        </aside>
        <div class="clear"></div>
    </div>

</footer>
<div id="copyright">
	<div class="container">
    	<div class="left"><?php echo of_get_option('footertext', true); ?></div>
    	<div class="right"><?php echo of_get_option('footerlinks', true); ?></div>
        <div class="clear"></div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>
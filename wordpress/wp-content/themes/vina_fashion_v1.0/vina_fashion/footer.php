<?php
/**
 * @package Vina Fashion
 * @author VinaThemes.biz http://www.VinaThemes.biz
 * @copyright Copyright (c) 2013 VinaThemes.biz
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
?>
							</div><!--End Main-->

				<?php if (Helix::hasWidgets(array('right'))) : ?>
					<aside id="rightsidebar" class="span<?php echo Helix::Param('right_sidebar_width'); ?>">
						<?php Helix::addWidgets(array('right')); ?>
					</aside>
				<?php endif; ?>
			</div>
		
		</div><!-- #content -->
	</div>
	<?php if ( Helix::hasWidgets( array( 'position1') ) ) : ?>
        <section id="sp-position-1">
            <div class="container">
                <?php Helix::addWidgets( array( 'position1') ); ?>
            </div>
        </section>
    <?php endif; ?>
	<!--bottom-->
    
	<?php if ( Helix::hasWidgets( array( 'bottom1', 'bottom2', 'bottom3', 'bottom4' ) ) ) : ?>
		<section id="sp-bottom-wrapper">
			<div class="container">
				<?php Helix::addWidgets( array( 'bottom1', 'bottom2', 'bottom3', 'bottom4' ) ); ?>
			</div>
		</section>
	<?php endif; ?>

</section><!-- #sp-main -->

<footer id="sp-footer-wrapper" role="contentinfo">
	<div class="container">
		<div class="row-fluid">
			<div class="span7">
				<?php
					Helix::addFeatures('footer');
				?>
			</div>		
			<div class="span5">
				<?php Helix::addFeatures('gototop'); ?>
				<?php Helix::addWidgets(array('footer')); ?>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

<?php Helix::addFeatures('analytics'); ?>

</body>
</html>
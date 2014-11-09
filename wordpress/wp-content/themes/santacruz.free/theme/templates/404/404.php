<?php 
/**
 * Your Inspiration Themes
 * 
 * In this files there is a collection of a functions useful for the core
 * of the framework.   
 * 
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

?>
	<div class="border-img-bottom">
		<div class="border-img">
			<img class="error-404-image group" src="<?php echo YIT_THEME_URL.'/images/404.png' ?>" title="<?php _e( 'Error 404', 'yit' ); ?>" alt="<?php _e( '404 Error', 'yit' ) ?>" />
		</div>
	</div>
    <div class="error-404-text group">
    	<div class="two-fourth page404-left-content">
            <h2> whoops, our bad... </h2>
            <p class = "subtitle-left"> The page you requested was not found , and we have a fine guess why </p>
            <p class = "text"> - If you typed the URL directly, please make sure the spelling is correct.
                - If you clicked on a link to get here, the link is outdated.
            </p>
        </div>
        <div class="two-fourth page404-right-content last">
            <h2> what can i do </h2>
            <p class = "subtitle-right" > There are many ways you can get back on track with Santa Cruz Shop: </p>
            <p class = "text">
                - Go to the <a href = "#">home page</a>
                - Use the search form below
            </p>
            <?php get_search_form() ;?>
        </div>
   </div>
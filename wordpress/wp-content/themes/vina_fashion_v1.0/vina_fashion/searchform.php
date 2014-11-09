<?php
/**
 * @package Vina Fashion
 * @author VinaThemes.biz http://www.VinaThemes.biz
 * @copyright Copyright (c) 2013 VinaThemes.biz
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
?>
<div class="search-form pull-right">
	<form method="get" id="searchform" class="form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="input-append">
		  <input type="text" name="s" class="input-medium" id="s" placeholder="<?php esc_attr_e( 'Search', _THEME ); ?>" />
		  <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
		</div>
	</form>
</div>

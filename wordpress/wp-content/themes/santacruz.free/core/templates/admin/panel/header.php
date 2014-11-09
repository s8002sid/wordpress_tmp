<?php
/**
 * The header of the panel. 
 * 
 * @package WordPress
 * @subpackage Your Inspiration Themes
 */
?>

<div class="wrap">
    <!-- START HEADER -->
    <?php if(YIT_SHOW_PANEL_HEADER) :?>
    <div id="yit-header">
        <div id="logo"></div>
        
        <div id="spot">
            <a href="http://www.yithemes.com/?utm_source=yith-panel&utm_medium=wpadmin&utm_content=img-top-yith-panel&utm_campaign=yith-admin" target="_blank" title="Your Inspiration Themes"><?php _e( 'DOWNLOAD <strong>HIGH QUALITY</strong> WORDPRESS THEMES <strong>FOR FREE</strong>', 'yit' ) ?></a>
        </div>
        <div id="info">
            <p class="name-theme"><?php echo $yit->getConfigThemeName() . ' ' . $yit->getConfigThemeVersion(); ?></p>
            <p class="framework-version">YIT Framework <?php echo YIT_CORE_VERSION; ?></p>
        </div>
    </div>
    <?php endif ?>
    <!-- END HEADER -->
            
    <!-- START UTILITY BAR -->
    <?php if(YIT_SHOW_PANEL_HEADER_LINKS): ?>
    <div id="yit-utility-bar">
        <p><?php printf( __( '<strong>Need support?</strong> View the <a href="%s">documentation</a>. ', 'yit' ), YIT_DOCUMENTATION_URL );
            printf( __( 'If you want download this documentation and see it without any internet connection, you can download it by <a href="%s" title="Download documentation">this link</a>', 'yit' ), YIT_DOCUMENTATION_ZIP_URL ); ?>
        </p>
        <p class="right"><a href="<?php echo get_template_directory_uri() . '/Changelog.txt' ?>"><?php _e( 'Theme Changelog', 'yit' ) ?></a> <!-- | <a href="<?php echo YIT_FREE_THEMES_URL ?>"><?php _e( 'Our free themes', 'yit' ) ?></a> --></p>
    </div>
    <?php endif ?>
    <!-- END UTILITY BAR -->
    


<div class="wrap" id="yit_container">
	<div id="yit-wrapper">
		

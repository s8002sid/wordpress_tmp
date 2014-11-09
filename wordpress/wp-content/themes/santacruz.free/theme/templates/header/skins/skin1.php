<?php
/**
 * Your Inspiration Themes
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


<div id="header-container" class="header_skin1 container">
    <div class="row-fluid">
        <!-- START HEADER LEFT CONTENT -->
        <div class="span4">
            <?php do_action( 'yit_before_header_left_content' ); ?>
            <div class="header-left-content">
                <!-- START HEADER LEFT SIDEBAR -->
                <div id="header-left-sidebar"<?php if ( ! yit_get_option('responsive-show-header-sidebar') ) echo ' class="hidden-phone"' ?>>
                    <?php dynamic_sidebar( 'Header Left Sidebar' ) ?>
                </div>
                <!-- END HEADER LEFT SIDEBAR -->
            </div>
            <?php do_action( 'yit_after_header_left_content' ); ?>
        </div>
        <!-- END HEADER LEFT CONTENT -->

        <!-- START LOGO -->
        <div class="span4">
            <?php do_action( 'yit_before_logo' ) ?>
            <div id="logo">
                <?php
                /**
                 * @see yit_logo
                 */
                do_action( 'yit_logo' ) ?>
            </div>
            <?php do_action( 'yit_after_logo' ) ?>
        </div>
        <!-- END LOGO -->


        <!-- START HEADER RIGHT CONTENT -->
        <div id="header-cart-wrapper" class="span4">
            <?php do_action( 'yit_before_header_right_content' ); ?>
            <div id="header-right-content">
                <!-- START WELCOME MENU -->
                <div id="welcome-menu">
                    <?php
                    /**
                     * @see yit_main_navigation
                     */
                    do_action( 'yit_welcome_menu') ?>
                </div>
                <!-- END WELCOME MENU -->

                <!-- START CART -->
                <div id="header-cart">
                    <?php do_action('yit_header_cart') ?>
                </div>
                <!-- END CART -->

                <!-- START HEADER RIGHT SIDEBAR -->
                <div id="header-right-sidebar"<?php if ( ! yit_get_option('responsive-show-header-sidebar') ) echo ' class="hidden-phone"' ?>>
                    <?php dynamic_sidebar( 'Header Right Sidebar' ) ?>
                </div>
                <!-- END HEADER RIGHT SIDEBAR -->
            </div>
            <?php do_action( 'yit_after_header_right_content' ); ?>
        </div>
        <!-- END HEADER RIGHT CONTENT -->

        <div class="clearfix"></div>

        <!-- START NAVIGATION -->
        <div id="nav">
            <?php
            /**
             * @see yit_main_navigation
             */
            do_action( 'yit_main_navigation') ?>
        </div>
        <!-- END NAVIGATION -->
    </div>
</div>
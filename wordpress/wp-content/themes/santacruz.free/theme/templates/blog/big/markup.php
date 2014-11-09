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

$show_featured_image = ( yit_get_option( 'blog-show-featured' ) == 1) ?'show-featured':'hide-featured';
$post_classes = 'hentry-post group blog-big-image '. $show_featured_image.' ' .'row';
$span = yit_get_sidebar_layout() == 'sidebar-no' ? 12 : 9;

$post_format = get_post_format() == '' ? 'standard' : get_post_format();



$meta = yit_get_option( 'blog-show-author' )
    || yit_get_option( 'blog-show-comments' ) && comments_open()
    || yit_get_option( 'blog-show-categories' )
    || yit_get_option( 'blog-show-tags' )
    || yit_get_option( 'blog-show-share' );


if( yit_get_option( 'blog-post-formats-list' ) ) {
    $post_classes .= ' post-formats-on-list';
}

$has_thumbnail = ( ! has_post_thumbnail() || ( ! is_single() && ! yit_get_option( 'blog-show-featured' ) )  ) ? false : true;
$upper = yit_get_option('blog-big-title-uppercase') ? ' upper' : '';
$link = get_permalink();
$title = get_the_title() == '' ? __( '(this post does not have a title)', 'yit' ) : get_the_title();

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>

    <?php if(is_single() && $post_format != 'quote') : ?>
        <?php yit_get_template( 'blog/big/post-formats/' . $post_format . '.php', array('span' => $span, 'has_thumbnail' => $has_thumbnail, 'upper' => $upper, 'link' => $link, 'title' => $title ) ); ?>
    <?php elseif( $post_format != 'quote' ): ?>
        <?php yit_get_template( 'blog/big/post-formats/standard.php', array('span' => $span, 'has_thumbnail' => $has_thumbnail, 'upper' => $upper, 'link' => $link, 'title' => $title ) ); ?>
    <?php endif; ?>

    <div class="span<?php echo $span ?>">
        <!-- post content -->
        <div class="blog-big-image-content row">

            <div class="the-content-post">

                <!-- post title -->
                <?php

                if( !is_single() && $post_format != 'quote' ) {
                    if( yit_get_option( 'blog-show-read-more' ) && !yit_get_option( 'blog-show-featured' ) ) {
                        the_content( '',FALSE,'' );
                    } else {
                        the_excerpt();
                    }
                }
                if(is_single() && $post_format != 'quote'){
                    the_content();
                }

                ?>

                <?php if( yit_get_option( 'blog-show-read-more' ) && strcmp( yit_get_option( 'blog-read-more-text' ), '' ) != 0 && !is_single() && $post_format != 'quote' ) : ?>
                    <div class="buttons blog">
                        <a href="<?php the_permalink() ?>"><?php echo yit_get_option( 'blog-read-more-text' )?></a>
                    </div>
                <?php endif; ?>

                <?php edit_post_link( __( 'Edit', 'yit' ), '<span class="edit-link"><i class="icon-pencil"></i>', '</span>' ); ?>
                <?php wp_link_pages(); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
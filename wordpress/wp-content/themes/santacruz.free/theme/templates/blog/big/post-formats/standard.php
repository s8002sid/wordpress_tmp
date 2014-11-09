<?php
/**
 * Your Inspiration Themes
 *
 * @package    WordPress
 * @subpackage Your Inspiration Themes
 * @author     Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
?>

<?php
$comments_number = get_comments_number();
$comments_label = ( $comments_number == 1 ) ? __( 'comment', 'yit' ) : __( 'comments', 'yit' );
?>

<?php if ( $has_thumbnail && ! is_single() ): ?>
    <div class="thumbnail span<?php echo $span; ?>">

        <div class="thumbnail-wrapper span<?php echo $span; ?>">

            <?php
            if ( $has_thumbnail ) {
                yit_image( "size=blog_big&alt=blogimage" );
            }
            ?>

            <div class="blog-meta">
                <?php if ( yit_get_option( 'blog-show-date' ) ): ?>
                    <div class="blog-big-image-date">
                        <span class="day"><?php echo get_the_date( 'd' ) ?></span>
                        <span class="month"><?php echo get_the_date( 'M' ) ?></span>
                    </div>
                <?php endif ?>
            </div>

            <div class="thumb-overlay hidden-phone">
                <div class="thumb-overlay-container">
                    <!-- post title -->
                    <?php yit_string( "<h3 class=\"post-title{$upper}\"><a href=\"$link\">", $title, "</a></h3>" ); ?>

                    <!-- post meta -->
                    <div class="meta">
                        <?php if ( yit_get_option( 'blog-show-comments' ) ): ?>
                            <div class="meta-elem">
                                <img class="comments-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/comments-1.png">
                                <a href="<?php comments_link(); ?>" class="blog-big-image-comments-count"><?php echo $comments_number;?>&nbsp;<?php echo $comments_label ?></a>
                            </div>
                        <?php endif ?>

                        <?php if ( get_the_author() != '' && yit_get_option( 'blog-show-author' ) ) : ?>
                            <div class="meta-elem">
                                <img class="author-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/author-1.png">
                                <span><?php _e( 'Author:', 'yit' )?></span>&nbsp;<?php the_author_posts_link(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( yit_get_option( 'blog-show-categories' ) && has_category() ) : ?>
                            <div class="meta-elem">
                                <img class="categories-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/categories.png">
                                <?php the_category( ', ' ) ?>
                            </div>
                        <?php endif; ?>


                        <?php if ( yit_get_option( 'blog-show-tags' ) && has_tag() ) : ?>
                            <div class="meta-elem">
                                <img class="tags-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/tags.png">
                                <span><?php the_tags( __( 'Tags: ', 'yit' ), ', ' ); ?></span>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="thumbnail-wrapper blog-header span<?php echo $span; ?> visible-phone">
            <?php yit_string( "<h1 class=\"post-title{$upper}\"><a class=\"post-title-link\" href=\"$link\">", $title, "</a></h1>" ); ?>
            <div class="meta">
                <?php if ( yit_get_option( 'blog-show-comments' ) ): ?>
                    <div class="meta-elem">
                        <img class="comments-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/comments-grey-1.png">
                        <a href="<?php comments_link(); ?>" class="blog-big-image-comments-count"><?php echo $comments_number;?>&nbsp;<?php echo $comments_label ?></a>
                    </div>
                <?php endif ?>

                <?php if ( get_the_author() != '' && yit_get_option( 'blog-show-author' ) ) : ?>
                    <div class="meta-elem">
                        <img class="author-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/author-grey-1.png">
                        <span><?php _e( 'Author:', 'yit' )?></span>&nbsp;<?php the_author_posts_link(); ?>
                    </div>
                <?php endif; ?>

                <?php if ( yit_get_option( 'blog-show-categories' ) && has_category() ) : ?>
                    <div class="meta-elem">
                        <img class="categories-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/categories-grey.png">
                        <?php the_category( ', ' ) ?>
                    </div>
                <?php endif; ?>


                <?php if ( yit_get_option( 'blog-show-tags' ) && has_tag() ) : ?>
                    <div class="meta-elem">
                        <img class="tags-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/tags-grey.png">
                        <span><?php the_tags( __( 'Tags: ', 'yit' ), ', ' ); ?></span>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="blog-header span<?php echo $span; ?>">
        <div class="blog-meta">
            <?php if ( yit_get_option( 'blog-show-date' ) ): ?>
                <div class="blog-big-image-date">
                    <span class="day"><?php echo get_the_date( 'd' ) ?></span>
                    <span class="month"><?php echo get_the_date( 'M' ) ?></span>
                </div>
            <?php endif ?>
        </div>
        <?php if ( is_single() ): ?>
            <div class="blog-comment hidden-phone">
                <a href="<?php comments_link(); ?>" class="blog-big-image-comments-count"><?php echo $comments_number;?></a>
            </div>
        <?php endif; ?>
        <?php yit_string( "<h1 class=\"post-title{$upper}\"><a href=\"$link\">", $title, "</a></h1>" ); ?>
        <div class="meta">
            <?php if ( yit_get_option( 'blog-show-comments' ) && !is_single() ): ?>
                <div class="meta-elem">
                    <img class="comments-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/comments-grey-1.png">
                    <a href="<?php comments_link(); ?>" class="blog-big-image-comments-count"><?php echo $comments_number;?>&nbsp;<?php echo $comments_label ?></a>
                </div>
            <?php endif ?>

            <?php if ( get_the_author() != '' && yit_get_option( 'blog-show-author' ) ) : ?>
                <div class="meta-elem">
                    <img class="author-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/author-grey-1.png">
                    <span><?php _e( 'Author:', 'yit' )?></span>&nbsp;<?php the_author_posts_link(); ?>
                </div>
            <?php endif; ?>

            <?php if ( yit_get_option( 'blog-show-categories' ) && has_category() ) : ?>
                <div class="meta-elem">
                    <img class="categories-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/categories-grey.png">
                    <?php the_category( ', ' ) ?>
                </div>
            <?php endif; ?>


            <?php if ( yit_get_option( 'blog-show-tags' ) && has_tag() ) : ?>
                <div class="meta-elem">
                    <img class="tags-icon" src="<?php echo get_template_directory_uri() ?>/images/icons/tags-grey.png">
                    <span><?php the_tags( __( 'Tags: ', 'yit' ), ', ' ); ?></span>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="thumbnail span<?php echo $span; ?>">
        <div class="thumbnail-wrapper span<?php echo $span; ?>">
            <?php
            if ( is_single() && $has_thumbnail ) {
                yit_image( "size=blog_big&alt=blogimage" );
            }
            ?>
        </div>
    </div>
<?php endif; ?>
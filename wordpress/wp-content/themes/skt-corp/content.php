<?php
/**
 * @package SKT Corp
 */
?>
<div class="blog-post-repeat">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php esc_url( the_permalink()); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <?php if ( 'post' == get_post_type() ) : ?>
                <div class="postmeta">
                    <div class="post-date"><?php echo get_the_date(); ?></div><!-- post-date -->
                    <div class="post-comment"> &nbsp;|&nbsp; <a href="<?php esc_url(comments_link()); ?> "><?php comments_number(); ?></a></div>
                    <div class="post-categories"> &nbsp;|&nbsp; <?php echo skt_corp_getPostCategories();?></div>
                    <div class="clear"></div>
                </div><!-- postmeta -->
            <?php endif; ?>
            <div class="post-thumb"><?php the_post_thumbnail(); ?>
            </div><!-- post-thumb -->
        </header><!-- .entry-header -->
    
        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
           	<?php the_excerpt(); ?>
            <p class="read-more"><a href="<?php esc_url(the_permalink()); ?>"><?php _e('Read More &raquo;','skt-corp'); ?></a></p>
        </div><!-- .entry-summary -->
        <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'skt-corp' ) ); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'skt-corp' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->
        <?php endif; ?>
    
        <footer class="entry-meta" style="display:none;">
            <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
                <?php
                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list( __( ', ', 'skt-corp' ) );
                    if ( $categories_list && skt_corp_categorized_blog() ) :
                ?>
                <span class="cat-links">
                    <?php printf( __( 'Posted in %1$s', 'skt-corp' ), $categories_list ); ?>
                </span>
                <?php endif; // End if categories ?>
    
                <?php
                    /* translators: used between list items, there is a space after the comma */
                    $tags_list = get_the_tag_list( '', __( ', ', 'skt-corp' ) );
                    if ( $tags_list ) :
                ?>
                <span class="tags-links">
                    <?php printf( __( 'Tagged %1$s', 'skt-corp' ), $tags_list ); ?>
                </span>
                <?php endif; // End if $tags_list ?>
            <?php endif; // End if 'post' == get_post_type() ?>
    
            <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
            <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'skt-corp' ), __( '1 Comment', 'skt-corp' ), __( '% Comments', 'skt-corp' ) ); ?></span>
            <?php endif; ?>
    
            <?php edit_post_link( __( 'Edit', 'skt-corp' ), '<span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-meta -->
    </article><!-- #post-## -->
</div><!-- blog-post-repeat -->
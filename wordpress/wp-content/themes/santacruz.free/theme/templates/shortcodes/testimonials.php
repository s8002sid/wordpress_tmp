<?php
wp_reset_query();

$args = array(
    'post_type' => 'testimonial'
);

$args['posts_per_page'] = ( isset( $items ) && $items != '' ) ? $items : - 1;

if ( isset( $cat ) && ! empty( $cat ) ) {
    $cat               = array_map( 'trim', explode( ',', $cat ) );
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category-testimonial',
            'field'    => 'id',
            'terms'    => $cat
        )
    );
}

$tests = new WP_Query( $args );

if ( ! $tests->have_posts() ) {
    return false;
} ?>
<?php $i = 0;
$row = ( yit_get_sidebar_layout() == 'sidebar-no' ) ? 4 : 3;
$span = ( yit_get_sidebar_layout() != 'sidebar-no' ) ? 4 : 3;
while ( $tests->have_posts() ) : $tests->the_post();
    if ( $i == 0 || $i % $row == 0 ) {
        echo '<div class="row-fluid">';
    }
    $fulltext = '';
    $text     = ( strcmp( yit_get_option( 'text-type-testimonials' ), 'content' ) == 0 ) ? get_the_content() : get_the_excerpt();

    $title      = the_title( '<span  class="name">', '</span>', false );
    $label      = yit_get_post_meta( get_the_ID(), '_site-label' );
    $siteurl    = yit_get_post_meta( get_the_ID(), '_site-url' );
    $smallquote = yit_get_post_meta( get_the_ID(), '_small-quote' );
    $website    = '';
    if ( $siteurl != '' ):
        if ( $label != '' ):
            $website = '<a class="website" href="' . esc_url( $siteurl ) . '">' . $label . '</a>';
        else:
            $website = '<a class="website" href="' . esc_url( $siteurl ) . '">' . $siteurl . '</a>';
        endif;
    else:
        $website = '<span class="website">' . $label . '</span>';
    endif;
    ?>

    <div class="testimonial span<?php echo $span ?>">
        <?php if ( yit_get_option( 'thumbnail-testimonials' ) && get_the_post_thumbnail( null, 'thumb-testimonial' ) ) : ?>
            <div class="testimonial-head">
                <div class="thumbnail">
                    <?php echo get_the_post_thumbnail( null, 'thumb-testimonial' ); ?>
                    <div class="thumbnail-overlay">
                        <div class="testimonial-name <?php if ( ! yit_get_option( 'thumbnail-testimonials' ) || ! get_the_post_thumbnail( null, 'thumb-testimonial' ) ) : ?>nothumb<?php endif ?>"><?php echo $title . $website; ?></div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <div class="testimonial-content">
            <?php if ( isset( $smallquote ) && $smallquote != '' ) : ?>
                <div class="testimonial-smallquote"><?php echo $smallquote ?></div>
            <?php endif ?>
            <div class="testimonial-text">
                <blockquote>
                    <?php echo wpautop( $text ); ?>
                </blockquote>
            </div>
        </div>
    </div>

    <?php $i ++;
    if ( $i % $row == 0 ) {
        echo '</div>';
    } ?>
<?php endwhile; ?>

<?php if ( $i % $row != 0 ) {
    echo '</div>';
} ?>
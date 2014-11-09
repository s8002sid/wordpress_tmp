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

 
/**
 * Add more shortcodes to the framework
 * 
 */
function yit_add_shortcodes( $shortcodes ) {
	/** Edit attributes in existing shortcodes */
    unset($shortcodes['section_services']['attributes']['show_detail_hover']);
	unset($shortcodes['section_services']['attributes']['show_title_hover']);
	
	$shortcodes['section']['attributes']['items_per_row'] = array(
		'title' => __('Items per row', 'yit'),
		'type' => 'select',
		'options' => array(
		   '2' => __('2 items', 'yit'),
		   '3' => __('3 items', 'yit'),
		   '4' => __('4 items', 'yit'),
		   '6' => __('6 items', 'yit')
		  ),
        'std' => '4'
	);
	
	$shortcodes['section']['attributes']['show_services_button'] = array(
		'title' => __('Show Button', 'yit'),
		'type' => 'checkbox',
        'std' => 'yes'
	);

	$shortcodes['section']['attributes']['services_button_text'] = array(
		'title' => __('Button Text', 'yit'),
		'type' => 'text',
        'std' => 'Read More'
	);

    $shortcodes['section_services']['attributes']['items_per_row'] = array(
		'title' => __('Items per row', 'yit'),
		'type' => 'select',
		'options' => array(
		   '2' => __('2 items', 'yit'),
		   '3' => __('3 items', 'yit'),
		   '4' => __('4 items', 'yit'),
		   '6' => __('6 items', 'yit')
		  ),
        'std' => '4'
	);

	$shortcodes['section_services']['attributes']['show_services_button'] = array(
		'title' => __('Show Button', 'yit'),
		'type' => 'checkbox',
        'std' => 'yes'
	);

	$shortcodes['section_services']['attributes']['services_button_text'] = array(
		'title' => __('Button Text', 'yit'),
		'type' => 'text',
        'std' => 'Read More'
	);

    $shortcodes['section_services']['attributes']['services_icon_title'] = array(
        'title' => __( 'Title icon URL', 'yit' ),
        'type' => 'text',
        'desc' => __( 'Select the icon to use for the title.', 'yit' ),
        'std'  => ''
    );

    $shortcodes['section']['attributes']['services_icon_title'] = array(
        'title' => __( 'Title icon URL', 'yit' ),
        'type' => 'text',
        'desc' => __( 'Select the icon to use for the title.', 'yit' ),
        'std'  => ''
    );

//	$faq_categories = yit_get_faq_categories();
	$testimonial_categories = yit_get_testimonial_categories();
    $testimonial = yit_get_testimonial();
	
    return array_merge( $shortcodes, array(
		/* === TESTIMONIALS === */
		'testimonials' => array(
			'title' => __('Testimonials', 'yit' ),
			'description' => __('Show all post on testimonials post types', 'yit' ),
			'tab' => 'cpt',
            'has_content' => false,
			'attributes' => array(
				'items' => array(
					'title' => __('N. of items', 'yit'),
					'description' => __('Show all with -1', 'yit'),
            		'type' => 'number', 
					'std'  => '-1'
				),
				'cat' => array(
					'title' => __('Categories', 'yit'),
					'description' => __('Select the categories of posts to show', 'yit'),
            		'type' => 'select', 
            		'options' => $testimonial_categories,
					'std'  => ''
                )
			)
		),
        /* === HIDE FOR THIS THEME === */
        'label' => array(
        'hide' => true,
        )
	));
}
add_filter( 'yit_add_shortcodes', 'yit_add_shortcodes' );

add_action('wp_enqueue_scripts', 'add_shortcodes_theme_css');

if( !function_exists( 'add_shortcodes_theme_css' ) ) {
	/*
	 * Add style of widgets in theme
	 */
	function add_shortcodes_theme_css(){
		$url = YIT_THEME_ASSETS_URL . '/css/shortcodes.css';
	    //wp_register_style('shortcodes_theme_css', $url);
	    yit_enqueue_style(1201, 'shortcodes_theme_css', $url);	
	}
}

function yit_get_faq_categories(){
	global $wpdb, $blog_id, $current_blog;
	
	wp_reset_query();
	$terms = $wpdb->get_results( "SELECT name, t.term_id FROM $wpdb->terms AS t, $wpdb->term_taxonomy AS tt WHERE t.term_id = tt.term_id AND taxonomy = 'category-faq' ORDER BY name ASC" );
	
	$categories = array();
	$categories['0'] = __('All categories', 'yit');
	if ($terms) :
		foreach ($terms as $cat) : 
			$categories[$cat->term_id] = ($cat->name) ? $cat->name : 'ID: '. $cat->term_id;
		endforeach;
	endif;
	return $categories;		
}

function yit_get_testimonial_categories(){
	global $wpdb, $blog_id, $current_blog;
	
	wp_reset_query();
	$terms = $wpdb->get_results('SELECT name, ' . $wpdb->prefix . 'terms.term_id FROM ' . $wpdb->prefix . 'terms, ' . $wpdb->prefix . 'term_taxonomy WHERE ' . $wpdb->prefix . 'terms.term_id = ' . $wpdb->prefix . 'term_taxonomy.term_id AND taxonomy = "category-testimonial" ORDER BY name ASC;');
	
	$categories = array();
	$categories['0'] = __('All categories', 'yit');
	if ($terms) :
		foreach ($terms as $cat) : 
			$categories[$cat->term_id] = ($cat->name) ? $cat->name : 'ID: '. $cat->term_id;
		endforeach;
	endif;
	return $categories;		
}

function yit_get_testimonial(){
    wp_reset_query();
    $posts = get_posts(
        array(
            'post_type' => 'testimonial'
        )
    );

    $return = array();
    foreach($posts as $post){
        $return[$post->ID] = $post->post_title;
    }
    return $return;
}
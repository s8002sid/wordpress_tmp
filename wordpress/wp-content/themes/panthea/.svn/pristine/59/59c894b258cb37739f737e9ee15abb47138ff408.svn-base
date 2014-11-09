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
    unset($shortcodes['section_blog']);
    unset($shortcodes['contact_info']);
    unset($shortcodes['testimonials_slider']);
    unset($shortcodes['section_services']);

    //$faq_categories = yit_get_faq_categories();
    $testimonial_categories = yit_get_testimonial_categories();

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
                ),
                'style' => array(
                    'title' => __('Style', 'yit'),
                    'description' => __('Select the style of testimonials', 'yit'),
                    'type' => 'select',
                    'options' => array('square'=>'square', 'comic'=>'comic'),
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


function yit_shortcodes_tabs_remove($name_tab){

    unset($name_tab['section']);
    return $name_tab;
}

add_filter( 'yit_shortcodes_tabs', 'yit_shortcodes_tabs_remove');
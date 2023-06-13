<?php
/*
The file contain theme functions.
*/

$opt_name = 'secretlab';

// Page preloader

add_action('wp_head', 'sell_preloader_styles');
function sell_preloader_styles() {
    global $secretlab;
    if (isset ($secretlab['pageloader'])) {
        if ($secretlab['pageloader'] == 1) {
            echo '<style>
                /* Pageloader */
            #page-preloader {position: absolute;  left: 0; top:0; right: 0; bottom: 0; height: 100%; width: 100%; cursor: default;  pointer-events: none; text-align: center; vertical-align: middle; background-color: #FFF; z-index: 9999999}
            #page-preloader img {position: absolute; top: calc(50% - 48px); left: calc(50% - 42px); animation-name: rotationY; animation-duration: 1750ms; animation-iteration-count: infinite; animation-timing-function: linear;}
            

            @keyframes rotationY {
                0% {transform:rotate(0deg) translateZ(0);}
                25% {transform:rotate(15deg) translateZ(0);}
                50% {transform:rotate(0deg) translateZ(0);}
                75% {transform:rotate(-15deg) translateZ(0);}
                100% {transform:rotate(0deg) translateZ(0);}
            }
              </style>';
        }
    }

}

// Check pagetype for Boxed background setting
function thelawyer_check_pagetype($thelawyer_pagetype_prefix) {
    global $thelawyer_layout, $secretlab;

if (isset($secretlab['boxed-background'])) {
    if (isset($secretlab['boxed-background-color'])) {
        $props = array('shop-' => array('boxed-background', 'boxed-background-color'),
            'blog-' => array());

        foreach ($props[$thelawyer_pagetype_prefix] as $prop) {
            if (!isset($thelawyer_layout[$thelawyer_pagetype_prefix . $prop])) {
                $thelawyer_layout[$thelawyer_pagetype_prefix . $prop] = $secretlab[$prop];
            }
        }
    }
}
    if (isset($secretlab['blog-columns'])) {
        $thelawyer_layout['blog-columns'] = $secretlab['blog-columns'];
    }


}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function thelawyer_my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

//The function set global variables for correct work of Metabox Plugin with page setting: sidebar and slider
function set_globals() {

    global $secretlab, $thelawyer_layout, $post;
	
    $plugins = get_option('active_plugins');
    if (!in_array('revslider/revslider.php', $plugins) && !in_array('LayerSlider/layerslider.php', $plugins)) $secretlab['is_active_slider_plugins'] = false; else $secretlab['is_active_slider_plugins'] = true;		

    if (is_singular()) {
        $thelawyer_layout = json_decode(get_post_meta($post->ID, 'layout_settings', true), true);
        if (!$thelawyer_layout) $thelawyer_layout = $secretlab;
        if ( in_category( 'blog' ) || thelawyer_post_is_in_descendant_category(get_term_by( 'name', 'blog', 'category' ) )) {
            $secretlab['thelawyer_page_type'] = 'blog';
            $secretlab['thelawyer_design_layout'] = 'blog-layout';
            $secretlab['thelawyer_pagetype_prefix'] = 'blog-';
            thelawyer_check_pagetype($secretlab['thelawyer_pagetype_prefix']);
        }
        else if (function_exists('is_woocommerce') && is_woocommerce()) {
            $secretlab['thelawyer_page_type'] = 'shop';
            $secretlab['thelawyer_design_layout'] = 'design-layout';
            $secretlab['thelawyer_pagetype_prefix'] = 'shop-';
            thelawyer_check_pagetype($secretlab['thelawyer_pagetype_prefix']);
        }
        else {
            $secretlab['thelawyer_page_type'] = '';
            $secretlab['thelawyer_design_layout'] = 'design-layout';
            $secretlab['thelawyer_pagetype_prefix'] = '';
        }
    }
    else if (function_exists('is_woocommerce') && is_woocommerce()) {
        $thelawyer_layout = $secretlab;
        $secretlab['thelawyer_page_type'] = 'shop';
        $secretlab['thelawyer_design_layout'] = 'design-layout';
        $secretlab['thelawyer_pagetype_prefix'] = 'shop-';
        thelawyer_check_pagetype($secretlab['thelawyer_pagetype_prefix']);
    }
    else if (is_category()) {
        $thelawyer_layout = $secretlab;
        $category = get_category( get_query_var( 'cat' ) );
        $cat_tree = get_category_parents($category->term_id, FALSE, ':', TRUE);
        $top_cat = explode(':',$cat_tree);
        $parent = $top_cat[0];
        if ($top_cat[0] == 'blog') {
            $secretlab['thelawyer_page_type'] = 'blog';
            $secretlab['thelawyer_design_layout'] = 'blog-layout';
            $secretlab['thelawyer_pagetype_prefix'] = 'blog-';
        }
        else {
            $thelawyer_layout = $secretlab;
            $secretlab['thelawyer_page_type'] = '';
            $secretlab['thelawyer_design_layout'] = 'design-layout';
            $secretlab['thelawyer_pagetype_prefix'] = '';
        }
    }
    else {
        $thelawyer_layout = $secretlab;
        $secretlab['thelawyer_page_type'] = '';
        $secretlab['thelawyer_design_layout'] = 'design-layout';
        $secretlab['thelawyer_pagetype_prefix'] = '';
    }

}

// Admin Panel Features Image 55x55 in posts list and pages list
function thelawyer_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thelawyer_featured_preview');
        return $post_thumbnail_img[0];
    }
}
// ADD NEW COLUMN
function thelawyer_columns_head($defaults) {
    $defaults['featured_image'] = esc_html__('Featured Image', 'the-lawyer');
    return $defaults;
}

// SHOW THE FEATURED IMAGE
function thelawyer_columns_content($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
        $post_featured_image = thelawyer_get_featured_image($post_ID);
        if ($post_featured_image) {
            echo '<img src="' . $post_featured_image . '" />';
        } else {
            echo '<img src="'.esc_url(get_template_directory_uri()).'/images/not55.jpg" alt="'.esc_html__('No Featured Image', 'the-lawyer').'" />';
        }
    }
}
add_filter('manage_posts_columns', 'thelawyer_columns_head');
add_action('manage_posts_custom_column', 'thelawyer_columns_content', 10, 2);

/* Color Schemes - Generate CSS */
function thelawyer_to_row($arr) {

    $keys = array();
    $values = array();
    foreach ($arr as $key=>$val) {
        if (is_array($val)) {
            foreach ($val as $k=>$v) {
                if (!is_array($v)) {
                    $keys[] = '/\$'.$key.'_'.$k.'\$/';
                    $values[] = $v;
                }
                else {
                    foreach ($v as $k1=>$v1) {
                        $keys[] = '/\$'.$key.'_'.$k.'_'.$k1.'\$/';
                        $values[] = $v1;
                    }
                }
            }
        }
        else {
            $keys[] = '/\$'.$key.'\$/';
            $values[] = $val;
        }
    }
    $result = array();
    $result['keys'] = $keys; ksort($result['keys']);
    $result['values'] = $values; ksort($result['values']);

    //echo '<pre>'; print_r($result['keys']); echo '</pre>';
    //echo '<pre>'; print_r($result['values']); echo '</pre>';

    return $result;
}
add_action ('redux/options/' . $opt_name . '/settings/change', 'thelawyer_change_action', 10, 3);

/* Generate CSS by Template */
function thelawyer_change_action($opts) {

    global $wp_filesystem, $secretlab;

    $sl_design_css = isset($secretlab['design-css']) ? $secretlab['design-css'] : 1;
    if ( $sl_design_css == 1 ) {
        $template_css = get_template_directory() . '/css/theme.css';
    }
    if ( $sl_design_css == 2 ) {
        $template_css = get_template_directory() . '/css/themedark.css';
    }
    if ( $sl_design_css == 3 ) {
        $template_css = get_template_directory() . '/css/theme2.css';
    }

    if( empty( $wp_filesystem ) ) {
        WP_Filesystem();
    }

    if( $wp_filesystem ) {
        $css = get_template_directory() . '/css/dynamic.css';
        $content = $wp_filesystem->get_contents($template_css);
        $opts = thelawyer_to_row($opts);
        $content = preg_replace($opts['keys'], $opts['values'], $content);
        $wp_filesystem->put_contents($css, $content, FS_CHMOD_FILE);
    }
}



// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function thelawyer_add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function thelawyer_remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Add menu to locations after import
function set_menu_to_locations() {
    $native_menu = wp_get_nav_menu_object('Menu 1');
    $locations = array('thelawyer_top_menu');
    $menu_set = array();
    foreach ($locations as $location) {
        $menu_set[$location] = $native_menu->term_id;
    }
    if (count($menu_set) > 0) {
        set_theme_mod('nav_menu_locations', $menu_set);
    }
	
	$homepage = get_page_by_title( 'Homepage with menu line' );
	if (($homepage && $homepage->ID)) {
	    update_option('show_on_front', 'page');
        if ($homepage && $homepage->ID) {
            update_option('page_on_front', $homepage->ID); // Front Page
        }		
	}
	
}

add_action('import_end', 'set_menu_to_locations');
// ttt
function secretlab_option( $id, $fallback = false, $param = false ) {
    global $secretlab;
    if (!isset($secretlab)) {
        $s = get_option('secretlab');
    }
    else $s = $secretlab;
    if ( $fallback == false ) $fallback = '';
    $output = ( isset($s[$id]) && $s[$id] !== '' ) ? $s[$id] : $fallback;
    if ( !empty($s[$id]) && $param ) {
        $output = ( isset($s[$id][$param]) && $s[$id][$param] !== '' ) ? $s[$id][$param] : $fallback;
    }
    return $output;
}

//Disablle Redux welcome page
add_filter('wp_redirect', 'thelawyer_disable_redux_welcome');

function thelawyer_disable_redux_welcome($path) {
    if (preg_match('/redux.about|vc.welcome/', $path)) {
        $path = preg_replace('/redux.about|vc.welcome/', 'secretlab-welcome', $path);
    }

    return $path;
}
/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *

 *
 * @return string The Link format URL.
 */
function thelawyer_get_link_url() {
    $content = get_the_content();
    $has_url = get_url_in_content( $content );

    return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ...
 * and a Continue reading link.
 *sprintf( ' <a href="%1$s" class="more-link">Continue reading  <span class="meta-nav">&rarr;</span></a>',
esc_url( get_permalink( get_the_ID() ) )
)
 * @param string $more Default Read More excerpt link.
 * @return string Filtered Read More excerpt link.
 */
if ( ! function_exists( 'thelawyer_excerpt_more' ) && ! is_admin() ) :
    function thelawyer_excerpt_more( $more ) {
        $link = '';
        return $link;
    }
    add_filter( 'excerpt_more', 'thelawyer_excerpt_more' );
endif;





?>

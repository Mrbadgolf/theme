<?php

function thelawyer_set_ajax_connector($hook) {
    wp_localize_script('jquery', 'localajax', 
	    array(
	        'url' => admin_url('admin-ajax.php')
    	)
	);	
}

add_action('admin_enqueue_scripts', 'thelawyer_set_ajax_connector');
add_action('wp_enqueue_scripts', 'thelawyer_set_ajax_connector');

add_action( 'wp_ajax_handle_post_layout', 'thelawyer_handle_post_layout' );
add_action( 'wp_ajax_nopriv_handle_post_layout', 'thelawyer_handle_post_layout' );

function thelawyer_handle_post_layout () {
    if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
        if (delete_post_meta($_POST['post_id'], 'layout_settings')) echo "data removed for id=".$_POST['post_id']; else echo "data not removed for id=".$_POST['post_id'];
	}
}



/* 
    thelawyer_get_customized_slider() returns aliases of available sliders, depending
	of $thelawyer_page_type which can indicate WooComerce page (forms 'shop' prefix, 
	                                 Blog page (forms 'blog' prefix),
									 and regular page (forms '' prefix)
*/

function thelawyer_get_customized_slider() {
	
    global $secretlab, $thelawyer_layout;
	if ($secretlab['thelawyer_page_type'] == 'blog') {
	    $secretlab['thelawyer_pagetype_prefix'] = 'blog-';
	}
	else if ($secretlab['thelawyer_page_type'] == 'shop') {
	    $secretlab['thelawyer_pagetype_prefix'] = 'shop-';
	}
	else {
	    $secretlab['thelawyer_pagetype_prefix'] = '';
	}
	$param_name = $secretlab['thelawyer_pagetype_prefix'].'header14_slider';
	if (count($thelawyer_layout) == 0 || $thelawyer_layout[$param_name] == 'default') {
	    $params = $secretlab; 
	}
	else {
	    $params = $thelawyer_layout;
	}
    
	if (!empty($params[$param_name]) && preg_match('/(rev_|lay_)(.+)/', $params[$param_name], $slider)) {
		
		$type = $slider[1];
		$slider = $slider[2];
		if ($type == 'lay_') echo do_shortcode('[layerslider id="'.$slider.'"]');
		if ($type == 'rev_') echo do_shortcode('[rev_slider alias="'.$slider.'"]');
	}
	else return;
}

function thelawyer_array_insert($array, $var, $position) {
    $before = array_slice($array, 0, $position);
    $after = array_slice($array, $position);

    $return = array_merge($before, (array) $var);
    return array_merge($return, $after);
}

add_action('get_header_scripts', 'thelawyer_get_header_scripts');
function thelawyer_get_header_scripts() {

    global $secretlab;

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

	wp_register_script('jsbootstrap', esc_url(get_template_directory_uri()) . '/js/bootstrap.min.js', array('jquery'), false, true);
	wp_enqueue_script('jsbootstrap');
	wp_register_script('thelawyer_mainjs', esc_url(get_template_directory_uri()) . '/js/main.js', array('jquery'), false, true);
	wp_enqueue_script('thelawyer_mainjs');
	wp_register_script('thelawyer_category_block_js', esc_url(get_template_directory_uri()) . '/js/cat_shortcode.js', array('jquery'), false, true);
	wp_enqueue_script('thelawyer_category_block_js');

	wp_enqueue_style('thelawyer_css', esc_url(get_template_directory_uri()) . '/css/dynamic.css', array(), false, 'all');
	wp_enqueue_style('thelawyer_alico', esc_url(get_template_directory_uri()) . '/css/alico.css', array(), false, 'all');
	wp_enqueue_style('thelawyer_ownstyles', esc_url(get_template_directory_uri()) . '/style.css', array('thelawyer_css'), false, 'all');


	if (isset ($secretlab['rtloption'])) {
		if ($secretlab['rtloption'] == 1) {

			$sl_design_css = isset($secretlab['design-css']) ? $secretlab['design-css'] : 1;
			if ($sl_design_css == 1 or $sl_design_css == 2) {
				wp_register_style('thelawyer_rtl', esc_url(get_template_directory_uri()) . '/css/1rtl.css', array('thelawyer_css'), false, 'all');
				wp_enqueue_style('thelawyer_rtl');
			}
			if ($sl_design_css == 3) {
				wp_register_style('thelawyer_rtl', esc_url(get_template_directory_uri()) . '/css/2rtl.css', array('thelawyer_css'), false, 'all');
				wp_enqueue_style('thelawyer_rtl');
			}
		}
	}


}

function thelawyer_post_is_in_descendant_category( $cats, $_post = null )
{
    foreach ( (array) $cats as $cat ) {
        // get_term_children() accepts integer ID only
        $descendants = get_term_children( (int) $cat, 'category');
        if ( $descendants && in_category( $descendants, $_post ) )
            return true;
    }
    return false;
}


/* 
  Function passing params to Slick Carousel JS script
*/

function thelawyer_add_slick_carousel() {

    global $secretlab;
	
    foreach ($secretlab['slick'] as $params) {
	
	if (!isset($params["961"])) {
	    $params['961'] = array( 'sp_row' => $params['sp_row'],
		                        'sp_scroll' => $params['sp_scroll'],
								'sp_show' => $params['sp_show'] );
	}
	
	if (!isset($params["768"])) {
	    $params['768'] = array( 'sp_row' => $params['sp_row'],
		                        'sp_scroll' => $params['sp_scroll'],
								'sp_show' => $params['sp_show'] );
	}

		echo '<script type="text/javascript">jQuery(document).ready(function() { jQuery(".'.$params['class'].'").not(\'.slick-initialized\').slick({
		  autoplay      : '.$params['autoplay'].
		 ',arrows        : '.$params['enable_nav'].
		 ',autoplaySpeed : '.$params['speed'].
		 ',dots : '.$params['dots'].
		',arrows : '.$params['arrows'].'';
		if (isset ($secretlab['rtlcarousel'])) {
			if ($secretlab['rtlcarousel'] == 1) {
				echo ', rtl: true';
			}
		}
		 echo ',slidesPerRow : '.$params['sp_row'].
		 ',slidesToScroll : '.$params['sp_scroll'].
		 ',slidesToShow : '.$params['sp_show'].
		  			 
		 ',responsive : [
          {
		      breakpoint : 961,
			  settings : {
			      slidesPerRow : '.$params["961"]["sp_row"].',
				  slidesToScroll : '.$params["961"]["sp_scroll"].', 
				  slidesToShow : '.$params["961"]["sp_show"].'
			  }
		  },		 
          {
		      breakpoint : 768,
			  settings : {
			      slidesPerRow : ' . $params["768"]["sp_row"].',
				  slidesToScroll : ' . $params["768"]["sp_scroll"].',
				  slidesToShow : ' . $params["768"]["sp_show"] . '				  
			  }
		  }		  
		  ]
		 }); });</script>';
		 
	}
			
    }

/**
 * Print HTML with meta information for current post in SecretLab Shortcodes Plugin: author, categories, date and comment counter.
 */
if ( ! function_exists( 'thelawyer_get_entry_meta' ) ) :

	function thelawyer_get_entry_meta($meta_set = true, $item = null)
	{
		global $secretlab, $post;
		
		if (!$meta_set) { 
		    $settings = $secretlab;
		}
		else {
		    $settings = array ( 'show_post_date' => true,
                                'show_post_category' => true,
								'show_post_author' => true,
								'show_comments_count' => true );
		}
		
		if (!$item) {
		    $p = $post;
		}
		else {
		    $p = $item;
		}
		
		$out = '';
		
		if (is_sticky($p->ID))
			$out .= '';

		// Post author
		$sl_show_author = isset($settings['show_post_author']) ? $settings['show_post_author'] : 1;
		if ($sl_show_author == 1) {
			if ('post' == get_post_type($p->ID)) {
				$author = get_user_by('id', $p->post_author);
				$out .= '<span class="author vcard">'.esc_html__('by', 'the-lawyer').' <a class="url fn n" href="'.
					esc_url(get_author_posts_url($p->post_author)).'"  title="'.esc_html__('View all posts by ', 'the-lawyer').''.$author->user_login.'" rel="author">'.
					$author->user_login.'</a></span>';
			}
		}
		// Categories: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list(esc_html__(', ', 'the-lawyer'), 'single', $p->ID);
		$sl_show_post_category = isset($settings['show_post_category']) ? $settings['show_post_category'] : 1;
		if ($sl_show_post_category == 1) {
			if ($categories_list) {
				$out .= esc_html__('in', 'the-lawyer').' <span class="categories-links">' . $categories_list . '</span>';
			}
		}
		/* Post data */
		$sl_show_post_date = isset($settings['show_post_date']) ? $settings['show_post_date'] : 1;
		if ($sl_show_post_date == 1) {
			if (!has_post_format('link') && 'post' == get_post_type($p)) {
				$out .= '<span class="date">'.get_the_date('F j, Y', $p).'</span>';
			}
		}

		// Comments counter
		$sl_show_comments_count = isset($settings['show_comments_count']) ? $settings['show_comments_count'] : 1;
		if ($sl_show_comments_count == 1) {
			if (comments_open($p->ID)) {
			    $comments = wp_count_comments( $p->ID );
				if ($comments->approved > 0) {
				    $out .= '<span class="comments-link"> ';
				    $out .= '<a href="'.get_permalink($p->ID).'#comments'.'">'.$comments->approved.' '.esc_html__('comments', 'the-lawyer').'</a>';
					$out .= '</span>';
				}
		        else {
		            $out .= '<span class="comments-link">
		                    <a href="'.get_permalink($p->ID).'#respond"> '.esc_html__( 'Leave a comment', 'the-lawyer' ).'</a>
				        </span>';
				}
			
            }			
		}
		
			
		return $out;
	}
endif;

// Excerpt function for SecretLab Shortcodes Plugin
function thelawyer_get_excerpt($p, $excerpt, $length = 35)
{
    global $post;
    if ($excerpt) return $excerpt;
	if (!$p) $p = $post;

    $text = strip_shortcodes( $p->post_content );
	$text = preg_replace( '~\[[^\]]+\]~', '', $text );

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);
    $excerpt_length = apply_filters('excerpt_length', $length);

	$more_link_text = '';
	$excerpt_more = apply_filters( 'the_content_more_link', '', $more_link_text );
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length || count($words) <= 5) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = '<p>'.$text.'...</p>';
    } else {
            $text = implode(' ', $words);
    }
	$raw_excerpt = '';
	
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}


function thelawyer_get_content ($p = null, $more_link_text = null, $strip_teaser = false) {
    global $post;
	if (!$p) $p = $post;

	if ( null === $more_link_text )
		$more_link_text = esc_html__( 'Continue reading', 'the-lawyer' ).'&hellip;';

	$output = '';
	$has_teaser = false;

	// If post password required and it doesn't match the cookie.
	if ( post_password_required( $p ) )
		return get_the_password_form( $p );

	$content = apply_filters( 'the_content', $p->post_content);
	if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
		$content = explode( $matches[0], $content, 2 );
		if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) )
			$more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );

		$has_teaser = true;
	} else {
		$content = array( $content );
	}

	if ( false !== strpos( $p->post_content, '<!--noteaser-->' ) && ( ! $multipage ) )
		$strip_teaser = true;

	$teaser = $content[0];

	if ( $more_link_text && $strip_teaser && $has_teaser )
		$teaser = '';

	$output .= $teaser;

	if ( count( $content ) > 1 ) {
		if ( $more ) {
			$output .= '<span id="more-' . $post->ID . '"></span>' . $content[1];
		} else {
			if ( ! empty( $more_link_text ) )
                $more_link_text = preg_replace('/%s/', '', $more_link_text); // it is a hack !!
				/**
				 * Filter the Read More link text.
				 *
				 * @since 2.8.0
				 *
				 * @param string $more_link_element Read More link element.
				 * @param string $more_link_text    Read More text.
				 */
				$output .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink($p->ID) . "#more-{$p->ID}\" class=\"more-link\">$more_link_text</a>", $more_link_text );
		}
	}
	
	$preview = false;

	if ( $preview ) // Preview fix for JavaScript bug with foreign languages.
		$output =	preg_replace_callback( '/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output );

	return $output;	
}


?>

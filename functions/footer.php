<?php
/*
The file contain functions for footer sections.
*/


function thelawyer_set_footer_sidebar_layout() {
	global $secretlab, $thelawyer_layout;

	$sl_sidebar_layout = isset($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'] . 'sidebar-layout']) ? $thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'] . 'sidebar-layout'] : 1;
	if ($sl_sidebar_layout == 2 or $sl_sidebar_layout == 4) {
		echo '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 widget-area">';
		if ($secretlab['thelawyer_page_type'] == '') $prefix = ''; else $prefix = '_';
		if (isset($thelawyer_layout[$secretlab['thelawyer_page_type'] . $prefix . 'right_sidebar_widgets'])) {
			dynamic_sidebar($thelawyer_layout[$secretlab['thelawyer_page_type'] . $prefix . 'right_sidebar_widgets']);
		}
		else {
			dynamic_sidebar($secretlab['thelawyer_page_type'] . '_default_right_sidebar');
		}
		echo '</div>';
	}
	
}


// Copyright date and text
if ( ! function_exists( 'thelawyer_copyright' ) ) {
    function thelawyer_copyright() {
        global $secretlab;
        $allowed_html = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
                'target' => array(),
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'p' => array(
                'style' => array(),
            ),
            'b' => array(),
            'i' => array(),
            'u' => array(),
            'ol' => array(),
            'ul' => array(),
            'li' => array(),
            'code' => array(),
            'del' => array()
        );
        if (isset ($secretlab['copyr-text'])) {
            $sl_copyright = $secretlab['copyr-text'];
            if (!empty($sl_copyright)) {
                echo '&copy; ' . date('Y') . ' ' . wp_kses($sl_copyright, $allowed_html );

            }
        } else {
            echo '&copy; ' . date('Y');
        }
    }
}

// Social buttons
if ( ! function_exists( 'thelawyer_socialbuttons_footer' ) ) {
    function thelawyer_socialbuttons_footer()
    {
        global $secretlab;
        if (isset ($secretlab['social-footer'])) {
            $sl_social_footer = $secretlab['social-footer'];
            if ($sl_social_footer == 1) {
                echo '<ul>';
                if (isset ($secretlab['social_link_facebook'])) {
                    $sl_fb = $secretlab['social_link_facebook'];
                    if (!empty($sl_fb)) {
                        echo '<li><a href="' . esc_url($sl_fb) . '" target="_blank"><i class="icon-facebook"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_twitter'])) {
                    $sl_tw = $secretlab['social_link_twitter'];
                    if (!empty($sl_tw)) {
                        echo '<li><a href="' . esc_url($sl_tw) . '" target="_blank"><i class="icon-twitter"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_myspace'])) {
                    $sl_myspace = $secretlab['social_link_myspace'];
                    if (!empty($sl_myspace)) {
                        echo '<li><a href="' . esc_url($sl_myspace) . '" target="_blank"><i class="icon-users"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_linkedin'])) {
                    $sl_linkedin = $secretlab['social_link_linkedin'];
                    if (!empty($sl_linkedin)) {
                        echo '<li><a href="' . esc_url($sl_linkedin) . '" target="_blank"><i class="icon-linkedin"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_google'])) {
                    $sl_google = $secretlab['social_link_google'];
                    if (!empty($sl_google)) {
                        echo '<li><a href="' . esc_url($sl_google) . '" target="_blank"><i class="icon-google-plus"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_tumblr'])) {
                    $sl_tumblr = $secretlab['social_link_tumblr'];
                    if (!empty($sl_tumblr)) {
                        echo '<li><a href="' . esc_url($sl_tumblr) . '" target="_blank"><i class="icon-tumblr"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_pinterest'])) {
                    $sl_pinterest = $secretlab['social_link_pinterest'];
                    if (!empty($sl_pinterest)) {
                        echo '<li><a href="' . esc_url($sl_pinterest) . '" target="_blank"><i class="icon-pinterest-p"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_youtube'])) {
                    $sl_youtube = $secretlab['social_link_youtube'];
                    if (!empty($sl_youtube)) {
                        echo '<li><a href="' . esc_url($sl_youtube) . '" target="_blank"><i class="icon-youtube-play"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_instagram'])) {
                    $sl_instagram = $secretlab['social_link_instagram'];
                    if (!empty($sl_instagram)) {
                        echo '<li><a href="' . esc_url($sl_instagram) . '" target="_blank"><i class="icon-instagram"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_vkcom'])) {
                    $sl_vkcom = $secretlab['social_link_vkcom'];
                    if (!empty($sl_vkcom)) {
                        echo '<li><a href="' . esc_url($sl_vkcom) . '" target="_blank"><i class="icon-vk"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_reddit'])) {
                    $sl_reddit = $secretlab['social_link_reddit'];
                    if (!empty($sl_reddit)) {
                        echo '<li><a href="' . esc_url($sl_reddit) . '" target="_blank"><i class="icon-reddit"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_blogger'])) {
                    $sl_blogger = $secretlab['social_link_blogger'];
                    if (!empty($sl_blogger)) {
                        echo '<li><a href="' . esc_url($sl_blogger) . '" target="_blank"><span class="icon-pencil6"></span></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_wordpress'])) {
                    $sl_wordpress = $secretlab['social_link_wordpress'];
                    if (!empty($sl_wordpress)) {
                        echo '<li><a href="' . esc_url($sl_wordpress) . '" target="_blank"><i class="icon-wordpress"></i></a></li>';
                    }
                }
                if (isset ($secretlab['social_link_behance'])) {
                    $sl_behance = $secretlab['social_link_behance'];
                    if (!empty($sl_behance)) {
                        echo '<li><a href="' . esc_url($sl_behance) . '" target="_blank"><i class="icon-behance"></i></a></li>';
                    }
                }
                echo '</ul>';
            }
        }
    }
}
// footer logo display
if ( ! function_exists( 'thelawyer_footer_logo' ) ) {
    function thelawyer_footer_logo()
    {
        global $secretlab;
        if (isset ($secretlab['logo-footer'])) {
            $sl_footer_logo = $secretlab['logo-footer']['url'];
            if (!empty($sl_footer_logo)) {
                echo '<img src="' . esc_url($sl_footer_logo) . '" alt="';
                if (isset ($secretlab['comp-name'])) {
                    echo esc_attr($secretlab['comp-name']);
                }
                echo '" />';
            }
        } else {
            echo '<a href="/"><img src="' . esc_url(get_template_directory_uri()) . '/images/logo.png" class="logo" alt="'.esc_attr__( 'The Lawyer WordPress Theme', 'the-lawyer' ).'" /></a>';
        }
    }
}

if ( ! function_exists( 'thelawyer_footer_address_section' ) ) {
    function thelawyer_footer_address_section()
    {
        global $secretlab;
        if (isset ($secretlab['address-footer'])) {
            if ($secretlab['address-footer'] == 1) {
                echo '<section class="meta"><div class="container">';
                dynamic_sidebar('botttom_sidebar_one');
                dynamic_sidebar('botttom_sidebar_two');
                dynamic_sidebar('botttom_sidebar_three');
                dynamic_sidebar('botttom_sidebar_four');
                echo '</div></section>';
            }
        }
    }
}



function thelawyer_footer_close_boxedlayout() {

    global $secretlab, $thelawyer_layout;
    if (isset ($thelawyer_layout[$secretlab['thelawyer_design_layout']])) {
        $sl_design_layout = $thelawyer_layout[$secretlab['thelawyer_design_layout']];
        if ($sl_design_layout == 2) {
            echo '</div></div></div>';
        }
    }

    if (isset ($secretlab['footer-nested'])) {
        if ($secretlab['footer-nested'] == 1) {
            if (isset ($secretlab['footer-nested-ace-js'])) {
                if (strlen($secretlab['footer-nested-ace-js']) > 0 && $secretlab['footer-nested-ace-js'] != 'function hello() { alert ("HELLO"); }') {
                    echo '<script type="text/javascript">' . $secretlab['footer-nested-ace-js'] . '</script>';
                }
            }
        }
    }
    if (isset ($secretlab['footer-nested'])) {
        if ($secretlab['footer-nested'] == 1) {
            if (isset ($secretlab['footer-nested-ace-css'])) {
                if (strlen($secretlab['footer-nested-ace-css']) > 0 && $secretlab['footer-nested-ace-css'] != 'body { margin : 0; padding : 0; }') {
                    echo '<style type="text/css">' . $secretlab['footer-nested-ace-css'] . '</style>';
                }
            }
        }
    }
}
// Additional CSS class for Security Design #2
function sell_footer_sec2_class() {
    global $secretlab;
    $sl_design_css = isset($secretlab['design-css']) ? $secretlab['design-css'] : 1;
    if ( $sl_design_css == 1 ) {
        echo ' foo_1des';
    }
    if ( $sl_design_css == 2 ) {
        echo ' foo_2des';
    }
}

// Additional CSS class for Security Design #2
function sell_footer_num_class() {
    global $secretlab;
    $sl_design_t = isset($secretlab['footer-type-layout']) ? $secretlab['footer-type-layout'] : 1;
    if ( $sl_design_t == 1 ) {
        echo ' predes';
    }
    if ( $sl_design_t == 2 ) {
        echo ' cusdes';
    }
}

// Switch between footers
function sell_footer_switch() {
    global $secretlab;

    echo '<footer class="footer';
    sell_footer_sec2_class();
    sell_footer_num_class();
    echo '">';
    if (isset ($secretlab['footer-type-layout'])) {
        if ($secretlab['footer-type-layout'] == 1) {
            sell_footer_1();
        } else {
            sell_footer_2();
        }
    }
    echo '</footer>';
}
// Footer #1
if ( ! function_exists( 'sell_footer_1' ) ) {
    function sell_footer_1() {
        thelawyer_footer_address_section();
        echo '<section class="footer">
            <div class="col-md-3 col-sm-2 hidden-xs"></div>
            <div class="col-md-6 col-sm-8 text-center">';
                thelawyer_footer_logo();
                echo '<div class="subscribe-form">';
                dynamic_sidebar( '_default_bottom_sidebar' );
        echo '</div>
            <div class="social">';
                thelawyer_socialbuttons_footer();
            echo '</div>
            </div>
            <div class="col-md-3 col-sm-2 hidden-xs"></div>
        </section>
        <section class="footer-b">
            <p>';
            thelawyer_copyright();
            echo '</p>
        </section>';
    }
}
// Footer #2
if ( ! function_exists( 'sell_footer_2' ) ) {
    function sell_footer_2() {
        echo '<div class="container"><div class="row">';
        dynamic_sidebar( '_default_bottom_sidebar_second' );
        echo '</div></div>';
    }
}
?>

<?php
/*
The file contain functions for headers sections.
*/
// Favicon and apple touch icon
function thelawyer_headicons() {
    global $secretlab;
    if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
        if (isset ($secretlab['favicon'])) {
            $sl_favicon = $secretlab['favicon']['url'];
            if (!empty($sl_favicon)) {
                echo '<link href="' . esc_url($sl_favicon) . '" rel="shortcut icon">';
            }
        }
    }
    if (isset ($secretlab['apple-touch-icon'])) {
        $sl_ati = $secretlab['apple-touch-icon']['url'];
        if (!empty($sl_ati)) {
            echo '<link href="' . esc_url($sl_ati) . '" rel="apple-touch-icon">';
        }
    }
}

// Pageloader
if ( ! function_exists( 'thelawyer_pageloader' ) ) {
    function thelawyer_pageloader()
    {
        global $secretlab;
        if (isset ($secretlab['pageloader'])) {
            if (isset ($secretlab['pageloaderimage']['url'])) {
                $sell_image = $secretlab['pageloaderimage']['url'];
                if ($secretlab['pageloader'] == 1) {
                    echo '<div id="page-preloader"><img src="' . esc_url($sell_image) . '" alt="Wait when page loaded" /></div>';
                }
            }
        }
    }
}

// Social buttons
if ( ! function_exists( 'thelawyer_socialbuttons_header' ) ) {
    function thelawyer_socialbuttons_header()
    {
        global $secretlab;
        $sl_header_social_buttons = $secretlab['header-social-buttons'];
        if ($sl_header_social_buttons == true) {
            echo '<ul class="socialbartransparent">';
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
// Display 1 phone number in header with icon
if ( ! function_exists( 'thelawyer_phone_header' ) ) {
    function thelawyer_phone_header()
    {
        global $secretlab;
        if (isset ($secretlab['phone'])) {
            $sl_phone = $secretlab['phone'][0];
            if (!empty($sl_phone)) {
                echo ' <p><span class="icon-phone2"></span> ' . esc_attr($sl_phone) . '</p>';
            }
        }
    }
}

// Display 1 phone number in header
if ( ! function_exists( 'thelawyer_phone_header_noico' ) ) {
    function thelawyer_phone_header_noico() {
        global $secretlab;
        if (isset ($secretlab['phone'])) {
            $sl_phone = $secretlab['phone'][0];
            if (!empty($sl_phone)) {
                echo esc_attr($sl_phone);
            }
        }
    }
}
// Office Address Text
if ( ! function_exists( 'thelawyer_phone_text' ) ) {
    function thelawyer_phone_text(){
        global $secretlab;
        if (isset ($secretlab['phone_text'])) {
            echo '<span>'.esc_attr($secretlab['phone_text']).'</span>';
        }
    }
}
// Display 1 email in header
if ( ! function_exists( 'thelawyer_email_header' ) ) {
    function thelawyer_email_header()
    {
        global $secretlab;
        if (isset ($secretlab['email'][0])) {
            $sl_email = $secretlab['email'][0];
            if (!empty($sl_email)) {
                echo '<p class="top-email"><span class="icon-envelope"></span> ' . esc_attr($sl_email) . '</p>';
            }
        }
    }
}
// Display unlimited phone number in header
if ( ! function_exists( 'thelawyer_get_header_tels' ) ) {
    function thelawyer_get_header_tels()
    {
        global $secretlab;
        $head_phones = implode('<br><span class="icon-phone2"></span> ', $secretlab['phone']);
        return $head_phones;
    }
}
if ( ! function_exists( 'thelawyer_phones_header' ) ) {
    function thelawyer_phones_header()
    {
        global $secretlab;
        if (isset ($secretlab['phone'])) {

            if (!empty($secretlab['phone'])) {
                echo '<p><span class="icon-phone2"></span> ' . thelawyer_get_header_tels() . '</p>';
            }
        }
    }
}

// Sticky menu class
if ( ! function_exists( 'thelawyer_sticky_class' ) ) {
    function thelawyer_sticky_class()
    {
        global $secretlab;
        if (isset ($secretlab['sticky-menu'])) {
            $sl_sticky_menu = $secretlab['sticky-menu'];
            if ($sl_sticky_menu == true) {
                echo 'id="stickymenu"';
            }
        }
    }
}

// Light Logo
if ( ! function_exists( 'thelawyer_logo_img' ) ) {
    function thelawyer_logo_img()
    {
        global $secretlab;
        if (isset ($secretlab['logo-head'])) {
            $sl_top_logo = $secretlab['logo-head']['url'];
            if (!empty($sl_top_logo)) {
                echo '<a href="'.home_url('/').'"><img src="' . esc_url($sl_top_logo) . '" class="logo" alt="';
                if (isset ($secretlab['comp-name'])) {
                    echo esc_attr($secretlab['comp-name']);
                }
                echo '" /></a>';;
            }
        } else {
            echo '<a href="/"><img src="' . esc_url(get_template_directory_uri()) . '/images/logo.png" class="logo" alt="'.esc_attr__( 'The Lawyer WordPress Theme', 'the-lawyer' ).'" /></a>';
        }
    }
}
// Dark Logo
if ( ! function_exists( 'thelawyer_logo_dark' ) ) {
    function thelawyer_logo_dark()
    {
        global $secretlab;
        if (isset ($secretlab['logo-head-dark'])) {
            $sl_top_logo = $secretlab['logo-head-dark']['url'];
            if (!empty($sl_top_logo)) {
                echo '<a href="'.home_url('/').'"><img src="' . esc_url($sl_top_logo) . '" class="logo" alt="';
                if (isset ($secretlab['comp-name'])) {
                    echo esc_attr($secretlab['comp-name']);
                }
                echo '" /></a>';;
            }
        }
    }
}
// Logo for header 3
if ( ! function_exists( 'thelawyer_logo_img_h3' ) ) {
    function thelawyer_logo_img_h3()
    {
        global $secretlab;
        if (isset ($secretlab['logo-head3'])) {
            $sl_top_logo3 = $secretlab['logo-head3']['url'];
            if (!empty($sl_top_logo3)) {
                echo '<a href="'.home_url('/').'"><img src="' . esc_url($sl_top_logo3) . '" class="logo" alt="';
                if (isset ($secretlab['comp-name'])) {
                    echo esc_attr($secretlab['comp-name']);
                }
                echo '" /></a>';;
            }
        }
    }
}

// Search icon and form for menu
if ( ! function_exists( 'thelawyer_search_menu' ) ) {
    function thelawyer_search_menu()
    {
        global $secretlab;
        if (isset ($secretlab['search_icon_menu'])) {
            $sl_search_menu = $secretlab['search_icon_menu'];
            if ($sl_search_menu == 1) {
                echo '<li class="li-search"><a href="#" class="open-search"><span class="icon-search22"></span></a></li>
                  <li class="search-item-nav"><div class="search-block">
                       <form method="get" id="searchform" action="' . home_url() . '/">
                       <input type="text" placeholder="Search" class="search-inpt" value="" name="s" id="s" />
                       <button class="search-sbmt left10" type="submit" id="searchsubmit" ><span class="icon-search22"></span></button>
                       <button class="search-sbmt search-sbmt-close" type="button"><span class="icon-cross4"></span></button>
                       </form>
                  </div></li>';
            }
        }
    }
}

// Topbar
if ( ! function_exists( 'thelawyer_topbar' ) ) {
    function thelawyer_topbar()
    {
        global $secretlab;
        if (isset ($secretlab['header-topbar'])) {
            $sl_header_topbar = $secretlab['header-topbar'];
            if ($sl_header_topbar == 1) {
                echo '<div class="top">
        <div class="container">
            <div class="row"><div class="col-md-6 col-sm-6 col-xs-12 contacttb"><div>';
                thelawyer_email_header();
                echo '</div><div>';
                thelawyer_phone_header();
                echo '</div></div>
                <div class="col-md-6 col-sm-6 col-xs-12 social">';
                thelawyer_socialbuttons_header();
                echo '</div>
            </div>
        </div>
    </div>';
            }
        }
    }
}
// Topbar 2
if ( ! function_exists( 'thelawyer_topbar2' ) ) {
    function thelawyer_topbar2()
    {
        global $secretlab;
        if (isset ($secretlab['header-topbar'])) {
            $sl_header_topbar = $secretlab['header-topbar'];
            if ($sl_header_topbar == 1) {
                echo '<div class="top topbar2">
                    <div class="container">
                        <div class="row">';
                    thelawyer_logo_dark();
                    thelawyer_topbar_cta();
                    echo '<div class="phone"><i class="icon-phone-wave"></i> ';
                    thelawyer_phone_header_noico();
                    echo '<span>';
                    thelawyer_business_hours();
                    echo '</span></div>';
                    echo '
                        </div>
                    </div>
                </div>';
            }
        }
    }
}

// Topbar 3: big one with addr, time, phone, socials
if ( ! function_exists( 'thelawyer_topbar3' ) ) {
    function thelawyer_topbar3()
    {
        global $secretlab;
        if (isset ($secretlab['header-topbar'])) {
            $sl_header_topbar = $secretlab['header-topbar'];
            if ($sl_header_topbar == 1) {
                echo '<div class="top topbar3">
                <div class="container">
                    <div class="row">
                         <div class="col-md-12 col-sm-12 col-xs-12">';

                            echo '<div class="tb3_logo">'; thelawyer_logo_img(); echo '</div>';
                            echo '<div class="tb3_social social">'; thelawyer_socialbuttons_header(); echo '</div>';
                            echo '<div class="tb3_search"><ul>'; thelawyer_cart_menu_short(); thelawyer_search_menu();  echo '</ul></div>';
                            echo '<div class="tb3_phone">'; thelawyer_phone_text(); echo '<div>'; thelawyer_phone_header_noico(); echo '</div></div>';
                            echo '<div class="tb3_time">'; thelawyer_business_hours_text(); echo '<div>'; thelawyer_business_hours(); echo '</div></div>';
                            echo '<div class="tb3_add">'; thelawyer_office_address_text(); echo '<div>'; thelawyer_office_address(); echo '</div></div>';
                        echo '</div>
                        </div>
                    </div>
                </div>';
            }
        }
    }
}

// Office Address
if ( ! function_exists( 'thelawyer_office_address' ) ) {
    function thelawyer_office_address(){
        global $secretlab;
        if (isset ($secretlab['office_address'])) {
            echo esc_attr($secretlab['office_address']);
        }
    }
}
// Office Address Text
if ( ! function_exists( 'thelawyer_office_address_text' ) ) {
    function thelawyer_office_address_text(){
        global $secretlab;
        if (isset ($secretlab['office_address_text'])) {
            echo '<span>'.esc_attr($secretlab['office_address_text']).'</span>';
        }
    }
}
// Logo choosing for Topbar 2 at different
function thelawyer_topbar2_logo() {
    global $secretlab;
    $sl_design_css = isset($secretlab['design-css']) ? $secretlab['design-css'] : 1;
    if ( $sl_design_css == 1 or $sl_design_css == 3 ) {
        thelawyer_logo_img();
    }
    if ( $sl_design_css == 2 ) {
        thelawyer_logo_dark();
    }
}
// Business hours
if ( ! function_exists( 'thelawyer_business_hours' ) ) {
    function thelawyer_business_hours(){
        global $secretlab;
        if (isset ($secretlab['business_hours'])) {
            echo esc_attr($secretlab['business_hours']);
        }
    }
}
// Business hours Text
if ( ! function_exists( 'thelawyer_business_hours_text' ) ) {
    function thelawyer_business_hours_text(){
        global $secretlab;
        if (isset ($secretlab['business_hours_text'])) {
            echo '<span>'.esc_attr($secretlab['business_hours_text']).'</span>';
        }
    }
}
// CTA topbar button
if ( ! function_exists( 'thelawyer_topbar_cta' ) ) {
    function thelawyer_topbar_cta() {
        global $secretlab;
        if (isset ($secretlab['topbar-cta'])) {
            if ($secretlab['topbar-cta'] == 1) {
                if (isset ($secretlab['topbar-cta-url'])) {
                    if (isset ($secretlab['topbar-cta-buttontext'])) {
                        echo '<a href="' . $secretlab['topbar-cta-url'] . '" class="btn">' . $secretlab['topbar-cta-buttontext'] . '</a>';
                    }
                }
            }
        }
    }
}
// number of header type
function thelawyer_head_num() {
    global $secretlab;
    if (isset ($secretlab['header-layout'])) {
        $sl_header_layout = $secretlab['header-layout'];
        if (!empty($sl_header_layout)) {
            get_template_part('header'.$sl_header_layout);
        }
    }  else {
        get_template_part('header1');
    }
}

// boxed layout
function thelawyer_set_boxed_background() {

    global $secretlab, $thelawyer_layout;

	$sl_design_layout = isset($thelawyer_layout[$secretlab['thelawyer_design_layout']]) ? $thelawyer_layout[$secretlab['thelawyer_design_layout']] : 1;
	if ( $sl_design_layout == 2 ) {
        if (!empty($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background-color'])) {
		    if (!is_array($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background-color'])) {
		        $bg_color = $thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background-color'];
			}
			else if  (is_array($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background-color'])) {
			    $bg_color = $thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background-color']['color'];
			} 
		}
		else {
		    $bg_color = 'transparent';
		}
		if (isset($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background'])) {
		    if (! empty($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background']) && !is_array($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background'])) { $src = json_decode($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background'], true); } 
			else { $src = $thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'].'boxed-background']; }
			if ($src['url'] != 'none' && $src['url'] != '') {
			    $bg_image = 'background-image : url("'.$src['url'].'") !important; }';
			}
			else $bg_image = '';
		}
		else {
		    $bg_image = '';
		}
		echo '<style type="text/css">.mainbgr { 
                background-color : '.$bg_color.' !important;'.			           
			    $bg_image.
			  '</style>';
    }
    // Custom CSS and JS
    if (isset ($secretlab['header-nested'])) {
        if ($secretlab['header-nested'] == 1) {
            if (isset ($secretlab['header-nested-ace-js'])) {
                if (strlen($secretlab['header-nested-ace-js']) > 0 && $secretlab['header-nested-ace-js'] != 'function hello() { alert ("HELLO"); }') {
                    echo '<script type="text/javascript">' . $secretlab['header-nested-ace-js'] . '</script>';
                }
            }
        }
    }
    if (isset ($secretlab['header-nested'])) {
        if ($secretlab['header-nested'] == 1) {
            if (isset ($secretlab['header-nested-ace-css'])) {
                if (strlen($secretlab['header-nested-ace-css']) > 0 && $secretlab['header-nested-ace-css'] != 'body { margin : 0; padding : 0; }') {
                    echo '<style type="text/css">' . $secretlab['header-nested-ace-css'] . '</style>';
                }
            }
        }
    }

}


function thelawyer_set_boxed_layout() {

    global $secretlab, $thelawyer_layout;
    if (isset ($thelawyer_layout[$secretlab['thelawyer_design_layout']])) {
        $sl_design_layout = $thelawyer_layout[$secretlab['thelawyer_design_layout']];
        if ($sl_design_layout == 2) {
            echo '<div class="mainbgr"><div class="container"><div class="row">';
        }
    }
}


function thelawyer_set_header_sidebar_layout() {
	global $secretlab, $thelawyer_layout;
	$sl_sidebar_layout = isset($thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'] . 'sidebar-layout']) ? $thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'] . 'sidebar-layout'] : 1;
	if ($sl_sidebar_layout == 2 or $sl_sidebar_layout == 3) {
		echo '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 widget-area">';
		if ($secretlab['thelawyer_page_type'] == '') $prefix = ''; else $prefix = '_';
		if (isset($thelawyer_layout[$secretlab['thelawyer_page_type'] . $prefix . 'left_sidebar_widgets'])) {
			dynamic_sidebar($thelawyer_layout[$secretlab['thelawyer_page_type'] . $prefix . 'left_sidebar_widgets']);
		} else {
			dynamic_sidebar($secretlab['thelawyer_page_type'] . '_default_left_sidebar');
		}
		echo '</div>';
	}
	if ($sl_sidebar_layout == 1) {
		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main">';
	}
	if ($sl_sidebar_layout == 2) {
		echo '<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 pr40 pl40 main blogsidebarspage">';
	}
	if ($sl_sidebar_layout == 3) {
		echo '<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 pl40 main blogsidebarpage">';
	}
	if ($sl_sidebar_layout == 4) {
		echo '<div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 pr40 main blogsidebarpage">';
	}

}

if ( ! function_exists( 'thelawyer_set_customized_slider' ) ) {
    function thelawyer_set_customized_slider() {
        global $secretlab, $thelawyer_layout;

        if (!$secretlab['is_active_slider_plugins']) {

        } else {
            $sl_headerslider = $thelawyer_layout[$secretlab['thelawyer_pagetype_prefix'] . 'header14_slider'];
            if (!empty($sl_headerslider)) {
                echo '<div class="header-transparent">';
                thelawyer_get_customized_slider();
                echo '</div>';
            }
        }
    }
}

if ( ! function_exists( 'thelawyer_minimized_switcher' ) ) {
    function thelawyer_minimized_switcher() {
        global $secretlab;
        $sl_design_css = isset($secretlab['design-css']) ? $secretlab['design-css'] : 1;
        if ($sl_design_css == 1 or $sl_design_css == 2) {
            echo '<div class="container margin74">
            <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12 mrgb20 phone-head">';
            thelawyer_phones_header();
            echo '</div>';
            echo '<div class="col-md-6 col-sm-6 col-xs-12 mrgb20 tac">';
            thelawyer_logo_img_h3();
            echo '</div>
            <div class="col-md-3 col-sm-3 col-xs-12 mrgb20 burger">
                <button id="hide4">
                    <span class="icon-cross4"></span>
                </button>
            </div>
            </div>
            </div>
            <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul id="header-menu-4" class="nav navbar-nav nav-list">';
                                sell_set_nav();
                                thelawyer_cart_menu();
                                thelawyer_search_menu();
                        echo '</ul>
            </div>
            </div>
            </div>';
        }
        if ($sl_design_css == 3) {
            echo '<div class="container-fluid margin74">
                <div class="row">
                    <div class="col-xs-12 burger">
                        <button id="hide4">
                            <span class="icon-cross4"></span>
                        </button>
                    </div>
                </div>
            </div>
            
                            <ul id="header-menu-4" class="nav navbar-nav nav-list">';
                                sell_set_nav();
                                thelawyer_cart_menu();
                                thelawyer_search_menu();
                        echo '</ul>
            ';
        }
    }
}


?>

<?php
/*
The file contain functions for Woocommerce.
*/

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function thelawyer_body_class( $classes ) {
    if ( ! is_multi_author() )
        $classes[] = 'single-author';

    if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
        $classes[] = 'sidebar';

    if ( ! get_option( 'show_avatars' ) )
        $classes[] = 'no-avatars';

    return $classes;
}
add_filter( 'body_class', 'thelawyer_body_class' );

/*
 * Adjust content_width value for video post formats and attachment templates.
*/
if ( ! isset( $content_width ) ) {
    $content_width = 1140;
}
function thelawyer_content_width() {
    global $content_width;

    if ( is_attachment() )
        $content_width = 724;
    elseif ( has_post_format( 'audio' ) )
        $content_width = 484;
}
add_action( 'template_redirect', 'thelawyer_content_width' );

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 */
if ( ! function_exists( 'thelawyer_paging_nav' ) ) :
    function thelawyer_paging_nav() {
        global $wp_query;

        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 )
            return;
        ?>
        <nav class="navigation paging-navigation" role="navigation">
            <div class="nav-links clearfix">

                <?php if ( get_next_posts_link() ) : ?>
                    <div class="nav-previous alignleft"><?php next_posts_link( '<span class="icon-arrow-left17"></span> '.esc_html__( 'Older posts', 'the-lawyer' ) ); ?></div>
                <?php endif; ?>

                <?php if ( get_previous_posts_link() ) : ?>
                    <div class="nav-next alignright"><?php previous_posts_link( esc_html__( 'Newer posts', 'the-lawyer' ).' <span class="icon-arrow-right17"></span>' ); ?></div>
                <?php endif; ?>

            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
        <?php
    }
endif;
/**
 * Print the attached image with a link to the next attached image.
 */
if ( ! function_exists( 'thelawyer_the_attached_image' ) ) :

    function thelawyer_the_attached_image() {
        /**
         * Filter the image attachment size to use.
         *
         * @since Twenty thirteen 1.0
         *
         * @param array $size {
         *     @type int The attachment height in pixels.
         *     @type int The attachment width in pixels.
         * }
         */
        $attachment_size     = apply_filters( 'thelawyer_attachment_size', array( 724, 724 ) );
        $next_attachment_url = wp_get_attachment_url();
        $post                = get_post();

        /*
         * Grab the IDs of all the image attachments in a gallery so we can get the URL
         * of the next adjacent image in a gallery, or the first image (if we're
         * looking at the last image in a gallery), or, in a gallery of one, just the
         * link to that image file.
         */
        $attachment_ids = get_posts( array(
            'post_parent'    => $post->post_parent,
            'fields'         => 'ids',
            'numberposts'    => -1,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => 'ASC',
            'orderby'        => 'menu_order ID',
        ) );

        // If there is more than 1 attachment in a gallery...
        if ( count( $attachment_ids ) > 1 ) {
            foreach ( $attachment_ids as $attachment_id ) {
                if ( $attachment_id == $post->ID ) {
                    $next_id = current( $attachment_ids );
                    break;
                }
            }

            // get the URL of the next image attachment...
            if ( $next_id )
                $next_attachment_url = get_attachment_link( $next_id );

            // or get the URL of the first image attachment.
            else
                $next_attachment_url = get_attachment_link( reset( $attachment_ids ) );
        }

        printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
            esc_url( wp_get_attachment_url() ),
            the_title_attribute( array( 'echo' => false ) ),
            wp_get_attachment_image( $post->ID, $attachment_size )
        );
    }
endif;

// Column Control of Service Category page
function thelawyer_services_column_control() {
    global $secretlab;
    if (isset ($secretlab['lawyer_serv_col'])) {
        $sl_serv_col = $secretlab['lawyer_serv_col'];
        if ($sl_serv_col == 1) {
            echo 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
        }
        if ($sl_serv_col == 2) {
            echo 'col-lg-4 col-md-4 col-sm-6 col-xs-12';
        }
        if ($sl_serv_col == 3) {
            echo 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
        }
    } else {
        echo 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
    }
}

// Column Control of Case Category page
function thelawyer_case_column_control() {
    global $secretlab;
    if (isset ($secretlab['lawyer_cases_col'])) {
        $sl_serv_col = $secretlab['lawyer_cases_col'];
        if ($sl_serv_col == 1) {
            echo 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
        }
        if ($sl_serv_col == 2) {
            echo 'col-lg-4 col-md-4 col-sm-6 col-xs-12 col3';
        }
        if ($sl_serv_col == 3) {
            echo 'col-lg-3 col-md-3 col-sm-6 col-xs-12 col4';
        }
    } else {
        echo 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
    }
}

// Headline 1
function thelawyer_heading_header4() {
    if ( is_single() ) {
        global $secretlab;
        if (isset ($secretlab['header-layout'])) {
            $sl_head_lay = $secretlab['header-layout'];
            if ( $sl_head_lay != 4 ) {
                echo '<h1 class="entry-title">';
                the_title();
                echo '</h1>';
            }
        }
        if (class_exists( 'Redux' )) {
            if (isset($secretlab['single-post-header'])) {
                if ($secretlab['single-post-header'] == 1) {
                    echo '<h1 class="archive-title">' . get_the_title() . '</h1>';
                }
            }
        } else {
            echo '<h1 class="archive-title">' . get_the_title() . '</h1>';
        }
    }
}

//Scroll to top button
function thelawyer_scroll_button() {
    global $secretlab;
    if (isset ($secretlab['scroll-to-top'])) {
        if ($secretlab['scroll-to-top'] == 1) {
            echo '<a href="#" id="scroller"></a>';
        }
    }
}

// Title for Case Study page
function thelawyer_case_title() {
    global $secretlab;
    if (isset($secretlab['cases_arch_title'])) {
        if (!empty($secretlab['cases_arch_title'])) {
            echo esc_html($secretlab['cases_arch_title']);
        }
    }
}
function thelawyer_portfolio_desc() {
    global $secretlab;
    $allowed_html = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'img' => array(
            'src' => array(),
            'title' => array(),
            'alt' => array(),
            'class' => array(),
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
    if (isset ($secretlab['portfolio_arch_desc'])) {
        $sl_padesc = $secretlab['portfolio_arch_desc'];
        if ($sl_padesc != '') {
            echo '<div class="archive_descr">'.wp_kses($sl_padesc, $allowed_html).'</div>';
        }
    }
}

// Title for Services page
function thelawyer_serv_title() {
    global $secretlab;
    if (isset($secretlab['services_arch_title'])) {
        if (!empty($secretlab['services_arch_title'])) {
            echo esc_html($secretlab['services_arch_title']);
        }
    }
}
function thelawyer_services_desc() {
    global $secretlab;
    $allowed_html = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'img' => array(
            'src' => array(),
            'title' => array(),
            'alt' => array(),
            'class' => array(),
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
    if (isset ($secretlab['services_arch_desc'])) {
        $sl_sadesc = $secretlab['services_arch_desc'];
        if ($sl_sadesc != '') {
            echo '<div class="archive_descr">'.wp_kses($sl_sadesc, $allowed_html).'</div>';
        }
    }
}

// Title for Team page
function thelawyer_team_title() {
    global $secretlab;
    if (isset($secretlab['teammate_arch_title'])) {
        if (!empty($secretlab['teammate_arch_title'])) {
            echo esc_html($secretlab['teammate_arch_title']);
        }
    }
}
function thelawyer_team_desc() {
    global $secretlab;
    $allowed_html = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'img' => array(
            'src' => array(),
            'title' => array(),
            'alt' => array(),
            'class' => array(),
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
    if (isset ($secretlab['team_arch_desc'])) {
        $sl_tadesc = $secretlab['team_arch_desc'];
        if ($sl_tadesc != '') {
            echo '<div class="archive_descr">'.wp_kses($sl_tadesc, $allowed_html).'</div>';
        }
    }
}

// Title for Team page
function thelawyer_testi_title() {
    global $secretlab;
    if (isset($secretlab['testimonials_arch_title'])) {
        if (!empty($secretlab['testimonials_arch_title'])) {
            echo esc_html($secretlab['testimonials_arch_title']);
        }
    }
}
function thelawyer_testi_desc() {
    global $secretlab;
    $allowed_html = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'img' => array(
            'src' => array(),
            'title' => array(),
            'alt' => array(),
            'class' => array(),
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
    if (isset ($secretlab['testi_arch_desc'])) {
        $sl_teadesc = $secretlab['testi_arch_desc'];
        if ($sl_teadesc != '') {
            echo '<div class="archive_descr">'.wp_kses($sl_teadesc, $allowed_html).'</div>';
        }
    }
}

/* Teammate Archive Design */
if ( ! function_exists( 'thelawyer_teammate_switcher' ) ) {
    function thelawyer_teammate_switcher() {
        global $secretlab;
        $postofmember = types_render_field("post-of-member", array("output" => "normal"));
        $facebookprofile = types_render_field("facebook-profile", array("output" => "normal"));
        $youtubeprofile = types_render_field("youtube-profile", array("output" => "normal"));
        $twitterprofile = types_render_field("twitter-profile", array("output" => "normal"));
        $behanceprofile = types_render_field("behance-profile", array("output" => "normal"));
        $linkedinprofile = types_render_field("linkedin-profile", array("output" => "normal"));
        $photoofmember = types_render_field("photo-of-member", array("url" => "true"));
        $sell_memberphone = types_render_field("thelawyer_member_phone", array("output" => "normal"));
        $sell_memberemail = types_render_field("thelawyer_member_email", array("output" => "normal"));

        $sl_design_css = isset($secretlab['design-css']) ? $secretlab['design-css'] : 1;
        if ($sl_design_css == 1 or $sl_design_css == 2) {
            echo '<div class="team-item col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<div class="meta-info">';
            if (!empty($sell_memberphone)) {
                echo '<span><span class="icon-phone2 mrgr10"></span> <a href="';
                the_permalink();
                echo '" rel="bookmark">' . esc_attr($sell_memberphone) . '</a></span>';
            }
            if (!empty($sell_memberemail)) {
                echo '<span><span class="icon-envelope mrgr10"></span> <a href="';
                the_permalink();
                echo '" rel="bookmark">' . esc_attr($sell_memberemail) . '</a></span>';
            }
            echo '</div>
        <div class="photo">';
            echo '<img src="' . esc_url($photoofmember) . '" alt="' . get_the_title() . '" class="img-responsive"/>';
            echo '<div class="team-overlay">
        <p class="team-overlay-link">';
            if (!empty($facebookprofile)) {
                echo '<a href="' . esc_url($facebookprofile) . '" target="_blank"><i class="icon-facebook"></i></a>';
            }
            if (!empty($youtubeprofile)) {
                echo '<a href="' . esc_url($youtubeprofile) . '" target="_blank"><i class="icon-youtube-play"></i></a>';
            }
            if (!empty($twitterprofile)) {
                echo '<a href="' . esc_url($twitterprofile) . '" target="_blank"><i class="icon-twitter"></i></a>';
            }
            if (!empty($behanceprofile)) {
                echo '<a href="' . esc_url($behanceprofile) . '" target="_blank"><i class="icon-behance"></i></a>';
            }
            if (!empty($linkedinprofile)) {
                echo '<a href="' . esc_url($linkedinprofile) . '" target="_blank"><i class="icon-linkedin"></i></a>';
            }
            echo '</p>
            </div>
        </div>
        <div class="main-info">
            <span class="name">';
            the_title();
            echo '</span>
            <span class="regalies">';
            if (!empty($postofmember)) {
                echo esc_attr($postofmember);
            }
            echo '</span>
        </div>
        </div>';
        }
        if ($sl_design_css == 3) {
            echo '<div class="team-item team-secondd col-md-3 col-sm-4 col-xs-12"><div>
						<div class="photo">
							<a href="' . get_permalink() . '" rel="bookmark"><img src="' . esc_url($photoofmember) . '" alt="' . get_the_title() . '" class="img-responsive"/></a>
						</div>
						<span class="name"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></span>';
            if (!empty($postofmember)) {
                echo '<span class="regalies">' . esc_attr($postofmember) . '</span>';
            }
            echo '<div class="meta-info">';
            if (!empty($sell_memberphone)) {
                echo '<span class="memberphone"><a href="' . get_the_permalink() . '" rel="bookmark">' . esc_attr($sell_memberphone) . '</a></span>';
            }
            if (!empty($sell_memberemail)) {
                echo '<span class="memberemail"><a href="' . get_the_permalink() . '" rel="bookmark">' . esc_attr($sell_memberemail) . '</a></span>';
            }
            echo '</div>';
            echo '
                                <p class="team-overlay-link">';
            if (!empty($facebookprofile)) {
                echo '<a href="' . esc_url($facebookprofile) . '" target="_blank"><i class="icon-facebook"></i></a>';
            }
            if (!empty($youtubeprofile)) {
                echo '<a href="' . esc_url($youtubeprofile) . '" target="_blank"><i class="icon-youtube-play"></i></a>';
            }
            if (!empty($twitterprofile)) {
                echo '<a href="' . esc_url($twitterprofile) . '" target="_blank"><i class="icon-twitter"></i></a>';
            }
            if (!empty($behanceprofile)) {
                echo '<a href="' . esc_url($behanceprofile) . '" target="_blank"><i class="icon-behance"></i></a>';
            }
            if (!empty($linkedinprofile)) {
                echo '<a href="' . esc_url($linkedinprofile) . '" target="_blank"><i class="icon-linkedin"></i></a>';
            }
            echo '</p>
              </div></div>';
        }
    }
}


/* Teammate Page Designs */
if ( ! function_exists( 'thelawyer_teammate_page_switcher' ) ) {
    function thelawyer_teammate_page_switcher() {
        global $secretlab;
        $postofmember = types_render_field("post-of-member", array("output" => "normal"));
        $facebookprofile = types_render_field("facebook-profile", array("output" => "normal"));
        $youtubeprofile = types_render_field("youtube-profile", array("output" => "normal"));
        $twitterprofile = types_render_field("twitter-profile", array("output" => "normal"));
        $behanceprofile = types_render_field("behance-profile", array("output" => "normal"));
        $linkedinprofile = types_render_field("linkedin-profile", array("output" => "normal"));
        $photoofmember = types_render_field("photo-of-member", array("url" => "true"));
        $sell_memberphone = types_render_field("thelawyer_member_phone", array("output" => "normal"));
        $sell_memberemail = types_render_field("thelawyer_member_email", array("output" => "normal"));

        $sl_design_css = isset($secretlab['design-css']) ? $secretlab['design-css'] : 1;
        if ($sl_design_css == 1 or $sl_design_css == 2) {
            if (!empty($photoofmember)) {
                echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 teammate pr40 mrgb40 tar"><img src="' . esc_url($photoofmember) . '" alt="' . get_the_title() . '" class="mwa" ></div>';
            }
        echo '<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 mb40 pl40 teammate">
                            <h1>'.get_the_title().'</h1>
        <div class="subhead">';
        if (!empty($postofmember)) {echo esc_attr($postofmember);}
        echo '</div>'.
        get_the_excerpt().'
        <h3>'.esc_html( 'Contacts', 'the-lawyer' ).'</h3>
        <ul class="contact-list">';
        if (!empty($sell_memberphone)) { echo '<li><span class="icon-phone2"></span> <strong>'.esc_html( 'Phone', 'the-lawyer' ).':</strong> '.esc_attr($sell_memberphone).'</li>'; }
        if (!empty($sell_memberemail)) { echo '<li><span class="icon-envelope"></span> <strong>'.esc_html( 'E-mail', 'the-lawyer' ).':</strong> '.esc_attr($sell_memberemail).'</li>'; }

        if (!empty($facebookprofile) or !empty($youtubeprofile) or !empty($twitterprofile) or !empty($behanceprofile) or !empty($linkedinprofile)) {
            echo '<li><span class="icon-rss"></span> <strong>'.esc_html( 'Social', 'the-lawyer' ).':</strong> <span class="socialprofiles">'; }
            if (!empty($facebookprofile)) {
                echo '<a href="'.esc_url($facebookprofile).'" target="_blank"><i class="icon-facebook"></i></a>';
            }
            if (!empty($youtubeprofile)) {
                echo '<a href="'.esc_url($youtubeprofile).'" target="_blank"><i class="icon-youtube-play"></i></a>';
            }
            if (!empty($twitterprofile)) {
                echo '<a href="'.esc_url($twitterprofile).'" target="_blank"><i class="icon-twitter"></i></a>';
            }
            if (!empty($behanceprofile)) {
                echo '<a href="'.esc_url($behanceprofile).'" target="_blank"><i class="icon-behance"></i></a>';
            }
            if (!empty($linkedinprofile)) {
                echo '<a href="'.esc_url($linkedinprofile).'" target="_blank"><i class="icon-linkedin"></i></a>';
            }
            if (!empty($facebookprofile) or !empty($youtubeprofile) or !empty($twitterprofile) or !empty($behanceprofile) or !empty($linkedinprofile)) {
                echo '</span></li>'; }
            echo '</ul>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb40 teammate">
        <div class="abouthead">'.esc_html( 'About', 'the-lawyer' ).'</div><div class="teamcontent">';
	        the_content();
            thelawyer_post_nav();
        echo '</div></div>';
        }
        if ($sl_design_css == 3) {
            echo '<div class="team_sec_page">';
                echo '<div class="info col-md-3 col-sm-6 col-xs-12"><div class="photo"><img src="' . esc_url($photoofmember) . '" alt="' . get_the_title() . '" class="img-responsive"/></div>
                    <div class="name">' . get_the_title() . '</div>';
                    if (!empty($postofmember)) {
                        echo '<div class="regalies">' . esc_attr($postofmember) . '</div>';
                    }
                        echo '<div class="social">';
                        if (!empty($facebookprofile)) {
                            echo '<a href="'.esc_url($facebookprofile).'" target="_blank"><i class="icon-facebook"></i></a>';
                        }
                        if (!empty($youtubeprofile)) {
                            echo '<a href="'.esc_url($youtubeprofile).'" target="_blank"><i class="icon-youtube-play"></i></a>';
                        }
                        if (!empty($twitterprofile)) {
                            echo '<a href="'.esc_url($twitterprofile).'" target="_blank"><i class="icon-twitter"></i></a>';
                        }
                        if (!empty($behanceprofile)) {
                            echo '<a href="'.esc_url($behanceprofile).'" target="_blank"><i class="icon-behance"></i></a>';
                        }
                        if (!empty($linkedinprofile)) {
                            echo '<a href="'.esc_url($linkedinprofile).'" target="_blank"><i class="icon-linkedin"></i></a>';
                        }
                        echo '</div>';
                    if (!empty($sell_memberphone)) { echo '<div class="phone">'.esc_attr($sell_memberphone).'</div>'; }
                    if (!empty($sell_memberemail)) { echo '<div class="mail">'.esc_attr($sell_memberemail).'</div>'; }
                echo '</div>';
                echo '<div class="teamcontent col-md-9 col-sm-6 col-xs-12"><h1>'.get_the_title().'</h1>';
                    the_content();
                echo '</div>';
            thelawyer_post_nav();
            echo '</div>';
        }
    }
}
/* Cases archive design */
if ( ! function_exists( 'thelawyer_cases_switcher' ) ) {
    function thelawyer_cases_switcher() {
        global $secretlab;
$thelawyer_case_cat = types_render_field("theseo_project_category", array("output"=>"normal"));

        $sl_design_css = isset($secretlab['design-css']) ? $secretlab['design-css'] : 1;
        if ($sl_design_css == 1 or $sl_design_css == 2) {
            echo '<div class="';
            thelawyer_case_column_control();
            echo ' lawyer_cases">';
            echo '<div class="entry-thumbnail">';
            if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                the_post_thumbnail( 'thelawyer_services' );
            } else {
                echo '<img src="'.esc_url(get_template_directory_uri()).'/images/nots.gif" alt="'.get_the_title().'" />';
            }
            echo '<div class="staticover">
                        <h5><a href="'.get_the_permalink().'" class="more">'.get_the_title().'</a></h5>
                    </div>
                    <div class="thumbhover"><a href="'.get_the_permalink().'"><span class="icon-eye2"></span></a></div>
                    <div class="thumbover_cat"><h4>'.esc_attr($thelawyer_case_cat).'</h4></div>
                </div>
                </div>';

        }
        if ($sl_design_css == 3) {
            echo '<div class="';
            thelawyer_case_column_control();
            echo ' lawyer_cases">';
            echo '<div class="entry-thumbnail">';
            if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                the_post_thumbnail( 'thelawyer_services' );
            } else {
                echo '<img src="'.esc_url(get_template_directory_uri()).'/images/nots.gif" alt="'.get_the_title().'" />';
            }
            echo '<div class="thumbhover"><a href="'.get_the_permalink().'"><span class="icon-arrow-right22"></span></a></div></div>
                    <div class="staticover">
                        <h5><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>
                        '.get_the_time('F j, Y').' / '.esc_attr($thelawyer_case_cat).'
                    </div>
                </div>';
        }
    }
}

// Page H1 heading
if ( ! function_exists( 'thelawyer_entry_header' ) ) {
    global $secretlab;
    function thelawyer_entry_header() {
        if (class_exists( 'Redux' )) {
            if (isset($secretlab['single-header'])) {
                if ($secretlab['single-header'] == 1) {
                    echo '<h1 class="archive-title">' . get_the_title() . '</h1>';
                }
            }
        } else {
            echo '<h1 class="archive-title">' . get_the_title() . '</h1>';
        }
    }
}
?>

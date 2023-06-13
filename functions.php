<?php
/*
 *  Author: SecretLab
 *  URL: http://secretlab.pw
 *  Custom functions, support and more.
 */


$GLOBALS['redux_notice_check'] = 0;
update_option('ultimate_vc_addons_redirect', false);
$ultimate_constants = get_option('ultimate_constants');
$ultimate_constants['ULTIMATE_NO_PLUGIN_PAGE_NOTICE'] = 1;
update_option('ultimate_constants', $ultimate_constants);
update_option( 'wpb_js_composer_license_activation_notified', 'yes' );
remove_action('init', 'vc_page_welcome_redirect');
remove_action('vc_activation_hook', 'vc_page_welcome_set_redirect');
delete_transient('_redux_activation_redirect');
delete_transient('_wc_activation_redirect');
$GLOBALS['redux_notice_check'] = 0;
update_option('revslider-valid-notice', 'false');

add_action( 'after_setup_theme', 'remove_vc_reminder' );

function remove_vc_reminder() {
	SetCookie('vchideactivationmsg_vc11', '12.0');
}

add_action('admin_head', 'sell_admin_styles');

function sell_admin_styles() {
    echo '<style>
    #setting-error-the-lawyer {display:block} 
  </style>';
}
	
// Welcome Page section */
add_action('admin_menu', 'thelawyer_welcome_screen_page');
function thelawyer_welcome_screen_page(){
	add_theme_page(esc_html__( 'Welcome', 'the-lawyer'), esc_html__( 'Welcome', 'the-lawyer'), 'read', 'secretlab-welcome', 'thelawyer_welcome_page');
}
function thelawyer_welcome_page(){
	require_once(get_template_directory() . '/inc/welcome_page.php');
}
// end of Welcome Page section

if ( class_exists( 'Redux' ) && file_exists( get_template_directory() . '/inc/config.php' ) ) {
	require_once( get_template_directory() . '/inc/config.php' );
}


/**
 * The Lawyer only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

/**
 *  The Lawyer setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 *  The Lawyer supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *

 */

function thelawyer_setup() {
	/*
	 * Makes The SEO available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on SecretLab, use a find and
	 * replace to change 'the-lawyer' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'the-lawyer', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css' ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * This theme supports all available post formats by default.
	 * See https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'audio', 'gallery', 'image', 'link', 'quote', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'thelawyer_top_menu', esc_html__( 'Header Menu', 'the-lawyer' ) );


	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1170, 560, false );
	//add_image_size('thelawyer_large', 1170, 560, true); // Large Thumbnail for 1 and 2 columns blogs
	add_image_size('thelawyer_smalldigital', 250, 320, false); // For 2 col post feed
	add_image_size('thelawyer_last4', 90, 80, false); // 4 Last Posts - 3
	add_image_size('thelawyer_last41', 680, 250, false); // 4 Last Posts - 1
	add_image_size('thelawyer_related', 400, 191, false); // Related Post Thumbnails
	add_image_size('thelawyer_services', 600, 400, false); // Services Presentation
	add_image_size('thelawyer_featured_preview', 55, 55, false);

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'thelawyer_setup' );

/*------------------------------------*\
	Menu and Sidebar
\*------------------------------------*/
/* Menu Layout Settings */
function sell_set_nav() {
	wp_nav_menu(
		array(
			'theme_location'  => 'thelawyer_top_menu',
			'menu'            => '',
			'container'       => '',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => '',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '%3$s',
			'depth'           => 3,
			'walker'          => ''
		)
	);

}

/**
 * Register 7 widget areas.
 */
function thelawyer_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'the-lawyer' ),
		'id'            => '_default_left_sidebar',
		'description'   => esc_html__( 'Appears in the left section of the site.', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Bottom Sidebar', 'the-lawyer' ),
		'id'            => '_default_bottom_sidebar',
		'description'   => esc_html__( 'Appears on posts and pages in the footer.', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'the-lawyer' ),
		'id'            => '_default_right_sidebar',
		'description'   => esc_html__( 'Appears in the right section of the site.', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Left Blog Sidebar', 'the-lawyer' ),
		'id'            => 'blog_default_left_sidebar',
		'description'   => esc_html__( 'Appears in the left blog section of the site.', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Right Blog Sidebar', 'the-lawyer' ),
		'id'            => 'blog_default_right_sidebar',
		'description'   => esc_html__( 'Appears in the right blog section of the site.', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Left Shop Sidebar', 'the-lawyer' ),
		'id'            => 'shop_default_left_sidebar',
		'description'   => esc_html__( 'Appears in the left shop section of the site.', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Right Shop Sidebar', 'the-lawyer' ),
		'id'            => 'shop_default_right_sidebar',
		'description'   => esc_html__( 'Appears in the left shop section of the site.', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Bottoms Sidebars: 1 of 4', 'the-lawyer' ),
		'id'            => 'botttom_sidebar_one',
		'description'   => esc_html__( 'Appears in the bottom section. There are 4 sidebars', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget col-md-3 col-sm-6 col-xs12">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4><div class="bordered"></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Bottoms Sidebars: 2 of 4', 'the-lawyer' ),
		'id'            => 'botttom_sidebar_two',
		'description'   => esc_html__( 'Appears in the bottom section. There are 4 sidebars', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget col-md-3 col-sm-6 col-xs12 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4><div class="bordered"></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Bottoms Sidebars: 3 of 4', 'the-lawyer' ),
		'id'            => 'botttom_sidebar_three',
		'description'   => esc_html__( 'Appears in the bottom section. There are 4 sidebars', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget col-md-3 col-sm-6 col-xs12 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4><div class="bordered"></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Bottoms Sidebars: 4 of 4', 'the-lawyer' ),
		'id'            => 'botttom_sidebar_four',
		'description'   => esc_html__( 'Appears in the bottom section. There are 4 sidebars', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget col-md-3 col-sm-6 col-xs12 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4><div class="bordered"></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Bottom Sidebar for Design #2', 'the-lawyer' ),
		'id'            => '_default_bottom_sidebar_second',
		'description'   => esc_html__( 'Displays in the footer.', 'the-lawyer' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'thelawyer_widgets_init' );



add_action( 'vc_before_init', 'lawyer_setup_vc' );

function lawyer_setup_vc() {
	if(function_exists('vc_set_default_editor_post_types') && function_exists('vc_default_editor_post_types')) {
		$list = vc_default_editor_post_types();
		$post_types = array( 'post', 'page', 'teammate', 'cases', 'service' );
		$list = array_merge( $list, $post_types );
		vc_set_default_editor_post_types( $list );
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Include Designs Functions
/*-----------------------------------------------------------------------------------*/
if ( function_exists('sell_add_widgets_init' ) ) {
	sell_add_widgets_init();
}

require_once(get_template_directory() . '/auxillary.php'); //Extra functions for layout and SecretLab Shortcodes Plugin
require_once(get_template_directory() . '/functions/blog.php'); // Functions and layouts for blog
require_once(get_template_directory() . '/functions/functions.php'); // General Functions of the theme. Under the hood.
require_once(get_template_directory() . '/functions/layout.php'); // General Functions of the theme. Under the hood.
require_once(get_template_directory() . '/functions/woocommerce.php'); // Functions for woocommerce and a cart in menu
require_once(get_template_directory() . '/functions/footer.php'); // Functions for footer section
require_once(get_template_directory() . '/functions/header.php'); // Functions for header section

// Change plugins list if inctaller is active
if (function_exists( 'welcome_notice' )) {
	require_once ( get_template_directory() . '/inc/plugins-list.php');
} else {
	require_once ( get_template_directory() . '/inc/plugins-list_f.php');
}

<?php
/**
 * The Lawyer back compat functionality
 *
 * Prevents The Lawyer from running on WordPress versions prior to 4.1,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.1.
 *
 * @package WordPress
 * @since The Lawyer 1.0
 */

/**
 * Prevent switching to The Lawyer on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since The Lawyer 1.0
 */
function thelawyer_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'thelawyer_upgrade_notice' );
}
add_action( 'after_switch_theme', 'thelawyer_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * The Lawyer on WordPress versions prior to 4.1.
 *
 * @since The Lawyer 1.0
 */
function thelawyer_upgrade_notice() {
	$message = sprintf( __( 'The Lawyer requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'the-lawyer' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.1.
 *
 * @since The Lawyer 1.0
 */
function thelawyer_customize() {
	wp_die( sprintf( __( 'The Lawyer requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'the-lawyer' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'thelawyer_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.1.
 *
 * @since The Lawyer 1.0
 */
function thelawyer_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'The Lawyer requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'the-lawyer' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'thelawyer_preview' );

if ( ! function_exists( 'wp_body_open' ) ) {
        function wp_body_open() {
                do_action( 'wp_body_open' );
        }
}


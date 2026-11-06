<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Small, safe hardening + SEO fallbacks (no plugin needed).
 * An SEO plugin can take over the meta description later: it simply replaces this output.
 */

/* 1. Don't leak admin usernames: block the public REST users list and ?author=N enumeration */
add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
} );
add_action( 'template_redirect', function () {
	if ( ! is_admin() && isset( $_GET['author'] ) && ! is_user_logged_in() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
	if ( is_author() && ! is_user_logged_in() ) {
		wp_safe_redirect( home_url( '/blog/' ), 301 );
		exit;
	}
}, 1 );

/* 2. Remove version / extra head clutter */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
add_filter( 'xmlrpc_enabled', '__return_false' );


/**
 * Where form notifications are delivered. Defaults to the public contact email, but can be
 * pointed at any inbox (Customizer > Velocrix: Contact > "Deliver form emails to") without
 * changing the email shown on the website.
 */
function vx_notify_to() {
	$n = trim( (string) get_theme_mod( 'vx_notify_email', '' ) );
	if ( $n && is_email( $n ) ) return $n;
	return vx( 'vx_email', get_option( 'admin_email' ) );
}

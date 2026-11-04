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

/* 3. Meta description fallback (only when no SEO plugin is active) */
add_action( 'wp_head', function () {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'THE_SEO_FRAMEWORK_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) return;
	$default = 'Velocrix Cricket Academy at Sarvottam International School, Greater Noida West. Professional coaching, structured training and a performance-driven approach, founded by Indian international cricketer Meghna Singh.';
	$desc = $default;
	if ( is_singular() ) {
		$ex = has_excerpt() ? get_the_excerpt() : '';
		if ( $ex ) $desc = wp_strip_all_tags( $ex );
		elseif ( is_single() ) $desc = wp_trim_words( wp_strip_all_tags( get_the_content() ), 30, '…' ) ?: $default;
	}
	echo '<meta name="description" content="' . esc_attr( mb_substr( $desc, 0, 300 ) ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( wp_get_document_title() ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( mb_substr( $desc, 0, 200 ) ) . '">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:site_name" content="Velocrix Cricket Academy">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( VX_URI . '/assets/img/training-1.jpg' ) . '">' . "\n";
}, 1 );

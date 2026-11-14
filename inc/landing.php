<?php
/**
 * Velocrix animated one-page ("Velocrix Animated Home" page template).
 *
 * - Markup:  template-parts/landing/page.php
 * - Assets:  assets/landing/{css,js,vendor,fonts,media} (all local: no CDN, no plugin)
 * - Use:     edit a page > Template > "Velocrix Animated Home". When the static front page uses it,
 *            front-page.php renders this design; switch the template back to "Default" to restore the classic home.
 * The regular theme CSS/JS is not loaded on this template, so the two designs never clash.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VX_LANDING_TEMPLATE', 'page-templates/velocrix-landing.php' );

/** True when the current request renders the animated page. */
function vx_is_landing() {
	if ( ! is_page() ) return false;
	return get_page_template_slug( get_queried_object_id() ) === VX_LANDING_TEMPLATE;
}

/** URL of a file inside assets/landing/, versioned by file time (cache-busting). */
function vx_landing_uri( $rel ) {
	$rel  = ltrim( $rel, '/' );
	$file = get_template_directory() . '/assets/landing/' . $rel;
	$url  = VX_URI . '/assets/landing/' . $rel;
	return file_exists( $file ) ? add_query_arg( 'v', filemtime( $file ), $url ) : $url;
}

/** Version string for enqueue (theme version + file time). */
function vx_landing_ver( $rel ) {
	$file = get_template_directory() . '/assets/landing/' . ltrim( $rel, '/' );
	return VX_VER . '.' . ( file_exists( $file ) ? filemtime( $file ) : 0 );
}

/** The intro must start before the header paints, so its tiny boot script is printed inline right after #intro. */
function vx_landing_intro_script() {
	$file = get_template_directory() . '/assets/landing/js/intro-boot.js';
	if ( file_exists( $file ) ) {
		wp_print_inline_script_tag( file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	}
}

/** Swap the theme's assets for the animated page's assets. */
function vx_landing_assets() {
	if ( ! vx_is_landing() ) return;

	wp_dequeue_style( 'vx-fonts' );
	wp_dequeue_style( 'vx-main' );
	wp_dequeue_script( 'vx-main' );

	$css = array(
		'vx-landing-fonts' => 'fonts/fonts.css',
		'vx-landing-base'  => 'css/base.css',
		'vx-landing-main'  => 'css/main.css',
		'vx-landing-fixes' => 'css/fixes.css',
	);
	$prev = array();
	foreach ( $css as $handle => $rel ) {
		wp_enqueue_style( $handle, VX_URI . '/assets/landing/' . $rel, $prev, vx_landing_ver( $rel ) );
		$prev = array( $handle );
	}

	// Same order as the original page; loaded at the end of <body>.
	$js = array(
		'vx-landing-site'      => 'js/site.js',
		'vx-landing-lineart'   => 'js/lineart-parallax.js',
		'vx-landing-reviews'   => 'js/reviews.js',
		'vx-three'             => 'vendor/three/three.min.js',
		'vx-three-orbit'       => 'vendor/three/OrbitControls.js',
		'vx-landing-admission' => 'js/admission.js',
		'vx-landing-3d'        => 'js/three-scenes.js',
	);
	$prev = array();
	foreach ( $js as $handle => $rel ) {
		wp_enqueue_script( $handle, VX_URI . '/assets/landing/' . $rel, $prev, vx_landing_ver( $rel ), array( 'in_footer' => true ) );
		$prev = array( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'vx_landing_assets', 50 );

/** The Google Fonts preconnect is only for the classic design. */
add_action( 'wp', function () {
	if ( vx_is_landing() ) remove_action( 'wp_head', 'vx_preconnect', 1 );
} );

/** Body class hook for styling (e.g. the admin-bar offset in fixes.css). */
add_filter( 'body_class', function ( $classes ) {
	if ( vx_is_landing() ) $classes[] = 'vx-landing';
	return $classes;
} );

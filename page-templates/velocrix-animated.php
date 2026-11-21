<?php
/**
 * Template Name: Velocrix Animated
 * Template Post Type: page
 * Description: Animated version of this page, where one exists (see vx_landing_optional_pages() in inc/landing.php).
 *              Pages without an animated version keep showing their normal (Default) design.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( vx_is_landing() ) {
	get_template_part( 'template-parts/landing/document' );
	return;
}

// No animated version for this page yet: show the same thing as the Default template.
$vx_slug = get_post_field( 'post_name', get_queried_object_id() );
$vx_file = locate_template( array( 'page-' . $vx_slug . '.php', 'page.php' ) );
if ( $vx_file ) {
	require $vx_file;
}

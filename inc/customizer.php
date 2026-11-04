<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Appearance > Customize: every editable value of the site.
 * (Built into WordPress - no plugin.)
 */
function vx_customize( $wp ) {

	$add = function ( $section, $id, $label, $default = '', $type = 'text', $sanitize = 'sanitize_text_field' ) use ( $wp ) {
		$wp->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => $sanitize ) );
		$wp->add_control( $id, array( 'label' => $label, 'section' => $section, 'type' => $type ) );
	};

	/* Contact */
	$wp->add_section( 'vx_contact', array( 'title' => 'Velocrix: Contact', 'priority' => 30 ) );
	$add( 'vx_contact', 'vx_phone',   'Primary phone',   '+91 879 644 7595' );
	$add( 'vx_contact', 'vx_phone2',  'Secondary phone', '+91 7017810766' );
	$add( 'vx_contact', 'vx_email',   'Email (enquiries are sent here)', '', 'email', 'sanitize_email' );
	$add( 'vx_contact', 'vx_address', 'Address', 'Sarvottam International School, Sector 10 Campus, Greater Noida West', 'textarea', 'sanitize_textarea_field' );
	$add( 'vx_contact', 'vx_hours',   'Timings', 'Mon - Sat: 6:00 AM - 8:00 PM' );
	$add( 'vx_contact', 'vx_map',     'Google Maps embed URL (src only)', '', 'url', 'esc_url_raw' );

	/* Social */
	$wp->add_section( 'vx_social', array( 'title' => 'Velocrix: Social Links', 'priority' => 31 ) );
	foreach ( array( 'facebook', 'instagram', 'youtube', 'linkedin' ) as $s ) {
		$add( 'vx_social', "vx_$s", ucfirst( $s ) . ' URL', '', 'url', 'esc_url_raw' );
	}

	/* Hero */
	$wp->add_section( 'vx_hero', array( 'title' => 'Velocrix: Home Hero', 'priority' => 32 ) );
	$add( 'vx_hero', 'vx_hero_eyebrow', 'Small top text', 'Under the mentorship of Ms. Meghna Singh' );
	$add( 'vx_hero', 'vx_hero_title',   'Headline (one line per row; a lime dot is added after each)', "Champions are not born\nThey are trained", 'textarea', 'sanitize_textarea_field' );
	$add( 'vx_hero', 'vx_video',        'Intro video link (YouTube/MP4). Empty = no play button', '', 'url', 'esc_url_raw' );
	$add( 'vx_hero', 'vx_hero_sub',     'Sub text', 'Expert coaching, scientific training and all-round development for young cricketers.', 'textarea', 'sanitize_textarea_field' );
	$add( 'vx_hero', 'vx_hero_btn',     'Button text', 'Join the Academy' );
	$wp->add_setting( 'vx_hero_img', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp->add_control( new WP_Customize_Image_Control( $wp, 'vx_hero_img', array( 'label' => 'Hero background image', 'section' => 'vx_hero' ) ) );

	/* Admission / fees */
	$wp->add_section( 'vx_fees', array( 'title' => 'Velocrix: Fees & Admission', 'priority' => 33 ) );
	$add( 'vx_fees', 'vx_status',  'Top announcement bar (empty = hidden)', 'Registrations are open. Early bird discount available.' );
	$add( 'vx_fees', 'vx_regfee',  'Registration fee (number only)', '1,999' );
	$add( 'vx_fees', 'vx_regnote', 'Registration note', 'Early bird discount available. *Terms & conditions apply.' );
	for ( $n = 1; $n <= 4; $n++ ) {
		$add( 'vx_fees', "vx_plan{$n}_name",  "Plan $n: name" );
		$add( 'vx_fees', "vx_plan{$n}_price", "Plan $n: price (number only)" );
		$add( 'vx_fees', "vx_plan{$n}_desc",  "Plan $n: description" );
	}

	/* Mentor */
	$wp->add_section( 'vx_mentor', array( 'title' => 'Velocrix: Mentor', 'priority' => 34 ) );
	$add( 'vx_mentor', 'vx_mentor_name',  'Mentor name', 'Ms. Meghna Singh' );
	$add( 'vx_mentor', 'vx_mentor_role',  'Designation', 'International Cricketer' );
	$add( 'vx_mentor', 'vx_mentor_bio',   'Short bio', 'Velocrix Cricket Academy functions under the mentorship of Ms. Meghna Singh, bringing international-level experience to every training session.', 'textarea', 'sanitize_textarea_field' );
	$wp->add_setting( 'vx_mentor_img', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp->add_control( new WP_Customize_Image_Control( $wp, 'vx_mentor_img', array( 'label' => 'Mentor photo', 'section' => 'vx_mentor' ) ) );
}
add_action( 'customize_register', 'vx_customize' );

/** "Text with *lime* words" => HTML */
function vx_lime( $text ) {
	return preg_replace( '/\*(.+?)\*/', '<span class="lime">$1</span>', esc_html( $text ) );
}

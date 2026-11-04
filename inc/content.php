<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Single source of truth for REAL academy content (extracted from the official
 * posters / brochures). The Customizer (Appearance > Customize > "Velocrix: ...")
 * can override any key; empty value here = hidden on the site.
 */
function vx_defaults() {
	static $d = null;
	if ( $d !== null ) return $d;
	$d = array(
		// Contact
		'vx_phone'   => '+91 879 644 7595',
		'vx_phone2'  => '+91 7017810766',
		'vx_email'   => 'admissions@velocrix.com',
		'vx_address' => 'Sarvottam International School (Sector 10 Campus), Greater Noida West, Uttar Pradesh 201318',
		'vx_hours'   => '',   // not provided yet: hidden until set
		'vx_map'     => '',
		// Social (handle on posters: @velocrixofficial). Only Instagram URL is confirmed.
		'vx_instagram' => 'https://www.instagram.com/velocrixofficial/',
		'vx_facebook'  => '',
		'vx_youtube'   => '',
		'vx_linkedin'  => '',
		'vx_x'         => '',
		// Fees
		'vx_status'  => 'Registrations are open. Early bird discount available.',
		'vx_regfee'  => '1,999',
		'vx_regnote' => 'Early bird discount available. *Terms & conditions apply.',
		// Mentor
		'vx_mentor_name' => 'Ms. Meghna Singh',
		'vx_mentor_role' => 'International Cricketer',
		'vx_mentor_bio'  => 'Velocrix Cricket Academy functions under the mentorship of Ms. Meghna Singh, International Cricketer.',
		'vx_mentor_img'  => VX_URI . '/assets/img/mentor.jpg',
		'vx_mentor_quote'=> 'Discipline, hard work and the right guidance can take you to places you never imagined. Keep believing, keep playing!',
	);
	return $d;
}

/** Fixed brand copy used across pages */
function vx_copy( $key = null ) {
	$c = array(
		'about'   => 'Velocrix Cricket Academy is a next-generation cricket academy focused on developing disciplined, skilled and confident cricketers through world-class coaching, modern training methods and a competitive environment.',
		'tagline' => 'Champions are not born, they are trained!',
		'mantra'  => 'Train hard. Learn smart. Improve everyday. Achieve greatness.',
		'school'  => 'Sarvottam International School: a leading senior secondary school affiliated to CBSE.',
		'pillars' => array(
			array( 'Expert Coaching', 'Guidance from certified and experienced coaches under the mentorship of an international cricketer.' ),
			array( 'Skill-Based Training', 'Structured, scientific training that builds technique step by step.' ),
			array( 'Fitness & Performance', 'Fitness, discipline and sportsmanship developed alongside cricketing skill.' ),
			array( 'Match Practice & Exposure', 'Real match exposure and a competitive environment to test what you learn.' ),
			array( 'Individual Attention', 'Personalised training plans so every player gets the focus they need.' ),
			array( 'Pathway to Professional Cricket', 'A route from the academy to district, state and national level cricket.' ),
		),
		'why'     => array(
			array( 'Mentorship by an International Cricketer', 'Learn under the mentorship of international cricketer Ms. Meghna Singh.' ),
			array( 'Certified & Experienced Coaches', 'Qualified, experienced coaches guide every session.' ),
			array( 'Modern Training Facilities', 'A professional training environment with turf ground and net practice.' ),
			array( 'Personalized Training Plans', 'Training plans shaped around each player\'s level and goals.' ),
			array( 'Focus on Fitness, Discipline & Sportsmanship', 'Building strong, disciplined players with the right attitude to the game.' ),
			array( 'Exposure to Tournaments & Competitive Matches', 'Real match exposure to grow confidence and temperament.' ),
			array( 'Pathway to District, State & National Level Cricket', 'A clear pathway for players who want to take cricket further.' ),
		),
		'plan_features' => array( 'Expert coaching', 'Qualified & experienced coaches', 'Fitness & skill development', 'Teamwork & character building', 'Professional training environment', 'Pathway to professional career' ),
	);
	return $key ? $c[ $key ] : $c;
}

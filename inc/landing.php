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
/** "Velocrix Animated" page template: any page can pick it; it shows the animated version when one exists. */
define( 'VX_ANIMATED_TEMPLATE', 'page-templates/velocrix-animated.php' );

/**
 * Pages that have BOTH designs: page slug => animated view key (a key of vx_landing_sections()).
 * Edit page > Template: "Default" = classic page-{slug}.php, "Velocrix Animated" = this animated view.
 * To give another page an animated version, add its sections to vx_landing_sections() and list it here.
 */
function vx_landing_optional_pages() {
	return array( 'about' => 'about' );
}

/**
 * Sections shown on each animated page, in order (files in template-parts/landing/sections/).
 * 'home' = the page using the "Velocrix Animated Home" template.
 */
function vx_landing_sections( $view = 'home' ) {
	$map = array(
		// Home: short overview; fees come from vx_plans(). The founder (Kirti Sharma) section lives on the classic About page (template-parts/about-founder.php).
		'home'         => array( 'hero', 'board', 'partner', 'delivery', 'moments', 'pillars', 'explore', 'fees', 'visit' ),
		// /about/: page-about.php. All text from inc/content.php / Customizer (same facts as the classic About).
		'about'        => array( 'page-hero', 'who', 'vision', 'pillars', 'values', 'mentor-tease', 'partner', 'impact', 'about-faq', 'cta' ),
		// /training/: how training works (page-training.php). The interactive tools moved to their own Training Lab pages.
		'training'     => array( 'page-hero', 'training', 'bowl', 'girls', 'nets', 'parents', 'lab-index', 'reviews', 'cta' ),
		// /training-lab/: hub that lists every tool (page-training-lab.php)
		'training-lab' => array( 'page-hero', 'lab-index', 'cta' ),
	);
	if ( isset( $map[ $view ] ) ) return $map[ $view ];
	// /training-lab/{tool}/: one tool per page (inc/training-lab.php)
	$tool = function_exists( 'vx_lab_tool' ) ? vx_lab_tool( $view ) : null;
	return $tool ? array( 'page-hero', $tool['section'], 'lab-more', 'cta' ) : array();
}

/** Animated inner pages: page slug => view key (Training and the hub use page-{slug}.php, tool pages the template_include filter). */
function vx_landing_inner_pages() {
	// 'about' went back to the classic About layout (page-about.php) with the motion layer on top.
	$pages = array( 'training' => 'training', 'training-lab' => 'training-lab' );
	if ( function_exists( 'vx_lab_tools' ) ) {
		foreach ( array_keys( vx_lab_tools() ) as $slug ) $pages[ $slug ] = $slug;
	}
	return $pages;
}

/** Which animated page this request renders: 'home', another key of vx_landing_sections(), or '' (not animated). */
function vx_landing_view() {
	if ( ! is_page() ) return '';
	$id = get_queried_object_id();
	$tpl = get_page_template_slug( $id );
	if ( $tpl === VX_LANDING_TEMPLATE ) return 'home';
	$slug = get_post_field( 'post_name', $id );
	if ( $tpl === VX_ANIMATED_TEMPLATE ) {
		// the front page picked "Velocrix Animated": same as "Velocrix Animated Home"
		if ( (int) get_option( 'page_on_front' ) === (int) $id ) return 'home';
		$opt = vx_landing_optional_pages();
		if ( isset( $opt[ $slug ] ) ) return $opt[ $slug ];
	}
	$inner = vx_landing_inner_pages();
	return isset( $inner[ $slug ] ) ? $inner[ $slug ] : '';
}

/**
 * Link to an anchor of the animated design, wherever that section now lives.
 * Same page: "#anchor". Other page: full URL + "#anchor". Used in the section files.
 */
function vx_lx( $anchor ) {
	if ( 'mentor' === $anchor ) return home_url( '/meghna-singh/#message' ); // classic Our Mentor page (video section id="message")

	// #visit (trial form) and #fees only exist on the animated Home. With the classic Home they go to WhatsApp / Packages.
	if ( in_array( $anchor, array( 'visit', 'fees' ), true ) && ! vx_landing_home_is_animated() ) {
		return 'visit' === $anchor && function_exists( 'vx_trial_url' ) ? vx_trial_url() : home_url( '/pricing/' );
	}

	$where = array( 'visit' => 'home', 'fees' => 'home', 'training' => 'training', 'rvShare' => 'training', 'lab' => 'training-lab' );
	// every Training Lab tool lives on its own page
	if ( function_exists( 'vx_lab_anchor_map' ) ) $where = array_merge( $where, vx_lab_anchor_map() );

	$view = isset( $where[ $anchor ] ) ? $where[ $anchor ] : vx_landing_view();
	if ( $view === vx_landing_view() ) return '#' . $anchor;
	if ( 'home' === $view ) return home_url( '/' ) . '#' . $anchor;
	if ( function_exists( 'vx_lab_tool' ) && vx_lab_tool( $view ) ) return vx_lab_tool_url( $view ) . '#' . $anchor;
	return home_url( '/' . $view . '/' ) . '#' . $anchor;
}

/** True when the static front page uses one of the animated templates. */
function vx_landing_home_is_animated() {
	$front = (int) get_option( 'page_on_front' );
	return $front && in_array( get_page_template_slug( $front ), array( VX_LANDING_TEMPLATE, VX_ANIMATED_TEMPLATE ), true );
}

/** Hero text for the animated inner pages. */
function vx_landing_page_hero( $view ) {
	$h = array(
		'about'        => array(
			'kicker' => 'About Velocrix',
			'title'  => array( 'Where dreams', 'meet discipline.' ),
			'lede'   => 'Founded by ' . vx_founder()['name'] . ' and mentored by Indian international cricketer ' . vx( 'vx_mentor_name', 'Ms. Meghna Singh' ) . ', Velocrix nurtures the next generation of cricketers through professional coaching, structured training and a performance-driven approach.',
			'jumps'  => array( 'who' => 'Who we are', 'pillars' => 'Our pillars', 'values' => 'Our values', 'faq' => 'Questions' ),
			'stats'  => array( array( '1', 'international mentor' ), array( '4', 'flexible plans' ), array( (string) count( vx_copy( 'pillars' ) ), 'training pillars' ) ),
		),
		'training'     => array(
			'kicker' => 'Training at Velocrix',
			'title'  => array( 'Every day', 'has a job.' ),
			'lede'   => 'How a Velocrix week works: four training days, one session plan, three ability levels and a weekly report for parents. The level check, bat-size guide and session plan are in the Training Lab.',
			'jumps'  => array( 'training' => 'The week', 'parents' => 'For parents', 'lab-tools' => 'Training Lab tools', 'reviews' => 'Reviews' ),
			'stats'  => array( array( '4', 'training days' ), array( '3', 'levels' ), array( '5', 'stages a session' ) ),
		),
		'training-lab' => array(
			'kicker' => 'The Velocrix Training Lab',
			'title'  => array( 'Bowl it. Bat it.', 'In 3D.' ),
			'lede'   => 'Hands-on tools built on real pitch measurements: bowl a delivery, set a batter\'s stance, learn every fielding position, walk around our ground and face the bowling yourself. Each tool has its own page.',
			'jumps'  => array(),
			'stats'  => array( array( (string) ( function_exists( 'vx_lab_tools' ) ? count( vx_lab_tools() ) : 8 ), 'tools' ), array( '22', 'yards, to scale' ), array( '4', '3D scenes' ) ),
		),
	);
	if ( isset( $h[ $view ] ) ) return $h[ $view ];
	// Training Lab tool pages: one tool each, no stats or jump links (the "more tools" strip follows the tool)
	$tool = function_exists( 'vx_lab_tool' ) ? vx_lab_tool( $view ) : null;
	return $tool ? array_merge( $tool['hero'], array( 'jumps' => array(), 'stats' => array(), 'parent' => array( 'Training Lab', vx_lab_hub_url() ) ) ) : null;
}

/** True when the current request renders an animated page. */
function vx_is_landing() {
	return '' !== vx_landing_view();
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

/** The intro must start before the page paints, so its tiny boot script is printed inline right after #intro. */
function vx_landing_intro_script() {
	$file = get_template_directory() . '/assets/landing/js/intro-boot.js';
	if ( file_exists( $file ) ) {
		wp_print_inline_script_tag( file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	}
}

/** Swap the theme's assets for the animated page's assets. */
function vx_landing_assets() {
	if ( ! vx_is_landing() ) return;

	// 'vx-fonts' (Public Sans) stays: the shared site header uses it.
	wp_dequeue_style( 'vx-main' );
	wp_dequeue_script( 'vx-main' );
	// the classic motion layer depends on vx-main; drop it too or WordPress re-adds vx-main as its dependency
	wp_dequeue_style( 'vx-motion' );
	wp_dequeue_script( 'vx-motion' );

	$css = array(
		// fonts/fonts.css (Playfair Display + Jost) is no longer loaded: the animated pages use Public Sans (css/type.css)
		'vx-landing-base'  => 'css/base.css',
		'vx-landing-main'  => 'css/main.css',
		'vx-landing-brand' => 'css/brand.css',       // Velocrix brand colours (lime + ink) over the original palette
		'vx-landing-fixes' => 'css/fixes.css',
		'vx-landing-pages' => 'css/pages.css',       // sections added in WordPress (page hero, explore, CTA, rail)
		'vx-landing-lab'   => 'css/lab.css',         // Training Lab: tool index, "more tools" strip, solo tool pages
		'vx-landing-header' => 'css/site-header.css', // classic site header (template-parts/site-header.php)
		'vx-landing-footer' => 'css/site-footer.css', // classic site footer (generated: tools/build-footer-css.mjs)
		'vx-landing-type'   => 'css/type.css',        // Velocrix font (Public Sans) everywhere; loaded last
	);
	$prev = array();
	foreach ( $css as $handle => $rel ) {
		wp_enqueue_style( $handle, VX_URI . '/assets/landing/' . $rel, $prev, vx_landing_ver( $rel ) );
		$prev = array( $handle );
	}

	// Same order as the original page; loaded at the end of <body>. Three.js only where a 3D scene is shown.
	$sections = vx_landing_sections( vx_landing_view() );
	$has_3d   = (bool) array_intersect( $sections, array( 'delivery', 'lab-delivery', 'lab-stance', 'ground', 'play' ) );
	$js = array(
		'vx-landing-site'      => 'js/site.js',
		'vx-landing-lineart'   => 'js/lineart-parallax.js',
		'vx-landing-reviews'   => in_array( 'reviews', $sections, true ) ? 'js/reviews.js' : '',
		// Three.js and the 3D scenes are NOT enqueued here: they are heavy (~7s of script work on a phone),
		// so the loader below adds them only when a 3D section comes near the screen.
		'vx-landing-admission' => in_array( 'visit', $sections, true ) ? 'js/admission.js' : '',
		'vx-landing-pages'     => 'js/pages.js',
	);
	$prev = array();
	foreach ( array_filter( $js ) as $handle => $rel ) {
		wp_enqueue_script( $handle, VX_URI . '/assets/landing/' . $rel, $prev, vx_landing_ver( $rel ), array( 'in_footer' => true ) );
		$prev = array( $handle );
	}

	// Old links to tools that now have their own page (/training-lab/#play, /training/#level ...): pages.js forwards them.
	if ( in_array( vx_landing_view(), array( 'training', 'training-lab' ), true ) && function_exists( 'vx_lab_moved_hashes' ) ) {
		wp_add_inline_script( 'vx-landing-pages', 'window.VX_LAB_MOVED=' . wp_json_encode( vx_lab_moved_hashes() ) . ';', 'before' );
	}

	if ( $has_3d ) {
		$three = array();
		foreach ( array( 'vendor/three/three.min.js', 'vendor/three/OrbitControls.js', 'js/three-scenes.js' ) as $rel ) {
			$three[] = add_query_arg( 'ver', vx_landing_ver( $rel ), VX_URI . '/assets/landing/' . $rel );
		}
		wp_add_inline_script( 'vx-landing-pages', vx_three_loader_js( $three ) );
	}
}

/**
 * Lazy loader for the 3D scenes: loads the scripts in order once a 3D section is within ~0.4 of a screen,
 * or right away (after the page has loaded and the browser is idle) when one is already on screen.
 */
function vx_three_loader_js( $urls ) {
	return '(function(){var U=' . wp_json_encode( array_values( $urls ) ) . ',done=false;'
		. 'var els=document.querySelectorAll("#storyCanvas,#simCanvas,#stCanvas,#facCanvas,#gameCanvas");if(!els.length)return;'
		. 'function load(){if(done)return;done=true;(function next(i){if(i>=U.length)return;var s=document.createElement("script");s.src=U[i];s.onload=s.onerror=function(){next(i+1)};document.body.appendChild(s)})(0)}'
		. 'function idle(){("requestIdleCallback" in window)?requestIdleCallback(load,{timeout:2500}):setTimeout(load,600)}'
		. 'if(!("IntersectionObserver" in window)){window.addEventListener("load",idle);return}'
		. 'var io=new IntersectionObserver(function(es){for(var i=0;i<es.length;i++){if(es[i].isIntersecting){io.disconnect();if(document.readyState==="complete")idle();else window.addEventListener("load",idle);return}}},{rootMargin:"40% 0px"});'
		. 'for(var i=0;i<els.length;i++)io.observe(els[i].closest("section")||els[i])})();';
}
add_action( 'wp_enqueue_scripts', 'vx_landing_assets', 50 );

/** Body class hook for styling (e.g. the admin-bar offset in fixes.css). */
add_filter( 'body_class', function ( $classes ) {
	if ( vx_is_landing() ) {
		$classes[] = 'vx-landing';
		$classes[] = 'vx-view-' . sanitize_html_class( vx_landing_view() );
	}
	return $classes;
} );

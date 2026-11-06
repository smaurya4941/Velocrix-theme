<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * SEO layer.
 *  - One place for every page's title, description and social image (vx_seo_map()).
 *  - Works with The SEO Framework (preferred): the data is written into the plugin's own page fields
 *    (so it can be edited per page later) and also fed through its filters as a safety net.
 *  - Works without any plugin (fallback title / description / social tags).
 *  - Structured data (JSON-LD): SportsActivityLocation, Person, Service, FAQPage (built from the FAQs
 *    that are actually shown on the page), BreadcrumbList.
 *  - Favicon, LCP image preload, noindex for utility pages.
 * Everything uses home_url(), so the domain can change (velocrixx.ureligible.com -> velocrix.com) with no edits.
 */

const VX_SEO_VERSION = 3; // bump when titles/descriptions below change; the next admin visit re-syncs them

/** slug => title (full, brand included), description, social image, hero image (for preload) */
function vx_seo_map() {
	$plans = function_exists( 'vx_plans' ) ? vx_plans() : array();
	$min   = 0;
	foreach ( $plans as $p ) {
		$n = (int) str_replace( array( ',', ' ' ), '', $p['price'] );
		if ( $n && ( ! $min || $n < $min ) ) $min = $n;
	}
	$from = $min ? 'Plans start at ₹' . number_format_i18n( $min ) . '. ' : '';

	return array(
		'home' => array(
			'Cricket Academy in Noida | Velocrix at Sarvottam School',
			'Velocrix Cricket Academy at Sarvottam International School, Sector 10, Greater Noida West. Professional coaching founded by Indian cricketer Meghna Singh.',
			'training-2.jpg', 'training-2.jpg',
		),
		'about' => array(
			'About Velocrix Cricket Academy | Founded by Meghna Singh',
			'Founded by Indian international cricketer Meghna Singh, Velocrix builds cricketing fundamentals, fitness, discipline and sportsmanship in Greater Noida West.',
			'training-1.jpg', 'training-1.jpg',
		),
		'meghna-singh' => array(
			'Meghna Singh | Indian Cricketer & Founder of Velocrix',
			'Meghna Singh, Indian international cricketer (Test, ODI and T20I) and right-arm medium-fast bowler from Bijnor, founded Velocrix Cricket Academy.',
			'training-1.jpg', 'training-1.jpg',
		),
		'pricing' => array(
			'Cricket Coaching Packages & Fees | Velocrix Noida',
			'Training plans from 1 month to 1 year at Velocrix Cricket Academy, Greater Noida West. ' . $from . 'Confirm current fees with us.',
			'hero-pricing.jpg', 'hero-pricing.jpg',
		),
		'services' => array(
			'Cricket Services: Tournaments, Workshops, Lectures | Velocrix',
			'Corporate cricket tournaments, hands-on workshops and guest lectures by Velocrix Cricket Academy at Sarvottam International School, Greater Noida West.',
			'hero-team.jpg', 'hero-team.jpg',
		),
		'corporate-tournament' => array(
			'Corporate Cricket Tournament in Noida | Velocrix',
			'Corporate cricket tournaments for office teams at Velocrix Cricket Academy, Greater Noida West. Team matches, fair play and fun. Enquire for dates and fees.',
			'fac-nets.jpg', 'fac-nets.jpg',
		),
		'workshops' => array(
			'Cricket Workshops for Players in Noida | Velocrix',
			'Hands-on cricket workshops covering batting, bowling, fielding and fitness for players of all levels at Velocrix Cricket Academy, Greater Noida West.',
			'prog-3.jpg', 'prog-3.jpg',
		),
		'guest-lectures' => array(
			'Cricket Guest Lectures for Schools & Clubs | Velocrix',
			'Guest lectures on cricket journeys, discipline and mental strength for schools, players and parents, organised by Velocrix Cricket Academy.',
			'prog-2.jpg', 'prog-2.jpg',
		),
		'gallery' => array(
			'Photo Gallery | Velocrix Cricket Academy Noida',
			'Photos from training sessions at Velocrix Cricket Academy, Sarvottam International School, Sector 10 Campus, Greater Noida West.',
			'training-1.jpg', 'training-1.jpg',
		),
		'coaches' => array(
			'Our Coaches & Team | Velocrix Cricket Academy',
			'Meet the coaching team at Velocrix Cricket Academy in Greater Noida West, led by Indian international cricketer and founder Meghna Singh.',
			'hero-team.jpg', 'hero-team.jpg',
		),
		'faq' => array(
			'FAQs: Fees, Joining & Training | Velocrix Cricket Academy',
			'Answers about joining Velocrix Cricket Academy in Greater Noida West: registration fee, training plans, location, batches and how to enrol.',
			'training-2.jpg', 'training-2.jpg',
		),
		'blog' => array(
			'Cricket Blog & Articles | Velocrix Cricket Academy',
			'Cricket tips, training guides and updates from Velocrix Cricket Academy at Sarvottam International School, Greater Noida West.',
			'hero-blog.jpg', 'hero-blog.jpg',
		),
		'contact' => array(
			'Contact Velocrix Cricket Academy | Greater Noida West',
			'Contact Velocrix Cricket Academy at Sarvottam International School, Sector 10 Campus, Greater Noida West. Call, email or send us a message.',
			'training-1.jpg', '',
		),
		'registration' => array(
			'Join Velocrix Cricket Academy | Trainee Registration',
			'Register your child at Velocrix Cricket Academy, Greater Noida West. Fill in the trainee form and our team will call you to confirm the batch and fees.',
			'hero-pricing.jpg', 'hero-pricing.jpg',
		),
	);
}

function vx_seo_tsf() {
	return defined( 'THE_SEO_FRAMEWORK_VERSION' );
}

/** Current page's SEO entry (array: title, desc, social image, hero image) or null */
function vx_seo_current() {
	if ( is_admin() ) return null;
	$map = vx_seo_map();
	if ( is_front_page() ) return $map['home'];
	if ( is_home() && ! is_front_page() ) return $map['blog'];
	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( isset( $map[ $slug ] ) ) return $map[ $slug ];
	}
	return null;
}

function vx_seo_img_details( $file ) {
	$path = get_template_directory() . '/assets/img/' . $file;
	if ( ! file_exists( $path ) ) return null;
	$sz = @getimagesize( $path );
	return array(
		'url'      => VX_URI . '/assets/img/' . $file,
		'id'       => 0,
		'width'    => $sz ? $sz[0] : 1200,
		'height'   => $sz ? $sz[1] : 630,
		'alt'      => 'Velocrix Cricket Academy, Greater Noida West',
		'caption'  => '',
		'filesize' => (int) @filesize( $path ),
	);
}

/* ---------------------------------------------------------------------------------------------
 * A. Write the data into The SEO Framework's own page fields (editable per page later).
 *    Never overwrites a value an editor changed: we remember what we wrote last time.
 * ------------------------------------------------------------------------------------------- */
function vx_seo_sync() {
	$done = array();
	foreach ( vx_seo_map() as $slug => $e ) {
		$page = ( $slug === 'home' )
			? ( get_option( 'page_on_front' ) ? get_post( (int) get_option( 'page_on_front' ) ) : null )
			: get_page_by_path( $slug );
		if ( ! $page ) continue;
		$id   = $page->ID;
		$prev = (array) get_post_meta( $id, '_vx_seo_managed', true );
		$want = array( '_genesis_title' => $e[0], '_genesis_description' => $e[1] );
		foreach ( $want as $key => $val ) {
			$cur = (string) get_post_meta( $id, $key, true );
			if ( $cur === '' || ( isset( $prev[ $key ] ) && $prev[ $key ] === $cur ) ) {
				update_post_meta( $id, $key, $val );
				$prev[ $key ] = $val;
			}
		}
		update_post_meta( $id, '_tsf_title_no_blogname', 1 ); // our titles already carry the brand
		update_post_meta( $id, '_vx_seo_managed', $prev );
		$done[] = $slug;
	}
	// Proper site name / tagline (only replaces the old defaults)
	if ( in_array( get_option( 'blogname' ), array( '', 'Velocrix', 'velocrix' ), true ) ) update_option( 'blogname', 'Velocrix Cricket Academy' );
	if ( in_array( get_option( 'blogdescription' ), array( '', 'Just another WordPress site' ), true ) ) update_option( 'blogdescription', 'Where Dreams Meet Discipline' );
	vx_seo_tsf_settings();
	update_option( 'vx_seo_synced', VX_SEO_VERSION );
	return $done;
}
add_action( 'admin_init', function () {
	if ( current_user_can( 'manage_options' ) && (int) get_option( 'vx_seo_synced', 0 ) < VX_SEO_VERSION ) vx_seo_sync();
} );

/* ---------------------------------------------------------------------------------------------
 * B. Safety nets through the plugin's filters (used if a page field is empty)
 * ------------------------------------------------------------------------------------------- */
add_filter( 'the_seo_framework_title_from_custom_field', function ( $t ) {
	$e = vx_seo_current(); return ( $t === '' && $e ) ? $e[0] : $t;
} );
add_filter( 'the_seo_framework_custom_field_description', function ( $d ) {
	$e = vx_seo_current(); return ( $d === '' && $e ) ? $e[1] : $d;
} );
// Social image: our per-page photo instead of a random/empty one when the page has no image of its own
add_filter( 'the_seo_framework_generated_image_details', function ( $details ) {
	$e = vx_seo_current();
	if ( $e && ( $i = vx_seo_img_details( $e[2] ) ) ) return array( $i );
	if ( empty( $details ) && ( $i = vx_seo_img_details( 'training-1.jpg' ) ) ) return array( $i );
	return $details;
} );

/* ---------------------------------------------------------------------------------------------
 * C. Fallback output when no SEO plugin is active
 * ------------------------------------------------------------------------------------------- */
add_filter( 'pre_get_document_title', function ( $title ) {
	if ( vx_seo_tsf() ) return $title;
	$e = vx_seo_current();
	return $e ? $e[0] : $title;
}, 20 );

add_action( 'wp_head', function () {
	if ( vx_seo_tsf() || defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) return;
	$e     = vx_seo_current();
	$title = $e ? $e[0] : wp_get_document_title();
	$desc  = $e ? $e[1] : 'Velocrix Cricket Academy at Sarvottam International School, Greater Noida West. Professional coaching founded by Indian international cricketer Meghna Singh.';
	if ( ! $e && is_singular() ) {
		$ex   = has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 30, '…' );
		$desc = $ex ? wp_strip_all_tags( $ex ) : $desc;
	}
	$img = $e ? vx_seo_img_details( $e[2] ) : null;
	if ( ! $img && is_singular() && has_post_thumbnail() ) {
		$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		if ( $src ) $img = array( 'url' => $src[0], 'width' => $src[1], 'height' => $src[2] );
	}
	if ( ! $img ) $img = vx_seo_img_details( 'training-1.jpg' );
	$url = is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );
	echo '<meta name="description" content="' . esc_attr( mb_substr( $desc, 0, 300 ) ) . '">' . "\n";
	echo '<meta property="og:locale" content="en_IN">' . "\n";
	echo '<meta property="og:type" content="' . ( is_single() ? 'article' : 'website' ) . '">' . "\n";
	echo '<meta property="og:site_name" content="Velocrix Cricket Academy">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( mb_substr( $desc, 0, 200 ) ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	if ( $img ) {
		echo '<meta property="og:image" content="' . esc_url( $img['url'] ) . '">' . "\n";
		echo '<meta property="og:image:width" content="' . (int) $img['width'] . '">' . "\n";
		echo '<meta property="og:image:height" content="' . (int) $img['height'] . '">' . "\n";
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( mb_substr( $desc, 0, 200 ) ) . '">' . "\n";
	if ( $img ) echo '<meta name="twitter:image" content="' . esc_url( $img['url'] ) . '">' . "\n";
}, 1 );

/* ---------------------------------------------------------------------------------------------
 * D. Utility pages should not be indexed (search results, 404, registration confirmation states)
 * ------------------------------------------------------------------------------------------- */
function vx_seo_is_utility() {
	if ( is_search() || is_404() ) return true;
	if ( is_page( 'registration' ) && ( isset( $_GET['vx'] ) || isset( $_GET['vxk'] ) ) ) return true;
	if ( isset( $_GET['nl'] ) || ( isset( $_GET['vx'] ) && ! is_page( 'registration' ) ) ) return true;
	return false;
}
add_filter( 'wp_robots', function ( $r ) {
	if ( vx_seo_is_utility() ) { $r['noindex'] = true; $r['follow'] = true; unset( $r['max-image-preview'] ); }
	return $r;
}, 30 );
add_filter( 'the_seo_framework_robots_meta_array', function ( $r ) {
	if ( vx_seo_is_utility() ) { $r['noindex'] = 'noindex'; }
	return $r;
} );

/* ---------------------------------------------------------------------------------------------
 * E. Structured data (JSON-LD)
 * ------------------------------------------------------------------------------------------- */
function vx_seo_business_id() { return home_url( '/#academy' ); }

function vx_seo_business() {
	$same = array();
	foreach ( array( 'instagram', 'facebook', 'youtube', 'linkedin', 'x' ) as $k ) {
		if ( $u = vx( "vx_$k" ) ) $same[] = $u;
	}
	$phone = vx( 'vx_phone', '+91 879 644 7595' );
	$b = array(
		'@type'       => array( 'SportsActivityLocation', 'LocalBusiness' ),
		'@id'         => vx_seo_business_id(),
		'name'        => 'Velocrix Cricket Academy',
		'alternateName' => 'Velocrix',
		'description' => 'Cricket academy at Sarvottam International School, Sector 10 Campus, Greater Noida West, founded by Indian international cricketer Meghna Singh.',
		'url'         => home_url( '/' ),
		'slogan'      => 'Where Dreams Meet Discipline',
		'logo'        => VX_URI . '/assets/img/logo-mark.png',
		'image'       => VX_URI . '/assets/img/training-1.jpg',
		'telephone'   => $phone,
		'email'       => vx( 'vx_email', 'admissions@velocrix.com' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Sarvottam International School, Sector 10 Campus',
			'addressLocality' => 'Greater Noida West',
			'addressRegion'   => 'Uttar Pradesh',
			'postalCode'      => '201318',
			'addressCountry'  => 'IN',
		),
		'areaServed'  => array( 'Noida', 'Greater Noida', 'Greater Noida West' ),
		'sport'       => 'Cricket',
		'founder'     => array( '@type' => 'Person', 'name' => vx( 'vx_mentor_name', 'Meghna Singh' ), 'jobTitle' => 'Founder and Mentor' ),
		'parentOrganization' => array( '@type' => 'EducationalOrganization', 'name' => 'Sarvottam International School' ),
	);
	if ( $hrs = vx( 'vx_hours' ) ) $b['openingHours'] = $hrs;
	if ( $same ) $b['sameAs'] = $same;
	return $b;
}

function vx_seo_graph() {
	if ( is_admin() || vx_seo_is_utility() ) return array();
	$g    = array();
	$slug = is_front_page() ? 'home' : ( is_page() ? get_post_field( 'post_name', get_queried_object_id() ) : '' );
	$e    = vx_seo_current();

	if ( in_array( $slug, array( 'home', 'about', 'contact' ), true ) ) $g[] = vx_seo_business();

	if ( $slug === 'meghna-singh' ) {
		$g[] = array(
			'@type'       => 'Person',
			'@id'         => home_url( '/meghna-singh/#person' ),
			'name'        => vx( 'vx_mentor_name', 'Meghna Singh' ),
			'jobTitle'    => 'Founder and Mentor, Velocrix Cricket Academy',
			'description' => 'Indian international cricketer and right-arm medium-fast bowler from Bijnor, Uttar Pradesh, who has represented India in Test, ODI and T20I cricket.',
			'image'       => vx( 'vx_mentor_img' ),
			'nationality' => 'IN',
			'url'         => home_url( '/meghna-singh/' ),
			'worksFor'    => array( '@id' => vx_seo_business_id() ),
		);
	}

	if ( in_array( $slug, array( 'corporate-tournament', 'workshops', 'guest-lectures' ), true ) && $e ) {
		$sd = function_exists( 'vx_service_data' ) ? vx_service_data( $slug ) : null;
		$g[] = array(
			'@type'       => 'Service',
			'name'        => $sd ? $sd['name'] : get_the_title(),
			'description' => $e[1],
			'url'         => get_permalink(),
			'provider'    => array( '@type' => 'SportsActivityLocation', '@id' => vx_seo_business_id(), 'name' => 'Velocrix Cricket Academy' ),
			'areaServed'  => array( 'Noida', 'Greater Noida West' ),
		);
	}

	// Breadcrumbs for inner pages
	if ( is_page() && $slug && $slug !== 'home' ) {
		$crumbs = array( array( 'Home', home_url( '/' ) ) );
		if ( in_array( $slug, array( 'corporate-tournament', 'workshops', 'guest-lectures' ), true ) ) $crumbs[] = array( 'Services', home_url( '/services/' ) );
		if ( in_array( $slug, array( 'gallery', 'coaches', 'faq' ), true ) ) $crumbs[] = array( 'Resources', home_url( '/blog/' ) );
		$crumbs[] = array( $e ? preg_replace( '/\s*\|.*$/', '', $e[0] ) : get_the_title(), get_permalink() );
		$items = array();
		foreach ( $crumbs as $i => $c ) $items[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'name' => $c[0], 'item' => $c[1] );
		$g[] = array( '@type' => 'BreadcrumbList', 'itemListElement' => $items );
	}
	return apply_filters( 'vx_seo_extra_graph', $g );
}

function vx_seo_print_ld( $nodes ) {
	if ( ! $nodes ) return;
	$doc = array( '@context' => 'https://schema.org', '@graph' => array_values( $nodes ) );
	echo '<script type="application/ld+json">' . wp_json_encode( $doc, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', function () { vx_seo_print_ld( vx_seo_graph() ); }, 5 );

/** FAQPage schema from the FAQs that are really on the page (collected by the FAQ template parts) */
function vx_seo_collect_faq( $faqs ) {
	foreach ( (array) $faqs as $f ) {
		if ( is_array( $f ) && isset( $f[0] ) && is_string( $f[0] ) ) {
			$GLOBALS['vx_faq_schema'][] = array( $f[0], $f[1] );
		} elseif ( is_array( $f ) ) {
			vx_seo_collect_faq( $f );
		}
	}
}
add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['vx_faq_schema'] ) || vx_seo_is_utility() ) return;
	$seen = array(); $qa = array();
	foreach ( $GLOBALS['vx_faq_schema'] as $f ) {
		$k = md5( $f[0] );
		if ( isset( $seen[ $k ] ) ) continue;
		$seen[ $k ] = 1;
		$qa[] = array( '@type' => 'Question', 'name' => wp_strip_all_tags( $f[0] ), 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $f[1] ) ) );
	}
	if ( $qa ) vx_seo_print_ld( array( array( '@type' => 'FAQPage', 'mainEntity' => $qa ) ) );
}, 5 );

/* ---------------------------------------------------------------------------------------------
 * F. Favicon / app icons, and LCP image preload
 * ------------------------------------------------------------------------------------------- */
add_action( 'wp_head', function () {
	if ( ! has_site_icon() ) {
		foreach ( array( array( 32, 'icon' ), array( 192, 'icon' ), array( 180, 'apple-touch-icon' ) ) as $i ) {
			$f = 'assets/img/favicon-' . $i[0] . '.png';
			if ( file_exists( get_template_directory() . '/' . $f ) ) {
				echo '<link rel="' . $i[1] . '" type="image/png" sizes="' . $i[0] . 'x' . $i[0] . '" href="' . esc_url( vx_asset( $f ) ) . '">' . "\n";
			}
		}
	}
	$e = vx_seo_current();
	if ( $e && $e[3] && file_exists( get_template_directory() . '/assets/img/' . $e[3] ) && ( ! is_front_page() || ! vx( 'vx_hero_img' ) ) ) {
		echo '<link rel="preload" as="image" href="' . esc_url( VX_URI . '/assets/img/' . $e[3] ) . '" fetchpriority="high">' . "\n";
	}
}, 3 );

// /favicon.ico requests (browsers ask for it by default)
add_action( 'do_faviconico', function () {
	$f = get_template_directory() . '/assets/img/favicon-32.png';
	if ( has_site_icon() || ! file_exists( $f ) ) return;
	header( 'Content-Type: image/png' );
	header( 'Cache-Control: public, max-age=604800' );
	readfile( $f );
	exit;
}, 1 );

/* Posts page (Blog) is not "singular", so core prints no canonical for it */
add_action( 'wp_head', function () {
	if ( vx_seo_tsf() || defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) return;
	if ( is_home() && ! is_front_page() ) {
		$paged = get_query_var( 'paged' );
		$url   = get_permalink( (int) get_option( 'page_for_posts' ) );
		if ( $paged > 1 ) $url = trailingslashit( $url ) . 'page/' . (int) $paged . '/';
		echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
	}
}, 2 );
add_filter( 'vx_seo_extra_graph', function ( $g ) {
	if ( ! ( is_home() && ! is_front_page() ) ) return $g;
	$g[] = array( '@type' => 'BreadcrumbList', 'itemListElement' => array(
		array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url( '/' ) ),
		array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => get_permalink( (int) get_option( 'page_for_posts' ) ) ),
	) );
	return $g;
} );

/* ---------------------------------------------------------------------------------------------
 * G. Plugin settings we need (only touches these keys; runs from the same sync as the page data)
 * ------------------------------------------------------------------------------------------- */
function vx_seo_tsf_settings() {
	if ( ! vx_seo_tsf() || ! defined( 'THE_SEO_FRAMEWORK_SITE_OPTIONS' ) ) return false;
	$o   = (array) get_option( THE_SEO_FRAMEWORK_SITE_OPTIONS, array() );
	$map = vx_seo_map();
	$set = array(
		'homepage_tagline'   => 0,   // don't append the tagline to the home title
		'homepage_title'     => $map['home'][0],
		'homepage_description' => $map['home'][1],
		'knowledge_name'     => 'Velocrix Cricket Academy',
		'knowledge_type'     => 'organization',
		'knowledge_instagram'=> (string) vx( 'vx_instagram' ),
		'knowledge_facebook' => (string) vx( 'vx_facebook' ),
		'knowledge_twitter'  => (string) vx( 'vx_x' ),
		'knowledge_linkedin' => (string) vx( 'vx_linkedin' ),
		'knowledge_youtube'  => (string) vx( 'vx_youtube' ),
	);
	foreach ( $set as $k => $v ) {
		if ( $k === 'homepage_tagline' || ! isset( $o[ $k ] ) || $o[ $k ] === '' || $o[ $k ] === 0 ) $o[ $k ] = $v;
	}
	update_option( THE_SEO_FRAMEWORK_SITE_OPTIONS, $o );
	return true;
}
add_action( 'admin_init', function () {
	if ( vx_seo_tsf() && current_user_can( 'manage_options' ) && get_option( 'vx_seo_tsf_synced' ) !== (string) VX_SEO_VERSION ) {
		vx_seo_tsf_settings();
		update_option( 'vx_seo_tsf_synced', (string) VX_SEO_VERSION );
	}
}, 20 );

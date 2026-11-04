<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VX_VER', '1.0.0' );
define( 'VX_URI', get_template_directory_uri() );

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/forms.php';

/** Theme setup */
function vx_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 260, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array(
		'primary' => 'Primary Menu',
		'footer'  => 'Footer Menu',
	) );
	add_image_size( 'vx-card', 800, 600, true );
}
add_action( 'after_setup_theme', 'vx_setup' );

/** Assets */
function vx_assets() {
	wp_enqueue_style( 'vx-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Oswald:wght@500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'vx-main', VX_URI . '/assets/css/main.css', array(), VX_VER );
	wp_enqueue_script( 'vx-main', VX_URI . '/assets/js/main.js', array(), VX_VER, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'vx_assets' );

/** Preconnect for Google Fonts */
function vx_preconnect() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'vx_preconnect', 1 );

/** Remove unused WP front-end bloat (keeps site light) */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
add_action( 'wp_enqueue_scripts', function () {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}, 100 );

/** Theme-mod helper */
function vx( $key, $default = '' ) {
	$v = get_theme_mod( $key, $default );
	return ( $v === '' || $v === false ) ? $default : $v;
}

function vx_phone_href( $num ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $num );
}

/** Default menu items (used until a menu is assigned in Appearance > Menus) */
function vx_default_menu() {
	return array(
		'Home'     => home_url( '/' ),
		'About'    => home_url( '/about/' ),
		'Programs' => home_url( '/programs/' ),
		'Coaches'  => home_url( '/coaches/' ),
		'Facilities' => home_url( '/facilities/' ),
		'Pricing'  => home_url( '/pricing/' ),
		'Gallery'  => home_url( '/gallery/' ),
		'Blog'     => home_url( '/blog/' ),
		'Contact'  => home_url( '/contact/' ),
	);
}

function vx_primary_menu() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-list', 'depth' => 2 ) );
		return;
	}
	echo '<ul class="nav-list">';
	foreach ( vx_default_menu() as $label => $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/** Page hero used on every inner page */
function vx_page_hero( $title, $sub = '', $eyebrow = 'Velocrix Cricket Academy' ) {
	?>
	<section class="page-hero">
		<div class="container">
			<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h1><?php echo wp_kses_post( $title ); ?></h1>
			<?php if ( $sub ) : ?><p class="lead"><?php echo esc_html( $sub ); ?></p><?php endif; ?>
		</div>
	</section>
	<?php
}

/** Section heading helper */
function vx_heading( $eyebrow, $title, $center = false ) {
	echo '<div class="sec-head' . ( $center ? ' center' : '' ) . '"><span class="eyebrow">' . esc_html( $eyebrow ) . '</span><h2>' . wp_kses_post( $title ) . '</h2></div>';
}

/** Get the 4 pricing plans (editable in Customizer) */
function vx_plans() {
	$defaults = array(
		array( '1 Month',  '2,999',  'Ideal for beginners to explore and build basics' ),
		array( '3 Months', '7,999',  'Structured training to improve skills consistently' ),
		array( '6 Months', '14,999', 'Advanced coaching for performance enhancement' ),
		array( '1 Year',   '27,999', 'Complete development program for long-term excellence' ),
	);
	$plans = array();
	foreach ( $defaults as $i => $d ) {
		$n = $i + 1;
		$plans[] = array(
			'name'  => vx( "vx_plan{$n}_name", $d[0] ),
			'price' => vx( "vx_plan{$n}_price", $d[1] ),
			'desc'  => vx( "vx_plan{$n}_desc", $d[2] ),
			'feat'  => $n === 3,
		);
	}
	return $plans;
}

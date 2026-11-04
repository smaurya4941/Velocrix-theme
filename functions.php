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
	wp_enqueue_style( 'vx-fonts', 'https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,500;0,600;1,600&display=swap', array(), null );
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

/** Inline SVG icons (no icon library) */
function vx_icon( $name ) {
	$i = array(
		'arrow'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>',
		'pin'      => '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z"/></svg>',
		'calendar' => '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M7 2v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2V2h-2v2H9V2H7Zm-2 8h14v10H5V10Z"/></svg>',
		'clock'    => '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm1 5v5.4l3.6 2.1-1 1.6L11 13V7h2Z"/></svg>',
		'play'     => '<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7L8 5Z"/></svg>',
		'facebook' => '<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M14 8V6.5c0-.7.3-1 1-1h2V2h-3c-3 0-4.5 1.8-4.5 4.4V8H7v3.5h2.5V22H14V11.5h2.8L17 8h-3Z"/></svg>',
		'instagram'=> '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>',
		'youtube'  => '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2C2 8.8 2 12 2 12s0 3.2.4 4.8a2.5 2.5 0 0 0 1.8 1.8C5.8 19 12 19 12 19s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8c.4-1.6.4-4.8.4-4.8s0-3.2-.4-4.8ZM10 15V9l5 3-5 3Z"/></svg>',
		'linkedin' => '<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3 9.5h4V21H3V9.5Zm6.5 0h3.8v1.6h.1c.5-1 1.9-1.9 3.8-1.9 4 0 4.8 2.6 4.8 6V21h-4v-5.1c0-1.2 0-2.8-1.7-2.8s-2 1.3-2 2.7V21h-4V9.5Z"/></svg>',
	);
	return isset( $i[ $name ] ) ? $i[ $name ] : '';
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

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VX_VER', '1.0.5' );
define( 'VX_URI', get_template_directory_uri() );

require get_template_directory() . '/inc/content.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/forms.php';
require get_template_directory() . '/inc/registration.php';
require get_template_directory() . '/inc/hardening.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/services.php';

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
	wp_enqueue_style( 'vx-main', VX_URI . '/assets/css/main.css', array(), VX_VER . '.' . filemtime( get_template_directory() . '/assets/css/main.css' ) );
	wp_enqueue_script( 'vx-main', VX_URI . '/assets/js/main.js', array(), VX_VER . '.' . filemtime( get_template_directory() . '/assets/js/main.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
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
function vx( $key, $default = "" ) {
	$d = vx_defaults();
	if ( array_key_exists( $key, $d ) ) $default = $d[ $key ];
	$v = get_theme_mod( $key, $default );
	return ( $v === "" || $v === false ) ? $default : $v;
}

function vx_phone_href( $num ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $num );
}

/** Default menu items (used until a menu is assigned in Appearance > Menus) */
function vx_default_menu() {
	return array(
		'Home'        => home_url( '/' ),
		'About'       => home_url( '/about/' ),
		'Our Mentor'  => home_url( '/meghna-singh/' ),
		'Packages'    => home_url( '/pricing/' ),
		'Services'    => array( '_url' => home_url( '/services/' ),
			'Corporate Tournament' => home_url( '/corporate-tournament/' ),
			'Workshops'            => home_url( '/workshops/' ),
			'Guest Lectures'       => home_url( '/guest-lectures/' ),
		),
		'Resources'   => array(
			'Gallery' => home_url( '/gallery/' ),
			'Team'    => home_url( '/coaches/' ),
			'FAQ'     => home_url( '/faq/' ),
			'Blog'    => home_url( '/blog/' ),
		),
		'Contact'     => home_url( '/contact/' ),
	);
}

/** The three services (shared by the Home "Our Services" section and the Services page): title, text, image file, page path */
function vx_services() {
	return array(
		array( 'Corporate Tournament', 'Competitive cricket for corporate teams, built around fitness, fun and fair play.', 'fac-nets.jpg', '/corporate-tournament/' ),
		array( 'Workshops', 'Hands-on sessions focused on skills, fitness and the fundamentals of the game.', 'prog-3.jpg', '/workshops/' ),
		array( 'Guest Lectures', 'Talks from cricket experts to inspire and guide the next generation of players.', 'prog-2.jpg', '/guest-lectures/' ),
	);
}

function vx_primary_menu() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-list', 'depth' => 2 ) );
		return;
	}
	echo '<ul class="nav-list">';
	foreach ( vx_default_menu() as $label => $url ) {
		if ( is_array( $url ) ) {
			echo '<li class="menu-item-has-children"><a href="' . esc_url( isset( $url['_url'] ) ? $url['_url'] : '#' ) . '" aria-haspopup="true">' . esc_html( $label ) . '</a><ul class="sub-menu">';
			unset( $url['_url'] );
			foreach ( $url as $sl => $su ) {
				echo '<li><a href="' . esc_url( $su ) . '">' . esc_html( $sl ) . '</a></li>';
			}
			echo '</ul></li>';
			continue;
		}
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
		'check'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9.5"/><path d="m8 12.3 2.8 2.8L16 9.5"/></svg>',
		'search'   => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2"/></svg>',
		'x'        => '<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M17.53 3h3.26l-7.12 8.14L22 21h-6.55l-5.13-6.7L4.4 21H1.14l7.62-8.7L1 3h6.7l4.64 6.13L17.53 3Zm-1.14 16.1h1.8L6.7 4.8H4.77l11.62 14.3Z"/></svg>',
		'whatsapp' => '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm5.2 14.3c-.2.6-1.2 1.2-1.7 1.2-.4.1-1 .1-1.6-.1-.4-.1-.9-.3-1.5-.6-2.6-1.1-4.3-3.8-4.4-4-.1-.2-1-1.3-1-2.5s.6-1.8.9-2c.2-.2.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.3 0 .5l-.3.5-.4.4c-.1.1-.3.3-.1.6.2.3.7 1.2 1.5 1.9 1 .9 1.9 1.2 2.2 1.3.3.1.4.1.6-.1l.8-1c.2-.2.4-.2.6-.1l1.9.9c.3.1.5.2.5.3.1.1.1.6-.1 1.2Z"/></svg>',
		'user'     => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9.5"/><circle cx="12" cy="10" r="3"/><path d="M6.5 18.2c1.2-2.2 3.2-3.2 5.5-3.2s4.300 1 5.500 3.200"/></svg>',
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

/** The 4 training plans (all editable in Customizer > Velocrix: Fees & Admission) */
function vx_plans() {
	$base = vx_copy( "plan_features" );
	$defaults = array(
		array( "1 Month",  "2,999",  "Ideal for beginners to explore and build basics", $base ),
		array( "3 Months", "7,999",  "Structured training to improve skills consistently", $base ),
		array( "6 Months", "14,999", "Advanced coaching for performance enhancement", $base ),
		array( "1 Year",   "27,999", "Complete development program for long-term excellence", $base ),
	);
	$popular = (int) vx( 'vx_plan_popular', 4 );
	$plans   = array();
	foreach ( $defaults as $i => $d ) {
		$n    = $i + 1;
		$feat = vx( "vx_plan{$n}_features", '' );
		$plans[] = array(
			'name'     => vx( "vx_plan{$n}_name", $d[0] ),
			'price'    => vx( "vx_plan{$n}_price", $d[1] ),
			'desc'     => vx( "vx_plan{$n}_desc", $d[2] ),
			'features' => $feat ? array_filter( array_map( 'trim', explode( "\n", $feat ) ) ) : $d[3],
			'feat'     => ( $n === $popular ),
		);
	}
	return $plans;
}

/** Pricing card (shared by every plan + the registration card) */
function vx_plan_card( $p, $url, $btn = 'Choose Plan', $unit = '', $badge = '' ) {
	?>
	<article class="pcard<?php echo $p['feat'] ? ' is-popular' : ''; ?>">
		<?php if ( $p['feat'] && $badge ) echo '<span class="p-badge">' . esc_html( $badge ) . '</span>'; ?>
		<h3><?php echo esc_html( $p['name'] ); ?></h3>
		<p class="p-desc"><?php echo esc_html( $p['desc'] ); ?></p>
		<div class="p-price"><span class="cur">&#8377;</span><?php echo esc_html( $p['price'] ); ?><?php if ( $unit ) echo '<small>' . esc_html( $unit ) . '</small>'; ?></div>
		<a class="btn btn-block" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $btn ); ?></a>
		<ul class="p-list">
			<?php foreach ( $p['features'] as $f ) echo '<li>' . vx_icon( 'check' ) . esc_html( $f ) . '</li>'; // phpcs:ignore ?>
		</ul>
	</article>
	<?php
}

/** Coaches list shared by About and Team pages. Add real coaches here (name, role, photo URL). */
function vx_coaches() {
	return array(
		array(
			'name'  => vx( 'vx_mentor_name', 'Ms. Meghna Singh' ),
			'role'  => vx( 'vx_mentor_role', 'International Cricketer' ) . ' & Mentor',
			'photo' => vx( 'vx_mentor_img' ),
			'soon'  => false,
			'url'   => home_url( '/meghna-singh/' ),
		),
		array( 'name' => 'Head Coach', 'role' => 'Profile coming soon', 'photo' => '', 'soon' => true ),
		array( 'name' => 'Coach',      'role' => 'Profile coming soon', 'photo' => '', 'soon' => true ),
	);
}

/** Asset URL with a file-modified version, so replaced images never get stuck in browser cache */
function vx_asset( $path ) {
	$file = get_template_directory() . '/' . ltrim( $path, '/' );
	$v    = file_exists( $file ) ? filemtime( $file ) : VX_VER;
	return VX_URI . '/' . ltrim( $path, '/' ) . '?v=' . $v;
}

<?php
/**
 * Training Lab: one page per interactive tool, grouped under the "Training Lab" menu item.
 *
 * vx_lab_tools() is the single source of truth. Everything else is derived from it:
 *  - pages      /training-lab/ (hub) and /training-lab/{slug}/ (one tool each), created by Appearance > Velocrix Setup
 *  - menu       header dropdown + footer column (vx_default_menu(), inc/setup.php)
 *  - rendering  each tool page = page-hero + the tool's section + "more tools" + CTA (inc/landing.php)
 *  - links      vx_lx( 'anchor' ) finds the page a tool now lives on; old /training/#level style links are forwarded
 *  - SEO        title + description per tool page (inc/seo.php)
 *
 * The tools' markup lives in template-parts/landing/sections/ and their scripts in assets/landing/js/.
 * Every script block is guarded by its element ids, and the 3D scenes start lazily from their section id,
 * so a tool works the same on its own page as it did on the long page.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

const VX_LAB_HUB = 'training-lab';

/**
 * slug => tool.
 *  title   page title, menu label and card title
 *  section section file in template-parts/landing/sections/
 *  anchors element ids inside that section that other pages link to (vx_lx())
 *  tag     short label on the cards
 *  img     card image: 'media/…' (assets/landing/) or 'img/…' (assets/img/)
 *  card    one line for cards and the dropdown
 *  hero    page hero: kicker, two-line title, lede
 *  seo     title, description, social image (assets/img/)
 */
function vx_lab_tools() {
	static $tools = null;
	if ( null !== $tools ) return $tools;
	$tools = array(
		'delivery-lab'   => array(
			'title'   => 'Delivery Lab',
			'section' => 'lab-delivery',
			'anchors' => array( 'lab-delivery' ),
			'tag'     => '3D',
			'img'     => 'media/bowler-follow.jpg',
			'card'    => 'Pace, swing and seam, bowled down 22 yards.',
			'hero'    => array(
				'kicker' => 'Training Lab · 3D',
				'title'  => array( 'Bowl it', 'down 22 yards.' ),
				'lede'   => 'Pick a classic delivery or set your own pace, length, line, swing and seam, then watch it travel down a pitch built to real measurements.',
			),
			'seo'     => array( 'Cricket Delivery Simulator in 3D | Velocrix Training Lab', 'Bowl a delivery in 3D: set pace, length, line, swing and seam and see where it pitches and whether it hits the stumps. A Velocrix Cricket Academy training tool.', 'fac-nets.jpg' ),
		),
		'stance-studio'  => array(
			'title'   => 'Stance Studio',
			'section' => 'lab-stance',
			'anchors' => array( 'lab-stance' ),
			'tag'     => '3D',
			'img'     => 'media/batting-nets.jpg',
			'card'    => 'Bat size, stance and shots for any height.',
			'hero'    => array(
				'kicker' => 'Training Lab · 3D',
				'title'  => array( 'Set your stance.', 'Then play a shot.' ),
				'lede'   => 'Enter the player\'s height and the batter takes guard with the matching bat. Adjust stance, knee bend, grip and bat angle and the coach\'s checks update live.',
			),
			'seo'     => array( 'Batting Stance & Bat Size in 3D | Velocrix Training Lab', 'Set a young batter\'s height and see the right bat size, stance and shots in 3D, with live coaching checks. A Velocrix Cricket Academy training tool.', 'training-2.jpg' ),
		),
		'batting-game'   => array(
			'title'   => 'Batting Game',
			'section' => 'play',
			'anchors' => array( 'play' ),
			'tag'     => 'Game',
			'img'     => 'media/catch.jpg',
			'card'    => 'Time your shot and beat your best score.',
			'hero'    => array(
				'kicker' => 'Training Lab · Game',
				'title'  => array( 'Your turn', 'to bat.' ),
				'lede'   => 'A short 3D batting game in the browser. Pick a level, time your swing and see how many runs you can score.',
			),
			'seo'     => array( '3D Cricket Batting Game | Velocrix Training Lab', 'Play a free 3D cricket batting game in your browser: time your shot, score runs and beat your best. From Velocrix Cricket Academy, Greater Noida West.', 'prog-1.jpg' ),
		),
		'know-the-field' => array(
			'title'   => 'Know the Field',
			'section' => 'field',
			'anchors' => array( 'field' ),
			'tag'     => 'Interactive',
			'img'     => 'img/fac-run.jpg',
			'card'    => 'Every fielding position, and why it is there.',
			'hero'    => array(
				'kicker' => 'Training Lab · Interactive',
				'title'  => array( 'Know', 'the field.' ),
				'lede'   => 'Good fielders know where they stand and why. Tap a position to learn it, or drag the fielder and see where you have placed them.',
			),
			'seo'     => array( 'Cricket Fielding Positions Explained | Velocrix Training Lab', 'Learn every cricket fielding position on an interactive field: tap a position or drag a fielder to see its name and role. A Velocrix Cricket Academy tool.', 'fac-run.jpg' ),
		),
		'ground-tour'    => array(
			'title'   => 'Ground Tour',
			'section' => 'ground',
			'anchors' => array( 'ground' ),
			'tag'     => '3D',
			'img'     => 'img/fac-nets.jpg',
			'card'    => 'Walk around our training area in 3D.',
			'hero'    => array(
				'kicker' => 'Training Lab · 3D',
				'title'  => array( 'Walk around', 'our ground.' ),
				'lede'   => 'A 3D model of our training area at Sarvottam International School, Sector 10. Drag to look around, or tap a stop.',
			),
			'seo'     => array( 'Velocrix Ground Tour in 3D | Sarvottam School, Greater Noida West', 'Take a 3D tour of the Velocrix Cricket Academy training area at Sarvottam International School, Sector 10, Greater Noida West.', 'fac-nets.jpg' ),
		),
		'session-plan'   => array(
			'title'   => 'Session Plan',
			'section' => 'yards',
			'anchors' => array( 'yards' ),
			'tag'     => 'Interactive',
			'img'     => 'media/poster-technique.jpg',
			'card'    => 'One training session, laid out on 22 yards.',
			'hero'    => array(
				'kicker' => 'Training Lab · Interactive',
				'title'  => array( 'One session,', 'stage by stage.' ),
				'lede'   => 'Every session follows the same plan, so your child always knows what comes next. Tap a stage to bowl the ball down the pitch.',
			),
			'seo'     => array( 'How a Cricket Training Session Works | Velocrix Training Lab', 'See how a Velocrix cricket training session runs, stage by stage, from warm-up to feedback, laid out on an interactive 22-yard pitch.', 'prog-1.jpg' ),
		),
		'level-check'    => array(
			'title'   => 'Level Check',
			'section' => 'level',
			'anchors' => array( 'level' ),
			'tag'     => 'Quiz',
			'img'     => 'media/focus-ball.jpg',
			'card'    => 'A quick quiz to find your child\'s level.',
			'hero'    => array(
				'kicker' => 'Training Lab · Quiz',
				'title'  => array( 'Where does', 'your child start?' ),
				'lede'   => 'Answer a few quick questions about your child\'s cricket so far and see which group is likely to fit. We confirm the level on the ground.',
			),
			'seo'     => array( 'Cricket Level Check for Kids | Velocrix Training Lab', 'A quick quiz to see which training group may suit your child at Velocrix Cricket Academy, Greater Noida West. The coaches confirm the level on the ground.', 'training-1.jpg' ),
		),
		'kit-check'      => array(
			'title'   => 'Kit & Bat Size',
			'section' => 'kit',
			'anchors' => array( 'kit' ),
			'tag'     => 'Tools',
			'img'     => 'media/bowler-load.jpg',
			'card'    => 'Right bat size, a home warm-up and a kit list.',
			'hero'    => array(
				'kicker' => 'Training Lab · Tools',
				'title'  => array( 'Pack the bag.', 'Pick the bat.' ),
				'lede'   => 'Three quick tools: find the right bat size for your child\'s height, warm up at home and tick off the kit list.',
			),
			'seo'     => array( 'Cricket Bat Size Chart & Kit List for Kids | Velocrix', 'Find the right junior cricket bat size by height, follow a home warm-up and tick off the cricket kit list. A Velocrix Cricket Academy tool.', 'training-2.jpg' ),
		),
	);
	return $tools;
}

/** The tool registered for a page slug, or null. */
function vx_lab_tool( $slug ) {
	$t = vx_lab_tools();
	return isset( $t[ $slug ] ) ? $t[ $slug ] : null;
}

/** The published WP page of a tool (child of the hub), or null. */
function vx_lab_tool_page( $slug ) {
	$p = get_page_by_path( VX_LAB_HUB . '/' . $slug );
	return ( $p && 'publish' === $p->post_status ) ? $p : null;
}

/** URL of a tool page (works before the page exists, so links never break). */
function vx_lab_tool_url( $slug ) {
	$p = vx_lab_tool_page( $slug );
	return $p ? get_permalink( $p ) : home_url( '/' . VX_LAB_HUB . '/' . $slug . '/' );
}

function vx_lab_hub_url() {
	return home_url( '/' . VX_LAB_HUB . '/' );
}

/** Card image URL for a tool. */
function vx_lab_img( $tool ) {
	$ref = $tool['img'];
	if ( 0 === strpos( $ref, 'img/' ) ) return VX_URI . '/assets/' . $ref;
	return vx_landing_uri( $ref );
}

/** anchor id => tool slug, for every element id a tool page owns. */
function vx_lab_anchor_map() {
	$map = array();
	foreach ( vx_lab_tools() as $slug => $t ) {
		foreach ( $t['anchors'] as $a ) $map[ $a ] = $slug;
	}
	return $map;
}

/**
 * Old links such as /training-lab/#play or /training/#level point at sections that now have their own page.
 * Map of hash => new URL, printed on the two old pages (see vx_landing_assets()) and followed by pages.js.
 */
function vx_lab_moved_hashes() {
	$out = array();
	foreach ( vx_lab_anchor_map() as $anchor => $slug ) $out[ $anchor ] = vx_lab_tool_url( $slug );
	$out['lab'] = vx_lab_hub_url() . '#lab-tools'; // the old two-tool "Delivery & stance" block
	return $out;
}

/** Previous and next tool (wraps around), for the "more tools" strip. */
function vx_lab_neighbours( $slug ) {
	$keys = array_keys( vx_lab_tools() );
	$i    = array_search( $slug, $keys, true );
	if ( false === $i ) return array( null, null );
	$n = count( $keys );
	return array( $keys[ ( $i - 1 + $n ) % $n ], $keys[ ( $i + 1 ) % $n ] );
}

/** Menu group used by the header fallback and the footer (vx_default_menu()). */
function vx_lab_menu_group() {
	$g = array( '_url' => vx_lab_hub_url() );
	foreach ( vx_lab_tools() as $slug => $t ) $g[ $t['title'] ] = vx_lab_tool_url( $slug );
	return $g;
}

/** Tool pages have no page-{slug}.php of their own: render them with the animated document. */
add_filter( 'template_include', function ( $template ) {
	if ( ! is_page() || is_front_page() ) return $template;
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	if ( ! vx_lab_tool( $slug ) ) return $template;
	// a custom template picked in the editor ("Velocrix Animated" etc.) already renders the same document
	$doc = locate_template( 'template-parts/landing/document.php' );
	return $doc ? $doc : $template;
} );

/** Create the hub + tool pages when missing (Appearance > Velocrix Setup). Returns log lines. */
function vx_lab_setup_pages() {
	$log = array();
	$hub = get_page_by_path( VX_LAB_HUB );
	if ( ! $hub ) return array( 'Training Lab page missing: tool pages not created' );
	$order = 0;
	foreach ( vx_lab_tools() as $slug => $t ) {
		$order++;
		$p = get_page_by_path( VX_LAB_HUB . '/' . $slug );
		if ( ! $p ) {
			// a page with this slug may exist at the top level (made by hand): move it under the hub instead of duplicating it
			$loose = get_posts( array( 'post_type' => 'page', 'name' => $slug, 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'numberposts' => 1 ) );
			if ( $loose ) {
				wp_update_post( array( 'ID' => $loose[0]->ID, 'post_parent' => $hub->ID, 'post_status' => 'publish', 'menu_order' => $order ) );
				$log[] = 'Moved under Training Lab: ' . $t['title'];
				continue;
			}
			$id    = wp_insert_post( array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_name'   => $slug,
				'post_title'  => $t['title'],
				'post_parent' => $hub->ID,
				'menu_order'  => $order,
			) );
			$log[] = ( $id && ! is_wp_error( $id ) ) ? 'Created page: Training Lab / ' . $t['title'] : 'FAILED to create page: ' . $t['title'];
		} elseif ( 'publish' !== $p->post_status ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'publish' ) );
			$log[] = 'Published existing page: ' . $t['title'];
		}
	}
	return $log;
}

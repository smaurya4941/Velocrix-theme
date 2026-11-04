<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * One-click site setup (Appearance > Velocrix Setup).
 * Creates the final pages if missing, drafts the retired pages, trashes the Sample Page and
 * builds the final primary menu. Safe to run more than once. It never edits the content of
 * existing pages, never touches enquiries/users/settings, and keeps any old menu.
 */

function vx_setup_pages() {
	// slug => title (used only when the page does not exist yet)
	return array(
		'about'                => 'About Us',
		'meghna-singh'         => 'Ms. Meghna Singh',
		'pricing'              => 'Pricing',
		'services'             => 'Services',
		'corporate-tournament' => 'Corporate Tournament',
		'workshops'            => 'Workshops',
		'guest-lectures'       => 'Guest Lectures',
		'gallery'              => 'Gallery',
		'coaches'              => 'Our Coaches',
		'faq'                  => 'FAQ',
		'contact'              => 'Contact',
		'registration'         => 'Trainee Registration',
	);
}

function vx_run_setup() {
	$log = array();

	// 1. Create missing pages
	foreach ( vx_setup_pages() as $slug => $title ) {
		$p = get_page_by_path( $slug );
		if ( $p ) {
			if ( $p->post_status === 'trash' || $p->post_status === 'draft' ) {
				wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'publish' ) );
				$log[] = "Published existing page: $title";
			}
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => in_array( $slug, array( 'corporate-tournament', 'workshops', 'guest-lectures' ), true ) ? '<p>Details coming soon.</p>' : '',
		) );
		$log[] = ( $id && ! is_wp_error( $id ) ) ? "Created page: $title" : "FAILED to create page: $title";
	}

	// 2. Retire old pages (draft, not deleted)
	foreach ( array( 'programs', 'facilities', 'admission', 'achievements' ) as $slug ) {
		$p = get_page_by_path( $slug );
		if ( $p && $p->post_status === 'publish' ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
			$log[] = "Moved to draft: $slug";
		}
	}

	// 3. Sample Page (default WordPress page) to trash
	$s = get_page_by_path( 'sample-page' );
	if ( $s && $s->post_status === 'publish' ) {
		wp_trash_post( $s->ID );
		$log[] = 'Sample Page moved to trash';
	}

	// 4. Menu
	$name = 'Velocrix Primary';
	$menu = wp_get_nav_menu_object( $name );
	$mid  = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $name );
	if ( $mid ) {
		foreach ( (array) wp_get_nav_menu_items( $mid ) as $it ) wp_delete_post( $it->ID, true );

		$page = function ( $slug, $label, $parent = 0 ) use ( $mid ) {
			$p = get_page_by_path( $slug );
			if ( $p && $p->post_status === 'publish' ) {
				return wp_update_nav_menu_item( $mid, 0, array(
					'menu-item-title' => $label, 'menu-item-object' => 'page', 'menu-item-object-id' => $p->ID,
					'menu-item-type' => 'post_type', 'menu-item-status' => 'publish', 'menu-item-parent-id' => $parent,
				) );
			}
			return wp_update_nav_menu_item( $mid, 0, array(
				'menu-item-title' => $label, 'menu-item-url' => home_url( '/' . $slug . '/' ),
				'menu-item-type' => 'custom', 'menu-item-status' => 'publish', 'menu-item-parent-id' => $parent,
			) );
		};
		wp_update_nav_menu_item( $mid, 0, array( 'menu-item-title' => 'Home', 'menu-item-url' => home_url( '/' ), 'menu-item-type' => 'custom', 'menu-item-status' => 'publish' ) );
		$page( 'about', 'About' );
		$page( 'meghna-singh', 'Our Mentor' );
		$page( 'pricing', 'Packages' );
		$svc = $page( 'services', 'Services' );
		$page( 'corporate-tournament', 'Corporate Tournament', $svc );
		$page( 'workshops', 'Workshops', $svc );
		$page( 'guest-lectures', 'Guest Lectures', $svc );
		$res = wp_update_nav_menu_item( $mid, 0, array( 'menu-item-title' => 'Resources', 'menu-item-url' => '#', 'menu-item-type' => 'custom', 'menu-item-status' => 'publish' ) );
		$page( 'gallery', 'Gallery', $res );
		$page( 'coaches', 'Team', $res );
		$page( 'faq', 'FAQ', $res );
		$page( 'blog', 'Blog', $res );
		$page( 'contact', 'Contact' );

		$loc = get_theme_mod( 'nav_menu_locations', array() );
		$loc['primary'] = $mid;
		set_theme_mod( 'nav_menu_locations', $loc );
		$log[] = 'Menu "' . $name . '" rebuilt and assigned to Primary Menu';
	} else {
		$log[] = 'FAILED to create the menu';
	}

	flush_rewrite_rules( false );
	$log[] = 'Permalinks refreshed';
	return $log;
}

add_action( 'admin_menu', function () {
	add_theme_page( 'Velocrix Setup', 'Velocrix Setup', 'manage_options', 'vx-setup', 'vx_setup_screen' );
} );

function vx_setup_screen() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	$log = get_transient( 'vx_setup_log_' . get_current_user_id() );
	if ( $log ) delete_transient( 'vx_setup_log_' . get_current_user_id() );
	?>
	<div class="wrap">
		<h1>Velocrix Setup</h1>
		<?php if ( $log ) : ?>
			<div class="notice notice-success"><p><b>Setup finished.</b></p><ul style="list-style:disc;margin-left:22px"><?php foreach ( $log as $l ) echo '<li>' . esc_html( $l ) . '</li>'; ?></ul>
			<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener">View site</a> &middot; <a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>">Check menu</a></p></div>
		<?php endif; ?>
		<p>One click to bring this site in line with the final design. It will:</p>
		<ul style="list-style:disc;margin-left:22px">
			<li>Create the pages that are missing: Services, Corporate Tournament, Workshops, Guest Lectures, FAQ (and the core pages if absent).</li>
			<li>Move the retired pages (Programs, Facilities, Admission, Achievements) to <b>Draft</b>. Nothing is deleted.</li>
			<li>Move the default <b>Sample Page</b> to the trash.</li>
			<li>Build the menu <b>Velocrix Primary</b> (Home, About, Our Mentor, Packages, Services &#9662;, Resources &#9662;, Contact) and assign it to the Primary Menu location. Your old menu is kept.</li>
		</ul>
		<p>It does <b>not</b> change the content of existing pages, enquiries, users or settings. Safe to run again.</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="vx_setup">
			<?php wp_nonce_field( 'vx_setup', 'vx_setup_nonce' ); ?>
			<?php submit_button( 'Run Velocrix Setup', 'primary large' ); ?>
		</form>
	</div>
	<?php
}

add_action( 'admin_post_vx_setup', function () {
	if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['vx_setup_nonce'] ) || ! wp_verify_nonce( $_POST['vx_setup_nonce'], 'vx_setup' ) ) {
		wp_die( 'Not allowed.', 403 );
	}
	set_transient( 'vx_setup_log_' . get_current_user_id(), vx_run_setup(), 300 );
	wp_safe_redirect( admin_url( 'themes.php?page=vx-setup' ) );
	exit;
} );

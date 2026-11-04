<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enquiry / admission forms, plain PHP (no form plugin).
 * Every submission is saved in WP Admin > Enquiries AND emailed.
 */

function vx_register_enquiry_cpt() {
	register_post_type( 'vx_enquiry', array(
		'labels'       => array( 'name' => 'Enquiries', 'singular_name' => 'Enquiry' ),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-email-alt',
		'menu_position'=> 25,
		'supports'     => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities' => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap' => true,
	) );
}
add_action( 'init', 'vx_register_enquiry_cpt' );

/** Render a form. $type = 'contact' | 'admission' */
function vx_form( $type = 'contact' ) {
	$state = isset( $_GET['vx'] ) ? sanitize_key( $_GET['vx'] ) : '';
	if ( $state === 'sent' ) {
		echo '<div class="notice ok">Thank you! Your message has been received. We will contact you shortly.</div>';
	} elseif ( $state === 'err' ) {
		echo '<div class="notice err">Please fill in your name and a valid phone number, then try again.</div>';
	}
	?>
	<form class="vx-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="vx_enquiry">
		<input type="hidden" name="form_type" value="<?php echo esc_attr( $type ); ?>">
		<input type="hidden" name="_back" value="<?php echo esc_url( get_permalink() ); ?>">
		<?php wp_nonce_field( 'vx_enquiry', 'vx_nonce' ); ?>
		<div class="hp" aria-hidden="true"><label>Leave empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

		<div class="grid-2">
			<label><span><?php echo $type === 'admission' ? 'Player name' : 'Your name'; ?> *</span><input type="text" name="name" required></label>
			<label><span>Phone *</span><input type="tel" name="phone" required></label>
		</div>
		<div class="grid-2">
			<label><span>Email</span><input type="email" name="email"></label>
			<?php if ( $type === 'admission' ) : ?>
				<label><span>Player age</span><input type="number" name="age" min="4" max="60"></label>
			<?php else : ?>
				<label><span>Subject</span><input type="text" name="subject"></label>
			<?php endif; ?>
		</div>
		<?php if ( $type === 'admission' ) : ?>
		<div class="grid-2">
			<label><span>Interested plan</span>
				<select name="plan">
					<option value="">Not sure yet</option>
					<?php foreach ( vx_plans() as $p ) echo '<option>' . esc_html( $p['name'] ) . '</option>'; ?>
				</select>
			</label>
			<label><span>Experience level</span>
				<select name="level"><option>Beginner</option><option>Intermediate</option><option>Advanced</option></select>
			</label>
		</div>
		<?php endif; ?>
		<label><span>Message</span><textarea name="message" rows="4"></textarea></label>
		<button class="btn" type="submit"><?php echo $type === 'admission' ? 'Register Now' : 'Send Message'; ?></button>
	</form>
	<?php
}

function vx_handle_enquiry() {
	$back = isset( $_POST['_back'] ) ? esc_url_raw( wp_unslash( $_POST['_back'] ) ) : home_url( '/' );
	$back = wp_validate_redirect( $back, home_url( '/' ) );

	if ( ! isset( $_POST['vx_nonce'] ) || ! wp_verify_nonce( $_POST['vx_nonce'], 'vx_enquiry' ) ) {
		wp_safe_redirect( add_query_arg( 'vx', 'err', $back ) ); exit;
	}
	if ( ! empty( $_POST['website'] ) ) { // honeypot: bots fill this
		wp_safe_redirect( add_query_arg( 'vx', 'sent', $back ) ); exit;
	}

	$f = function ( $k ) { return isset( $_POST[ $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) : ''; };
	$name  = $f( 'name' );
	$phone = $f( 'phone' );
	if ( $name === '' || strlen( preg_replace( '/\D/', '', $phone ) ) < 8 ) {
		wp_safe_redirect( add_query_arg( 'vx', 'err', $back ) . '#form' ); exit;
	}

	$type  = $f( 'form_type' ) === 'admission' ? 'Admission' : 'Contact';
	$email = sanitize_email( $f( 'email' ) );
	$lines = array(
		"Type: $type", "Name: $name", "Phone: $phone", "Email: $email",
		'Age: ' . $f( 'age' ), 'Plan: ' . $f( 'plan' ), 'Level: ' . $f( 'level' ),
		'Subject: ' . $f( 'subject' ), '',
		isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '',
	);
	$body = implode( "\n", $lines );

	wp_insert_post( array(
		'post_type'    => 'vx_enquiry',
		'post_status'  => 'publish',
		'post_title'   => "$type: $name ($phone)",
		'post_content' => $body,
	) );

	$to = vx( 'vx_email', get_option( 'admin_email' ) );
	$headers = array();
	if ( $email ) $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
	wp_mail( $to, "[Velocrix] New $type enquiry: $name", $body, $headers );

	wp_safe_redirect( add_query_arg( 'vx', 'sent', $back ) . '#form' ); exit;
}
add_action( 'admin_post_nopriv_vx_enquiry', 'vx_handle_enquiry' );
add_action( 'admin_post_vx_enquiry', 'vx_handle_enquiry' );

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* =====================================================================
 * TRAINEE REGISTRATION  (page: /registration/)
 * Plain PHP, no plugin. Saved to WP Admin > Enquiries (with photo) + emailed.
 * ===================================================================== */

/** Rules & terms from the official Trainee Registration Form (page 2). */
function vx_terms() {
	return array(
		'Trainee will have to be in their proper sports uniform.',
		'All the trainees will have to adhere to the scheduled timings.',
		'Any trainee not coming for coaching shall intimate the coach at least 5 hours in advance.',
		'Trainee will have to maintain the discipline of Velocrix Cricket Academy, and if found otherwise would be expelled from the coaching.',
		'Trainee will attend all training and events set forth by the Coach.',
		'Trainee will approach training and matches with a professional attitude and apply them accordingly.',
		'Velocrix Cricket Academy shall not be responsible for any loss or untoward incident to any trainee while coming to or going from the Velocrix Cricket Academy.',
		'Parents are not allowed to stay in the field at the time of coaching.',
		'Though the endeavour of Velocrix Cricket Academy is to provide quality coaching to the trainees, the Academy does not guarantee any selection and is not responsible in any manner.',
		'There will be no refund of fee on any account, therefore parents are requested to deposit fee after careful consideration.',
		'Management reserves the right to change the rules and regulations at any time without prior notice.',
		'Trainees should deposit their fees between the 1st and 5th of every month; after that Rs. 50/- per day will be charged as fine.',
		'Velocrix Cricket Academy is not responsible for any injury during practice as well as during matches.',
		'Trainee should be regular in the coaching. If a trainee is absent for one month he/she should submit 50% fees, and if there is a gap of two months or more then re-registration has to be done by the trainee for rejoining.',
	);
}

/** Allowed values for the choice fields */
function vx_reg_options() {
	return array(
		'gender' => array( 'Male', 'Female' ),
		'blood'  => array( 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Not sure' ),
		'bat'    => array( 'Right hand', 'Left hand' ),
		'bowl'   => array( 'Right arm', 'Left arm', 'Undefined' ),
		'prof'   => array( 'Medium pace', 'Fast', 'Off spinner', 'Leg spinner', 'Undefined' ),
		'keeper' => array( 'Yes', 'No' ),
	);
}

/** Handles the POST from the registration form */
function vx_handle_registration() {
	$back = home_url( '/registration/' );
	$min  = defined( 'MINUTE_IN_SECONDS' ) ? MINUTE_IN_SECONDS : 60;

	$fail = function ( $errors, $data ) use ( $back, $min ) {
		$key = strtolower( wp_generate_password( 14, false ) );
		set_transient( 'vx_reg_' . $key, array( 'data' => $data, 'errors' => $errors ), 15 * $min );
		wp_safe_redirect( add_query_arg( 'vxk', $key, $back ) . '#form' );
		exit;
	};

	$f    = function ( $k ) { return isset( $_POST[ $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) : ''; };
	$data = array();
	foreach ( array( 'name', 'dob', 'gender', 'blood', 'father', 'mother', 'phone', 'email', 'bat', 'bowl', 'prof', 'keeper', 'plan', 'signed' ) as $k ) {
		$data[ $k ] = $f( $k );
	}
	$data['address'] = isset( $_POST['address'] ) ? sanitize_textarea_field( wp_unslash( $_POST['address'] ) ) : '';
	$data['declare'] = ! empty( $_POST['declare'] ) ? 1 : 0;
	$data['agree']   = ! empty( $_POST['agree'] ) ? 1 : 0;

	if ( ! isset( $_POST['vx_nonce'] ) || ! wp_verify_nonce( $_POST['vx_nonce'], 'vx_registration' ) ) {
		$fail( array( 'Your session expired. Please submit the form again.' ), $data );
	}
	if ( ! empty( $_POST['website'] ) ) { // honeypot: bots fill this
		wp_safe_redirect( add_query_arg( 'vx', 'sent', $back ) );
		exit;
	}

	// simple rate limit: 5 submissions per hour per IP
	$ipk = 'vx_rl_' . md5( isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : 'x' );
	$cnt = (int) get_transient( $ipk );
	if ( $cnt >= 5 ) $fail( array( 'Too many submissions from this device. Please try again later or call us.' ), $data );
	set_transient( $ipk, $cnt + 1, 60 * $min );

	$opt = vx_reg_options();
	$e   = array();

	if ( strlen( $data['name'] ) < 2 ) $e[] = "Please enter the trainee's name.";

	$dob_ok = false;
	if ( preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $data['dob'], $m ) && checkdate( (int) $m[2], (int) $m[3], (int) $m[1] ) ) {
		$ts     = strtotime( $data['dob'] );
		$dob_ok = ( $ts && $ts <= time() && (int) $m[1] >= 1960 );
	}
	if ( ! $dob_ok ) $e[] = 'Please enter a valid date of birth.';

	if ( ! in_array( $data['gender'], $opt['gender'], true ) ) $e[] = 'Please select gender.';
	if ( ! in_array( $data['blood'], $opt['blood'], true ) ) $e[] = 'Please select blood group.';
	if ( strlen( $data['father'] ) < 2 ) $e[] = "Please enter father's name.";
	if ( strlen( $data['mother'] ) < 2 ) $e[] = "Please enter mother's name.";
	if ( strlen( preg_replace( '/\D/', '', $data['phone'] ) ) < 10 ) $e[] = 'Please enter a valid 10-digit contact number.';
	if ( $data['email'] !== '' && ! is_email( $data['email'] ) ) $e[] = 'Please enter a valid email address or leave it empty.';
	if ( strlen( $data['address'] ) < 8 ) $e[] = 'Please enter the residential & communication address.';

	$labels = array( 'bat' => 'batting style', 'bowl' => 'bowling style', 'prof' => 'proficiency in bowling', 'keeper' => 'wicket keeping' );
	foreach ( $labels as $k => $lbl ) {
		if ( ! in_array( $data[ $k ], $opt[ $k ], true ) ) $e[] = 'Please select ' . $lbl . '.';
	}

	$plans = wp_list_pluck( vx_plans(), 'name' );
	if ( $data['plan'] !== '' && ! in_array( $data['plan'], $plans, true ) ) $data['plan'] = '';

	if ( strlen( $data['signed'] ) < 2 ) $e[] = "Please type the parent/guardian's full name as signature.";
	if ( ! $data['declare'] ) $e[] = 'Please tick the declaration.';
	if ( ! $data['agree'] ) $e[] = 'Please confirm that you have read and agree to the rules and terms.';

	// optional passport-size photo (JPG/PNG, max 2 MB)
	$has_photo = ! empty( $_FILES['photo']['name'] ) && isset( $_FILES['photo']['error'] ) && (int) $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;
	if ( $has_photo ) {
		if ( (int) $_FILES['photo']['error'] !== UPLOAD_ERR_OK ) {
			$e[] = 'The photo could not be uploaded. Please try a smaller JPG or PNG file.';
		} elseif ( $_FILES['photo']['size'] > 2 * 1024 * 1024 ) {
			$e[] = 'The photo is larger than 2 MB.';
		} else {
			$chk = wp_check_filetype_and_ext( $_FILES['photo']['tmp_name'], $_FILES['photo']['name'], array( 'jpg|jpeg' => 'image/jpeg', 'png' => 'image/png' ) );
			if ( empty( $chk['ext'] ) || empty( $chk['type'] ) || ! @getimagesize( $_FILES['photo']['tmp_name'] ) ) {
				$e[] = 'Photo must be a JPG or PNG image.';
			}
		}
	}

	if ( $e ) $fail( $e, $data );

	// ---- save
	$lines = array(
		'TRAINEE REGISTRATION',
		'Name: ' . $data['name'],
		'Date of birth: ' . $data['dob'],
		'Gender: ' . $data['gender'],
		'Blood group: ' . $data['blood'],
		"Father's name: " . $data['father'],
		"Mother's name: " . $data['mother'],
		'Contact number: ' . $data['phone'],
		'Email: ' . $data['email'],
		'Address: ' . str_replace( array( "\r", "\n" ), ', ', $data['address'] ),
		'Batting style: ' . $data['bat'],
		'Bowling style: ' . $data['bowl'],
		'Proficiency in bowling: ' . $data['prof'],
		'Wicket keeping: ' . $data['keeper'],
		'Interested plan: ' . ( $data['plan'] ? $data['plan'] : 'Not selected' ),
		'Declaration accepted: Yes',
		'Rules & terms accepted: Yes',
		'Parent/Guardian (digital signature): ' . $data['signed'],
		'Submitted: ' . current_time( 'Y-m-d H:i' ),
	);

	$post_id = wp_insert_post( array(
		'post_type'    => 'vx_enquiry',
		'post_status'  => 'publish',
		'post_title'   => 'Registration: ' . $data['name'],
		'post_content' => implode( "\n", $lines ),
	) );
	if ( ! $post_id || is_wp_error( $post_id ) ) $fail( array( 'We could not save your form. Please try again or call us.' ), $data );

	$ref = 'VCA-' . gmdate( 'y' ) . '-' . str_pad( (string) $post_id, 4, '0', STR_PAD_LEFT );
	update_post_meta( $post_id, 'vx_ref', $ref );
	update_post_meta( $post_id, 'vx_form', 'registration' );
	wp_update_post( array( 'ID' => $post_id, 'post_title' => "Registration $ref: " . $data['name'] ) );

	// Photo goes to a PRIVATE folder (not the media library, not publicly reachable)
	$attach = array();
	$tmp_mail_photo = '';
	if ( $has_photo ) {
		$stored = vx_store_private_photo( $_FILES['photo']['tmp_name'], $post_id );
		if ( $stored ) {
			update_post_meta( $post_id, 'vx_photo_file', $stored );
			$tmp_mail_photo = vx_private_photo_temp_copy( $stored, $ref );
			if ( $tmp_mail_photo ) $attach[] = $tmp_mail_photo;
			wp_update_post( array( 'ID' => $post_id, 'post_content' => implode( "\n", $lines ) . "\nPhoto: uploaded (view it on this entry in WP Admin)" ) );
		}
	}

	// ---- emails
	$to  = vx( 'vx_email', get_option( 'admin_email' ) );
	$hdr = array();
	if ( $data['email'] ) $hdr[] = 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>';
	wp_mail( $to, "[Velocrix] New registration $ref: " . $data['name'], implode( "\n", $lines ) . ( $attach ? "\nPhoto: attached" : '' ), $hdr, $attach );
	if ( $tmp_mail_photo && file_exists( $tmp_mail_photo ) ) @unlink( $tmp_mail_photo );
	if ( $data['email'] ) {
		wp_mail(
			$data['email'],
			"Velocrix Cricket Academy: registration received ($ref)",
			"Hello,\n\nThank you for registering " . $data['name'] . " at Velocrix Cricket Academy.\nYour reference number is $ref.\n\nOur team will contact you on " . $data['phone'] . " shortly.\nFor any query call " . vx( 'vx_phone' ) . ".\n\nChampions are not born, they are trained!\nVelocrix Cricket Academy"
		);
	}

	wp_safe_redirect( add_query_arg( array( 'vx' => 'sent', 'ref' => rawurlencode( $ref ) ), $back ) );
	exit;
}
add_action( 'admin_post_nopriv_vx_registration', 'vx_handle_registration' );
add_action( 'admin_post_vx_registration', 'vx_handle_registration' );

/** Small helpers used by the form template */
function vx_reg_state() {
	$state = array( 'sent' => false, 'ref' => '', 'errors' => array(), 'old' => array() );
	if ( isset( $_GET['vx'] ) && sanitize_key( $_GET['vx'] ) === 'sent' ) {
		$state['sent'] = true;
		$state['ref']  = isset( $_GET['ref'] ) ? sanitize_text_field( wp_unslash( rawurldecode( $_GET['ref'] ) ) ) : '';
		if ( ! preg_match( '/^VCA-\d{2}-\d{4,}$/', $state['ref'] ) ) $state['ref'] = '';
	} elseif ( isset( $_GET['vxk'] ) ) {
		$t = get_transient( 'vx_reg_' . sanitize_key( $_GET['vxk'] ) );
		if ( is_array( $t ) ) { $state['errors'] = $t['errors']; $state['old'] = $t['data']; }
	}
	return $state;
}

/* =====================================================================
 * PRIVATE PHOTO STORAGE
 * Photos are re-encoded (max 600px, metadata/GPS removed), stored under a random
 * name with a non-image extension in wp-content/uploads/vx-private/, blocked from
 * direct web access, and shown only to logged-in admins on the Enquiry screen.
 * ===================================================================== */

function vx_private_dir() {
	$u   = wp_upload_dir( null, false );
	$dir = trailingslashit( $u['basedir'] ) . 'vx-private';
	if ( ! is_dir( $dir ) ) {
		wp_mkdir_p( $dir );
	}
	// Block direct access (Apache) + no directory listing
	if ( ! file_exists( $dir . '/.htaccess' ) ) {
		@file_put_contents( $dir . '/.htaccess', "Options -Indexes\n<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nOrder allow,deny\nDeny from all\n</IfModule>\n" );
	}
	if ( ! file_exists( $dir . '/index.html' ) ) {
		@file_put_contents( $dir . '/index.html', '' );
	}
	return $dir;
}

/** Re-encode the uploaded image and save it privately. Returns the stored file name or ''. */
function vx_store_private_photo( $tmp_path, $post_id ) {
	if ( ! $tmp_path || ! is_uploaded_file( $tmp_path ) && ! file_exists( $tmp_path ) ) return '';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$dir  = vx_private_dir();
	$name = wp_generate_password( 32, false, false ) . '.vxp';
	$dest = $dir . '/' . $name;

	$editor = wp_get_image_editor( $tmp_path );
	if ( ! is_wp_error( $editor ) ) {
		$editor->resize( 600, 800, false );
		$editor->set_quality( 85 );
		$tmp_jpg = wp_tempnam( 'vxphoto' ) . '.jpg';
		$saved   = $editor->save( $tmp_jpg, 'image/jpeg' );        // re-encoding drops EXIF/GPS
		if ( ! is_wp_error( $saved ) && ! empty( $saved['path'] ) && file_exists( $saved['path'] ) ) {
			$ok = @rename( $saved['path'], $dest ) || ( @copy( $saved['path'], $dest ) && @unlink( $saved['path'] ) );
			if ( $ok ) return $name;
		}
	}
	// Fallback: keep the original bytes (already validated as an image above)
	return @move_uploaded_file( $tmp_path, $dest ) || @copy( $tmp_path, $dest ) ? $name : '';
}

/** Temporary .jpg copy, used only as an email attachment */
function vx_private_photo_temp_copy( $stored, $ref ) {
	$src = vx_private_dir() . '/' . basename( $stored );
	if ( ! file_exists( $src ) ) return '';
	$tmp = trailingslashit( get_temp_dir() ) . sanitize_file_name( $ref ) . '-photo.jpg';
	return @copy( $src, $tmp ) ? $tmp : '';
}

/** Admin-only image viewer: admin-post.php?action=vx_reg_photo&id=123&_wpnonce=... */
function vx_serve_private_photo() {
	if ( ! is_user_logged_in() || ! current_user_can( 'edit_others_posts' ) ) {
		wp_die( 'Forbidden', 'Forbidden', array( 'response' => 403 ) );
	}
	$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
	if ( ! $id || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'vx_photo_' . $id ) ) {
		wp_die( 'Link expired. Reopen the entry and try again.', 'Forbidden', array( 'response' => 403 ) );
	}
	$file = get_post_meta( $id, 'vx_photo_file', true );
	$path = $file ? vx_private_dir() . '/' . basename( $file ) : '';
	if ( ! $path || ! file_exists( $path ) ) {
		wp_die( 'Photo not found.', 'Not found', array( 'response' => 404 ) );
	}
	nocache_headers();
	header( 'Content-Type: image/jpeg' );
	header( 'X-Content-Type-Options: nosniff' );
	header( 'Content-Length: ' . filesize( $path ) );
	readfile( $path );
	exit;
}
add_action( 'admin_post_vx_reg_photo', 'vx_serve_private_photo' );

/** Show the photo (admin only) on the Enquiry edit screen */
function vx_photo_metabox() {
	add_meta_box( 'vx_photo', 'Trainee photo (private)', function ( $post ) {
		$file = get_post_meta( $post->ID, 'vx_photo_file', true );
		if ( ! $file ) { echo '<p>No photo uploaded.</p>'; return; }
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=vx_reg_photo&id=' . $post->ID ), 'vx_photo_' . $post->ID );
		echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener"><img src="' . esc_url( $url ) . '" alt="Trainee photo" style="max-width:100%;height:auto;border-radius:6px"></a>';
		echo '<p class="description">Visible only to logged-in administrators.</p>';
	}, 'vx_enquiry', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'vx_photo_metabox' );

/** Delete the private photo when the entry is deleted */
function vx_delete_private_photo( $post_id ) {
	if ( get_post_type( $post_id ) !== 'vx_enquiry' ) return;
	$file = get_post_meta( $post_id, 'vx_photo_file', true );
	if ( $file ) {
		$p = vx_private_dir() . '/' . basename( $file );
		if ( file_exists( $p ) ) @unlink( $p );
	}
}
add_action( 'before_delete_post', 'vx_delete_private_photo' );

<?php
get_header();
$img   = VX_URI . '/assets/img/';
$st    = vx_reg_state();
$old   = $st['old'];
$opt   = vx_reg_options();
$phone = vx( 'vx_phone' );
$o     = function ( $k ) use ( $old ) { return isset( $old[ $k ] ) ? $old[ $k ] : ''; };

// 1. HERO (shared part)
get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'Trainee Registration',
	'title'   => 'Begin Your Cricket<br>Journey with Velocrix',
	'text'    => 'Fill in the registration form below. Our team will contact you to confirm the batch and complete your admission.',
	'image'   => $img . 'hero-pricing.jpg',
) );

/** radio chips */
function vx_chips( $name, $values, $selected ) {
	echo '<div class="chips">';
	foreach ( $values as $v ) {
		echo '<label class="chip-opt"><input type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $v ) . '"' . checked( $selected, $v, false ) . ' required><span>' . esc_html( $v ) . '</span></label>';
	}
	echo '</div>';
}
?>

<section class="section dark reg-sec" id="form">
	<div class="container reg-grid">

		<aside class="reg-aside">
			<span class="eyebrow">How it works</span>
			<h2>Three simple steps</h2>
			<ol class="reg-steps">
				<li><span>1</span><div><b>Fill the form</b><small>Trainee, parent and playing details.</small></div></li>
				<li><span>2</span><div><b>Accept the terms</b><small>Read the academy rules and tick the declaration.</small></div></li>
				<li><span>3</span><div><b>We contact you</b><small>Our team calls to confirm the batch and fees.</small></div></li>
			</ol>
			<div class="reg-fee">
				<small>Registration fee</small>
				<strong>&#8377;<?php echo esc_html( vx( 'vx_regfee' ) ); ?></strong>
				<span>Early bird discount available. Terms &amp; conditions apply.</span>
			</div>
			<p class="reg-help">Need help? Call <a href="<?php echo esc_url( vx_phone_href( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a><?php if ( $e = vx( 'vx_email' ) ) : ?> or write to <a href="mailto:<?php echo esc_attr( $e ); ?>"><?php echo esc_html( $e ); ?></a><?php endif; ?></p>
		</aside>

		<div class="talk-card reg-card">
		<?php if ( $st['sent'] ) : ?>
			<div class="reg-done">
				<span class="done-ico"><?php echo vx_icon( 'check' ); // phpcs:ignore ?></span>
				<h2>Registration received!</h2>
				<?php if ( $st['ref'] ) : ?><p class="done-ref">Your reference number<b><?php echo esc_html( $st['ref'] ); ?></b></p><?php endif; ?>
				<p>Thank you for registering with Velocrix Cricket Academy. Our team will contact you shortly on the number you provided to confirm the batch and fees.</p>
				<div class="btn-row">
					<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to Home</a>
					<a class="btn btn-ghost" href="<?php echo esc_url( vx_phone_href( $phone ) ); ?>">Call <?php echo esc_html( $phone ); ?></a>
				</div>
			</div>
		<?php else : ?>
			<h2>Trainee Registration Form</h2>
			<p class="reg-sub">Fields marked <span class="req">*</span> are required.</p>

			<?php if ( $st['errors'] ) : ?>
				<div class="notice err" role="alert"><b>Please fix the following:</b>
					<ul><?php foreach ( $st['errors'] as $er ) echo '<li>' . esc_html( $er ) . '</li>'; ?></ul>
				</div>
			<?php endif; ?>

			<form class="talk-form reg-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="action" value="vx_registration">
				<?php wp_nonce_field( 'vx_registration', 'vx_nonce' ); ?>
				<div class="hp" aria-hidden="true"><label>Leave empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

				<!-- 01 Personal -->
				<fieldset class="reg-block">
					<legend><span class="num">01</span> Personal details</legend>
					<div class="personal-grid">
						<div class="personal-fields">
							<label><span>Name <i class="req">*</i></span><input type="text" name="name" value="<?php echo esc_attr( $o( 'name' ) ); ?>" placeholder="Trainee's full name" required autocomplete="off"></label>
							<div class="tf-row">
								<label><span>Date of birth <i class="req">*</i></span><input type="date" name="dob" value="<?php echo esc_attr( $o( 'dob' ) ); ?>" min="1960-01-01" max="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>" required></label>
								<label><span>Blood group <i class="req">*</i></span>
									<select name="blood" required><option value="">Select</option><?php foreach ( $opt['blood'] as $b ) echo '<option value="' . esc_attr( $b ) . '"' . selected( $o( 'blood' ), $b, false ) . '>' . esc_html( $b ) . '</option>'; ?></select></label>
							</div>
							<div class="fld"><span class="lbl">Gender <i class="req">*</i></span><?php vx_chips( 'gender', $opt['gender'], $o( 'gender' ) ); ?></div>
						</div>
						<label class="photo-drop" for="photo">
							<input type="file" id="photo" name="photo" accept="image/jpeg,image/png">
							<span class="pd-ph"><svg viewBox="0 0 24 24" width="34" height="34" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 8a2 2 0 0 1 2-2h1.5l1.2-1.6A1 1 0 0 1 9.500 4h5a1 1 0 0 1 .8.4L16.500 6H18a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8Z"/><circle cx="12" cy="12.500" r="3.500"/></svg><b>Passport-size photo</b><small>JPG or PNG, max 2 MB (optional)</small></span>
							<img class="pd-prev" alt="Selected photo preview" hidden>
						</label>
					</div>
					<div class="tf-row">
						<label><span>Father's name <i class="req">*</i></span><input type="text" name="father" value="<?php echo esc_attr( $o( 'father' ) ); ?>" placeholder="Father's full name" required autocomplete="off"></label>
						<label><span>Mother's name <i class="req">*</i></span><input type="text" name="mother" value="<?php echo esc_attr( $o( 'mother' ) ); ?>" placeholder="Mother's full name" required autocomplete="off"></label>
					</div>
					<div class="tf-row">
						<label><span>Contact number <i class="req">*</i></span><input type="tel" name="phone" value="<?php echo esc_attr( $o( 'phone' ) ); ?>" placeholder="10-digit mobile number" inputmode="tel" required autocomplete="tel"></label>
						<label><span>Email address</span><input type="email" name="email" value="<?php echo esc_attr( $o( 'email' ) ); ?>" placeholder="For confirmation (optional)" autocomplete="email"></label>
					</div>
				</fieldset>

				<!-- 02 Address -->
				<fieldset class="reg-block">
					<legend><span class="num">02</span> Residential &amp; communication detail</legend>
					<label><span>Full address <i class="req">*</i></span><textarea name="address" rows="4" placeholder="House no., street, society, city, PIN code" required><?php echo esc_textarea( $o( 'address' ) ); ?></textarea></label>
				</fieldset>

				<!-- 03 Playing -->
				<fieldset class="reg-block">
					<legend><span class="num">03</span> Playing details</legend>
					<div class="fld"><span class="lbl">Batting style <i class="req">*</i></span><?php vx_chips( 'bat', $opt['bat'], $o( 'bat' ) ); ?></div>
					<div class="fld"><span class="lbl">Bowling style <i class="req">*</i></span><?php vx_chips( 'bowl', $opt['bowl'], $o( 'bowl' ) ); ?></div>
					<div class="fld"><span class="lbl">Proficiency in bowling <i class="req">*</i></span><?php vx_chips( 'prof', $opt['prof'], $o( 'prof' ) ); ?></div>
					<div class="fld"><span class="lbl">Wicket keeping <i class="req">*</i></span><?php vx_chips( 'keeper', $opt['keeper'], $o( 'keeper' ) ); ?></div>
					<label><span>Training plan you are interested in</span>
						<select name="plan"><option value="">Not sure yet</option>
							<?php $sel = $o( 'plan' ); foreach ( vx_plans() as $p ) echo '<option value="' . esc_attr( $p['name'] ) . '"' . selected( $sel, $p['name'], false ) . '>' . esc_html( $p['name'] . ' (₹' . $p['price'] . ')' ) . '</option>'; ?>
						</select></label>
				</fieldset>

					<!-- 04 Consent (rules open in a dialog) -->
					<fieldset class="reg-block reg-consent">

					<label class="consent"><input type="checkbox" name="agree" value="1" <?php checked( $o( 'agree' ), 1 ); ?> required>
						<span>I/We have read <button type="button" class="terms-link" data-terms-open>the rules, guidelines, terms and conditions</button> of the academy and undertake to abide by them. <i class="req">*</i></span></label>
					<label class="consent"><input type="checkbox" name="declare" value="1" <?php checked( $o( 'declare' ), 1 ); ?> required>
						<span>I/We hereby declare that the date of birth and other relevant information given above is correct to the best of our knowledge. <i class="req">*</i></span></label>

					<label><span>Parent/Guardian's signature (type full name) <i class="req">*</i></span><input type="text" name="signed" value="<?php echo esc_attr( $o( 'signed' ) ); ?>" placeholder="Parent / guardian's full name" required autocomplete="off"></label>
				</fieldset>

				<button class="btn btn-block" type="submit" id="reg-submit">Submit Registration</button>
				<p class="reg-note">Your details are used only for academy admission and are not shared with anyone else.</p>
			</form>
		<?php endif; ?>
		</div>
	</div>
</section>

<dialog class="terms-dialog" id="terms-dialog" aria-labelledby="terms-title">
	<div class="td-head">
		<h3 id="terms-title">Rules, Guidelines, Terms &amp; Conditions</h3>
		<button type="button" class="td-close" data-terms-close aria-label="Close">&times;</button>
	</div>
	<div class="td-body" tabindex="0">
		<ol><?php foreach ( vx_terms() as $t ) echo '<li>' . esc_html( $t ) . '</li>'; ?></ol>
	</div>
	<div class="td-foot"><button type="button" class="btn btn-sm" data-terms-close>Close</button></div>
</dialog>

<?php get_footer(); ?>

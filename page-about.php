<?php
get_header();
$img         = VX_URI . '/assets/img/';
$mentor_name = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$mentor_role = vx( 'vx_mentor_role', 'International Cricketer' );
$mentor_img  = vx( 'vx_mentor_img' );
$contact     = home_url( '/contact/' );
?>

<!-- 1. HERO -->
<section class="hero hero-about" style="--hero:url('<?php echo esc_url( $img . 'training-1.jpg' ); ?>')">
	<div class="container hero-inner">
		<span class="eyebrow light">About Us</span>
		<div class="ha-row">
			<h1>Where Every Player<br>Connects and Grows<i class="dot">.</i></h1>
			<p class="ha-text">Velocrix brings young cricketers together under expert coaching and a culture of discipline &mdash; building skill, fitness and character on and off the field.</p>
		</div>
	</div>
</section>

<!-- 2. VISION & MISSION -->
<section class="section vm">
	<div class="container vm-grid">
		<div class="vm-left">
			<h3 class="vm-title">Where players train, grow, and compete.</h3>
			<div class="pills"><?php foreach ( array( 'Training', 'Discipline', 'Passion', 'Academy', 'Coaching', 'Cricket' ) as $p ) echo '<span>' . esc_html( $p ) . '</span>'; ?></div>
		</div>
		<a class="vm-card photo" href="<?php echo esc_url( home_url( '/programs/' ) ); ?>">
			<img src="<?php echo esc_url( $img . 'prog-2.jpg' ); ?>" alt="Coach demonstrating a drill to young players" loading="lazy" width="800" height="800">
			<span class="round-btn is-lime"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
			<div class="vm-cap"><h3>Our Vision</h3><p>To nurture disciplined, focused and passionate cricketers who aim to be champions.</p></div>
		</a>
		<a class="vm-card dk" href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">
			<span class="round-btn light"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
			<div class="vm-cap"><h3>Our Mission</h3><p>Expert coaching, scientific training and all-round development for every young cricketer.</p></div>
		</a>
	</div>
</section>

<?php get_template_part( 'template-parts/partners' ); ?>

<!-- 3. IMPACT -->
<section class="section dark impact">
	<div class="container imp-grid">
		<div class="imp-photo">
			<img src="<?php echo esc_url( $img . 'prog-1.jpg' ); ?>" alt="Young cricketers training together" loading="lazy" width="800" height="800">
			<?php if ( $v = vx( 'vx_video' ) ) : ?><a class="play" href="<?php echo esc_url( $v ); ?>" target="_blank" rel="noopener" aria-label="Watch video"><?php echo vx_icon( 'play' ); // phpcs:ignore ?></a><?php endif; ?>
		</div>
		<div class="imp-body">
			<div>
				<span class="eyebrow">Our Impact</span>
				<h2>Strong Culture.<br>Real Growth.</h2>
			</div>
			<div>
				<div class="imp-line"></div>
				<div class="imp-stats">
					<div><b><span data-count="1">1</span></b><small>International Mentor</small></div>
					<div><b><span data-count="4">4</span></b><small>Flexible Plans</small></div>
					<div><b><span data-count="8">8</span></b><small>Core Strengths</small></div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- 4. FAQ -->
<section class="section faq-sec">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">FAQ</span>
			<h2>Get the Answers You Need</h2>
		</div>
		<?php
		$faqs = array(
			array(
				array( 'What do players get at Velocrix?', 'Expert coaching, scientific training, fitness and skill development, and teamwork and character building, all in a professional training environment.' ),
				array( 'Is the registration fee separate?', 'Yes. Registration is a one-time fee of ₹' . vx( 'vx_regfee', '1,999' ) . ' and training plans are paid separately. Early bird discounts may be available, so please confirm current terms with us.' ),
				array( 'How do I register?', 'Fill in the admission form on our Admission page or call us on ' . vx( 'vx_phone', '+91 879 644 7595' ) . ' and our team will guide you.' ),
			),
			array(
				array( 'Who can join the academy?', 'Players of all levels are welcome, from beginners to those aiming for a professional pathway. Contact us to find the right batch.' ),
				array( 'Where is the academy located?', 'At Sarvottam International School, Sector 10 Campus, Greater Noida West.' ),
				array( 'Who mentors the academy?', 'Velocrix functions under the mentorship of ' . $mentor_name . ', ' . $mentor_role . '.' ),
			),
		);
		?>
		<div class="faq-grid">
			<?php foreach ( $faqs as $col ) : ?>
			<div class="acc">
				<?php foreach ( $col as $i => $f ) : $open = ( $i === 0 ); ?>
				<div class="acc-item<?php echo $open ? ' is-open' : ''; ?>">
					<button class="acc-head" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>"><span><?php echo esc_html( $f[0] ); ?></span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
					<div class="acc-body"><div><p><?php echo esc_html( $f[1] ); ?></p></div></div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<p class="center muted faq-more">Have more questions? <a href="<?php echo esc_url( $contact ); ?>">Contact our team</a></p>
	</div>
</section>

<!-- 5. COACHES -->
<section class="section coaches">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Our Coaches</span>
			<h2>Power Your Game with<br>Our Professionals</h2>
		</div>
		<div class="cc-grid">
			<?php
			$coaches = array(
				array( $mentor_name, $mentor_role . ' &amp; Mentor', $mentor_img, true ),
				array( 'Head Coach', 'Profile coming soon', '', false ),
				array( 'Coach', 'Profile coming soon', '', false ),
			);
			foreach ( $coaches as $c ) : ?>
			<article class="cc<?php echo $c[3] ? '' : ' soon'; ?>">
				<div class="cc-photo">
					<?php if ( $c[2] ) : ?><img src="<?php echo esc_url( $c[2] ); ?>" alt="<?php echo esc_attr( $c[0] ); ?>" loading="lazy">
					<?php else : ?><svg class="sil" viewBox="0 0 200 240" aria-hidden="true"><circle cx="100" cy="85" r="48"/><path d="M20 240c0-56 36-92 80-92s80 36 80 92z"/></svg><?php endif; ?>
					<div class="cc-social">
						<?php foreach ( array( 'instagram', 'facebook', 'youtube' ) as $s ) if ( $u = vx( "vx_$s", '#' ) ) echo '<a href="' . esc_url( $u ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( ucfirst( $s ) ) . '">' . vx_icon( $s ) . '</a>'; // phpcs:ignore ?>
					</div>
				</div>
				<a class="cc-name" href="<?php echo esc_url( $contact ); ?>">
					<span><b><?php echo esc_html( $c[0] ); ?></b><small><?php echo wp_kses_post( $c[1] ); ?></small></span>
					<span class="round-btn light"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
				</a>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>

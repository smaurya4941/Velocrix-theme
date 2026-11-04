<?php
get_header();
$img         = VX_URI . '/assets/img/';
$mentor_name = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$mentor_role = vx( 'vx_mentor_role', 'International Cricketer' );
$mentor_img  = vx( 'vx_mentor_img' );
$contact     = home_url( '/contact/' );

// 1. HERO (shared part)
get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'About Us',
	'title'   => 'Where Every Player<br>Connects and Grows',
	'text'    => 'Velocrix brings young cricketers together under expert coaching and a culture of discipline — building skill, fitness and character on and off the field.',
	'image'   => $img . 'training-1.jpg',
) );
?>

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

<?php
// 4. FAQ (shared part)
get_template_part( 'template-parts/faq', null, array( 'faqs' => array(
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
) ) );
?>

<!-- 5. COACHES -->
<section class="section coaches">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Our Coaches</span>
			<h2>Power Your Game with<br>Our Professionals</h2>
		</div>
		<div class="cc-grid">
			<?php foreach ( vx_coaches() as $c ) get_template_part( "template-parts/coach-card", null, $c ); ?>
		</div>
	</div>
</section>

<?php get_template_part( "template-parts/cta" ); ?>

<?php get_footer(); ?>

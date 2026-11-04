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
	'title'   => 'Where Dreams<br>Meet Discipline',
	'text'    => 'Founded by Indian international cricketer ' . $mentor_name . ', Velocrix nurtures the next generation of cricketers through professional coaching, structured training and a performance-driven approach.',
	'image'   => $img . 'training-1.jpg',
) );
?>

<!-- 2. WHO WE ARE -->
<section class="section about-intro">
	<div class="container ai-grid">
		<div class="ai-head">
			<span class="eyebrow">Who We Are</span>
			<h2>Nurturing the Next<br>Generation of Cricketers</h2>
		</div>
		<div class="ai-body">
			<p class="big-text sm">Velocrix Cricket Academy, founded by Indian international cricketer <?php echo esc_html( $mentor_name ); ?>, aims to nurture the next generation of cricketers through professional coaching, structured training and a performance-driven approach.</p>
			<p>The academy focuses on developing strong cricketing fundamentals, fitness, mental resilience, discipline and sportsmanship. Combining international cricket experience with modern training methods, Velocrix aims to create an environment where aspiring players can learn, grow and prepare for competitive cricket.</p>
		</div>
	</div>
</section>

<!-- 3. VISION & MISSION -->
<section class="section vm">
	<div class="container vm-grid">
		<div class="vm-left">
			<h3 class="vm-title">Where players train, grow, and compete.</h3>
			<div class="pills"><?php foreach ( array( 'Cricketing Fundamentals', 'Fitness', 'Mental Resilience', 'Discipline', 'Sportsmanship' ) as $p ) echo '<span>' . esc_html( $p ) . '</span>'; ?></div>
		</div>
		<a class="vm-card photo" href="<?php echo esc_url( home_url( '/services/' ) ); ?>">
			<img src="<?php echo esc_url( $img . 'prog-2.jpg' ); ?>" alt="Coach demonstrating a drill to young players" loading="lazy" width="800" height="800">
			<span class="round-btn is-lime"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
			<div class="vm-cap"><h3>Our Vision</h3><p>To make quality cricket training accessible and help young cricketers turn their potential into performance.</p></div>
		</a>
		<a class="vm-card dk" href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">
			<span class="round-btn light"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
			<div class="vm-cap"><h3>Our Mission</h3><p>Professional coaching, scientific training, real match exposure and a pathway to a brighter future.</p></div>
		</a>
	</div>
</section>

<!-- 4. FOUNDER -->
<section class="section profile founder-tease">
	<div class="container profile-grid">
		<div class="profile-photo">
			<img src="<?php echo esc_url( $mentor_img ); ?>" alt="<?php echo esc_attr( $mentor_name ); ?>, <?php echo esc_attr( $mentor_role ); ?>" loading="lazy" width="384" height="776">
			<div class="profile-tag"><b><?php echo esc_html( $mentor_name ); ?></b><small>Founder &amp; <?php echo esc_html( $mentor_role ); ?></small></div>
		</div>
		<div class="profile-body">
			<span class="eyebrow">Our Founder</span>
			<h2>Experience of the<br>Highest Level</h2>
			<p class="big-text sm"><?php echo esc_html( $mentor_name ); ?> has represented India across Test, ODI and T20I formats, and brings that international and domestic experience to every Velocrix player.</p>
			<div class="btn-row">
				<a class="btn" href="<?php echo esc_url( home_url( '/meghna-singh/' ) ); ?>">Meet Our Mentor</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( $contact ); ?>">Contact Us</a>
			</div>
		</div>
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
					<div><b><span data-count="<?php echo count( vx_copy( 'pillars' ) ); ?>"><?php echo count( vx_copy( 'pillars' ) ); ?></span></b><small>Training Pillars</small></div>
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
		array( 'Is the registration fee separate?', 'Yes. Registration is a one-time fee of ₹' . vx( 'vx_regfee', '1,999' ) . ' and training plans are paid separately. Early bird discount is available and terms & conditions apply, so please confirm current terms with us.' ),
		array( 'How do I register?', 'Fill in the registration form on our Join Now page, call us on ' . vx( 'vx_phone' ) . ' or email ' . vx( 'vx_email' ) . ' and our team will guide you.' ),
	),
	array(
		array( 'Who can join the academy?', 'Aspiring cricketers who want to build skill, fitness and discipline. The 1 Month plan is ideal for beginners to explore and build basics. Contact us to find the right plan.' ),
		array( 'Where is the academy located?', vx( 'vx_address' ) . '.' ),
		array( 'Who mentors the academy?', 'Velocrix was founded by ' . $mentor_name . ', an Indian international cricketer, who also mentors the academy.' ),
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

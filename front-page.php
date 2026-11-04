<?php
get_header();
$hero = vx( 'vx_hero_img' ) ?: VX_URI . '/assets/img/training-1.jpg';
$mentor_img = vx( 'vx_mentor_img' );
$plans = vx_plans();
?>

<!-- HERO -->
<section class="hero" style="--hero:url('<?php echo esc_url( $hero ); ?>')">
	<div class="streaks" aria-hidden="true"></div>
	<div class="container hero-inner">
		<span class="eyebrow"><?php echo esc_html( vx( 'vx_hero_eyebrow', 'Under the mentorship of Ms. Meghna Singh' ) ); ?></span>
		<h1><?php echo vx_lime( vx( 'vx_hero_title', 'Champions are not born, *they are trained!*' ) ); // phpcs:ignore ?></h1>
		<p class="lead"><?php echo esc_html( vx( 'vx_hero_sub', 'Expert coaching, scientific training and all-round development for young cricketers.' ) ); ?></p>
		<div class="btn-row">
			<a class="btn" href="<?php echo esc_url( home_url( '/admission/' ) ); ?>"><?php echo esc_html( vx( 'vx_hero_btn', 'Join the Academy' ) ); ?></a>
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/programs/' ) ); ?>">View Programs</a>
		</div>
		<ul class="hero-pills">
			<li>Expert Coaching</li><li>Scientific Training</li><li>All-Round Development</li>
		</ul>
	</div>
	<div class="hero-card">
		<small>Registration Fee</small>
		<strong>&#8377;<?php echo esc_html( vx( 'vx_regfee', '1,999' ) ); ?></strong>
		<span>Early bird discount available</span>
	</div>
</section>

<!-- ABOUT -->
<section class="section">
	<div class="container split">
		<div class="photos">
			<img class="p1" src="<?php echo esc_url( VX_URI . '/assets/img/training-2-sm.jpg' ); ?>" alt="Young players warming up with their coach" loading="lazy" width="800" height="600">
			<img class="p2" src="<?php echo esc_url( VX_URI . '/assets/img/training-1-sm.jpg' ); ?>" alt="Coach leading a stretching drill on the ground" loading="lazy" width="800" height="600">
			<div class="badge"><b data-count="1">1</b><span>International Cricketer as Mentor</span></div>
		</div>
		<div>
			<?php vx_heading( 'About Us', 'Where talent meets <span class="lime">discipline</span>' ); ?>
			<p>Velocrix Cricket Academy is based at Sarvottam International School, Sector 10 Campus, Greater Noida West. We combine expert coaching, scientific training and a professional environment to help every player grow in skill, fitness and character.</p>
			<p class="muted">Train hard. Learn smart. Improve every day. Achieve greatness.</p>
			<div class="stats">
				<div><b data-count="4">4</b><span>Flexible plans</span></div>
				<div><b data-count="8">8</b><span>Core strengths</span></div>
				<div><b data-count="3">3</b><span>Training pillars</span></div>
			</div>
			<a class="btn" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">Discover More</a>
		</div>
	</div>
</section>

<!-- WHY -->
<section class="section dark">
	<div class="container">
		<?php vx_heading( 'Why Choose Us', 'Experience the <span class="lime">Velocrix</span> difference', true ); ?>
		<div class="grid-4">
			<?php
			$why = array(
				array( 'Expert Coaching', 'Qualified, experienced coaches guide every session with a clear plan for each player.' ),
				array( 'International Standards', 'Exposure to training methods and standards followed at the top level of the game.' ),
				array( 'Professional Environment', 'A disciplined, well-equipped setting that builds focus and confidence.' ),
				array( 'Pathway to a Career', 'A structured route for passionate players who want to take cricket further.' ),
			);
			foreach ( $why as $i => $w ) : ?>
			<article class="card num-card">
				<span class="num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
				<h3><?php echo esc_html( $w[0] ); ?></h3>
				<p><?php echo esc_html( $w[1] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- PROGRAMS -->
<section class="section">
	<div class="container">
		<div class="sec-row">
			<?php vx_heading( 'Our Programs', 'Training built for <span class="lime">every level</span>' ); ?>
			<a class="link-arrow" href="<?php echo esc_url( home_url( '/programs/' ) ); ?>">View all programs &rarr;</a>
		</div>
		<div class="grid-3">
			<?php
			$progs = array(
				array( 'Foundation Batch', 'Basics of batting, bowling and fielding for beginners.', 'training-2-sm.jpg' ),
				array( 'Skill Development', 'Technique, game awareness and consistent improvement.', 'training-1-sm.jpg' ),
				array( 'Fitness & Conditioning', 'Strength, agility and endurance built for cricket.', 'training-2-sm.jpg' ),
			);
			foreach ( $progs as $i => $p ) : ?>
			<a class="photo-card" href="<?php echo esc_url( home_url( '/programs/' ) ); ?>">
				<img src="<?php echo esc_url( VX_URI . '/assets/img/' . $p[2] ); ?>" alt="" loading="lazy" width="800" height="600">
				<div class="pc-body"><span class="num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3><?php echo esc_html( $p[0] ); ?></h3><p><?php echo esc_html( $p[1] ); ?></p></div>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- FACILITIES -->
<section class="section dark">
	<div class="container">
		<?php vx_heading( 'Our Facilities', 'Everything a player <span class="lime">needs</span>', true ); ?>
		<div class="grid-4 tight">
			<?php foreach ( array( 'Turf Practice Ground', 'Net Practice Cage', 'Fitness & Warm-up Zone', 'Coaching Equipment' ) as $f ) : ?>
				<div class="card line-card"><h3><?php echo esc_html( $f ); ?></h3></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- MENTOR -->
<section class="section">
	<div class="container split rev">
		<div class="mentor-photo">
			<?php if ( $mentor_img ) : ?>
				<img src="<?php echo esc_url( $mentor_img ); ?>" alt="<?php echo esc_attr( vx( 'vx_mentor_name', 'Ms. Meghna Singh' ) ); ?>" loading="lazy">
			<?php else : ?>
				<div class="ph">Mentor photo<br><small>Appearance &rarr; Customize &rarr; Velocrix: Mentor</small></div>
			<?php endif; ?>
		</div>
		<div>
			<?php vx_heading( 'Our Mentor', esc_html( vx( 'vx_mentor_name', 'Ms. Meghna Singh' ) ) ); ?>
			<p class="lime-text"><?php echo esc_html( vx( 'vx_mentor_role', 'International Cricketer' ) ); ?></p>
			<p><?php echo esc_html( vx( 'vx_mentor_bio' ) ?: 'Velocrix Cricket Academy functions under the mentorship of Ms. Meghna Singh.' ); ?></p>
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">Read More</a>
		</div>
	</div>
</section>

<!-- PRICING PREVIEW -->
<section class="section dark">
	<div class="container">
		<?php vx_heading( 'Training Fees', 'Simple plans, <span class="lime">clear pricing</span>', true ); ?>
		<div class="grid-4">
			<?php foreach ( $plans as $p ) : ?>
			<div class="plan<?php echo $p['feat'] ? ' feat' : ''; ?>">
				<h3><?php echo esc_html( $p['name'] ); ?></h3>
				<div class="price"><sup>&#8377;</sup><?php echo esc_html( $p['price'] ); ?></div>
				<p><?php echo esc_html( $p['desc'] ); ?></p>
				<a class="btn btn-sm" href="<?php echo esc_url( home_url( '/admission/' ) ); ?>">Enrol</a>
			</div>
			<?php endforeach; ?>
		</div>
		<p class="center muted small">+ One-time registration fee &#8377;<?php echo esc_html( vx( 'vx_regfee', '1,999' ) ); ?>. <?php echo esc_html( str_replace( '*', '', vx( 'vx_regnote', 'Early bird discount available. Terms & conditions apply.' ) ) ); ?></p>
	</div>
</section>

<!-- HOW TO JOIN -->
<section class="section">
	<div class="container">
		<?php vx_heading( 'How To Join', 'Four steps to <span class="lime">get started</span>', true ); ?>
		<div class="grid-4 steps">
			<?php foreach ( array( array( 'Enquire', 'Call us or fill the enquiry form.' ), array( 'Register', 'Complete registration and pick a plan.' ), array( 'Train', 'Begin structured sessions with our coaches.' ), array( 'Compete', 'Grow your game and step up to match play.' ) ) as $i => $s ) : ?>
			<div class="step"><span class="num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- BLOG (only shows when posts exist) -->
<?php $q = new WP_Query( array( 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) );
if ( $q->have_posts() ) : ?>
<section class="section dark">
	<div class="container">
		<div class="sec-row">
			<?php vx_heading( 'Blog & Articles', 'Latest from the <span class="lime">academy</span>' ); ?>
			<a class="link-arrow" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">All articles &rarr;</a>
		</div>
		<div class="grid-3">
			<?php while ( $q->have_posts() ) : $q->the_post(); get_template_part( 'template-parts/post-card' ); endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>

<?php
get_header();
$img  = VX_URI . '/assets/img/';
$hero = vx( 'vx_hero_img' ) ?: $img . 'training-2.jpg';
$mentor_name = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$mentor_role = vx( 'vx_mentor_role', 'International Cricketer' );
$mentor_img  = vx( 'vx_mentor_img' );
$join = home_url( '/admission/' );
$title_lines = array_filter( array_map( 'trim', explode( "\n", vx( 'vx_hero_title', "Champions are not born\nThey are trained" ) ) ) );
?>

<!-- 1. HERO -->
<section class="hero" style="--hero:url('<?php echo esc_url( $hero ); ?>')">
	<div class="container hero-inner">
		<span class="eyebrow light"><?php echo esc_html( vx( 'vx_hero_eyebrow', 'Under the mentorship of Ms. Meghna Singh' ) ); ?></span>
		<h1>
			<?php foreach ( $title_lines as $ln ) echo '<span class="hl">' . esc_html( $ln ) . '<i>.</i></span>'; ?>
		</h1>
		<div class="hero-row">
			<div class="glass-card event">
				<img src="<?php echo esc_url( $img . 'prog-1.jpg' ); ?>" alt="Young cricketers training with their coach" width="312" height="250" fetchpriority="high">
				<div>
					<small class="lime">Admissions Open</small>
					<h3>Velocrix Cricket Academy</h3>
					<ul>
						<li><?php echo vx_icon( 'pin' ); // phpcs:ignore ?> Sarvottam International School, Sector 10 Campus, GNW</li>
						<li><?php echo vx_icon( 'calendar' ); // phpcs:ignore ?> <?php echo esc_html( str_replace( '.', '', explode( '.', vx( 'vx_status', 'Registrations are open. Early bird discount available.' ) )[1] ?? 'Early bird discount available' ) ); ?></li>
						<li><?php echo vx_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( vx( 'vx_hours', 'Mon - Sat: 6:00 AM - 8:00 PM' ) ); ?></li>
					</ul>
				</div>
			</div>
			<div class="hero-stat">
				<div><strong>&#8377;<?php echo esc_html( vx( 'vx_regfee', '1,999' ) ); ?></strong><span>Registration Fee</span></div>
				<a class="btn" href="<?php echo esc_url( $join ); ?>"><?php echo esc_html( vx( 'vx_hero_btn', 'Join the Academy' ) ); ?></a>
			</div>
		</div>
	</div>
</section>

<!-- 2. ABOUT -->
<section class="section about">
	<div class="container">
		<div class="about-top">
			<div>
				<span class="eyebrow">About Us</span>
				<div class="pills"><?php foreach ( array( 'Training', 'Discipline', 'Passion', 'Academy', 'Coaching', 'Cricket' ) as $p ) echo '<span>' . esc_html( $p ) . '</span>'; ?></div>
			</div>
			<p class="big-text">Velocrix is more than coaching &mdash; it&rsquo;s a place where young cricketers build skill, fitness and character through expert guidance, scientific training and a shared passion for the game.</p>
		</div>
		<div class="about-row">
			<a class="stat-card" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">
				<span class="round-btn light"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
				<b><span data-count="8">8</span></b><small>Core Strengths</small>
			</a>
			<div class="about-media">
				<img src="<?php echo esc_url( $img . 'about-wide.jpg' ); ?>" alt="Coach leading a stretching drill with young players" loading="lazy" width="1400" height="645">
				<?php if ( $v = vx( 'vx_video' ) ) : ?><a class="play" href="<?php echo esc_url( $v ); ?>" target="_blank" rel="noopener" aria-label="Watch video"><?php echo vx_icon( 'play' ); // phpcs:ignore ?></a><?php endif; ?>
			</div>
			<a class="stat-card" href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">
				<span class="round-btn light"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
				<b><span data-count="4">4</span></b><small>Flexible Training Plans</small>
			</a>
		</div>
	</div>
</section>

<!-- 3. WHY CHOOSE US -->
<section class="section why">
	<div class="container why-grid">
		<div>
			<span class="eyebrow">Why Choose Us</span>
			<h2>Experience the Difference</h2>
			<a class="btn" href="<?php echo esc_url( $join ); ?>">Book a Trial</a>
		</div>
		<div class="acc">
			<?php
			$why = array(
				array( 'Expert Coaching', 'Learn from qualified, experienced coaches dedicated to refining your technique, building confidence and helping you reach your highest potential.' ),
				array( 'International Standards', 'Get exposure to the training methods and standards followed at the top level of the game, right from the start.' ),
				array( 'Professional Environment', 'Train in a disciplined, well-equipped setting that builds focus, teamwork and character alongside skill.' ),
				array( 'Pathway to a Career', 'A structured route for passionate players who want to take their cricket to the next level.' ),
			);
			foreach ( $why as $i => $w ) : $open = ( $i === 0 ); ?>
			<div class="acc-item<?php echo $open ? ' is-open' : ''; ?>">
				<button class="acc-head" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>"><span><?php echo esc_html( sprintf( '%02d. %s', $i + 1, $w[0] ) ); ?></span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
				<div class="acc-body"><div><p><?php echo esc_html( $w[1] ); ?></p></div></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Partners -->
<?php get_template_part( 'template-parts/partners' ); ?>

<!-- 4. PROGRAMS -->
<section class="section dark programs">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Our Programs</span>
			<h2>Designed to Shape<br>Better Cricketers</h2>
		</div>
		<div class="prog-grid">
			<?php
			$progs = array(
				array( 'Foundation Batch', 'Basics of batting, bowling and fielding in a fun, safe setting.', 'prog-1.jpg', 0 ),
				array( 'Skill Development', 'Technique, game awareness and steady improvement for every player.', 'prog-2.jpg', 1 ),
				array( 'Fitness & Conditioning', 'Strength, agility and endurance built around cricket.', 'prog-3.jpg', 0 ),
			);
			foreach ( $progs as $i => $p ) :
				$im = '<a class="prog-img" href="' . esc_url( home_url( '/programs/' ) ) . '"><img src="' . esc_url( $img . $p[2] ) . '" alt="" loading="lazy" width="800" height="800"><span class="round-btn light">' . vx_icon( 'arrow' ) . '</span></a>';
				$tx = '<div class="prog-text"><h3>' . esc_html( sprintf( '%02d. %s', $i + 1, $p[0] ) ) . '</h3><p>' . esc_html( $p[1] ) . '</p></div>'; ?>
				<div class="prog-col<?php echo $p[3] ? ' mid' : ''; ?>"><?php echo $p[3] ? $tx . $im : $im . $tx; // phpcs:ignore ?></div>
			<?php endforeach; ?>
		</div>
		<p class="center"><a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/programs/' ) ); ?>">View All Programs</a></p>
	</div>
</section>

<!-- 5. FACILITIES -->
<section class="section facilities">
	<div class="container">
		<div class="fac-head">
			<div><span class="eyebrow">Our Facilities</span><h2>Your Ground to<br>Train and Grow</h2></div>
			<p>From first-time drills to match-ready sessions &mdash; Velocrix offers a safe, professional space for every young cricketer.</p>
		</div>
		<div class="fac-top">
			<a class="fac wide" href="<?php echo esc_url( home_url( '/facilities/' ) ); ?>">
				<img src="<?php echo esc_url( $img . 'fac-wide.jpg' ); ?>" alt="Net practice cage and training ground" loading="lazy" width="1400" height="620">
				<span class="round-btn is-lime"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
				<div class="fac-cap"><h3>Professional Practice Ground</h3><p>Open turf and net cage designed for comfort, safety and performance.</p></div>
			</a>
			<a class="fac tall" href="<?php echo esc_url( home_url( '/facilities/' ) ); ?>">
				<img src="<?php echo esc_url( $img . 'fac-2.jpg' ); ?>" alt="Player training at the nets" loading="lazy" width="800" height="800">
				<span class="round-btn light"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
			</a>
		</div>
		<div class="fac-row">
			<?php foreach ( array( array( 'fac-3.jpg', 'Warm-up & Fitness Zone' ), array( 'fac-4.jpg', 'Drills & Conditioning' ), array( 'fac-5.jpg', 'Nets & Goal Area' ) ) as $f ) : ?>
			<a class="fac" href="<?php echo esc_url( home_url( '/facilities/' ) ); ?>">
				<img src="<?php echo esc_url( $img . $f[0] ); ?>" alt="<?php echo esc_attr( $f[1] ); ?>" loading="lazy" width="800" height="800">
				<span class="round-btn light"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
				<div class="fac-cap"><h3><?php echo esc_html( $f[1] ); ?></h3></div>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 6. MENTOR (replaces testimonials until real ones exist) -->
<section class="quote-split">
	<div class="qs-text">
		<div>
			<span class="eyebrow light">Our Mentor</span>
			<p class="qs-quote">Velocrix Cricket Academy functions under the mentorship of <?php echo esc_html( $mentor_name ); ?>. Our coaches care about every player&rsquo;s progress, making each session challenging yet enjoyable &mdash; a supportive family that grows stronger together.</p>
			<div class="qs-by">
				<span class="avatar"><?php echo $mentor_img ? '<img src="' . esc_url( $mentor_img ) . '" alt="">' : esc_html( strtoupper( substr( preg_replace( '/^(Ms|Mr|Dr)\.?\s*/i', '', $mentor_name ), 0, 1 ) ) ); // phpcs:ignore ?></span>
				<div><b><?php echo esc_html( $mentor_name ); ?></b><small><?php echo esc_html( $mentor_role ); ?></small></div>
			</div>
		</div>
	</div>
	<div class="qs-img" style="background-image:url('<?php echo esc_url( $img . 'training-1.jpg' ); ?>')" role="img" aria-label="Coach and players on the practice ground"></div>
</section>

<!-- 7. HOW TO JOIN -->
<section class="section join">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">How To Join</span>
			<h2>Start Your Journey<br>with Velocrix</h2>
		</div>
		<div class="join-grid">
			<div class="join-photo" style="background-image:url('<?php echo esc_url( $img . 'coach-lg.jpg' ); ?>')">
				<div class="glass-card mini">
					<b>Velocrix Cricket Academy</b> <small>&ndash; Under <?php echo esc_html( $mentor_name ); ?></small>
					<p>Champions are not born, they are trained!</p>
				</div>
			</div>
			<div>
				<p class="muted">Start your path to better skills, structured training and a team where growth and competition meet.</p>
				<ol class="steps">
					<?php foreach ( array(
						array( 'Choose Your Plan', 'Find the training plan that matches your goals and level.' ),
						array( 'Meet Our Coaches', 'Visit the academy for a quick skill and fitness evaluation.' ),
						array( 'Begin Your Training', 'Start your sessions and experience structured coaching.' ),
						array( 'Play and Compete', 'Build confidence, join matches and grow with the Velocrix family.' ),
					) as $i => $s ) : ?>
					<li><span class="step-n"><?php echo esc_html( $i + 1 ); ?></span><div><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></div></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</div>
</section>

<!-- 8. BLOG -->
<?php $q = new WP_Query( array( 'posts_per_page' => 4, 'ignore_sticky_posts' => true ) );
if ( $q->have_posts() ) : ?>
<section class="section blog">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Blog &amp; Articles</span>
			<h2>Inspiring Stories to<br>Grow Your Game</h2>
		</div>
		<div class="blog-grid">
			<?php $n = 0; while ( $q->have_posts() ) : $q->the_post(); $n++;
				$cat = get_the_category(); $cat = $cat ? $cat[0]->name : 'Academy';
				if ( $n === 1 ) : ?>
				<a class="blog-feat" href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
					<div class="bf-cap"><h3><?php the_title(); ?></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p><span class="rm">READ MORE <?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span></div>
				</a>
				<div class="blog-list">
				<?php else : ?>
					<a class="blog-item" href="<?php the_permalink(); ?>">
						<span class="bi-img"><?php if ( has_post_thumbnail() ) the_post_thumbnail( 'vx-card', array( 'loading' => 'lazy' ) ); ?></span>
						<span class="bi-body"><span class="chip"><?php echo esc_html( $cat ); ?></span><h3><?php the_title(); ?></h3><small><?php echo vx_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( get_the_date() ); ?></small></span>
					</a>
				<?php endif;
			endwhile; wp_reset_postdata(); ?>
			<?php if ( $n >= 1 ) echo '</div>'; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>

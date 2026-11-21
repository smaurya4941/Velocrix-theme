<?php
get_header();
$img    = VX_URI . '/assets/img/';
$name   = vx( 'vx_mentor_name' );
$role   = vx( 'vx_mentor_role' );
$photo  = vx( 'vx_mentor_img' );
$quote  = vx( 'vx_mentor_quote' );

// 1. HERO (shared part)
get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'Our Mentor',
	'title'   => 'Mentorship That Inspires.<br>Training That Transforms',
	'text'    => $name . ', an Indian international cricketer, mentors every player at Velocrix Cricket Academy, founded by ' . vx_founder()['name'] . '.',
	'image'   => $img . 'training-1.jpg',
) );
?>

<!-- 2. PROFILE -->
<section class="section profile">
	<div class="container profile-grid">
		<div class="profile-photo">
			<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $name ); ?>, <?php echo esc_attr( $role ); ?>" width="384" height="776">
			<div class="profile-tag"><b><?php echo esc_html( $name ); ?></b><small><?php echo esc_html( $role ); ?></small></div>
		</div>
		<div class="profile-body">
			<span class="eyebrow">Mentor Profile</span>
			<h2><?php echo esc_html( $name ); ?></h2>
			<span class="chip"><?php echo esc_html( $role ); ?></span>
			<p class="big-text sm"><?php echo esc_html( $name ); ?> is an Indian international cricketer and right-arm medium-fast bowler from Bijnor, Uttar Pradesh. She has represented India across Test, ODI and T20I formats and brings valuable international and domestic cricket experience to Velocrix Cricket Academy.</p>
			<ul class="profile-facts">
				<li><span>Role</span><b>Mentor, Velocrix Cricket Academy</b></li>
				<li><span>Bowling</span><b>Right-arm medium-fast</b></li>
				<li><span>From</span><b>Bijnor, Uttar Pradesh</b></li>
				<li><span>Represented</span><b>India (Test, ODI, T20I), Gujarat Giants (WPL), Uttar Pradesh and Railways</b></li>
			</ul>
			<div class="btn-row">
				<a class="btn" href="<?php echo esc_url( home_url( '/registration/' ) ); ?>">Join the Academy</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a>
			</div>
		</div>
	</div>
</section>

<!-- 2b. VIDEO MESSAGE (moved from the animated home page; "Watch Meghna's message" links here) -->
<section class="section dark vx-msg" id="message">
	<div class="container msg-grid">
		<div class="msg-player" id="msgPlayer">
			<video id="msgVideo" src="<?php echo esc_url( vx_landing_uri( 'media/meghna-manifesto.mp4' ) ); ?>" poster="<?php echo esc_url( vx_landing_uri( 'media/poster-meghna.jpg' ) ); ?>" playsinline preload="none" aria-label="<?php echo esc_attr( $name ); ?> explains why Velocrix exists (Hindi, with on-screen captions)"></video>
			<button type="button" class="msg-play" id="msgPlay" aria-label="Play the video with sound"><span class="msg-ico" aria-hidden="true"></span><span class="msg-lbl">Play with sound</span></button>
		</div>
		<div class="msg-copy">
			<span class="eyebrow">Her Message</span>
			<h2>Glory Is Built<br>Before Sunrise</h2>
			<div class="msg-lines">
				<p><b>Har koi glory chahta hai. Stadium ki lights, aur jersey pehenne ka sapna.</b><span>Everyone wants the glory: the stadium lights, the dream of wearing the jersey.</span></p>
				<p><b>Lekin jab subha 4:30 baje ground thand se jama hota hai, tab wahan bahut kam log hote hain.</b><span>But at 4:30 in the morning, when the ground is frozen, very few people turn up.</span></p>
				<p><b>Hamara mission sirf talent dhoondhna nahi hai, balki mindset banana hai.</b><span>Our job is to build the mindset, as well as find the talent. When the pressure rises, the eyes stay on the ball.</span></p>
			</div>
		</div>
	</div>
</section>

<?php
// 3. HER MESSAGE (shared part)
get_template_part( 'template-parts/quote-split', null, array(
	'eyebrow' => 'In Her Words',
	'text'    => "\u{201C}" . $quote . "\u{201D}",
	'image'   => $img . 'training-2.jpg',
) );
?>

<!-- 3b. CAREER HIGHLIGHTS -->
<section class="section highlights">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Career Highlights</span>
			<h2>A Career Built on<br>Hard Work and Class</h2>
		</div>
		<div class="hl-cards">
			<div class="hl-card feat"><b>4/37</b><small>Best WPL bowling, vs Delhi Capitals (2024)</small></div>
			<div class="hl-card"><b>3/26</b><small>Best ODI bowling figures</small></div>
			<div class="hl-card"><b>2/54</b><small>Best Test bowling figures</small></div>
		</div>
		<ol class="hl-list">
			<?php foreach ( array(
				'Represented India in all three international formats.',
				'Selected in India’s squad for the 2022 ICC Women’s Cricket World Cup.',
				'Part of India’s women’s cricket team that won the silver medal at the 2022 Commonwealth Games in Birmingham.',
				'Made her ODI and Test debuts against Australia in September 2021 and her T20I debut in July 2022.',
				'Represented Gujarat Giants in the Women’s Premier League (WPL).',
				'Recorded career-best WPL bowling figures of 4/37 against Delhi Capitals in 2024.',
				'Represented Uttar Pradesh and Railways in domestic cricket.',
				'Best international bowling figures: 3/26 in ODIs and 2/54 in Test cricket.',
			) as $i => $h ) : ?>
				<li><span><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><p><?php echo esc_html( $h ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- 3b2. HER ROAD (timeline, moved from the animated home page) -->
<section class="section tint vx-road" id="road">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Her Road</span>
			<h2>From Bijnor to<br>India Colours</h2>
		</div>
		<ol class="road" tabindex="0" aria-label="<?php echo esc_attr( $name ); ?>'s career timeline">
			<?php foreach ( array(
				array( 'Bijnor', 'Grows up in Uttar Pradesh', 'Born and raised in Bijnor, western UP.', '' ),
				array( '2012–13', 'Uttar Pradesh', 'Starts senior domestic cricket for her home state.', '' ),
				array( '2017–18', 'Railways', 'Joins Railways, one of the strongest sides in women\'s domestic cricket.', '' ),
				array( '2020 · 2022', 'Women\'s T20 Challenge', 'Plays for Velocity, then Supernovas.', '' ),
				array( 'September 2021', 'India debut', 'ODI and Test caps on the tour of Australia.', 'hot' ),
				array( '2022', 'World Cup and CWG', 'ODI World Cup squad in New Zealand. T20I debut and silver in Birmingham.', 'hot' ),
				array( '2024', 'WPL', 'Gujarat Giants, including 4 for 37 against Delhi Capitals.', '' ),
				array( 'Now', 'Velocrix', 'Mentoring young cricketers in Greater Noida West.', 'now' ),
			) as $r ) : ?>
			<li class="<?php echo esc_attr( $r[3] ); ?>"><span class="road-yr"><?php echo esc_html( $r[0] ); ?></span><b><?php echo esc_html( $r[1] ); ?></b><p><?php echo esc_html( $r[2] ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- 3c. BEYOND CRICKET -->
<section class="section about-intro">
	<div class="container ai-grid">
		<div class="ai-head">
			<span class="eyebrow">Beyond Cricket</span>
			<h2>Sharing the Game<br>with the Next Generation</h2>
		</div>
		<div class="ai-body">
			<p class="big-text sm">Through Velocrix, <?php echo esc_html( $name ); ?> aims to share her experience of professional cricket with aspiring players, helping them develop their skills, confidence and discipline while preparing for the next level of the game.</p>
			<p>Her vision is to build an environment where young cricketers receive the right guidance, learn from challenges and pursue their ambitions with commitment and purpose.</p>
		</div>
	</div>
</section>

<!-- 4. MANTRA -->
<section class="section mantra">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Our Philosophy</span>
			<h2>Train Hard. Learn Smart.<br>Improve Everyday.</h2>
		</div>
		<div class="grid-4 steps">
			<?php foreach ( array(
				array( 'Train Hard', 'Put in the work in every session, especially when it is difficult.' ),
				array( 'Learn Smart', 'Scientific, modern training methods that build real understanding.' ),
				array( 'Improve Everyday', 'Small steady gains that add up to big progress.' ),
				array( 'Achieve Greatness', 'Aim high and chase your cricket goals with confidence.' ),
			) as $i => $s ) : ?>
				<div class="step"><span class="num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/values' ); ?>

<?php get_template_part( 'template-parts/cta' ); ?>

<?php get_footer(); ?>

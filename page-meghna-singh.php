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
	'text'    => 'Velocrix Cricket Academy functions under the mentorship of ' . $name . ', ' . $role . '.',
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
			<span class="eyebrow">About the Mentor</span>
			<h2><?php echo esc_html( $name ); ?></h2>
			<span class="chip"><?php echo esc_html( $role ); ?></span>
			<p class="big-text sm">Under the mentorship of <?php echo esc_html( $name ); ?>, Velocrix brings expert coaching, scientific training and all-round development to every young cricketer.</p>
			<ul class="profile-facts">
				<li><span>Role</span><b>Mentor, Velocrix Cricket Academy</b></li>
				<li><span>Background</span><b><?php echo esc_html( $role ); ?></b></li>
				<li><span>Academy</span><b>Sarvottam International School (Sector 10 Campus), Greater Noida West</b></li>
				<li><span>Motto</span><b>Where Dreams Meet Discipline</b></li>
			</ul>
			<div class="btn-row">
				<a class="btn" href="<?php echo esc_url( home_url( '/admission/' ) ); ?>">Join the Academy</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a>
			</div>
		</div>
	</div>
</section>

<?php
// 3. HER MESSAGE (shared part)
get_template_part( 'template-parts/quote-split', null, array(
	'eyebrow' => 'Her Message',
	'text'    => "\u{201C}" . $quote . "\u{201D}",
	'image'   => $img . 'training-2.jpg',
) );
?>

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

<?php
get_header();
$img    = VX_URI . '/assets/img/';
$join   = home_url( '/registration/' );
$mentor = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );

// 1. HERO (shared part)
get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'Our Services',
	'title'   => 'Services Built to<br>Grow Your Game',
	'text'    => 'From corporate tournaments to workshops and guest lectures, every service is built to enhance growth, sharpen skills and strengthen your game.',
	'image'   => $img . 'hero-team.jpg',
) );

// 2. SERVICES (same zig-zag grid as the home Programs section)
$services = vx_services();
?>
<section class="section dark programs">
	<div class="container">
		<h2 class="sr-only">Our services</h2>
			<div class="prog-grid">
			<?php foreach ( $services as $i => $s ) : $s[4] = ( $i === 1 ) ? 1 : 0;
				$url = home_url( $s[3] );
				$im  = '<a class="prog-img" href="' . esc_url( $url ) . '" aria-label="' . esc_attr( $s[0] ) . '"><img src="' . esc_url( $img . $s[2] ) . '" alt="" loading="lazy" width="800" height="800"><span class="round-btn light">' . vx_icon( 'arrow' ) . '</span></a>';
				$tx  = '<div class="prog-text"><h3>' . esc_html( sprintf( '%02d. %s', $i + 1, $s[0] ) ) . '</h3><p>' . esc_html( $s[1] ) . '</p></div>'; ?>
				<div class="prog-col<?php echo $s[4] ? ' mid' : ''; ?>"><?php echo $s[4] ? $tx . $im : $im . $tx; // phpcs:ignore ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 3. WHY CHOOSE US -->
<section class="section why">
	<div class="container why-grid">
		<div>
			<span class="eyebrow">Why Choose Us</span>
			<h2>Experience the Difference</h2>
			<a class="btn" href="<?php echo esc_url( $join ); ?>">Join Now</a>
		</div>
		<div class="acc">
			<?php foreach ( vx_copy( 'why' ) as $i => $w ) : $open = ( $i === 0 ); ?>
			<div class="acc-item<?php echo $open ? ' is-open' : ''; ?>">
				<button class="acc-head" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>"><span><?php echo esc_html( sprintf( '%02d. %s', $i + 1, $w[0] ) ); ?></span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
				<div class="acc-body"><div><p><?php echo esc_html( $w[1] ); ?></p></div></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
// 4. MENTOR (shared part)
get_template_part( 'template-parts/quote-split', null, array(
	'eyebrow' => 'Our Mentor',
	'text'    => 'Mentorship that inspires. Training that transforms. Every Velocrix service is guided by the mentorship of ' . $mentor . '.',
	'image'   => $img . 'training-2.jpg',
) );

get_template_part( 'template-parts/cta' );
get_footer();

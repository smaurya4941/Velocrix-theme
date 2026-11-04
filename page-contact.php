<?php
get_header();
$img     = VX_URI . '/assets/img/';
$phone   = vx( 'vx_phone', '+91 879 644 7595' );
$phone2  = vx( 'vx_phone2', '+91 7017810766' );
$email   = vx( 'vx_email' );
$hours   = vx( 'vx_hours', 'Mon - Sat: 6:00 AM - 8:00 PM' );
$address = vx( 'vx_address', 'Sarvottam International School, Sector 10 Campus, Greater Noida West' );
$map     = vx( 'vx_map' ) ?: 'https://maps.google.com/maps?q=' . rawurlencode( $address ) . '&output=embed';
?>

<!-- 1. HERO (shared part) -->
<?php
ob_start(); ?>
<div class="connect-card">
	<h3>Let&rsquo;s Connect!</h3>
	<div class="connect-icons">
		<?php foreach ( array( "instagram" => "Instagram", "facebook" => "Facebook", "youtube" => "YouTube", "linkedin" => "LinkedIn" ) as $k => $label ) : ?>
			<a href="<?php echo esc_url( vx( "vx_$k", "#" ) ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo vx_icon( $k ); // phpcs:ignore ?></a>
		<?php endforeach; ?>
	</div>
</div>
<?php
get_template_part( "template-parts/hero-page", null, array(
	"eyebrow" => "Contact Us",
	"title"   => "We&rsquo;re Here<br>to Help You",
	"image"   => $img . "training-2.jpg",
	"class"   => "hero-contact",
	"side"    => ob_get_clean(),
) );
?>

<!-- 2. INFO + FORM -->
<section class="section dark contact-sec" id="form">
	<div class="container contact-grid">
		<div class="acc on-dark">
			<div class="acc-item">
				<button class="acc-head" aria-expanded="false"><span>Open Hours</span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
				<div class="acc-body"><div><p class="c-val"><?php echo esc_html( $hours ); ?></p></div></div>
			</div>
			<div class="acc-item is-open">
				<button class="acc-head" aria-expanded="true"><span>Phone Number</span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
				<div class="acc-body"><div>
					<p class="c-val"><a href="<?php echo esc_url( vx_phone_href( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
					<?php if ( $phone2 ) : ?><p class="c-val"><a href="<?php echo esc_url( vx_phone_href( $phone2 ) ); ?>"><?php echo esc_html( $phone2 ); ?></a></p><?php endif; ?>
				</div></div>
			</div>
			<div class="acc-item">
				<button class="acc-head" aria-expanded="false"><span>Email Address</span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
				<div class="acc-body"><div><p class="c-val"><?php echo $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : 'Send us a message using the form.'; // phpcs:ignore ?></p></div></div>
			</div>
			<div class="acc-item">
				<button class="acc-head" aria-expanded="false"><span>Address</span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
				<div class="acc-body"><div><p class="c-val c-sm"><?php echo esc_html( $address ); ?></p></div></div>
			</div>
		</div>

		<div class="talk-card">
			<h2>Let&rsquo;s Talk</h2>
			<?php vx_contact_form(); ?>
		</div>
	</div>
</section>

<!-- 3. MAP -->
<section class="map-sec">
	<iframe src="<?php echo esc_url( $map ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Velocrix Cricket Academy location map" allowfullscreen></iframe>
</section>

<?php get_footer(); ?>

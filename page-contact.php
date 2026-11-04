<?php get_header(); vx_page_hero( 'Contact <span class="lime">Us</span>', 'Questions about training or admission? Get in touch.' ); ?>
<section class="section" id="form">
	<div class="container split">
		<div>
			<?php vx_heading( 'Get in Touch', 'We would love to <span class="lime">hear from you</span>' ); ?>
			<ul class="contact-list">
				<li><b>Phone</b><a href="<?php echo esc_url( vx_phone_href( vx( 'vx_phone', '+91 879 644 7595' ) ) ); ?>"><?php echo esc_html( vx( 'vx_phone', '+91 879 644 7595' ) ); ?></a>
					<?php if ( $p2 = vx( 'vx_phone2', '+91 7017810766' ) ) : ?> / <a href="<?php echo esc_url( vx_phone_href( $p2 ) ); ?>"><?php echo esc_html( $p2 ); ?></a><?php endif; ?></li>
				<?php if ( $e = vx( 'vx_email' ) ) : ?><li><b>Email</b><a href="mailto:<?php echo esc_attr( $e ); ?>"><?php echo esc_html( $e ); ?></a></li><?php endif; ?>
				<li><b>Address</b><?php echo esc_html( vx( 'vx_address', 'Sarvottam International School, Sector 10 Campus, Greater Noida West' ) ); ?></li>
				<li><b>Timings</b><?php echo esc_html( vx( 'vx_hours', 'Mon - Sat: 6:00 AM - 8:00 PM' ) ); ?></li>
				<li><b>Website</b>www.velocrix.com</li>
			</ul>
		</div>
		<div class="form-card"><?php vx_form( 'contact' ); ?></div>
	</div>
	<?php if ( $map = vx( 'vx_map' ) ) : ?>
	<div class="container map"><iframe src="<?php echo esc_url( $map ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map"></iframe></div>
	<?php endif; ?>
</section>
<?php get_footer(); ?>

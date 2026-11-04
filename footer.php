</main>

<?php get_template_part( 'template-parts/cta' ); ?>

<footer class="site-footer">
	<div class="container foot-grid">
		<div>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="brand-mark">VELOCRIX</span><span class="brand-sub">Cricket Academy</span></a>
			<p class="muted">Champions are not born, they are trained. Expert coaching and scientific training under the mentorship of <?php echo esc_html( vx( 'vx_mentor_name', 'Ms. Meghna Singh' ) ); ?>.</p>
			<div class="social">
				<?php foreach ( array( 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn' ) as $k => $label ) :
					$u = vx( "vx_$k" ); if ( ! $u ) continue; ?>
					<a href="<?php echo esc_url( $u ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo esc_html( $label ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div>
			<h4>Quick Links</h4>
			<?php if ( has_nav_menu( 'footer' ) ) : wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'foot-list', 'depth' => 1 ) ); else : ?>
			<ul class="foot-list">
				<?php foreach ( array( 'About', 'Programs', 'Pricing', 'Admission', 'Gallery' ) as $l ) echo '<li><a href="' . esc_url( home_url( '/' . strtolower( $l ) . '/' ) ) . '">' . esc_html( $l ) . '</a></li>'; ?>
			</ul>
			<?php endif; ?>
		</div>
		<div>
			<h4>Academy</h4>
			<ul class="foot-list">
				<?php foreach ( array( 'Coaches', 'Facilities', 'Achievements', 'Blog', 'Contact' ) as $l ) echo '<li><a href="' . esc_url( home_url( '/' . strtolower( $l ) . '/' ) ) . '">' . esc_html( $l ) . '</a></li>'; ?>
			</ul>
		</div>
		<div>
			<h4>Get in Touch</h4>
			<ul class="foot-list contact">
				<li><a href="<?php echo esc_url( vx_phone_href( vx( 'vx_phone', '+91 879 644 7595' ) ) ); ?>"><?php echo esc_html( vx( 'vx_phone', '+91 879 644 7595' ) ); ?></a></li>
				<?php if ( $p2 = vx( 'vx_phone2', '+91 7017810766' ) ) : ?><li><a href="<?php echo esc_url( vx_phone_href( $p2 ) ); ?>"><?php echo esc_html( $p2 ); ?></a></li><?php endif; ?>
				<?php if ( $em = vx( 'vx_email' ) ) : ?><li><a href="mailto:<?php echo esc_attr( $em ); ?>"><?php echo esc_html( $em ); ?></a></li><?php endif; ?>
				<li><?php echo esc_html( vx( 'vx_address', 'Sarvottam International School, Sector 10 Campus, Greater Noida West' ) ); ?></li>
			</ul>
		</div>
	</div>
	<div class="container copy">
		<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Velocrix Cricket Academy. All rights reserved.</span>
		<span>In association with Sarvottam International School</span>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

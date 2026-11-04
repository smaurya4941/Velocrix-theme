</main>


<footer class="site-footer">
	<div class="container">
		<div class="foot-news" id="newsletter">
			<h3>Subscribe for the<br>Latest Cricket Updates</h3>
			<div class="news-box">
				<?php $nl = isset( $_GET['nl'] ) ? sanitize_key( $_GET['nl'] ) : ''; ?>
				<form class="news-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="vx_enquiry">
					<input type="hidden" name="form_type" value="newsletter">
					<input type="hidden" name="_back" value="<?php echo esc_url( home_url( add_query_arg( null, null ) ) ); ?>">
					<?php wp_nonce_field( 'vx_enquiry', 'vx_nonce' ); ?>
					<div class="hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
					<input type="email" name="email" placeholder="Enter your email" required aria-label="Email">
					<button type="submit" class="round-btn" aria-label="Subscribe"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
				</form>
				<?php if ( $nl === 'sent' ) echo '<p class="nl-msg ok">Thanks for subscribing!</p>'; elseif ( $nl === 'err' ) echo '<p class="nl-msg err">Please enter a valid email.</p>'; ?>
			</div>
		</div>

		<div class="foot-grid">
			<div>
				<h4>Let&rsquo;s Connect!</h4>
				<div class="social">
					<?php foreach ( array( 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube', 'facebook' => 'Facebook' ) as $k => $label ) :
						$u = vx( "vx_$k", '#' ); ?>
						<a href="<?php echo esc_url( $u ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo vx_icon( $k ); // phpcs:ignore ?></a>
					<?php endforeach; ?>
				</div>
			</div>
			<div>
				<h4>Quick Links</h4>
				<ul class="foot-list">
					<?php foreach ( array( 'Home' => '/', 'About' => '/about/', 'Programs' => '/programs/', 'Pricing' => '/pricing/' ) as $l => $u ) echo '<li><a href="' . esc_url( home_url( $u ) ) . '">' . esc_html( $l ) . '</a></li>'; ?>
				</ul>
			</div>
			<div>
				<h4>Quick Access</h4>
				<ul class="foot-list">
					<?php foreach ( array( 'Admission' => '/admission/', 'Facilities' => '/facilities/', 'Gallery' => '/gallery/', 'Blog' => '/blog/' ) as $l => $u ) echo '<li><a href="' . esc_url( home_url( $u ) ) . '">' . esc_html( $l ) . '</a></li>'; ?>
				</ul>
			</div>
			<div>
				<h4>Get in Touch</h4>
				<ul class="foot-list">
					<li><?php echo esc_html( vx( 'vx_address', 'Sarvottam International School, Sector 10 Campus, Greater Noida West' ) ); ?></li>
					<li><?php echo esc_html( vx( 'vx_hours', 'Mon - Sat: 6:00 AM - 8:00 PM' ) ); ?></li>
					<?php if ( $em = vx( 'vx_email' ) ) : ?><li><a href="mailto:<?php echo esc_attr( $em ); ?>"><?php echo esc_html( $em ); ?></a></li><?php endif; ?>
					<li><a href="<?php echo esc_url( vx_phone_href( vx( 'vx_phone', '+91 879 644 7595' ) ) ); ?>"><?php echo esc_html( vx( 'vx_phone', '+91 879 644 7595' ) ); ?></a><?php if ( $p2 = vx( 'vx_phone2', '+91 7017810766' ) ) : ?> &middot; <a href="<?php echo esc_url( vx_phone_href( $p2 ) ); ?>"><?php echo esc_html( $p2 ); ?></a><?php endif; ?></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="foot-word" aria-hidden="true">VELOCRIX</div>

	<div class="container copy">
		<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Velocrix Cricket Academy. All rights reserved.</span>
		<span>In association with Sarvottam International School &middot; Live the Sport</span>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

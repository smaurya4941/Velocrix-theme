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

		<?php
		// Footer link columns are built from the same list as the header menu, so they never drift apart.
		$quick  = array();
		$groups = array();
		foreach ( vx_default_menu() as $label => $url ) {
			if ( is_array( $url ) ) {
				$groups[ $label ] = $url;
			} else {
				$quick[ $label ] = $url;
			}
		}
		$quick['Join Now'] = home_url( '/registration/' );
		$phone1 = vx( 'vx_phone', '+91 879 644 7595' );
		$phone2 = vx( 'vx_phone2', '+91 7017810766' );
		?>
		<div class="foot-grid">
			<div class="foot-brand">
				<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img class="brand-logo" src="<?php echo esc_url( VX_URI . '/assets/img/logo-mark.png' ); ?>" alt="" width="54" height="50"><span class="brand-txt"><span class="brand-mark">VELOCRIX</span><span class="brand-sub">Cricket Academy</span></span>
				</a>
				<p class="foot-tag">Where Dreams Meet Discipline.</p>
				<div class="social">
					<?php // Instagram, LinkedIn, X and Facebook always show; they become links once a URL is set in Customizer > Velocrix: Social Links. YouTube shows only when set.
					foreach ( array( 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'x' => 'X', 'facebook' => 'Facebook', 'youtube' => 'YouTube' ) as $k => $label ) :
						$u = vx( "vx_$k" );
						if ( ! $u && $k === 'youtube' ) continue;
						if ( $u ) : ?>
						<a href="<?php echo esc_url( $u ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $label ); ?>" title="<?php echo esc_attr( $label ); ?>"><?php echo vx_icon( $k ); // phpcs:ignore ?></a>
						<?php else : ?>
						<span class="soc-pending" role="img" aria-label="<?php echo esc_attr( $label ); ?> (link coming soon)" title="<?php echo esc_attr( $label ); ?>"><?php echo vx_icon( $k ); // phpcs:ignore ?></span>
						<?php endif;
					endforeach; ?>
				</div>
			</div>

			<div>
				<h4>Quick Links</h4>
				<ul class="foot-list">
					<?php foreach ( $quick as $l => $u ) echo '<li><a href="' . esc_url( $u ) . '">' . esc_html( $l ) . '</a></li>'; ?>
				</ul>
			</div>

			<?php foreach ( $groups as $title => $items ) :
				$head = isset( $items['_url'] ) ? $items['_url'] : '';
				unset( $items['_url'] ); ?>
			<div>
				<h4><?php echo $head ? '<a href="' . esc_url( $head ) . '">' . esc_html( $title ) . '</a>' : esc_html( $title ); // phpcs:ignore ?></h4>
				<ul class="foot-list">
					<?php foreach ( $items as $l => $u ) echo '<li><a href="' . esc_url( $u ) . '">' . esc_html( $l ) . '</a></li>'; ?>
				</ul>
			</div>
			<?php endforeach; ?>

			<div class="foot-contact">
				<h4>Get in Touch</h4>
				<ul class="foot-list">
					<li class="fi"><?php echo vx_icon( 'pin' ); // phpcs:ignore ?><span><?php echo esc_html( vx( 'vx_address', 'Sarvottam International School, Sector 10 Campus, Greater Noida West' ) ); ?></span></li>
					<?php if ( $hrs = vx( 'vx_hours' ) ) : ?><li class="fi"><?php echo vx_icon( 'clock' ); // phpcs:ignore ?><span><?php echo esc_html( $hrs ); ?></span></li><?php endif; ?>
					<?php if ( $em = vx( 'vx_email' ) ) : ?><li class="fi"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg><span><a href="mailto:<?php echo esc_attr( $em ); ?>"><?php echo esc_html( $em ); ?></a></span></li><?php endif; ?>
					<li class="fi"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z"/></svg><span><a href="<?php echo esc_url( vx_phone_href( $phone1 ) ); ?>"><?php echo esc_html( $phone1 ); ?></a><?php if ( $phone2 ) : ?><br><a href="<?php echo esc_url( vx_phone_href( $phone2 ) ); ?>"><?php echo esc_html( $phone2 ); ?></a><?php endif; ?></span></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="foot-word" aria-hidden="true"></div>

	<div class="container copy">
		<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Velocrix Cricket Academy. All rights reserved.</span>
		<span class="copy-assoc">In association with <img src="<?php echo esc_url( vx_asset( 'assets/img/sarvottam-logo.png' ) ); ?>" alt="Sarvottam International School" width="400" height="100" loading="lazy"></span>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

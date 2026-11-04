<?php /** Coach card (About + Team). Args: name, role, photo, soon */
$c = wp_parse_args( $args, array( 'name' => '', 'role' => '', 'photo' => '', 'soon' => false, 'url' => home_url( '/contact/' ) ) ); ?>
<article class="cc<?php echo $c['soon'] ? ' soon' : ''; ?>">
	<div class="cc-photo">
		<?php if ( $c['photo'] ) : ?><img src="<?php echo esc_url( $c['photo'] ); ?>" alt="<?php echo esc_attr( $c['name'] ); ?>" loading="lazy">
		<?php else : ?><svg class="sil" viewBox="0 0 200 240" aria-hidden="true"><circle cx="100" cy="85" r="48"/><path d="M20 240c0-56 36-92 80-92s80 36 80 92z"/></svg><?php endif; ?>
		<div class="cc-social">
			<?php foreach ( array( 'instagram', 'facebook', 'youtube' ) as $s ) if ( $u = vx( "vx_$s" ) ) echo '<a href="' . esc_url( $u ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( ucfirst( $s ) ) . '">' . vx_icon( $s ) . '</a>'; // phpcs:ignore ?>
		</div>
	</div>
	<a class="cc-name" href="<?php echo esc_url( $c['url'] ); ?>">
		<span><b><?php echo esc_html( $c['name'] ); ?></b><small><?php echo esc_html( $c['role'] ); ?></small></span>
		<span class="round-btn light"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
	</a>
</article>

<?php
/**
 * Shared FAQ accordion (two columns). Args: eyebrow, title, faqs (array of columns of [q, a]), more_url
 */
$a = wp_parse_args( $args, array( 'eyebrow' => 'FAQ', 'title' => 'Get the Answers You Need', 'faqs' => array(), 'more_url' => home_url( '/contact/' ) ) );
?>
<section class="section faq-sec">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow"><?php echo esc_html( $a['eyebrow'] ); ?></span>
			<h2><?php echo wp_kses_post( $a['title'] ); ?></h2>
		</div>
		<div class="faq-grid">
			<?php foreach ( $a['faqs'] as $col ) : ?>
			<div class="acc">
				<?php foreach ( $col as $i => $f ) : $open = ( $i === 0 ); ?>
				<div class="acc-item<?php echo $open ? ' is-open' : ''; ?>">
					<button class="acc-head" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>"><span><?php echo esc_html( $f[0] ); ?></span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
					<div class="acc-body"><div><p><?php echo esc_html( $f[1] ); ?></p></div></div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<p class="center muted faq-more">Have more questions? <a href="<?php echo esc_url( $a['more_url'] ); ?>">Contact our team</a></p>
	</div>
</section>

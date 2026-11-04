<?php
/**
 * Shared full-screen page hero (About, Contact, Pricing, ...).
 * Args: eyebrow, title (html), text, image (url), class, side (html, optional, replaces text)
 */
$a = wp_parse_args( $args, array( 'eyebrow' => '', 'title' => '', 'text' => '', 'image' => '', 'class' => '', 'side' => '' ) );
?>
<section class="hero hero-page <?php echo esc_attr( $a['class'] ); ?>" style="--hero:url('<?php echo esc_url( $a['image'] ); ?>')">
	<div class="container hero-inner">
		<div class="ha-row">
			<div>
				<span class="eyebrow light"><?php echo esc_html( $a['eyebrow'] ); ?></span>
				<h1><?php echo wp_kses_post( $a['title'] ); ?><i class="dot">.</i></h1>
			</div>
			<?php if ( $a['side'] ) : ?>
				<?php echo $a['side']; // phpcs:ignore -- trusted markup built by our own templates ?>
			<?php elseif ( $a['text'] ) : ?>
				<p class="ha-text"><?php echo esc_html( $a['text'] ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

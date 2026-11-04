<?php
/**
 * FAQ group: title + intro on the left, accordion on the right (FAQ page).
 * Args: title, text, faqs (array of [q, a]), tint (bool, tinted background), open (bool, first item open)
 */
$a = wp_parse_args( $args, array( 'title' => '', 'text' => '', 'faqs' => array(), 'tint' => false, 'open' => true ) );
?>
<section class="section faq-split<?php echo $a['tint'] ? ' tint' : ''; ?>">
	<div class="container fs-grid">
		<div class="fs-head">
			<h2><?php echo esc_html( $a['title'] ); ?></h2>
			<p><?php echo esc_html( $a['text'] ); ?></p>
		</div>
		<div class="acc">
			<?php foreach ( $a['faqs'] as $i => $f ) : $open = ( $a['open'] && $i === 0 ); ?>
			<div class="acc-item<?php echo $open ? ' is-open' : ''; ?>">
				<button class="acc-head" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>"><span><?php echo esc_html( $f[0] ); ?></span><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></button>
				<div class="acc-body"><div><p><?php echo esc_html( $f[1] ); ?></p></div></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

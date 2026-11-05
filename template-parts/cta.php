<?php
/**
 * Shared full-width image CTA (shown before the footer on every page except Contact).
 * Optional args: title (html: br and i only), button (text), url
 */
$a = wp_parse_args( $args, array(
	'title'  => 'Join Velocrix and elevate<br>your game with us<i>.</i>',
	'button' => 'Join Our Academy',
	'url'    => home_url( '/registration/' ),
) );
?>
<section class="cta-img" style="--cta:url('<?php echo esc_url( VX_URI . '/assets/img/cta-bg.jpg' ); ?>')">
	<div class="container cta-inner">
		<h2><?php echo wp_kses( $a['title'], array( 'br' => array(), 'i' => array() ) ); ?></h2>
		<a class="btn" href="<?php echo esc_url( $a['url'] ); ?>"><?php echo esc_html( $a['button'] ); ?></a>
	</div>
</section>

<?php
/**
 * Shared dark text + photo split (mentor / testimonial slot). Args: eyebrow, text, image
 */
$a = wp_parse_args( $args, array( 'eyebrow' => 'Our Mentor', 'text' => '', 'image' => VX_URI . '/assets/img/training-1.jpg' ) );
$name = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$role = vx( 'vx_mentor_role', 'International Cricketer' );
$mimg = vx( 'vx_mentor_img' );
?>
<section class="quote-split">
	<div class="qs-text">
		<div>
			<span class="eyebrow light"><?php echo esc_html( $a['eyebrow'] ); ?></span>
			<p class="qs-quote"><?php echo esc_html( $a['text'] ); ?></p>
			<div class="qs-by">
				<span class="avatar"><?php echo $mimg ? '<img src="' . esc_url( $mimg ) . '" alt="">' : esc_html( strtoupper( substr( preg_replace( '/^(Ms|Mr|Dr)\.?\s*/i', '', $name ), 0, 1 ) ) ); // phpcs:ignore ?></span>
				<div><b><?php echo esc_html( $name ); ?></b><small><?php echo esc_html( $role ); ?></small></div>
			</div>
		</div>
	</div>
	<div class="qs-img" style="background-image:url('<?php echo esc_url( $a['image'] ); ?>')" role="img" aria-label="Coach and players on the practice ground"></div>
</section>

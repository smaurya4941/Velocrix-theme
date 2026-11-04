<?php
get_header();
$img = VX_URI . '/assets/img/';

// 1. HERO (shared part)
get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'Gallery',
	'title'   => 'Moments from<br>the Training Ground',
	'text'    => 'Real sessions, real effort. A look at life at Velocrix Cricket Academy.',
	'image'   => $img . 'training-1.jpg',
) );

// Photos attached to this page (Media > attach to Gallery page); falls back to theme photos.
$items = array();
foreach ( get_attached_media( 'image', get_the_ID() ) as $im ) {
	$full = wp_get_attachment_image_src( $im->ID, 'full' );
	$items[] = array( 'full' => $full[0], 'html' => wp_get_attachment_image( $im->ID, 'large', false, array( 'loading' => 'lazy', 'alt' => 'Velocrix Cricket Academy training' ) ) );
}
if ( ! $items ) {
	foreach ( array( 'training-1', 'prog-1', 'fac-nets', 'training-2', 'prog-2', 'fac-run', 'prog-3', 'fac-2', 'about-wide', 'fac-3', 'fac-4', 'fac-5' ) as $n ) {
		$p = $img . $n . '.jpg';
		if ( ! file_exists( get_template_directory() . '/assets/img/' . $n . '.jpg' ) ) continue;
		$items[] = array( 'full' => $p, 'html' => '<img src="' . esc_url( $p ) . '" alt="Velocrix Cricket Academy training" loading="lazy">' );
	}
}
?>

<!-- 2. GALLERY -->
<section class="section gal-sec">
	<div class="container">
		<div class="g-masonry">
			<?php foreach ( $items as $it ) : ?>
			<a class="g-item" href="<?php echo esc_url( $it['full'] ); ?>" aria-label="View photo">
				<?php echo $it['html']; // phpcs:ignore -- built from escaped attachment/theme data ?>
				<span class="round-btn is-lime"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/cta' );
get_footer();

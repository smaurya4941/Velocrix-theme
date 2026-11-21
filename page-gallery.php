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
	// Real academy photos from the animated design (assets/landing/media) first.
	foreach ( array( 'bowler-load' => 'A Velocrix student at the top of his bowling action', 'meghna-coaching' => 'Meghna Singh coaching at Velocrix', 'batting-nets' => 'Young batter driving in the Velocrix nets', 'focus-ball' => 'A Velocrix student holding a red ball before his run-up', 'bowler-follow' => 'A Velocrix student in his bowling delivery stride', 'catch' => 'A Velocrix student taking a high catch' ) as $n => $alt ) {
		if ( ! file_exists( get_template_directory() . '/assets/landing/media/' . $n . '.jpg' ) ) continue;
		$p = vx_landing_uri( 'media/' . $n . '.jpg' );
		$items[] = array( 'full' => $p, 'html' => '<img src="' . esc_url( $p ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">' );
	}
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

<!-- 3. VIDEOS (from the animated design) -->
<section class="section dark gal-videos" id="videos">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">From the Nets</span>
			<h2>Great Technique<br>Isn't an Accident</h2>
		</div>
		<div class="reel-row">
			<?php foreach ( array(
				array( 'reel-technique.mp4', 'poster-technique.jpg', 'Batting, catching, repeat: a normal Velocrix week' ),
				array( 'reel-pov.mp4', 'poster-pov.jpg', 'POV: you\'re a Velocrix student. Practice mode on.' ),
			) as $v ) : ?>
			<figure class="reel-card">
				<video class="reel-vid" src="<?php echo esc_url( vx_landing_uri( 'media/' . $v[0] ) ); ?>" poster="<?php echo esc_url( vx_landing_uri( 'media/' . $v[1] ) ); ?>" muted loop playsinline preload="none" aria-label="<?php echo esc_attr( $v[2] ); ?>"></video>
				<figcaption><?php echo esc_html( $v[2] ); ?></figcaption>
			</figure>
			<?php endforeach; ?>
		</div>
		<p class="reel-more">New videos every week on Instagram: <a href="https://www.instagram.com/velocrixofficial/" target="_blank" rel="noopener">@velocrixofficial</a></p>
	</div>
</section>

<?php
get_template_part( 'template-parts/cta' );
get_footer();

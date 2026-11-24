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
// Stills from the training video shoot (assets/img/training, WebP) always lead the grid.
$stills = array();
foreach ( array(
	'coach-demo'      => 'Coach with bat and glove, tossing the ball on the ground',
	'ball-toss'       => 'A cricket ball tossed from the hand, close up',
	'stumps-hit'      => 'Ball hitting the stumps',
	'ground-fielding' => 'Coach showing a low ground-fielding position',
	'bat-stance'      => 'Coach walking out with the bat',
) as $n => $alt ) {
	$p        = vx_asset( 'assets/img/training/' . $n . '.webp' );
	$stills[] = array( 'full' => $p, 'html' => '<img src="' . esc_url( $p ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" width="1080" height="1920">' );
}
$items = array_merge( $stills, $items );
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

<!-- 2b. LAUNCH DAY (academy opening; photos in assets/img/launch, WebP) -->
<section class="section gal-sec gal-launch" id="launch-day">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Launch Day</span>
			<h2>The Day Velocrix<br>Opened Its Gates</h2>
		</div>
		<div class="g-masonry">
			<?php foreach ( array(
				'ribbon-cut'    => 'Ribbon cutting to open the academy ground',
				'machine-start' => 'Guest starting the bowling machine at the launch',
				'coconut'       => 'Breaking a coconut at the ribbon, a traditional start',
				'ribbon-line'   => 'Team and guests at the ribbon on the turf',
				'team-cheer'    => 'Students cheering in their new academy jerseys',
				'young-bowler'  => 'A young student bowling on the outfield',
				'smile'         => 'A smiling student on the ground after his delivery',
				'school-cheer'  => 'School students cheering at the launch',
				'gift-tray'     => 'Students welcoming a guest with a gift tray',
				'plant-gift'    => 'A student honoured with a plant gift',
				'workshop-coach'=> 'Coach talking to students on the ground',
				'jersey-launch' => 'Guests and team launching the new jerseys on stage',
				'audience'      => 'Students in front of the Velocrix banner',
				'guest-talk'    => 'Audience at the launch talk',
				'cake-cut'      => 'Guests and team cutting the launch cake',
				'cake-kids'     => 'Students gathered around the launch cake',
				'cake'          => 'The Velocrix launch cake',
				'team-photo'    => 'Velocrix students in academy jerseys',
			) as $n => $alt ) :
				$p = vx_asset( 'assets/img/launch/' . $n . '.webp' ); ?>
			<a class="g-item" href="<?php echo esc_url( $p ); ?>" aria-label="View photo: <?php echo esc_attr( $alt ); ?>">
				<img src="<?php echo esc_url( $p ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" width="1400" height="935">
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
				// Training shoot (assets/video, muted 540x960 clips + WebP posters)
				array( vx_asset( 'assets/video/reel-coach.mp4' ), vx_asset( 'assets/video/reel-coach.webp' ), 'Coach on the ground: bat, glove and a quick demo' ),
				array( vx_asset( 'assets/video/reel-throwdowns.mp4' ), vx_asset( 'assets/video/reel-throwdowns.webp' ), 'Throwdowns in the nets' ),
				array( vx_asset( 'assets/video/reel-grip.mp4' ), vx_asset( 'assets/video/reel-grip.webp' ), 'Ball in hand: grip and release' ),
				array( vx_asset( 'assets/video/reel-stumps.mp4' ), vx_asset( 'assets/video/reel-stumps.webp' ), 'Hit the stumps' ),
				array( vx_landing_uri( 'media/reel-technique.mp4' ), vx_landing_uri( 'media/poster-technique.jpg' ), 'Batting, catching, repeat: a normal Velocrix week' ),
				array( vx_landing_uri( 'media/reel-pov.mp4' ), vx_landing_uri( 'media/poster-pov.jpg' ), 'POV: you\'re a Velocrix student. Practice mode on.' ),
			) as $v ) : ?>
			<figure class="reel-card">
				<video class="reel-vid" src="<?php echo esc_url( $v[0] ); ?>" poster="<?php echo esc_url( $v[1] ); ?>" muted loop playsinline preload="none" aria-label="<?php echo esc_attr( $v[2] ); ?>"></video>
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

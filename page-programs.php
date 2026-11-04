<?php get_header(); vx_page_hero( 'Our <span class="lime">Programs</span>', 'Structured cricket training for every age and level.' );
$progs = array(
	array( 'Foundation Batch', 'For beginners. Grip, stance, basic batting and bowling, catching and ground fielding in a fun, safe setting.', 'Beginner', 'training-2-sm.jpg' ),
	array( 'Skill Development', 'Technique refinement, match awareness and regular progress tracking for players with some experience.', 'Intermediate', 'training-1-sm.jpg' ),
	array( 'Advanced Performance', 'High-intensity sessions, match simulation and scientific training for serious competitors.', 'Advanced', 'training-2-sm.jpg' ),
	array( 'Fitness & Conditioning', 'Strength, agility, mobility and endurance work designed around the demands of cricket.', 'All levels', 'training-1-sm.jpg' ),
);
?>
<section class="section">
	<div class="container">
		<div class="grid-2 prog-list">
			<?php foreach ( $progs as $i => $p ) : ?>
			<article class="photo-card">
				<img src="<?php echo esc_url( VX_URI . '/assets/img/' . $p[3] ); ?>" alt="" loading="lazy" width="800" height="600">
				<div class="pc-body"><span class="num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><span class="tag"><?php echo esc_html( $p[2] ); ?></span><h3><?php echo esc_html( $p[0] ); ?></h3><p><?php echo esc_html( $p[1] ); ?></p><a class="link-arrow" href="<?php echo esc_url( home_url( '/admission/' ) ); ?>">Enquire &rarr;</a></div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>

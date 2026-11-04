<?php get_header(); vx_page_hero( 'Our <span class="lime">Coaches</span>', 'Qualified and experienced coaches, guided by an international cricketer.' ); ?>
<section class="section">
	<div class="container">
		<div class="grid-3">
			<article class="coach">
				<div class="ph"><?php echo ( $m = vx( 'vx_mentor_img' ) ) ? '<img src="' . esc_url( $m ) . '" alt="" loading="lazy">' : 'Photo'; ?></div>
				<h3><?php echo esc_html( vx( 'vx_mentor_name', 'Ms. Meghna Singh' ) ); ?></h3>
				<span class="lime-text"><?php echo esc_html( vx( 'vx_mentor_role', 'International Cricketer' ) ); ?> &middot; Mentor</span>
			</article>
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
			<article class="coach"><div class="ph">Photo</div><h3>Coach Name</h3><span class="lime-text">Head Coach</span></article>
			<?php endfor; ?>
		</div>
		<p class="center muted small">Coach profiles will be added once names and photographs are confirmed.</p>
	</div>
</section>
<?php get_footer(); ?>

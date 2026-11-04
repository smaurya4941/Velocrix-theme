<?php get_header(); vx_page_hero( 'Our <span class="lime">Facilities</span>', 'A professional training environment at Sarvottam International School.' ); ?>
<section class="section">
	<div class="container split">
		<div class="photos single"><img src="<?php echo esc_url( VX_URI . '/assets/img/training-2-sm.jpg' ); ?>" alt="Practice ground with net cage" loading="lazy" width="800" height="600"></div>
		<div>
			<?php vx_heading( 'The Ground', 'Space to <span class="lime">play and grow</span>' ); ?>
			<ul class="check-list">
				<?php foreach ( array( 'Turf practice ground', 'Net practice cage', 'Fitness and warm-up area', 'Quality coaching equipment', 'Safe, school-campus environment' ) as $f ) echo '<li>' . esc_html( $f ) . '</li>'; ?>
			</ul>
		</div>
	</div>
</section>
<?php get_footer(); ?>

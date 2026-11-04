<?php get_header(); vx_page_hero( 'About <span class="lime">Velocrix</span>', 'Cricket coaching with discipline, science and passion.' ); ?>

<section class="section">
	<div class="container split">
		<div>
			<?php vx_heading( 'Who We Are', 'Built for <span class="lime">future champions</span>' ); ?>
			<p>Velocrix Cricket Academy is located at Sarvottam International School, Sector 10 Campus, Greater Noida West, in association with Sarvottam School of Sports: <em>Live the Sport</em>.</p>
			<p>Our approach brings together expert coaching, scientific training and all-round development, so every player grows in skill, fitness and character.</p>
		</div>
		<div class="photos single"><img src="<?php echo esc_url( VX_URI . '/assets/img/training-1-sm.jpg' ); ?>" alt="Coach and players during a warm-up session" loading="lazy" width="800" height="600"></div>
	</div>
</section>

<section class="section dark">
	<div class="container">
		<?php vx_heading( 'Our Philosophy', 'Train hard. Learn smart. <span class="lime">Achieve greatness.</span>', true ); ?>
		<div class="grid-4">
			<?php foreach ( array( array( 'Be Disciplined', 'Consistency on and off the field.' ), array( 'Be Focused', 'Clear goals in every session.' ), array( 'Be Passionate', 'Love for the game drives growth.' ), array( 'Be a Champion', 'Aim high and earn it.' ) ) as $i => $v ) : ?>
				<article class="card num-card"><span class="num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3><?php echo esc_html( $v[0] ); ?></h3><p><?php echo esc_html( $v[1] ); ?></p></article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php vx_heading( 'What You Get', 'Eight reasons to <span class="lime">join us</span>', true ); ?>
		<ul class="check-grid">
			<?php foreach ( array( 'Expert coaching', 'Exposure to international standards', 'Professional training environment', 'Pathway to a professional career', 'Fitness & skill development', 'Teamwork & character building', 'Qualified & experienced coaches', 'All-round development through scientific training' ) as $c ) echo '<li>' . esc_html( $c ) . '</li>'; ?>
		</ul>
	</div>
</section>

<section class="section dark">
	<div class="container split rev">
		<div class="mentor-photo">
			<?php if ( $m = vx( 'vx_mentor_img' ) ) : ?><img src="<?php echo esc_url( $m ); ?>" alt="<?php echo esc_attr( vx( 'vx_mentor_name', 'Ms. Meghna Singh' ) ); ?>" loading="lazy"><?php else : ?><div class="ph">Mentor photo</div><?php endif; ?>
		</div>
		<div>
			<?php vx_heading( 'Mentorship', esc_html( vx( 'vx_mentor_name', 'Ms. Meghna Singh' ) ) ); ?>
			<p class="lime-text"><?php echo esc_html( vx( 'vx_mentor_role', 'International Cricketer' ) ); ?></p>
			<p><?php echo esc_html( vx( 'vx_mentor_bio', 'Velocrix Cricket Academy functions under the mentorship of Ms. Meghna Singh.' ) ); ?></p>
		</div>
	</div>
</section>
<?php get_footer(); ?>

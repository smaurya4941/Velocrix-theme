<?php
get_header();

get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'Our Team',
	'title'   => 'Guiding Every Step<br>Toward Greatness',
	'text'    => 'Led by experience and driven by passion, our team helps players evolve on and off the field.',
	'image'   => VX_URI . '/assets/img/hero-team.jpg',
) );
?>

<section class="section team-sec">
	<div class="container">
		<div class="cc-grid">
			<?php foreach ( vx_coaches() as $c ) get_template_part( 'template-parts/coach-card', null, $c ); ?>
		</div>
		<p class="center muted small team-note">More coach profiles will be added here soon.</p>
	</div>
</section>

<?php get_template_part( 'template-parts/cta' ); ?>

<?php get_footer(); ?>

<?php
get_header();
while ( have_posts() ) : the_post();
	vx_page_hero( get_the_title() );
	?>
	<section class="section">
		<div class="container narrow prose"><?php the_content(); ?></div>
	</section>
<?php endwhile;
get_footer();

<?php
get_header();
while ( have_posts() ) : the_post();
	vx_page_hero( get_the_title(), get_the_date(), 'Article' );
	?>
	<article class="section">
		<div class="container narrow prose">
			<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large', array( 'class' => 'feat-img' ) ); ?>
			<?php the_content(); ?>
		</div>
	</article>
<?php endwhile;
get_footer();

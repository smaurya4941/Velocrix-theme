<?php
// Blog list / archives / search (fallback for everything)
get_header();
vx_page_hero( is_home() ? 'Blog & <span class="lime">News</span>' : wp_strip_all_tags( get_the_archive_title() ), 'Cricket tips, academy news and updates.', 'Articles' );
?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid-3">
				<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/post-card' ); endwhile; ?>
			</div>
			<div class="pager"><?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '&larr;', 'next_text' => '&rarr;' ) ); ?></div>
		<?php else : ?>
			<p class="center muted">No articles yet. Check back soon.</p>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>

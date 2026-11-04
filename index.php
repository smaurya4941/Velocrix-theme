<?php
// Blog list / category / tag / search (fallback for everything not covered by another template)
get_header();

if ( is_search() ) {
	$hero = array( 'eyebrow' => 'Search', 'title' => 'Results for<br>&ldquo;' . esc_html( get_search_query() ) . '&rdquo;', 'text' => 'Articles matching your search.' );
} elseif ( is_home() || is_front_page() ) {
	$hero = array( 'eyebrow' => 'Blog & Articles', 'title' => 'From the Field<br>to Community', 'text' => 'Stories, tips and updates from Velocrix to connect players, share experiences and celebrate the people behind every session.' );
} else {
	$hero = array( 'eyebrow' => 'Articles', 'title' => wp_strip_all_tags( get_the_archive_title() ), 'text' => 'Cricket tips, academy news and updates.' );
}
$hero['image'] = VX_URI . '/assets/img/hero-blog.jpg';
get_template_part( 'template-parts/hero-page', null, $hero );
?>

<section class="section blog-sec">
	<div class="container blog-layout">
		<div class="blog-main">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/post-row' ); endwhile; ?>
				<?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) :
					$prev = get_previous_posts_page_link(); $next = get_next_posts_page_link(); $paged = max( 1, get_query_var( 'paged' ) ); ?>
					<nav class="pg-btns" aria-label="Pagination">
						<a class="btn<?php echo $paged > 1 ? '' : ' is-off'; ?>" <?php echo $paged > 1 ? 'href="' . esc_url( $prev ) . '"' : 'aria-disabled="true"'; ?>>&lsaquo; Prev</a>
						<a class="btn<?php echo $next ? '' : ' is-off'; ?>" <?php echo $next ? 'href="' . esc_url( $next ) . '"' : 'aria-disabled="true"'; ?>>Next &rsaquo;</a>
					</nav>
				<?php endif; ?>
			<?php else : ?>
				<p class="big-empty">No articles found. Try another search or <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">view all articles</a>.</p>
			<?php endif; ?>
		</div>
		<?php get_template_part( 'template-parts/blog-sidebar' ); ?>
	</div>
</section>

<?php get_footer(); ?>

<?php /** Blog sidebar: search + recent posts */ ?>
<aside class="blog-side">
	<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" name="s" placeholder="Search" value="<?php echo esc_attr( get_search_query() ); ?>" aria-label="Search articles">
		<button class="round-btn is-lime" type="submit" aria-label="Search"><?php echo vx_icon( 'search' ); // phpcs:ignore ?></button>
	</form>
	<?php $recent = get_posts( array( 'numberposts' => 3, 'post_status' => 'publish' ) ); if ( $recent ) : ?>
	<div class="recent">
		<h3>Recent Post</h3>
		<?php foreach ( $recent as $p ) : ?>
		<a class="rc-item" href="<?php echo esc_url( get_permalink( $p ) ); ?>">
			<b><?php echo esc_html( get_the_title( $p ) ); ?></b>
			<small><?php echo vx_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( get_the_date( '', $p ) ); ?></small>
		</a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</aside>

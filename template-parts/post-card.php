<article class="photo-card post-card">
	<a href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'vx-card', array( 'loading' => 'lazy' ) ); else echo '<div class="ph">Velocrix</div>'; ?>
	</a>
	<div class="pc-body">
		<span class="meta"><?php echo esc_html( get_the_date() ); ?><?php $c = get_the_category(); if ( $c ) echo ' &middot; ' . esc_html( $c[0]->name ); ?></span>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
		<a class="link-arrow" href="<?php the_permalink(); ?>">Read more &rarr;</a>
	</div>
</article>

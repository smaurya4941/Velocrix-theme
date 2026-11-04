<?php /** Blog list row: image left, text right (used by blog, category, search) */
$cat = get_the_category(); $cat = $cat ? $cat[0]->name : 'Academy'; ?>
<article class="post-row">
	<a class="pr-img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?></a>
	<div class="pr-body">
		<span class="chip"><?php echo esc_html( $cat ); ?></span>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
	</div>
</article>

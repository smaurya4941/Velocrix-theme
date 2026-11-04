<?php
get_header();

while ( have_posts() ) : the_post();

	$cat    = get_the_category();
	$cat    = $cat ? $cat[0]->name : 'Academy';
	$hero   = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'full' ) : VX_URI . '/assets/img/hero-blog.jpg';
	$url    = rawurlencode( get_permalink() );
	$title  = rawurlencode( get_the_title() );
	$shares = array(
		array( 'Facebook', 'facebook', 'https://www.facebook.com/sharer/sharer.php?u=' . $url ),
		array( 'X', 'x', 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title ),
		array( 'LinkedIn', 'linkedin', 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url ),
		array( 'WhatsApp', 'whatsapp', 'https://wa.me/?text=' . $title . '%20' . $url ),
	);

	// 1. HERO (shared part) with author + date on the right
	ob_start(); ?>
	<div class="post-meta">
		<span><?php echo vx_icon( 'user' ); // phpcs:ignore ?> <?php echo esc_html( get_the_author() ?: 'Velocrix Academy' ); ?></span>
		<span><?php echo vx_icon( 'calendar' ); // phpcs:ignore ?> <?php echo esc_html( get_the_date() ); ?></span>
	</div>
	<?php
	get_template_part( 'template-parts/hero-page', null, array(
		'eyebrow' => $cat,
		'title'   => esc_html( get_the_title() ),
		'image'   => $hero,
		'class'   => 'hero-single',
		'dot'     => false,
		'side'    => ob_get_clean(),
	) );
	?>

	<!-- 2. ARTICLE -->
	<article <?php post_class( 'section post-sec' ); ?>>
		<div class="post-wrap">
			<div class="share">
				<span class="share-label">Share :</span>
				<?php foreach ( $shares as $s ) : ?>
					<a class="share-btn" href="<?php echo esc_url( $s[2] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on <?php echo esc_attr( $s[0] ); ?>"><?php echo vx_icon( $s[1] ); // phpcs:ignore ?></a>
				<?php endforeach; ?>
			</div>

			<div class="post-main">
				<div class="prose post-content"><?php the_content(); ?></div>

				<?php $tags = get_the_tags(); if ( $tags ) : ?>
				<div class="post-tags">
					<span>Tags :</span>
					<?php foreach ( $tags as $t ) echo '<a class="chip" href="' . esc_url( get_tag_link( $t ) ) . '">' . esc_html( $t->name ) . '</a>'; ?>
				</div>
				<?php endif; ?>

				<hr class="post-div">

				<?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
			</div>
		</div>
	</article>

<?php endwhile;
get_footer();

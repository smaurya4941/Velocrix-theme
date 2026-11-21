<?php get_header(); vx_page_hero( '404: <span class="lime">Out of the park</span>', 'The page you are looking for does not exist. Try one of these instead.', 'Not found' ); ?>
<section class="section nf-sec">
	<div class="container">
		<div class="nf-grid">
			<?php foreach ( array(
				array( '/', 'Home', 'Back to the start' ),
				array( '/pricing/', 'Packages', 'Plans and fees' ),
				array( '/meghna-singh/', 'Our Mentor', 'Meet Meghna Singh' ),
				array( '/registration/', 'Join Now', 'Trainee registration' ),
				array( '/contact/', 'Contact', 'Call, write or visit' ),
			) as $l ) : ?>
			<a class="nf-link" href="<?php echo esc_url( home_url( $l[0] ) ); ?>"><span><b><?php echo esc_html( $l[1] ); ?></b><small><?php echo esc_html( $l[2] ); ?></small></span><span class="round-btn"><?php echo vx_icon( 'arrow' ); // phpcs:ignore ?></span></a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>

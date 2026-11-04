<?php get_header(); vx_page_hero( '<span class="lime">Gallery</span>', 'Moments from the training ground.' );
// Shows images attached to this page; falls back to theme photos.
$imgs = get_attached_media( 'image', get_the_ID() );
?>
<section class="section">
	<div class="container">
		<div class="gallery">
			<?php if ( $imgs ) : foreach ( $imgs as $im ) : ?>
				<a href="<?php echo esc_url( wp_get_attachment_url( $im->ID ) ); ?>"><?php echo wp_get_attachment_image( $im->ID, 'vx-card', false, array( 'loading' => 'lazy' ) ); ?></a>
			<?php endforeach; else :
				foreach ( array( 'training-1', 'training-2' ) as $n ) : ?>
				<a href="<?php echo esc_url( VX_URI . "/assets/img/$n.jpg" ); ?>"><img src="<?php echo esc_url( VX_URI . "/assets/img/$n-sm.jpg" ); ?>" alt="Training session" loading="lazy" width="800" height="600"></a>
			<?php endforeach; endif; ?>
		</div>
		<p class="center muted small">Upload photos to this page in the admin (Media &rarr; attach to Gallery page) and they appear here automatically.</p>
	</div>
</section>
<?php get_footer(); ?>

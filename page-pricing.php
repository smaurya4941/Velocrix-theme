<?php get_header(); vx_page_hero( 'Training <span class="lime">Fees</span>', 'Choose a plan that fits your goals.' ); ?>
<section class="section">
	<div class="container">
		<div class="grid-4">
			<?php foreach ( vx_plans() as $p ) : ?>
			<div class="plan<?php echo $p['feat'] ? ' feat' : ''; ?>">
				<?php if ( $p['feat'] ) echo '<span class="tag">Popular</span>'; ?>
				<h3><?php echo esc_html( $p['name'] ); ?></h3>
				<div class="price"><sup>&#8377;</sup><?php echo esc_html( $p['price'] ); ?></div>
				<p><?php echo esc_html( $p['desc'] ); ?></p>
				<a class="btn btn-sm" href="<?php echo esc_url( home_url( '/admission/' ) ); ?>">Enrol</a>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="reg-box">
			<div><small>One-time registration fee</small><strong>&#8377;<?php echo esc_html( vx( 'vx_regfee', '1,999' ) ); ?></strong></div>
			<p><?php echo wp_kses_post( vx_lime( vx( 'vx_regnote', 'Early bird discount available. *Terms & conditions apply.' ) ) ); ?></p>
		</div>
	</div>
</section>

<section class="section dark">
	<div class="container narrow">
		<?php vx_heading( 'FAQ', 'Common <span class="lime">questions</span>', true ); ?>
		<?php foreach ( array(
			array( 'Is the registration fee separate from training fees?', 'Yes. Registration is a one-time fee, and the training plan is paid separately.' ),
			array( 'Who can join?', 'Players of all levels, from complete beginners to advanced. Contact us to find the right batch.' ),
			array( 'Is the early bird discount still available?', 'Please call the academy to confirm current offers and terms.' ),
		) as $f ) : ?>
			<details class="faq"><summary><?php echo esc_html( $f[0] ); ?></summary><p><?php echo esc_html( $f[1] ); ?></p></details>
		<?php endforeach; ?>
	</div>
</section>
<?php get_footer(); ?>

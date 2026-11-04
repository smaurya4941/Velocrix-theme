<?php get_header(); vx_page_hero( 'Join the <span class="lime">Academy</span>', 'Register for a trial or enquire about admission.' ); ?>
<section class="section" id="form">
	<div class="container split">
		<div>
			<?php vx_heading( 'Admission', 'Start your <span class="lime">cricket journey</span>' ); ?>
			<p>Fill in the form and our team will call you back. Registration fee: <strong>&#8377;<?php echo esc_html( vx( 'vx_regfee', '1,999' ) ); ?></strong> (early bird discount available).</p>
			<ul class="check-list">
				<li>Expert coaching</li><li>Fitness &amp; skill development</li><li>Teamwork &amp; character building</li><li>Pathway to a professional career</li>
			</ul>
			<p class="muted">Or call: <a class="lime-text" href="<?php echo esc_url( vx_phone_href( vx( 'vx_phone', '+91 879 644 7595' ) ) ); ?>"><?php echo esc_html( vx( 'vx_phone', '+91 879 644 7595' ) ); ?></a></p>
		</div>
		<div class="form-card"><?php vx_form( 'admission' ); ?></div>
	</div>
</section>
<?php get_footer(); ?>

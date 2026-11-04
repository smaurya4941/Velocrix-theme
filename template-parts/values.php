<?php /** Dark "Be disciplined / focused / passionate / a champion" cards (from the official poster) */ ?>
<section class="section dark">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow">Our Values</span>
			<h2>Be Disciplined. Be Focused.<br>Be Passionate. Be a Champion.</h2>
		</div>
		<div class="grid-4">
			<?php foreach ( array(
				array( 'Be Disciplined', 'Consistency and respect for the process, on and off the field.' ),
				array( 'Be Focused', 'A clear goal in every session and every drill.' ),
				array( 'Be Passionate', 'Love for the game is what keeps you training.' ),
				array( 'Be a Champion', 'Aim high, work hard and earn it.' ),
			) as $i => $v ) : ?>
				<article class="card num-card"><span class="num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3><?php echo esc_html( $v[0] ); ?></h3><p><?php echo esc_html( $v[1] ); ?></p></article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

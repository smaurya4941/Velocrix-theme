<?php
/**
 * Classic Home: "Want to bowl faster? Start with your action."
 * Ported from template-parts/landing/sections/bowl.php. Text uses only verified facts
 * (Meghna Singh is a right-arm medium-fast bowler, see page-meghna-singh.php). The trial CTA is the owner's request (2026-11-20).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$mentor = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
?>
<section class="hx hx-bowl" aria-labelledby="hx-bowl-h" data-hx-gfx="icons">
	<div class="container hx-bowl-in">
		<div class="hx-photo hx-rv" data-hx-tilt><img src="<?php echo esc_url( vx_landing_uri( 'media/bowler-follow.jpg' ) ); ?>" alt="A Velocrix student in his bowling delivery stride, ball about to leave his hand" loading="lazy" width="1080" height="1435"></div>
		<div class="hx-bowl-copy hx-rv">
			<p class="hx-kicker">Built for fast bowlers too</p>
			<h2 id="hx-bowl-h">Want to bowl faster? <em>Start with your action.</em></h2>
			<p class="hx-lede">Pace comes from a repeatable, efficient action, not from running in harder. Our bowlers work on run-up rhythm, load-up and follow-through, mentored by <?php echo esc_html( $mentor ); ?>, an India international and right-arm medium-fast bowler. We look at every bowler's action from day one, so bad habits never set in.</p>
			<a class="btn btn-ghost hx-mag" href="<?php echo esc_url( vx_trial_url() ); ?>" target="_blank" rel="noopener">Bring your bowler for a trial</a>
		</div>
	</div>
</section>

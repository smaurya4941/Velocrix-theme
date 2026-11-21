<?php
/**
 * Classic Home: "One session, laid out on 22 yards" (a pitch with 5 session stages; a ball rolls to the active one).
 * Ported from template-parts/landing/sections/yards.php, text limited to Velocrix's own facts
 * (turf ground + net practice, see inc/content.php). Styles: assets/css/home-extras.css, script: assets/js/home-extras.js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$stages = array(
	array( 'Warm-up', 'Mobility and running drills to get bodies ready.' ),
	array( 'Skill block', "The day's focus, taught and demonstrated." ),
	array( 'Drills and nets', 'Small groups rotate through drills and net practice.' ),
	array( 'Short game', 'Put the skill to work under game pressure.' ),
	array( 'Cool-down and feedback', 'Stretch, recap the day and hear from the coach.' ),
);
?>
<section class="hx hx-yards" aria-labelledby="hx-yards-h" data-hx-gfx="field:right">
	<div class="container hx-yards-in">
		<div class="hx-head hx-rv">
			<h2 id="hx-yards-h">One session, laid out on <em>22 yards.</em></h2>
			<p class="hx-lede">Every session follows the same plan, so your child always knows what comes next.</p>
			<span class="hx-hint"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 11V5a2 2 0 0 1 4 0v5"/><path d="M13 10V8a2 2 0 0 1 4 0v4"/><path d="M17 11a2 2 0 0 1 4 0v3a7 7 0 0 1-7 7h-1a7 7 0 0 1-6-3.4L4.5 14a2 2 0 0 1 3.3-2.2L9 13.5"/></svg>Tap a stage to bowl the ball down the pitch</span>
		</div>
		<div class="hx-pitch hx-rv" role="group" aria-label="The five parts of a training session">
			<span class="hx-stumps l" aria-hidden="true"><i></i><i></i><i></i></span>
			<span class="hx-stumps r" aria-hidden="true"><i></i><i></i><i></i></span>
			<span class="hx-ball" aria-hidden="true"></span>
			<ol class="hx-stops">
				<?php foreach ( $stages as $s ) : ?>
				<li tabindex="0"><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></li>
				<?php endforeach; ?>
			</ol>
		</div>
		<div class="hx-creases" aria-hidden="true"><span>Bowling crease</span><span>Batting crease</span></div>
	</div>
</section>

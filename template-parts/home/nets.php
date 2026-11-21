<?php
/**
 * Classic Home: "Life at the nets" (card fan with a video + 2 photos).
 * Ported from the animated section template-parts/landing/sections/moments.php.
 * Styles: assets/css/home-extras.css, script: assets/js/home-extras.js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$mom = array(
	array( 'At the nets', 'Ball 1 of 3: batting, catching, repeat' ),
	array( 'The load-up', 'Ball 2 of 3: high arm, eyes on the target' ),
	array( 'Focus', 'Ball 3 of 3: every delivery starts in the head' ),
);
?>
<section class="hx hx-nets" aria-labelledby="hx-nets-h" data-hx-gfx="seams">
	<div class="container hx-nets-in">
		<div class="hx-head hx-rv">
			<h2 id="hx-nets-h">Life at the <em>nets.</em></h2>
			<p class="hx-lede">Three moments from a normal Velocrix week. Tap a card, or let them play.</p>
			<a class="btn btn-ghost hx-mag" href="<?php echo esc_url( vx_lab_tool_url( 'level-check' ) ); ?>">Check my child's level</a>
		</div>
		<div class="hx-stage hx-rv" data-hx-fan data-caps="<?php echo esc_attr( wp_json_encode( $mom ) ); ?>">
			<div class="hx-fan" aria-label="Moments from Velocrix training">
				<div class="hx-card" data-i="0" data-slot="0">
					<video class="hx-auto" src="<?php echo esc_url( vx_landing_uri( 'media/reel-technique.mp4' ) ); ?>" poster="<?php echo esc_url( vx_landing_uri( 'media/poster-technique.jpg' ) ); ?>" muted loop playsinline preload="none" aria-label="Velocrix students batting in the nets and catching"></video>
					<span class="hx-tag"><span class="hx-live" aria-hidden="true"></span>At the nets</span>
				</div>
				<div class="hx-card" data-i="1" data-slot="1"><img src="<?php echo esc_url( vx_landing_uri( 'media/bowler-load.jpg' ) ); ?>" alt="A Velocrix student at the top of his bowling action, arm high" width="1080" height="1435" loading="lazy"></div>
				<div class="hx-card" data-i="2" data-slot="2"><img src="<?php echo esc_url( vx_landing_uri( 'media/focus-ball.jpg' ) ); ?>" alt="A young Velocrix student holding a red ball, focused, before his run-up" width="1080" height="1435" loading="lazy"></div>
			</div>
			<div class="hx-stepper">
				<button type="button" class="hx-prev" aria-label="Previous moment"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg></button>
				<div class="hx-cap" aria-live="polite"><b><?php echo esc_html( $mom[0][0] ); ?></b><span><?php echo esc_html( $mom[0][1] ); ?></span></div>
				<button type="button" class="hx-next" aria-label="Next moment"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></button>
			</div>
			<div class="hx-dots" aria-hidden="true"><i class="on"></i><i></i><i></i></div>
		</div>
	</div>
</section>

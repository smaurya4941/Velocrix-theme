<?php
/**
 * Section "bowl": Want to bowl faster? Start with your action.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="bowl" aria-labelledby="bowl-h" style="padding-top:0" data-gfx="icons">
    <div class="wrap">
      <div class="photo" data-tilt><img src="<?php echo esc_url( vx_landing_uri( 'media/bowler-follow.jpg' ) ); ?>" alt="A Velocrix student in his bowling delivery stride, ball about to leave his hand" loading="lazy" width="1080" height="1435"></div>
      <div style="display:grid;gap:18px" data-reveal>
        <p class="kicker">Built for fast bowlers too</p>
        <h2 id="bowl-h">Want to bowl faster? <em>Start with your action.</em></h2>
        <p class="lede">Pace comes from a repeatable, efficient action, not from running in harder. Our bowlers work on run-up rhythm, load-up and follow-through every Wednesday, with a former India seamer's methods behind every drill. We look at every bowler's action at the trial, so bad habits never set in.</p>
        <a class="btn btn-ghost mag" href="<?php echo esc_url( vx_lx( 'visit' ) ); ?>" style="justify-self:start">Bring your bowler for a trial</a>
      </div>
    </div>
  </section>

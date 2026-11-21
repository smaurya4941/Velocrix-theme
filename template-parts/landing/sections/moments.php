<?php
/**
 * Section "moments": Life at the nets.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="moments" aria-labelledby="mom-h" data-gfx="seams">
    <div class="wrap">
      <div class="sec-head" style="margin-bottom:0" data-reveal>
        <h2 id="mom-h">Life at the <em>nets.</em></h2>
        <p class="lede">Three moments from a normal Velocrix week. Tap a card, or let them play.</p>
        <a class="btn btn-ghost mag" href="<?php echo esc_url( vx_lx( 'level' ) ); ?>" style="justify-self:start">Check my child's level</a>
      </div>
      <div class="stage" data-reveal>
        <div class="fan" id="fan" aria-label="Moments from Velocrix training">
          <div class="card-m" data-i="0" data-slot="0">
            <video class="auto" src="<?php echo esc_url( vx_landing_uri( 'media/reel-technique.mp4' ) ); ?>" poster="<?php echo esc_url( vx_landing_uri( 'media/poster-technique.jpg' ) ); ?>" muted loop playsinline preload="metadata" aria-label="Velocrix students batting in the nets and catching"></video>
            <span class="tag"><span class="live-dot"></span>At the nets</span>
          </div>
          <div class="card-m" data-i="1" data-slot="1"><img src="<?php echo esc_url( vx_landing_uri( 'media/bowler-load.jpg' ) ); ?>" alt="A Velocrix student at the top of his bowling action, arm high" width="1080" height="1435"></div>
          <div class="card-m" data-i="2" data-slot="2"><img src="<?php echo esc_url( vx_landing_uri( 'media/focus-ball.jpg' ) ); ?>" alt="A young Velocrix student holding a red ball, focused, before his run-up" width="1080" height="1435"></div>
        </div>
        <div class="stepper">
          <button type="button" id="prevCard" aria-label="Previous moment"><svg aria-hidden="true"><use href="#i-left"/></svg></button>
          <div class="cap" aria-live="polite"><b id="capT">At the nets</b><span id="capS">Ball 1 of 3: batting, catching, repeat</span></div>
          <button type="button" id="nextCard" aria-label="Next moment"><svg aria-hidden="true"><use href="#i-right"/></svg></button>
        </div>
        <div class="dots" id="dots" aria-hidden="true"><i class="on"></i><i></i><i></i></div>
      </div>
    </div>
  </section>

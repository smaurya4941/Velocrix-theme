<?php
/**
 * Section "delivery": One delivery.Half a second.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="st" id="delivery" aria-labelledby="st-h">
    <div class="st-stage">
      <canvas id="storyCanvas" aria-label="A 3D cricket ball bowled down the pitch as you scroll"></canvas>
      <div class="st-shade st-fade" aria-hidden="true"></div>
      <div class="st-copy">
        <div class="wrap">
          <p class="kicker">Scroll to bowl</p>
          <h2 id="st-h">One delivery.<span>Half a second.</span></h2>
          <p class="lede">Keep scrolling and watch a good-length ball travel 22 yards, find the gap and hit off stump. Reading that ball early is a skill, and it is trained at Velocrix.</p>
          <div class="hero-ctas"><a class="btn btn-primary mag" href="<?php echo esc_url( vx_lx( 'lab' ) ); ?>">Open the Training Lab</a></div>
        </div>
      </div>
      <div class="st-rail st-fade" aria-hidden="true"><span>Scroll</span><i></i></div>
      <div class="st-hud" id="storyHud" aria-live="polite">
        <div class="st-hud-top"><span id="hudStep">Delivery 1 / 5</span><b>VELOCRIX TV</b></div>
        <div class="st-hud-body">
          <div class="st-hud-title" id="hudTitle">The new ball</div>
          <div class="st-hud-text" id="hudText">Cork, leather and six rows of hand stitching. Scroll to send it down.</div>
          <div class="st-hud-chips" id="hudChips"><span>156 g</span><span>22.4 cm</span><span>6 rows</span></div>
        </div>
        <div class="st-hud-segs" id="hudSegs"><i class="on"></i><i></i><i></i><i></i><i></i></div>
        <div class="st-hud-bar"><i id="hudBar"></i></div>
      </div>
    </div>
  </section>

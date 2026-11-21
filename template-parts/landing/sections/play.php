<?php
/**
 * Section "play": Your turn to bat.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="gx" id="play" aria-labelledby="gx-h" data-gfx="rosette:left">
    <div class="wrap">
      <div class="gx-head">
        <div class="sec-head" style="margin-bottom:0">
          <p class="kicker">Nets Challenge</p>
          <h2 id="gx-h">Your turn <em>to bat.</em></h2>
          <p class="lede">A short 3D batting game against the Velocrix bowling machine. Three wickets and the innings is over.</p>
        </div>
        <ol class="gx-howto">
          <li><b>Pick a level</b><span>Easy, Medium or Hard. Harder levels bowl faster, with more swing and surprise deliveries.</span></li>
          <li><b>Swing as it arrives</b><span>Click, tap the Swing button, or press Space just before the ball reaches the bat.</span></li>
          <li><b>Time it well</b><span>Perfect timing is a six. Early goes leg side, late goes off side. Miss a straight one and you're bowled.</span></li>
          <li><b>Beat your best</b><span>Your best score for each level is saved on this device.</span></li>
        </ol>
      </div>
      <div class="game" id="gameStage">
        <canvas id="gameCanvas" aria-label="3D batting game. Press Space or tap to swing."></canvas>
        <div class="g-board">
          <div class="g-score"><span class="g-k">Runs / wkts</span><b id="gScore">0<span>/0</span></b></div>
          <div class="g-mini"><div><span class="g-k">Balls</span><b id="gBalls">0</b></div><div><span class="g-k">Strike rate</span><b id="gSR">0</b></div><div><span class="g-k">Best</span><b id="gBest">0</b></div></div>
        </div>
        <div class="g-right">
          <div class="g-lvl"><i id="gLight"></i><span id="gLevelLbl">Medium</span></div>
          <div class="g-over" id="gOver"></div>
          <button class="g-mute" id="gMute" aria-label="Sound on" type="button"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 9h4l5-4v14l-5-4H4z"/><path class="w" d="M16.5 8.5a5 5 0 0 1 0 7M19 6a8.5 8.5 0 0 1 0 12"/><path class="x" d="M17 9l5 6M22 9l-5 6"/></svg></button>
        </div>
        <div class="g-comm" id="gComm" aria-live="polite"></div>
        <div class="g-meter" id="gMeter"><div class="g-track"><i class="z early"></i><i class="z good"></i><i class="z perf"></i><i class="z good"></i><i class="z late"></i><b id="gMark"></b></div><div class="g-ml"><span>Early</span><strong id="gMeterLbl">Perfect timing</strong><span>Late</span></div></div>
        <button class="g-swing" id="gSwing" type="button">Swing</button>
        <div class="g-menu" id="gMenu">
          <div class="g-card">
            <p class="kicker" style="color:var(--on-band-2)">Nets Challenge</p>
            <h3 id="gMenuTitle">Choose your <span>level.</span></h3>
            <p id="gMenuText">Click, tap or press Space to swing. Three wickets and the innings is over.</p>
            <div class="g-levels" id="gLevels">
              <button data-v="easy" type="button"><b>Easy</b><span>80–90 km/h · generous timing</span><small>Best 0</small></button>
              <button data-v="medium" class="on" type="button"><b>Medium</b><span>105–120 km/h · swing and seam</span><small>Best 0</small></button>
              <button data-v="hard" type="button"><b>Hard</b><span>130–145 km/h · yorkers, bouncers, slower balls</span><small>Best 0</small></button>
            </div>
            <div class="g-actions">
              <button class="btn btn-primary" id="gStart" type="button">Take guard</button>
              <a class="btn g-ghost" id="gApply" href="<?php echo esc_url( vx_lx( 'visit' ) ); ?>" hidden>Train for real</a>
            </div>
            <div class="g-keys"><span><kbd>Space</kbd> or tap to swing</span><span><kbd>Enter</kbd> to start</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>

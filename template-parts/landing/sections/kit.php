<?php
/**
 * Section "kit": Before your trial.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="kit" id="kit" aria-labelledby="kit-h" style="padding-top:0" data-gfx="icons">
    <div class="wrap">
      <div class="sec-head" data-reveal>
        <h2 id="kit-h">Before your <em>trial.</em></h2>
        <p class="lede">Three quick tools: find the right bat size, warm up at home, and pack the bag.</p>
      </div>
      <div class="kit-grid">
        <div class="tool" data-reveal>
          <h3>Which bat size?</h3>
          <p class="s">A bat that's too big ruins technique. Move the slider to your child's height.</p>
          <div class="hrow"><input type="range" id="hgt" min="110" max="185" value="140" aria-label="Child's height in centimetres"><span class="hval" id="hval">140 cm</span></div>
          <div class="batviz" aria-hidden="true"><span class="kid" id="kidBar"></span><span class="bat" id="batBar"></span><div style="display:grid;gap:4px;align-self:center"><span class="bsize" id="bsize">Size 3</span><span class="hint" id="bage">Usually ages 8 to 10</span></div></div>
          <p class="s" style="font-size:.82rem">Height ranges follow a standard junior bat chart. We'll check the fit at the trial.</p>
          <a class="kit-3d" href="<?php echo esc_url( vx_lx( 'lab-stance' ) ); ?>" id="kitTo3d">See this bat and stance in 3D <svg aria-hidden="true" width="14" height="14"><use href="#i-right"/></svg></a>
        </div>
        <div class="tool" data-reveal>
          <h3>Two-minute warm-up</h3>
          <p class="s">Six moves, 20 seconds each. Do it before every session.</p>
          <div class="timer">
            <svg viewBox="0 0 110 110" aria-hidden="true"><circle cx="55" cy="55" r="48" fill="none" stroke="var(--line)" stroke-width="8"/><circle id="tring" cx="55" cy="55" r="48" fill="none" stroke="var(--cherry)" stroke-width="8" stroke-linecap="round" stroke-dasharray="301.6" stroke-dashoffset="0" transform="rotate(-90 55 55)" style="transition:stroke-dashoffset 1s linear"/><text x="55" y="65" text-anchor="middle" class="sec" id="tsec" fill="var(--ink)">20</text></svg>
            <div class="move" aria-live="polite"><span id="mstep">Move 1 of 6</span><b id="mname">Arm circles</b><span id="mtip">Big circles forwards, then backwards.</span></div>
          </div>
          <div class="tacts"><button class="btn btn-primary btn-sm" type="button" id="tstart"><svg aria-hidden="true"><use href="#i-play"/></svg><span>Start</span></button><button class="btn btn-ghost btn-sm" type="button" id="tnext">Next move</button></div>
        </div>
        <div class="tool" data-reveal>
          <h3>Trial-day bag</h3>
          <p class="s">Tick things off. We'll remember on this device.</p>
          <ul class="check" id="check"></ul>
        </div>
      </div>
    </div>
  </section>

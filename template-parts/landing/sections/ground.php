<?php
/**
 * Section "ground": Walk around the ground.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="fx" id="ground" aria-labelledby="fx-h" data-gfx="field:tr">
    <div class="wrap">
      <div class="sec-head" data-reveal>
        <p class="kicker">Our ground</p>
        <h2 id="fx-h">Walk around <em>the ground.</em></h2>
        <p class="lede">A 3D model of our training area at Sarvottam International School, Sector 10: the clay pitch, the bowling machine, the nets and the drills zone. Drag to look around, or tap a stop.</p>
      </div>
      <div class="fx-tour" data-reveal>
        <canvas id="facCanvas" aria-label="3D model of the Velocrix training area"></canvas>
        <div class="lx-pills fx-pills" id="facBtns"></div>
        <div class="fx-card">
          <div class="fx-nav"><span id="facIdx">1 / 5</span><div><button type="button" id="facPrev" aria-label="Previous stop"><svg aria-hidden="true"><use href="#i-left"/></svg></button><button type="button" id="facNext" aria-label="Next stop"><svg aria-hidden="true"><use href="#i-right"/></svg></button></div></div>
          <h3 id="facTitle">Clay pitch</h3>
          <p id="facText"></p>
        </div>
        <span class="fx-note">Illustrative model</span>
      </div>
    </div>
  </section>

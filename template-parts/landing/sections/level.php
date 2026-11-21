<?php
/**
 * Section "level": Grouped by ability, as well as age.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="lvls" id="level" aria-labelledby="lv-h" style="padding-top:0" data-gfx="contour:bl">
    <div class="wrap">
      <div class="sec-head" data-reveal>
        <h2 id="lv-h">Grouped by ability, <em>as well as age.</em></h2>
        <p class="lede">At the free trial we watch your child bat and bowl, then place them in one of three levels. We review the level every quarter with a written progress card.</p>
      </div>
      <div class="levels" id="levels" data-reveal>
        <div class="lv" data-lv="Beginner"><div class="bar" aria-hidden="true"><i class="on"></i><i></i><i></i></div><h3>Beginner</h3><p>New to the game. Grip, stance, a safe bowling action and the joy of hitting the ball well.</p></div>
        <div class="lv" data-lv="Development"><div class="bar" aria-hidden="true"><i class="on"></i><i class="on"></i><i></i></div><h3>Development</h3><p>Can bat and bowl the basics. Now it's footwork, consistency and reading the game.</p></div>
        <div class="lv" data-lv="Advanced"><div class="bar" aria-hidden="true"><i class="on"></i><i class="on"></i><i class="on"></i></div><h3>Advanced</h3><p>Match players. Pressure batting, plans for each bowler, and preparation for trials and tournaments.</p></div>
      </div>

      <div class="quiz" id="quiz" data-reveal>
        <div class="quiz-top"><h3>Level check: five quick questions</h3><span class="qcount" id="qcount">Question 1 of 5</span></div>
        <div class="qbar"><i id="qbar"></i></div>
        <div id="qbody"></div>
      </div>
    </div>
  </section>

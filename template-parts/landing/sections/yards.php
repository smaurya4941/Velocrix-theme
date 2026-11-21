<?php
/**
 * Section "yards": One session, laid out on 22 yards.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="yards" id="yards" aria-labelledby="yards-h" data-gfx="field:right">
    <div class="wrap pitch-wrap">
      <div class="sec-head" data-reveal>
        <h2 id="yards-h">One session, laid out on <em>22 yards.</em></h2>
        <p class="lede">The plan never changes, so any coach can run a Velocrix session the Velocrix way, and your child knows exactly what comes next.</p>
        <span class="hint"><svg aria-hidden="true"><use href="#i-hand"/></svg>Tap a stage to bowl the ball down the pitch</span>
      </div>
      <div class="pitch" id="pitch" role="group" aria-label="The five parts of a training session">
        <span class="stumps l" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="stumps r" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="ball" id="pball" aria-hidden="true"></span>
        <ol class="stops" id="stops">
          <li tabindex="0"><h3>Warm-up</h3><p>Mobility and running drills to get bodies ready.</p></li>
          <li tabindex="0"><h3>Skill block</h3><p>The day's focus, taught and demonstrated.</p></li>
          <li tabindex="0"><h3>Drills and machine</h3><p>Small groups rotate through drills and the bowling machine.</p></li>
          <li tabindex="0"><h3>Short game</h3><p>Put the skill to work under game pressure.</p></li>
          <li tabindex="0"><h3>Cool-down and feedback</h3><p>One line of feedback for every child, every session.</p></li>
        </ol>
      </div>
      <div class="creases" aria-hidden="true"><span>Bowling crease</span><span>Batting crease</span></div>
    </div>
  </section>

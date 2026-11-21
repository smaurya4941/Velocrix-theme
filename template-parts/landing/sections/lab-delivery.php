<?php
/**
 * Section "lab-delivery": Delivery Lab, one tool of the Training Lab (own page, see vx_lab_tools() in inc/training-lab.php).
 * Split out of the old two-tool "lab" section. Element ids are unchanged: assets/landing/js/three-scenes.js
 * starts the 3D scene lazily from #lab-delivery.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="lx lx-solo" aria-labelledby="lab-delivery-h" data-gfx="contour:tr icons">
    <div class="wrap">
      <div class="lx-block" id="lab-delivery">
        <div class="lx-head">
          <h2 id="lab-delivery-h"><span class="n">01</span>Delivery Lab</h2>
          <p>Pick a classic delivery or set your own. See where it lands, how high it reaches the bat and whether it hits the stumps.</p>
        </div>
        <div class="lx-tool">
          <div class="lx-stage" data-k="sim">
            <canvas id="simCanvas" aria-label="3D view of a delivery down the pitch"></canvas>
            <div class="lx-bar"><div class="lx-pills" id="simViews"><button type="button" data-v="batter" class="on">Behind stumps</button><button type="button" data-v="umpire">Umpire</button><button type="button" data-v="side">Side on</button><button type="button" data-v="top">Pitch map</button></div></div>
            <div class="lx-zoom"><button type="button" id="simZoomIn" aria-label="Zoom in">+</button><button type="button" id="simZoomOut" aria-label="Zoom out">−</button></div>
            <span class="lx-hint">Drag to turn the view</span>
          </div>
          <div class="lx-panel">
            <div class="lx-sec">
              <h4>Choose a delivery</h4>
              <div class="lx-chips" id="simPresets"><button type="button" data-p="outswing">Outswinger</button><button type="button" data-p="inswing">Inswinger</button><button type="button" data-p="yorker">Yorker</button><button type="button" data-p="bouncer">Bouncer</button><button type="button" data-p="cutter">Off-cutter</button><button type="button" data-p="slower">Slower ball</button></div>
              <p class="lx-desc" id="rDesc"></p>
            </div>
            <div class="lx-sec">
              <h4>Or set it yourself</h4>
              <div class="lx-ctrl"><label for="sSpeed">Speed <output id="oSpeed"></output></label><input type="range" id="sSpeed" min="60" max="145" value="118"></div>
              <div class="lx-ctrl"><label for="sLen">Lands from the stumps <output id="oLen"></output></label><input type="range" id="sLen" min="0.5" max="11" step="0.1" value="6"></div>
              <div class="lx-ctrl"><label for="sLine">Line <output id="oLine"></output></label><input type="range" id="sLine" min="-0.6" max="0.6" step="0.01" value="0.12"></div>
              <div class="lx-ctrl"><label for="sSwing">Swing in the air <output id="oSwing"></output></label><input type="range" id="sSwing" min="-40" max="40" value="12"></div>
              <div class="lx-ctrl"><label for="sSeam">Movement off the pitch <output id="oSeam"></output></label><input type="range" id="sSeam" min="-25" max="25" value="0"></div>
              <div class="lx-ctrl"><span class="lbl">Surface</span><div class="lx-seg" id="sSurf"><button type="button" data-v="turf" class="on">Grass / clay</button><button type="button" data-v="concrete">Concrete</button></div></div>
              <div class="lx-two">
                <div class="lx-ctrl"><span class="lbl">Playback</span><div class="lx-seg" id="sPlay"><button type="button" data-v="slow" class="on">Slow-mo</button><button type="button" data-v="real">Real</button></div></div>
                <div class="lx-ctrl"><span class="lbl">Batter</span><div class="lx-seg" id="sBatter"><button type="button" data-v="on" class="on">Show</button><button type="button" data-v="off">Hide</button></div></div>
              </div>
            </div>
            <div class="lx-sec">
              <div class="lx-verdict" id="rVerdict" data-s="miss"><span class="dot"></span><div><b id="rVerdictText">–</b><p>Right-arm bowler, over the wicket, to a right-handed batter.</p></div></div>
              <button type="button" class="btn btn-primary" id="bowlBtn" style="justify-content:center">Bowl again</button>
            </div>
          </div>
        </div>
        <div class="lx-reads">
          <div><span>Time to react</span><b><i id="rTime">–</i><small>ms</small></b></div>
          <div><span>Height at the bat</span><b><i id="rHeight">–</i><small>cm</small></b></div>
          <div><span>Speed at the bat</span><b><i id="rSpeed">–</i><small>km/h</small></b></div>
          <div><span>Reaches the</span><b id="rBody">–</b></div>
        </div>
        <p class="lx-note">Simplified physics for coaching: gravity, swing as a steady drift and a bounce that depends on the surface. Real deliveries also depend on spin, wind, the ball's age and the pitch on the day.</p>
      </div>
    </div>
  </section>

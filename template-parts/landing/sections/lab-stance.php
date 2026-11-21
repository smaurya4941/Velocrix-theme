<?php
/**
 * Section "lab-stance": Stance Studio, one tool of the Training Lab (own page, see vx_lab_tools() in inc/training-lab.php).
 * Split out of the old two-tool "lab" section. Element ids are unchanged: assets/landing/js/three-scenes.js
 * starts the 3D scene lazily from #lab-stance.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="lx lx-solo" aria-labelledby="lab-stance-h" data-gfx="contour:tr icons">
    <div class="wrap">
      <div class="lx-block" id="lab-stance">
        <div class="lx-head">
          <h2 id="lab-stance-h"><span class="n">02</span>Stance Studio</h2>
          <p>Set the player's height and the batter takes guard with the matching bat. Adjust stance, knee bend, grip and bat angle and the coach's checks update live. Then play a shot.</p>
        </div>
        <div class="lx-tool">
          <div class="lx-stage" id="stView" data-k="stance">
            <canvas id="stCanvas" aria-label="3D batter in stance, scaled to the chosen height and bat"></canvas>
            <div class="lx-bar"><div class="lx-pills" id="stViews"><button type="button" data-v="bowler">Bowler's view</button><button type="button" data-v="side" class="on">Side on</button><button type="button" data-v="behind">Behind</button><button type="button" data-v="top">Top</button></div></div>
            <div class="lx-zoom"><button type="button" id="stZoomIn" aria-label="Zoom in">+</button><button type="button" id="stZoomOut" aria-label="Zoom out">−</button></div>
            <div class="lx-shots" id="stShots"><span>Play</span><button type="button" data-shot="defence">Forward defence</button><button type="button" data-shot="drive">Cover drive</button><button type="button" data-shot="back">Back-foot defence</button></div>
          </div>
          <div class="lx-panel">
            <div class="lx-sec">
              <h4>Player</h4>
              <div class="lx-ctrl"><label for="stHeight">Height <output id="oStHeight">140 cm</output></label><input type="range" id="stHeight" min="105" max="190" value="140"></div>
              <div class="lx-ctrl"><span class="lbl">Batting hand</span><div class="lx-seg" id="stHand"><button type="button" data-v="R" class="on">Right-handed</button><button type="button" data-v="L">Left-handed</button></div></div>
            </div>
            <div class="lx-sec">
              <h4>Bat</h4>
              <div class="lx-ctrl"><label for="stBat">Bat size</label><select id="stBat" class="lx-select"></select></div>
              <div class="lx-fit">
                <div class="lx-fit-top"><b id="rFit" data-s="good">Good fit</b><span>vs. hip height</span></div>
                <div class="lx-fit-scale"><i id="rFitBar" style="left:50%"></i></div>
                <div class="lx-fit-labels"><span>Short</span><span>Right</span><span>Long</span></div>
              </div>
              <div class="lx-kv"><div><span>Size</span><b id="rBat">–</b></div><div><span>Length</span><b id="rBatLen">–</b></div><div><span>Usually</span><b id="rBatAge">–</b></div><div><span>Ball</span><b id="rBall">–</b></div></div>
            </div>
            <div class="lx-sec">
              <h4>Stance</h4>
              <div class="lx-ctrl"><span class="lbl">Guard</span><div class="lx-seg" id="stGuard"><button type="button" data-v="leg">Leg</button><button type="button" data-v="ml">Mid-leg</button><button type="button" data-v="mid" class="on">Middle</button><button type="button" data-v="off">Off</button></div></div>
              <div class="lx-ctrl"><span class="lbl">Stance</span><div class="lx-seg" id="stOpen"><button type="button" data-v="side" class="on">Side-on</button><button type="button" data-v="semi">Half-open</button><button type="button" data-v="open">Open</button></div></div>
              <div class="lx-ctrl"><label for="stWidth">Feet apart <output id="oStWidth"></output></label><input type="range" id="stWidth" min="60" max="160" value="105"></div>
              <div class="lx-ctrl"><label for="stKnee">Knee bend <output id="oStKnee"></output></label><input type="range" id="stKnee" min="0" max="40" value="18"></div>
              <div class="lx-ctrl"><label for="stLean">Lean from hips <output id="oStLean"></output></label><input type="range" id="stLean" min="0" max="32" value="16"></div>
              <div class="lx-ctrl"><span class="lbl">Weight on</span><div class="lx-seg" id="stWeight"><button type="button" data-v="back">Back foot</button><button type="button" data-v="even" class="on">Even</button><button type="button" data-v="front">Front foot</button></div></div>
            </div>
            <div class="lx-sec">
              <h4>Grip and bat</h4>
              <div class="lx-ctrl"><label for="stAngle">Bat angle at address <output id="oStAngle"></output></label><input type="range" id="stAngle" min="0" max="34" value="16"></div>
              <div class="lx-ctrl"><span class="lbl">Hands on handle</span><div class="lx-seg" id="stGrip"><button type="button" data-v="top" class="on">Top</button><button type="button" data-v="mid">Middle</button><button type="button" data-v="low">Low</button></div></div>
              <div class="lx-ctrl"><span class="lbl">Backlift for shots</span><div class="lx-seg" id="stLift"><button type="button" data-v="low" class="on">Compact</button><button type="button" data-v="high">High</button></div></div>
            </div>
            <div class="lx-sec">
              <h4>Coach's checks</h4>
              <ul class="lx-tips" id="stTips"></ul>
            </div>
          </div>
        </div>
        <div class="lx-reads">
          <div><span>Eye-line</span><b id="rEye">–</b></div>
          <div><span>Feet apart</span><b id="rFeet">–</b></div>
          <div><span>Recommended bat</span><b id="rRec">–</b></div>
          <div><span>Usually ages</span><b id="rAge">–</b></div>
        </div>
      </div>
    </div>
  </section>

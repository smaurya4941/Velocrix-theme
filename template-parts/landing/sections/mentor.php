<?php
/**
 * Section "mentor": Meghna Singh
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="mentor" id="mentor" aria-labelledby="mentor-h" data-gfx="rosette:tr">
    <div class="wrap">
      <div class="player" id="player" data-reveal>
        <video id="manifesto" src="<?php echo esc_url( vx_landing_uri( 'media/meghna-manifesto.mp4' ) ); ?>" poster="<?php echo esc_url( vx_landing_uri( 'media/poster-meghna.jpg' ) ); ?>" playsinline preload="metadata" aria-label="Meghna Singh explains why Velocrix exists (Hindi, with on-screen captions)"></video>
        <button type="button" id="playBtn"><svg aria-hidden="true"><use href="#i-sound"/></svg><span>Play with sound</span></button>
      </div>
      <div class="mentor-copy" data-reveal>
        <div class="who">
          <h2 id="mentor-h">Meghna Singh</h2>
          <span class="role">Mentor, Velocrix Cricket Academy</span>
        </div>
        <p class="lede">Meghna has bowled for India in Tests, ODIs and T20Is. She mentors the Velocrix coaching programme, so every drill your child does is built on what it actually takes at the top level.</p>
        <div class="manifesto" aria-label="From Meghna's message">
          <p><span class="hi">Har koi glory chahta hai. Stadium ki lights, aur jersey pehenne ka sapna.</span><span class="en">Everyone wants the glory: the stadium lights, the dream of wearing the jersey.</span></p>
          <p><span class="hi">Lekin jab subha 4:30 baje ground thand se jama hota hai, tab wahan bahut kam log hote hain.</span><span class="en">But at 4:30 in the morning, when the ground is frozen, very few people turn up.</span></p>
          <p><span class="hi">Hamara mission sirf talent dhoondhna nahi hai, balki mindset banana hai.</span><span class="en">Our job is to build the mindset, as well as find the talent. When the pressure rises, the eyes stay on the ball.</span></p>
        </div>
        <ul class="creds">
          <li><b>All three formats for India</b><span>Test, ODI and T20I debuts in 2021 and 2022</span></li>
          <li><b>Commonwealth Games silver</b><span>India women's team, Birmingham 2022</span></li>
          <li><b>2022 ODI World Cup squad</b><span>India, New Zealand 2022</span></li>
          <li><b>4 for 37 in the WPL</b><span>Gujarat Giants v Delhi Capitals, 2024</span></li>
        </ul>
      </div>
    </div>
    <div class="wrap road" data-reveal>
      <div class="road-head"><p class="kicker">Her road</p><h3>From Bijnor to <em>India colours.</em></h3></div>
      <ol class="road-list" tabindex="0" aria-label="Meghna Singh's career, scroll sideways">
        <li><span class="yr">1994 · Bijnor</span><b>Grows up in Uttar Pradesh</b><span class="tx">Born and raised in Bijnor, western UP.</span></li>
        <li><span class="yr">2012–13</span><b>Uttar Pradesh</b><span class="tx">Starts senior domestic cricket for her home state.</span></li>
        <li><span class="yr">2017–18</span><b>Railways</b><span class="tx">Joins Railways, one of the strongest sides in women's domestic cricket.</span></li>
        <li><span class="yr">2020 · 2022</span><b>Women's T20 Challenge</b><span class="tx">Plays for Velocity, then Supernovas.</span></li>
        <li class="hot"><span class="yr">September 2021</span><b>India debut</b><span class="tx">ODI and Test caps on the tour of Australia.</span></li>
        <li class="hot"><span class="yr">2022</span><b>World Cup and CWG</b><span class="tx">ODI World Cup squad in New Zealand. T20I debut and silver in Birmingham.</span></li>
        <li><span class="yr">2024</span><b>WPL</b><span class="tx">Gujarat Giants, including 4 for 37 against Delhi Capitals.</span></li>
        <li class="now"><span class="yr">Now</span><b>Velocrix</b><span class="tx">Mentoring young cricketers in Greater Noida West.</span></li>
      </ol>
    </div>
  </section>

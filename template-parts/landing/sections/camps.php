<?php
/**
 * Section "camps": Holiday camps: school's out, nets are open.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="camps" aria-labelledby="camps-h" data-gfx="rosette:tr">
    <div class="wrap">
      <div class="sec-head" data-reveal>
        <h2 id="camps-h">Holiday camps: <em>school's out, nets are open.</em></h2>
        <p class="lede">Short, intensive camps in every school holiday, open to children who don't train with us yet.</p>
      </div>
      <div class="camp-row" data-reveal>
        <article class="camp now"><span class="when">Next up: December–January</span><h3>Winter camp</h3><p>Technique work and fitness through the winter holidays, for students and newcomers. Limited seats.</p><a class="btn mag" style="background:#fff;color:#0C1230;justify-self:start" href="<?php echo esc_url( vx_lx( 'visit' ) ); ?>" data-interest="Winter camp">Register interest</a></article>
        
        <article class="camp"><span class="when">May–June</span><h3>Summer camp</h3><p>Our longest camp, ending with a match series.</p></article>
      </div>
    </div>
  </section>

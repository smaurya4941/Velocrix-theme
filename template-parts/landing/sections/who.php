<?php
/**
 * Section "who" (About): who we are. The big paragraph lights up word by word as you scroll (pages.js).
 * Text = the classic About copy. Styles: assets/landing/css/pages.css.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_name = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$vx_big  = 'Velocrix Cricket Academy, founded by Indian international cricketer ' . $vx_name . ', aims to nurture the next generation of cricketers through professional coaching, structured training and a performance-driven approach.';
?>
<section class="who-sec" id="who" aria-labelledby="who-h" data-gfx="seams">
  <div class="wrap">
    <div class="who-head" data-reveal>
      <p class="kicker">Who we are</p>
      <h2 id="who-h">Nurturing the next generation <em>of cricketers.</em></h2>
    </div>
    <div class="who-body">
      <p class="who-big" data-words><?php echo esc_html( $vx_big ); ?></p>
      <p class="lede" data-reveal>The academy focuses on developing strong cricketing fundamentals, fitness, mental resilience, discipline and sportsmanship. Combining international cricket experience with modern training methods, Velocrix aims to create an environment where aspiring players can learn, grow and prepare for competitive cricket.</p>
      <ul class="who-pills" aria-label="What we build">
        <?php foreach ( array( 'Cricketing Fundamentals', 'Fitness', 'Mental Resilience', 'Discipline', 'Sportsmanship' ) as $vx_i => $vx_p ) : ?>
          <li style="--i:<?php echo (int) $vx_i; ?>"><span><?php echo esc_html( $vx_p ); ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

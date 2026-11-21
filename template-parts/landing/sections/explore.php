<?php
/**
 * Section "explore" (Home): cards that lead to the pages the long one-page was split into.
 * Styles: assets/landing/css/pages.css.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_m = VX_URI . '/assets/landing/media/';
$vx_cards = array(
	array( home_url( '/training/' ), 'Training', 'Train hard. Learn smart.', 'How a Velocrix session works, a quick level check for your child and what to pack for training.', 'bowler-load.jpg', 'See how we train' ),
	array( home_url( '/training-lab/' ), 'Training Lab', 'Bowl it. Bat it. In 3D.', 'Bowl a delivery, set a batter\'s stance, learn every fielding position and walk around our ground.', 'batting-nets.jpg', 'Open the Lab' ),
	array( home_url( '/meghna-singh/' ), 'Our Mentor', 'Meghna Singh, International Cricketer.', 'Mentorship that inspires. Training that transforms. Her story and her message to young cricketers.', 'meghna-coaching.jpg', 'Meet Meghna' ),
	array( vx_lab_tool_url( 'batting-game' ), 'Play', 'Your turn to bat.', 'A 3D batting game in the browser. Time your shot, beat your best score, then come and try it for real.', 'catch.jpg', 'Play now' ),
);
?>
<section class="explore" id="explore" aria-labelledby="ex-h" data-gfx="seams">
  <div class="wrap">
    <div class="ex-head" data-reveal>
      <p class="kicker">Explore Velocrix</p>
      <h2 id="ex-h">There's more to <em>see.</em></h2>
      <p class="lede">The full picture is one tap away: how training works, our 3D Training Lab, our mentor and a game to try.</p>
    </div>
    <div class="ex-grid">
      <?php foreach ( $vx_cards as $vx_k => $vx_c ) : ?>
        <a class="ex-card" href="<?php echo esc_url( $vx_c[0] ); ?>" data-reveal data-tilt style="--d:<?php echo (int) $vx_k; ?>">
          <span class="ex-img"><img src="<?php echo esc_url( vx_landing_uri( 'media/' . $vx_c[4] ) ); ?>" alt="" loading="lazy" width="600" height="760"></span>
          <span class="ex-body">
            <span class="ex-n"><?php echo esc_html( sprintf( '%02d', $vx_k + 1 ) ); ?> · <?php echo esc_html( $vx_c[1] ); ?></span>
            <span class="ex-t"><?php echo esc_html( $vx_c[2] ); ?></span>
            <span class="ex-d"><?php echo esc_html( $vx_c[3] ); ?></span>
            <span class="ex-go"><?php echo esc_html( $vx_c[5] ); ?> <svg aria-hidden="true" width="16" height="16"><use href="#i-right"/></svg></span>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

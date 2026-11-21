<?php
/**
 * Section "values" (About): the four values from the official Velocrix poster. Cards stack on scroll (CSS position:sticky).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_values = array(
	array( 'Be Disciplined', 'Consistency and respect for the process, on and off the field.' ),
	array( 'Be Focused', 'A clear goal in every session and every drill.' ),
	array( 'Be Passionate', 'Love for the game is what keeps you training.' ),
	array( 'Be a Champion', 'Aim high, work hard and earn it.' ),
);
?>
<section class="val-sec" id="values" aria-labelledby="val-h">
  <div class="wrap">
    <div class="val-head">
      <p class="kicker">Our values</p>
      <h2 id="val-h">Four words we <em>train by.</em></h2>
      <p class="lede">Champions are not born, they are trained.</p>
    </div>
    <ol class="val-stack">
      <?php foreach ( $vx_values as $vx_i => $vx_v ) : ?>
        <li class="val-card" style="--i:<?php echo (int) $vx_i; ?>">
          <span class="val-n"><?php echo esc_html( sprintf( '%02d', $vx_i + 1 ) ); ?></span>
          <h3><?php echo esc_html( $vx_v[0] ); ?></h3>
          <p><?php echo esc_html( $vx_v[1] ); ?></p>
          <span class="val-ball" aria-hidden="true"></span>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

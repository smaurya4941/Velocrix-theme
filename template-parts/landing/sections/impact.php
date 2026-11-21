<?php
/**
 * Section "impact" (About): counters + "why Velocrix" list from inc/content.php ( vx_copy( 'why' ) ).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_why = vx_copy( 'why' );
$vx_n   = count( vx_copy( 'pillars' ) );
?>
<section class="imp-sec" id="impact" aria-labelledby="imp-h">
  <div class="wrap">
    <div class="imp-top">
      <div data-reveal>
        <p class="kicker">Our impact</p>
        <h2 id="imp-h">Strong culture. <em>Real growth.</em></h2>
      </div>
      <div class="imp-nums" data-reveal>
        <div><b data-count="1">1</b><span>International mentor</span></div>
        <div><b data-count="4">4</b><span>Flexible plans</span></div>
        <div><b data-count="<?php echo (int) $vx_n; ?>"><?php echo (int) $vx_n; ?></b><span>Training pillars</span></div>
      </div>
    </div>
    <div class="imp-grid">
      <figure class="imp-photo" data-reveal><img src="<?php echo esc_url( VX_URI . '/assets/img/prog-1.jpg' ); ?>" alt="Young cricketers training together at Velocrix" loading="lazy" width="800" height="800"></figure>
      <ol class="imp-why">
        <?php foreach ( $vx_why as $vx_i => $vx_w ) : ?>
          <li data-reveal style="--i:<?php echo (int) $vx_i; ?>"><span class="imp-tick" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m5 12.5 4.5 4.5L19 7.5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span><div><b><?php echo esc_html( $vx_w[0] ); ?></b><span><?php echo esc_html( $vx_w[1] ); ?></span></div></li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

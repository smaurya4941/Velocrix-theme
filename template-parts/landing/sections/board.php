<?php
/**
 * Section "board"
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="board" aria-label="Velocrix at a glance">
    <div class="wrap">
      <?php
      // Counts come from Velocrix's own data (inc/content.php, vx_plans()), so they stay true if that data changes.
      $vx_cells = array(
      	array( 1, 'International Cricketer as mentor' ),
      	array( count( vx_plans() ), 'flexible training plans' ),
      	array( count( vx_copy( 'pillars' ) ), 'pillars of every session' ),
      	array( count( vx_copy( 'why' ) ), 'reasons families choose Velocrix' ),
      );
      foreach ( $vx_cells as $vx_c ) : ?>
      <div class="cell"><b data-count="<?php echo (int) $vx_c[0]; ?>"><?php echo (int) $vx_c[0]; ?></b><span><?php echo esc_html( $vx_c[1] ); ?></span></div>
      <?php endforeach; ?>
    </div>
  </section>
  <div class="marquee" aria-hidden="true"><div class="track" id="track"></div></div>
